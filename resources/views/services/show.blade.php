<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Service Report #{{ $service->id }}</h2>
                <div class="mt-1 flex items-center space-x-4 text-sm text-gray-500">
                    <span>Date In: {{ $service->date_in ? $service->date_in->format('M d, Y') : 'N/A' }}</span>
                    <span>&bull;</span>
                    @php
                        $statusClass = match ($service->status) {
                            'Completed' => 'bg-green-100 text-green-800',
                            'Pending' => 'bg-yellow-100 text-yellow-800',
                            'In Progress' => 'bg-blue-100 text-blue-800',
                            'Cancelled' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800',
                        };
                    @endphp
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                        {{ $service->status }}
                    </span>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('services.print', $service) }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-5 h-5 mr-2 -ml-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    Print
                </a>
                <a href="{{ route('services.edit', $service) }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit Report
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Details Card -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900">Appliance Details</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Appliance</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $service->appliance_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Brand/Model</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $service->brand_model ?? 'N/A' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Problem Description</dt>
                            <dd class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                {{ $service->problem_desc }}
                            </dd>
                        </div>
                        @if($service->recommendation)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Diagnosis / Recommendation</dt>
                                <dd class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                    {{ $service->recommendation }}
                                </dd>
                            </div>
                        @endif
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Initial Labor Cost</dt>
                            <dd class="mt-1 text-lg font-bold text-gray-900">
                                ₱{{ number_format($service->labor_cost, 2) }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900">Progress Log & Comments</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4 mb-6 max-h-96 overflow-y-auto pr-2">
                            @forelse($service->comments as $comment)
                                <div class="flex space-x-3">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-bold">
                                            {{ substr($comment->user->name ?? 'U', 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex-1 bg-gray-50 p-3 rounded-lg rounded-tl-none">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-sm font-bold text-gray-900">
                                                {{ $comment->user->name ?? 'Unknown' }}</h4>
                                            <span
                                                class="text-xs text-gray-500">{{ $comment->created_at->format('M d, Y h:i A') }}</span>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-700">{{ $comment->comment }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 text-gray-500 text-sm">
                                    No comments yet. Start the conversation!
                                </div>
                            @endforelse
                        </div>

                        <form action="{{ route('services.comments.store', $service) }}" method="POST" class="relative">
                            @csrf
                            <input type="text" name="comment" required
                                class="block w-full pl-4 pr-12 py-3 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm shadow-sm"
                                placeholder="Add a status update or comment...">
                            <button type="submit"
                                class="absolute right-2 top-2 p-1 text-blue-600 hover:text-blue-800 rounded transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Customer Card -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900">Customer Info</h3>
                    </div>
                    <div class="p-6">
                        @if($service->customer)
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold">
                                        {{ substr($service->customer->first_name, 0, 1) }}
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900">{{ $service->customer->first_name }}
                                        {{ $service->customer->last_name }}</h4>
                                    <p class="text-xs text-gray-500">Customer ID: #{{ $service->customer->id }}</p>
                                </div>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    {{ $service->customer->phone_no }}
                                </div>
                                <div class="flex items-start text-gray-600">
                                    <svg class="w-4 h-4 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $service->customer->address ?? 'No address provided' }}
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 text-center">
                                <a href="{{ route('customers.show', $service->customer) }}"
                                    class="text-sm font-medium text-blue-600 hover:text-blue-500">View Profile</a>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-sm font-medium text-gray-900">{{ $service->customer_name }}</p>
                                <p class="text-xs text-gray-500">Guest / Unlinked</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Payments Card -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Payments</h3>
                        <a href="{{ route('transactions.create', ['report_id' => $service->id]) }}"
                            class="text-xs font-medium text-blue-600 hover:text-blue-500 hover:underline">
                            + Add
                        </a>
                    </div>
                    <div class="p-0">
                        @if($service->transactions->count() > 0)
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Total</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($service->transactions as $transaction)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-900">
                                                ₱{{ number_format($transaction->total_amount, 2) }}</td>
                                            <td class="px-4 py-2 text-right">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->payment_status == 'Paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $transaction->payment_status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-6 text-center text-sm text-gray-500">
                                No associated payments.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>