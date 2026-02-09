<x-app-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Dashboard Overview</h2>
            <p class="mt-1 text-sm text-gray-500">Welcome back! Here's what's happening with your repair service.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Weekly Customers -->
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        +12%
                    </span>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-bold text-gray-900">{{ $weeklyCustomers }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Weekly Customers</p>
                </div>
            </div>

            <!-- Weekly Income -->
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div class="p-3 bg-green-50 rounded-lg text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        +8%
                    </span>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-bold text-gray-900">₱{{ number_format($weeklyIncome, 2) }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Weekly Service Income</p>
                </div>
            </div>

            <!-- Weekly Services -->
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div class="p-3 bg-purple-50 rounded-lg text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        +5%
                    </span>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-bold text-gray-900">{{ $weeklyServices }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Weekly Total Services</p>
                </div>
            </div>

            <!-- Growth Rate -->
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div class="p-3 bg-orange-50 rounded-lg text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        +3%
                    </span>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-bold text-gray-900">+15%</h3>
                    <p class="text-sm text-gray-500 mt-1">Growth Rate</p>
                </div>
            </div>
        </div>

        <!-- Charts & Activity Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Popular Service Types -->
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Popular Service Types</h3>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="serviceTypesChart"></canvas>
                </div>
                <div class="mt-4 flex justify-center space-x-6">
                    <div class="flex items-center">
                        <span class="w-3 h-3 rounded-full bg-orange-500 mr-2"></span>
                        <span class="text-sm text-gray-500">Installation</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 rounded-full bg-green-500 mr-2"></span>
                        <span class="text-sm text-gray-500">Maintenance</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 rounded-full bg-blue-500 mr-2"></span>
                        <span class="text-sm text-gray-500">Repair</span>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Activity</h3>
                <div class="space-y-4">
                    @forelse($recentServices as $service)
                                    <div
                                        class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors border border-transparent hover:border-gray-100">
                                        <div
                                            class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm shrink-0">
                                            {{ substr($service->customer_name ?? 'U', 0, 1) }}
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex justify-between items-start">
                                                <h4 class="text-sm font-semibold text-gray-900">{{ $service->customer_name }}</h4>
                                                <span
                                                    class="px-2 py-0.5 text-xs rounded-full 
                                                        {{ $service->status === 'Completed' ? 'bg-green-100 text-green-800' :
                        ($service->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                                    {{ $service->status }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-500">{{ $service->appliance_name }}</p>
                                            <p class="text-xs text-gray-400 mt-1">{{ $service->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                    @empty
                        <div class="text-center py-4 text-gray-500 text-sm">No recent activity</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('serviceTypesChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Installation', 'Maintenance', 'Repair'],
                        datasets: [{
                            data: [30, 50, 20], // Static data for now
                            backgroundColor: ['#F97316', '#22C55E', '#3B82F6'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        cutout: '70%'
                    }
                });
            }
        });
    </script>
</x-app-layout>