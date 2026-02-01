@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="px-2 pt-2 pb-4">
        <!-- Main Dashboard Layout -->
        <div class="dashboard-grid">
            <!-- Weekly Customers Card -->
            <div class="card-box metric-card div14">
                <div class="icon-square customers">
                    <span class="material-icons card-icon">groups</span>
                </div>
                <div class="card-content">
                    <h5>Weekly Customers</h5>
                    <h2>{{ $weeklyCustomers ?? 0 }}</h2>
                </div>
            </div>

            <!-- Weekly Service Income Card -->
            <div class="card-box metric-card div7">
                <div class="icon-square income">
                    <span class="material-icons card-icon">payments</span>
                </div>
                <div class="card-content">
                    <h5>Weekly Service Income</h5>
                    <h2>₱{{ number_format($weeklyIncome ?? 0, 2) }}</h2>
                </div>
            </div>

            <!-- Weekly Total Services Card -->
            <div class="card-box metric-card div15">
                <div class="icon-square services">
                    <span class="material-icons card-icon">build_circle</span>
                </div>
                <div class="card-content">
                    <h5>Weekly Total Services</h5>
                    <h2>{{ $weeklyServices ?? 0 }}</h2>
                </div>
            </div>

            <!-- Popular Service Types -->
            <div class="card-box div2">
                <div class="section-title">Popular Service Types</div>
                <div class="chart-container small-chart">
                    <canvas id="serviceTypesChart"></canvas>
                </div>
            </div>

            <!-- Service Performance Overview -->
            <div class="card-box div16">
                <div class="section-title d-flex justify-content-between align-items-center">
                    <span>Service Performance Overview</span>
                    <select id="trendFilter" class="form-control" style="width: auto; font-size: 0.9rem;">
                        <option value="monthly">Monthly Trends</option>
                        <option value="weekly">Weekly Trends</option>
                        <option value="yearly">Yearly Trends</option>
                    </select>
                </div>
                <div class="chart-container performance-chart">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Low Stock Alert -->
            <div class="card-box div10">
                <div class="section-title d-flex align-items-center justify-content-between">
                    <span>Low Stock Alert</span>
                    <div class="d-flex align-items-center gap-2">
                        @if(isset($lowStockParts) && count($lowStockParts) > 0)
                            <span class="material-icons"
                                style="color: #dc3545; font-size: 28px; animation: pulse 2s infinite;">warning</span>
                            <span style="color: #dc3545; font-weight: 600; font-size: 0.9rem;">Need to Order</span>
                        @endif
                    </div>
                </div>
                <style>
                    @keyframes pulse {
                        0% {
                            transform: scale(1);
                            opacity: 1;
                        }

                        50% {
                            transform: scale(1.1);
                            opacity: 0.8;
                        }

                        100% {
                            transform: scale(1);
                            opacity: 1;
                        }
                    }
                </style>
                <div class="low-stock-container">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col" width="80%">Part Info</th>
                                <th scope="col" width="10%">Stock</th>
                                <th scope="col" width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStockParts as $part)
                                @php
                                    $stock = $part->quantity_stock;
                                    if ($stock == 0) {
                                        $statusClass = 'bg-danger';
                                        $statusText = 'Out of Stock';
                                    } elseif ($stock < 5) {
                                        $statusClass = 'bg-danger';
                                        $statusText = 'Critical';
                                    } else {
                                        $statusClass = 'bg-warning text-dark';
                                        $statusText = 'Low';
                                    }
                                @endphp
                                <tr>
                                    <td style='font-size: 0.9rem; font-weight: 500;'>{{ $part->part_no }} -
                                        {{ $part->description }}
                                    </td>
                                    <td style='font-size: 0.9rem; font-weight: 500;'>{{ $stock }}</td>
                                    <td><span class='badge {{ $statusClass }}'
                                            style='font-size: 0.85rem;'>{{ $statusText }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan='3' class='text-center text-muted'>No low stock items</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Transactions (Replacing Top Performing Staff for now if data missing) -->
            <div class="card-box div17">
                <div class="section-title">Recent Transactions</div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Report ID</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaction)
                                <tr>
                                    <td>#{{ $transaction->service_report_id }}</td>
                                    <td>₱{{ number_format($transaction->total_amount, 2) }}</td>
                                    <td><span class="badge bg-success">{{ $transaction->payment_status }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No recent transactions</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Placeholder Charts - Real data would need to be passed from controller
            const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctxRevenue, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Revenue',
                        data: [12000, 19000, 3000, 5000, 2000, 3000],
                        borderColor: '#4c7cf3',
                        tension: 0.4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            const ctxServices = document.getElementById('serviceTypesChart').getContext('2d');
            new Chart(ctxServices, {
                type: 'doughnut',
                data: {
                    labels: ['Repair', 'Maintenance', 'Installation'],
                    datasets: [{
                        data: [300, 50, 100],
                        backgroundColor: ['#4c7cf3', '#2bcd72', '#ffc107']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        </script>
    @endpush
@endsection