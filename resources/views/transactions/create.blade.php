<x-app-layout>
    <div class="w-full mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">Create New Transaction</h2>
            @if(request('report_id'))
                <a href="{{ route('services.show', request('report_id')) }}"
                    class="text-sm font-medium text-gray-500 hover:text-gray-900 flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Service Report
                </a>
            @else
                <a href="{{ route('transactions.index') }}"
                    class="text-sm font-medium text-gray-500 hover:text-gray-900 flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to List
                </a>
            @endif
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden" x-data="{
            reports: {{ Js::from($reports->map(function ($r) {
    return [
        'id' => $r->id,
        'labor' => $r->details ? $r->details->labor : 0,
        'materials' => $r->details ? $r->details->parts_total_charge : 0,
        'delivery' => $r->details ? $r->details->pullout_delivery : 0
    ];
})) }},
            selectedReportId: '{{ old('report_id', request('report_id')) }}',
            labor: {{ old('labor', 0) }},
            materials: {{ old('materials', 0) }},
            delivery: {{ old('delivery', 0) }},
            total_amount: 0,
            calculateTotal() {
                this.total_amount = ((parseFloat(this.labor) || 0) + (parseFloat(this.materials) || 0) + (parseFloat(this.delivery) || 0)).toFixed(2);
            },
            init() {
                this.$watch('selectedReportId', (value) => {
                    const report = this.reports.find(r => r.id == value);
                    if (report) {
                        this.labor = report.labor;
                        this.materials = report.materials;
                        this.delivery = report.delivery;
                    } else {
                        this.labor = 0;
                        this.materials = 0;
                        this.delivery = 0;
                    }
                    this.calculateTotal();
                });
                
                this.$watch('labor', () => this.calculateTotal());
                this.$watch('materials', () => this.calculateTotal());
                this.$watch('delivery', () => this.calculateTotal());
                
                // Trigger initial load if report_id exists
                if(this.selectedReportId && !{{ old('labor') ? 'true' : 'false' }}) {
                    const report = this.reports.find(r => r.id == this.selectedReportId);
                    if (report) {
                        this.labor = report.labor;
                        this.materials = report.materials;
                        this.delivery = report.delivery;
                    }
                }
                this.calculateTotal();
            }
        }">
            <div class="p-6">
                <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="space-y-6">
                        <!-- Service Report -->
                        <div>
                            <label for="report_id" class="block text-sm font-medium text-gray-700">Service
                                Report</label>
                            <select id="report_id" name="report_id" x-model="selectedReportId" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                                <option value="">Select Service Report</option>
                                @foreach($reports as $report)
                                    <option value="{{ $report->id }}">
                                        #{{ $report->id }} - {{ $report->customer_name }}
                                        ({{ $report->appliance ? $report->appliance->product : 'N/A' }}) -
                                        {{ $report->status }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-sm text-gray-500">Only "Completed" service reports are eligible for
                                payment.</p>
                            @error('report_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Labor Cost -->
                            <div>
                                <label for="labor" class="block text-sm font-medium text-gray-700">Labor Cost</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">₱</span>
                                    </div>
                                    <input type="number" name="labor" id="labor" step="0.01" x-model="labor" required
                                        class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 sm:text-sm border-gray-300 rounded-lg"
                                        placeholder="0.00">
                                </div>
                                @error('labor')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Materials Cost -->
                            <div>
                                <label for="materials" class="block text-sm font-medium text-gray-700">Materials
                                    (Parts)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">₱</span>
                                    </div>
                                    <input type="number" name="materials" id="materials" step="0.01" x-model="materials"
                                        required
                                        class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 sm:text-sm border-gray-300 rounded-lg"
                                        placeholder="0.00">
                                </div>
                                @error('materials')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Delivery Cost -->
                            <div>
                                <label for="delivery" class="block text-sm font-medium text-gray-700">Delivery
                                    Cost</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">₱</span>
                                    </div>
                                    <input type="number" name="delivery" id="delivery" step="0.01" x-model="delivery"
                                        required
                                        class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 sm:text-sm border-gray-300 rounded-lg"
                                        placeholder="0.00">
                                </div>
                                @error('delivery')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Total Amount -->
                        <div>
                            <label for="total_amount" class="block text-sm font-medium text-gray-700">Total
                                Amount</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm overflow-visible font-bold">₱</span>
                                </div>
                                <input type="number" name="total_amount" id="total_amount" step="0.01"
                                    x-model="total_amount" required
                                    class="font-bold focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 sm:text-sm border-gray-300 rounded-lg"
                                    placeholder="0.00">
                            </div>
                            @error('total_amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Status -->
                        <div>
                            <label for="payment_status" class="block text-sm font-medium text-gray-700">Payment
                                Status</label>
                            <select id="payment_status" name="payment_status"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                                <option value="Paid" {{ old('payment_status', 'Paid') == 'Paid' ? 'selected' : '' }}>Paid
                                </option>
                                <option value="Unpaid" {{ old('payment_status') == 'Unpaid' ? 'selected' : '' }}>Unpaid
                                </option>
                                <option value="Partial" {{ old('payment_status') == 'Partial' ? 'selected' : '' }}>Partial
                                </option>
                            </select>
                            @error('payment_status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                            @if(request('report_id'))
                                <a href="{{ route('services.show', request('report_id')) }}"
                                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    Cancel
                                </a>
                            @else
                                <a href="{{ route('transactions.index') }}"
                                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    Cancel
                                </a>
                            @endif
                            <button type="submit"
                                class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                Save Transaction
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>