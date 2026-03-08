<x-app-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Parts Inventory</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">Manage spare parts and inventory</p>
            </div>
            <a href="{{ route('inventory.create') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 dark:bg-blue-900 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Part
            </a>
        </div>

        <!-- Search -->
        <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" id="searchInput"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-200 dark:border-slate-600 rounded-lg leading-5 bg-white dark:bg-slate-800 placeholder-gray-400 focus:outline-none focus:placeholder-gray-300 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out"
                    placeholder="Search parts by name or part number...">
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-slate-700/50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                Part No
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                Part Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                Price
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                Stock
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200" id="inventoryTableBody">
                        @if(count($parts) > 0)
                            @foreach($parts as $part)
                                @php
                                    $qty = $part->quantity_stock;
                                    $maxDisplay = 50;
                                    $barPercent = min(100, ($qty / $maxDisplay) * 100);
                                    if ($qty === 0) {
                                        $statusLabel = 'Out of Stock';
                                        $statusColor = 'text-red-700 dark:text-red-400';
                                        $bgBadge = 'bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800';
                                        $barColor = 'bg-red-500';
                                        $dotColor = 'bg-red-500 animate-pulse';
                                    } elseif ($qty < 5) {
                                        $statusLabel = 'Critical';
                                        $statusColor = 'text-red-700 dark:text-red-400';
                                        $bgBadge = 'bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800';
                                        $barColor = 'bg-red-500';
                                        $dotColor = 'bg-red-500 animate-pulse';
                                    } elseif ($qty < 10) {
                                        $statusLabel = 'Low Stock';
                                        $statusColor = 'text-yellow-700 dark:text-yellow-400';
                                        $bgBadge = 'bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800';
                                        $barColor = 'bg-yellow-400';
                                        $dotColor = 'bg-yellow-400';
                                    } else {
                                        $statusLabel = 'In Stock';
                                        $statusColor = 'text-green-700 dark:text-green-400';
                                        $bgBadge = 'bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800';
                                        $barColor = 'bg-green-500';
                                        $dotColor = 'bg-green-500';
                                    }
                                @endphp
                                <tr class="hover:bg-gray-50 dark:bg-slate-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-purple-600 rounded-lg flex items-center justify-center text-white">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $part->part_no }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">
                                        {{ $part->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                                        ₱{{ number_format($part->price, 2) }}
                                    </td>

                                    <!-- Enhanced Stock Indicator -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col gap-1.5 min-w-[155px]">
                                            <!-- Row: dot + qty + badge -->
                                            <div class="flex items-center gap-2">
                                                <span class="inline-block w-2 h-2 rounded-full flex-shrink-0 {{ $dotColor }}"></span>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                                    {{ $qty }}
                                                    <span class="font-normal text-xs text-gray-400 dark:text-slate-500">units</span>
                                                </span>
                                                <span class="ml-auto text-[11px] font-semibold px-2 py-0.5 rounded-full {{ $bgBadge }} {{ $statusColor }}">
                                                    {{ $statusLabel }}
                                                </span>
                                            </div>
                                            <!-- Progress bar -->
                                            <div class="w-full bg-gray-200 dark:bg-slate-600 rounded-full h-1.5 overflow-hidden">
                                                <div class="{{ $barColor }} h-1.5 rounded-full transition-all duration-500" style="width: {{ $barPercent }}%"></div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-3">
                                            <a href="{{ route('inventory.edit', $part) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-900 transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('inventory.destroy', $part) }}" method="POST"
                                                class="inline-block" onsubmit="return confirm('Delete this part?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors"
                                                    title="Delete">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <p>No parts found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Search Script -->
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function () {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#inventoryTableBody tr');

            rows.forEach(function (row) {
                let text = row.textContent.toLowerCase();
                if (text.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</x-app-layout>