<x-app-layout>
    <div class="space-y-6">

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Weekly Customers -->
            <a href="{{ route('customers.index') }}"
                class="block bg-blue-50/50 dark:bg-slate-800 p-6 rounded-xl border border-blue-100 dark:border-slate-700 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
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
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $weeklyCustomers }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Weekly Customers</p>
                </div>
            </a>

            <!-- Weekly Income -->
            <a href="{{ route('transactions.index') }}"
                class="block bg-green-50/50 dark:bg-slate-800 p-6 rounded-xl border border-green-100 dark:border-slate-700 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div class="p-3 bg-green-100 rounded-lg text-green-700">
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
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">₱{{ number_format($weeklyIncome, 2) }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Weekly Service Income</p>
                </div>
            </a>

            <!-- Weekly Services -->
            <a href="{{ route('services.index') }}"
                class="block bg-purple-50/50 dark:bg-slate-800 p-6 rounded-xl border border-purple-100 dark:border-slate-700 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div class="p-3 bg-purple-100 rounded-lg text-purple-700">
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
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $weeklyServices }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Weekly Total Services</p>
                </div>
            </a>

            <!-- Growth Rate -->
            <a href="{{ route('transactions.index') }}"
                class="block bg-orange-50/50 dark:bg-slate-800 p-6 rounded-xl border border-orange-100 dark:border-slate-700 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div class="p-3 bg-orange-100 rounded-lg text-orange-700">
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
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">+15%</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Growth Rate</p>
                </div>
            </a>
        </div>

        <!-- Charts & Activity Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Popular Service Types (flip card) -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm" x-data="{ flipped: false }">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Popular Service Types</h3>
                    <!-- Flip toggle button -->
                    <button @click="flipped = !flipped"
                        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg border border-gray-200 dark:border-slate-600 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-700 hover:border-blue-300 transition-all"
                        :title="flipped ? 'Switch to Donut Chart' : 'Switch to Line Chart'">
                        <svg class="w-4 h-4 transition-transform duration-500" :class="flipped ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span x-text="flipped ? 'Donut' : 'Line'"></span>
                    </button>
                </div>

                <!-- Flip card wrapper -->
                <div class="relative" style="perspective: 1000px; height: 320px;">
                    <div class="w-full h-full absolute transition-all duration-700"
                        :style="flipped ? 'transform: rotateY(180deg); transform-style: preserve-3d;' : 'transform: rotateY(0deg); transform-style: preserve-3d;'"
                        style="transform-style: preserve-3d;">

                        <!-- FRONT: Donut Chart -->
                        <div class="absolute inset-0 flex flex-col" style="backface-visibility: hidden; -webkit-backface-visibility: hidden;">
                            <div class="flex-1 flex items-center justify-center relative">
                                <canvas id="serviceTypesChart"></canvas>
                                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                    <span class="text-3xl font-bold text-gray-900 dark:text-white" id="popularServicePercentage">50%</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider" id="popularServiceLabel">MAINTENANCE</span>
                                </div>
                            </div>
                            <div class="mt-2 flex justify-center space-x-6">
                                <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-orange-500 mr-2"></span><span class="text-sm text-gray-500 dark:text-gray-400">Installation</span></div>
                                <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-green-500 mr-2"></span><span class="text-sm text-gray-500 dark:text-gray-400">Maintenance</span></div>
                                <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-blue-500 mr-2"></span><span class="text-sm text-gray-500 dark:text-gray-400">Repair</span></div>
                            </div>
                        </div>

                        <!-- BACK: Line Chart -->
                        <div class="absolute inset-0 flex flex-col"
                            style="backface-visibility: hidden; -webkit-backface-visibility: hidden; transform: rotateY(180deg);">
                            <div class="flex-1 flex items-center justify-center">
                                <canvas id="serviceTypesLineChart"></canvas>
                            </div>
                            <p class="text-center text-xs text-gray-400 dark:text-gray-500 mt-1">Service type trends over the last 6 months</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-[14px] shadow-[0px_10px_15px_0px_rgba(0,0,0,0.1),0px_4px_6px_0px_rgba(0,0,0,0.1)] p-[24px] flex flex-col gap-[48px]">
                <div class="h-[48px] flex items-center justify-between">
                    <div class="flex flex-col gap-[4px]">
                        <h3 class="text-[18px] leading-[28px] font-bold text-[#101828]">Recent Activity</h3>
                        <p class="text-[12px] leading-[16px] text-[#6a7282]">Latest service updates</p>
                    </div>
                    <a href="{{ route('services.index') }}"
                        class="inline-flex items-center gap-[8px] text-[12px] leading-[16px] font-semibold text-[#155dfc]">
                        View All
                        <img class="w-[16px] h-[16px]" alt="" src="{{ asset('assets/icons/arrow-right-blue.svg') }}" />
                    </a>
                </div>

                <div class="flex flex-col gap-[16px]">
                    @if(count($recentServices) > 0)
                    @foreach($recentServices as $service)
                    @php
                        $status = strtolower($service->status ?? '');
                        if (str_contains($status, 'complete')) {
                            $pillBg = 'bg-[#dcfce7]';
                            $pillText = 'text-[#008236]';
                        } elseif (str_contains($status, 'wait')) {
                            $pillBg = 'bg-[#fef3c6]';
                            $pillText = 'text-[#bb4d00]';
                        } else {
                            $pillBg = 'bg-[#dbeafe]';
                            $pillText = 'text-[#1447e6]';
                        }
                        $titleCustomer = $service->customer_name ?: 'Unknown Customer';
                        $titleAppliance = $service->appliance_name ?? optional($service->appliance)->name ?? 'Service';
                    @endphp
                    <div class="relative h-[68px]">
                        <div class="relative h-full {{ $loop->last ? '' : 'border-l-2 border-[#e5e7eb]' }}">
                            <div class="absolute left-[28px] top-0 h-[52px] flex flex-col gap-[8px]">
                                <div class="h-[20px]">
                                    <p class="text-[14px] leading-[20px] font-semibold text-[#101828] truncate">
                                        {{ $titleCustomer }} - {{ $titleAppliance }}
                                    </p>
                                </div>
                                <div class="h-[24px] flex items-center gap-[8px]">
                                    <span class="h-[24px] px-[10px] py-[4px] rounded-[14px] inline-flex items-center justify-center {{ $pillBg }}">
                                        <span class="text-[12px] leading-[16px] font-semibold {{ $pillText }}">
                                            {{ $service->status ?? 'Unknown' }}
                                        </span>
                                    </span>
                                    <span class="text-[12px] leading-[16px] font-medium text-[#6a7282]">
                                        {{ optional($service->created_at)->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <span class="absolute left-[-9px] top-0 w-[16px] h-[16px] rounded-full bg-[#2b7fff] border-[4px] border-white"></span>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="text-[12px] leading-[16px] text-[#6a7282]">No recent activity.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- DONUT CHART ---
            const ctx = document.getElementById('serviceTypesChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Installation', 'Maintenance', 'Repair'],
                        datasets: [{
                            data: [30, 50, 20],
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
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.label + ': ' + context.raw + '%';
                                    }
                                }
                            }
                        },
                        cutout: '75%',
                        onHover: function(event, activeElements) {
                            if (activeElements.length > 0) {
                                const index = activeElements[0].index;
                                const data = this.data.datasets[0].data[index];
                                const label = this.data.labels[index];
                                document.getElementById('popularServicePercentage').textContent = data + '%';
                                document.getElementById('popularServiceLabel').textContent = label.toUpperCase();
                            }
                        }
                    }
                });
            }

            // --- LINE CHART ---
            const ctxLine = document.getElementById('serviceTypesLineChart');
            if (ctxLine) {
                new Chart(ctxLine, {
                    type: 'line',
                    data: {
                        labels: ['Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'],
                        datasets: [{
                                label: 'Installation',
                                data: [12, 19, 15, 22, 18, 30],
                                borderColor: '#F97316',
                                backgroundColor: 'rgba(249,115,22,0.08)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                            },
                            {
                                label: 'Maintenance',
                                data: [28, 32, 45, 40, 48, 50],
                                borderColor: '#22C55E',
                                backgroundColor: 'rgba(34,197,94,0.08)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                            },
                            {
                                label: 'Repair',
                                data: [10, 14, 18, 13, 20, 20],
                                borderColor: '#3B82F6',
                                backgroundColor: 'rgba(59,130,246,0.08)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    boxWidth: 10,
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0,0,0,0.04)'
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
