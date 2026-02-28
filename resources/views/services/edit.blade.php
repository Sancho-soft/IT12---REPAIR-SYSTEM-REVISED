<x-app-layout>
    <div class="w-full mx-auto space-y-6" x-data="{
        customers: {{ Js::from($customers) }},
        parts: {{ Js::from($parts) }},
        selectedCustomerId: '{{ old('customer_id', $service->customer_id) }}',
        selectedApplianceId: '{{ old('appliance_id', $service->appliance_id) }}',
        selectedParts: [],
        selectedPartId: '',
        partQuantity: 1,
        get currentCustomer() {
            return this.customers.find(c => c.id == this.selectedCustomerId) || null;
        },
        get customerAppliances() {
            return this.currentCustomer ? this.currentCustomer.appliances : [];
        },
        get totalPartsCost() {
            return this.selectedParts.reduce((total, part) => total + (part.price * part.quantity), 0);
        },
        addPart() {
            if (!this.selectedPartId || this.partQuantity < 1) return;
            const partIndex = this.parts.findIndex(p => p.id == this.selectedPartId);
            if (partIndex === -1) return;
            const part = this.parts[partIndex];
            
            // Check if already in list
            const existingIndex = this.selectedParts.findIndex(p => p.id === part.id);
            if (existingIndex !== -1) {
                this.selectedParts[existingIndex].quantity += parseInt(this.partQuantity);
            } else {
                this.selectedParts.push({
                    id: part.id,
                    name: part.name,
                    part_no: part.part_no,
                    price: parseFloat(part.price),
                    quantity: parseInt(this.partQuantity)
                });
            }
            this.selectedPartId = '';
            this.partQuantity = 1;
        },
        removePart(id) {
            this.selectedParts = this.selectedParts.filter(p => p.id !== id);
        },
        init() {
            this.$watch('selectedCustomerId', (newVal, oldVal) => {
                if(oldVal && oldVal !== newVal) {
                    this.selectedApplianceId = ''; // Only reset if specifically changed by user, not initial load
                }
            });
            
            // Re-populate selectedParts from old input or existing service parts
            let oldParts = @json(old('parts', $service->parts ?: []));
            if (oldParts.length > 0) {
                oldParts.forEach(oldPart => {
                    const p = this.parts.find(px => px.id == oldPart.id);
                    if (p) {
                         this.selectedParts.push({
                            id: p.id,
                            name: p.name,
                            part_no: p.part_no,
                            price: parseFloat(oldPart.pivot ? oldPart.pivot.price : (oldPart.price || p.price)),
                            quantity: parseInt(oldPart.pivot ? oldPart.pivot.quantity : oldPart.quantity)
                        });
                    }
                });
            }
        }
    }">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">Edit Service Report #{{ $service->id }}</h2>
            <a href="{{ route('services.index') }}"
                class="text-sm font-medium text-gray-500 hover:text-gray-900 flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6">
                <form action="{{ route('services.update', $service) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @php
                        $userRole = auth()->user()->role;
                        $isTech = $userRole === 'Technician';
                        $isSec = $userRole === 'Secretary';
                        
                        $techDisabled = $isTech ? 'disabled' : '';
                        $secDisabled = $isSec ? 'disabled' : '';
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Customer -->
                        <div>
                            <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer</label>
                            <select name="customer_id" id="customer_id" x-model="selectedCustomerId" required {{ $techDisabled }}
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed">
                                <option value="">-- Select Customer --</option>
                                <template x-for="customer in customers" :key="customer.id">
                                    <option :value="customer.id"
                                        x-text="customer.first_name + ' ' + (customer.last_name || '') + (customer.email ? ' ('+customer.email+')' : '')"
                                        :selected="customer.id == selectedCustomerId"></option>
                                </template>
                            </select>
                            @error('customer_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date Received -> Repair Date -->
                        <div>
                            <label for="date_in" class="block text-sm font-medium text-gray-700">Repair Date</label>
                            <input type="date" name="date_in" id="date_in"
                                value="{{ old('date_in', $service->date_in ? $service->date_in->format('Y-m-d') : '') }}"
                                required {{ $techDisabled }}
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed">
                            @error('date_in')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Appliance -->
                        <div>
                            <label for="appliance_id" class="block text-sm font-medium text-gray-700">Appliance</label>
                            <select name="appliance_id" id="appliance_id" x-model="selectedApplianceId" required {{ $techDisabled }}
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed"
                                :disabled="!customerAppliances.length || '{{ $techDisabled }}' === 'disabled'">
                                <option value="">-- Select Appliance --</option>
                                <template x-for="app in customerAppliances" :key="app.id">
                                    <option :value="app.id"
                                        x-text="app.product + ' - ' + app.brand + (app.model_no ? ' ('+app.model_no+')' : '')">
                                    </option>
                                </template>
                            </select>
                            <p x-show="selectedCustomerId && !customerAppliances.length"
                                class="text-xs text-red-500 mt-1">This customer has no appliances. Please add one in
                                their profile first.</p>
                            @error('appliance_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dealer -->
                        <div>
                            <label for="dealer" class="block text-sm font-medium text-gray-700">Dealer</label>
                            <input type="text" name="dealer" id="dealer" value="{{ old('dealer', $service->dealer) }}" {{ $techDisabled }}
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed"
                                placeholder="e.g. SM Appliance">
                            @error('dealer')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Purchase -->
                        <div>
                            <label for="dop" class="block text-sm font-medium text-gray-700">Date of Purchase</label>
                            <input type="date" name="dop" id="dop"
                                value="{{ old('dop', $service->dop ? $service->dop->format('Y-m-d') : '') }}" {{ $techDisabled }}
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed">
                            @error('dop')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @php
                            $savedTechs = $service->details ? explode(', ', $service->details->technician) : [];
                            $savedServiceTypes = $service->details && $service->details->service_types ? $service->details->service_types : [];
                        @endphp

                        <!-- Assigned Technicians -->
                        <div class="md:col-span-2">
                            <label for="technicians" class="block text-sm font-medium text-gray-700">Assigned
                                Technicians (1-3 max)</label>
                            <select id="technicians" name="technicians[]" multiple {{ $techDisabled }}
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg disabled:bg-gray-100 disabled:cursor-not-allowed"
                                size="3">
                                @foreach($technicians as $tech)
                                    <option value="{{ $tech->full_name }}" {{ in_array($tech->full_name, old('technicians', $savedTechs)) ? 'selected' : '' }}>
                                        {{ $tech->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Hold CTRL/Command to select multiple technicians.</p>
                            @error('technicians')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Service Types -->
                        <div class="md:col-span-2 mt-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Service Types</label>
                            <div class="flex flex-wrap gap-4">
                                @foreach(['Repair', 'Cleaning', 'Installation', 'Check-up'] as $type)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="service_types[]" value="{{ $type }}" {{ $techDisabled }}
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 disabled:bg-gray-100 disabled:cursor-not-allowed"
                                            {{ in_array($type, old('service_types', $savedServiceTypes)) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600">{{ $type }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('service_types')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Problem Description (Complaint) -->
                        <div class="md:col-span-2">
                            <label for="problem_desc" class="block text-sm font-medium text-gray-700">Problem
                                Description (Complaint)</label>
                            <textarea id="problem_desc" name="problem_desc" rows="3" required {{ $techDisabled }}
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed">{{ old('problem_desc', $service->details ? $service->details->complaint : '') }}</textarea>
                            @error('problem_desc')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Findings -->
                        <div class="md:col-span-2">
                            <label for="findings" class="block text-sm font-medium text-gray-700">Findings</label>
                            <textarea id="findings" name="findings" rows="3" {{ $secDisabled }}
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed">{{ old('findings', $service->findings) }}</textarea>
                            @error('findings')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remarks -->
                        <div class="md:col-span-2">
                            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                            <textarea id="remarks" name="remarks" rows="2" {{ $secDisabled }}
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed">{{ old('remarks', $service->remarks) }}</textarea>
                            @error('remarks')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dynamic Used Parts -->
                        <div class="md:col-span-2 bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Parts Used (Inventory)</h3>
                            
                            <div class="flex items-end gap-3 mb-4">
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-700">Select Part</label>
                                    <select x-model="selectedPartId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        <option value="">-- Choose Part --</option>
                                        <template x-for="part in parts" :key="part.id">
                                            <option :value="part.id" x-text="part.part_no + ' - ' + part.name + ' (₱' + part.price + ') - Stock: ' + part.quantity_stock"></option>
                                        </template>
                                    </select>
                                </div>
                                <div class="w-24">
                                    <label class="block text-xs font-medium text-gray-700">Qty</label>
                                    <input type="number" x-model="partQuantity" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                <button type="button" @click="addPart" class="mb-px px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                                    Add Part
                                </button>
                            </div>

                            <!-- Parts Table -->
                            <div x-show="selectedParts.length > 0" class="mt-4 border border-gray-200 rounded-md overflow-hidden bg-white">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Part No.</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Name/Desc</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Price</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500">Qty</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Subtotal</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <template x-for="(part, index) in selectedParts" :key="part.id">
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-900" x-text="part.part_no"></td>
                                                <td class="px-4 py-2 text-sm text-gray-900" x-text="part.name"></td>
                                                <td class="px-4 py-2 text-sm text-right text-gray-900" x-text="'₱' + part.price.toFixed(2)"></td>
                                                <td class="px-4 py-2 text-sm text-center text-gray-900">
                                                    <input type="number" x-model.number="part.quantity" min="1" class="w-16 p-1 text-center text-sm border-gray-300 rounded" @change="$dispatch('input')">
                                                </td>
                                                <td class="px-4 py-2 text-sm text-right text-gray-900" x-text="'₱' + (part.price * part.quantity).toFixed(2)"></td>
                                                <td class="px-4 py-2 text-sm text-center">
                                                    <button type="button" @click="removePart(part.id)" class="text-red-500 hover:text-red-700">
                                                        <svg class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </td>
                                                
                                                <!-- Hidden inputs to submit array -->
                                                <td class="hidden">
                                                    <input type="hidden" :name="'parts['+index+'][id]'" :value="part.id">
                                                    <input type="hidden" :name="'parts['+index+'][quantity]'" :value="part.quantity">
                                                    <input type="hidden" :name="'parts['+index+'][price]'" :value="part.price">
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                    <tfoot class="bg-gray-50 font-semibold">
                                        <tr>
                                            <td colspan="4" class="px-4 py-3 text-right text-sm text-gray-900">Parts Total:</td>
                                            <td class="px-4 py-3 text-right text-sm text-blue-700" x-text="'₱' + totalPartsCost.toFixed(2)"></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                            <!-- Optional manual text just in case they need to write something else that is not in inventory -->
                            <div class="mt-4">
                                <label for="used_parts" class="block text-xs font-medium text-gray-700">Additional Notes / Miscellaneous Not In Inventory</label>
                                <textarea id="used_parts" name="used_parts" rows="1" {{ $secDisabled }} class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed" placeholder="Any screws, tapes, manual items used...">{{ old('used_parts', $service->used_parts) }}</textarea>
                            </div>
                        </div>

                        <!-- Initial Cost -->
                        <div>
                            <label for="labor_cost" class="block text-sm font-medium text-gray-700">Labor Cost</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">₱</span>
                                </div>
                                <input type="number" name="labor_cost" id="labor_cost" step="0.01" {{ $techDisabled }}
                                    value="{{ old('labor_cost', $service->details ? $service->details->labor : 0) }}"
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 sm:text-sm border-gray-300 rounded-lg disabled:bg-gray-100 disabled:cursor-not-allowed">
                            </div>
                            @error('labor_cost')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" {{ $secDisabled }}
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg disabled:bg-gray-100 disabled:cursor-not-allowed">
                            <option value="Pending" {{ old('status', $service->status) == 'Pending' ? 'selected' : '' }}>
                                Pending</option>
                            <option value="Waiting for Parts" {{ old('status', $service->status) == 'Waiting for Parts' ? 'selected' : '' }}>Waiting for Parts</option>
                            <option value="Under Repair" {{ old('status', $service->status) == 'Under Repair' ? 'selected' : '' }}>Under Repair</option>
                            <option value="Unrepairable" {{ old('status', $service->status) == 'Unrepairable' ? 'selected' : '' }}>Unrepairable</option>
                            <option value="Completed" {{ old('status', $service->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Cancelled" {{ old('status', $service->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('services.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Update Service Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>