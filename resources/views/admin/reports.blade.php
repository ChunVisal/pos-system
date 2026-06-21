@extends('layouts.app')

@php
    use App\Helpers\ReportData;
    $summary = ReportData::getSummary();
    $trend = ReportData::getRevenueTrend();
    $dailySales = ReportData::getDailySales();
    $topItems = ReportData::getTopItems();
    $salespeople = ReportData::getSalesBySalesperson();
    $payments = ReportData::getPaymentBreakdown();
    $inventorySummary = ReportData::getInventorySummary();
    $stockByCategory = ReportData::getStockByCategory();
@endphp

@section('content')
    <div class="w-full p-5">

        <!-- Title + Date Range + Export -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Reports</h1>
                <p class="text-xs text-gray-500">Sales, inventory, and staff performance insights</p>
            </div>
            <div class="flex items-center gap-2 mt-3 sm:mt-0">
                <div class="relative">
                    <select
                        class="bg-white appearance-none text-xs border border-gray-300 rounded-md pl-3 pr-8 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                        <option>Today</option>
                        <option>Yesterday</option>
                        <option selected>Last 7 Days</option>
                        <option>This Month</option>
                        <option>Last Month</option>
                        <option>Custom Range</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor"
                        class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
                <button
                    class="bg-white inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50 transition">
                    <x-heroicon-m-arrow-down-tray class="w-4 h-4" />
                    Export
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
            <div class="bg-white p-3 rounded-md shadow-xs border border-gray-300/40 flex flex-col justify-between h-32">
                <div class="flex items-center gap-2">
                    <div class="rounded-md p-2 px-3" style="background-color:#10B98120;">
                        <i class="fa-solid fa-dollar-sign text-[18px]" style="color:#10B981;"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 uppercase">Total Revenue</p>
                </div>
                <div class="flex flex-col items-start gap-1">
                    <h2 class="text-2xl font-bold text-gray-800">${{ number_format($summary['total_revenue']) }}</h2>
                    <div class="flex items-center gap-1 text-xs">
                        <span
                            class="font-semibold {{ $summary['revenue_trend'] === 'up' ? 'text-green-500' : 'text-red-500' }} flex items-center gap-0.5">
                            <i class="fa-solid fa-arrow-trend-{{ $summary['revenue_trend'] }}"></i>
                            {{ $summary['revenue_change'] }}
                        </span>
                        <span class="text-gray-600">vs previous period</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-3 rounded-md shadow-xs border border-gray-300/40 flex flex-col justify-between h-32">
                <div class="flex items-center gap-2">
                    <div class="rounded-md p-2 px-3" style="background-color:#8B5CF620;">
                        <i class="fa-solid fa-receipt text-[18px]" style="color:#8B5CF6;"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 uppercase">Transactions</p>
                </div>
                <div class="flex flex-col items-start gap-1">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $summary['total_transactions'] }}</h2>
                    <div class="flex items-center gap-1 text-xs">
                        <span
                            class="font-semibold {{ $summary['transactions_trend'] === 'up' ? 'text-green-500' : 'text-red-500' }} flex items-center gap-0.5">
                            <i class="fa-solid fa-arrow-trend-{{ $summary['transactions_trend'] }}"></i>
                            {{ $summary['transactions_change'] }}
                        </span>
                        <span class="text-gray-600">vs previous period</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-3 rounded-md shadow-xs border border-gray-300/40 flex flex-col justify-between h-32">
                <div class="flex items-center gap-2">
                    <div class="rounded-md p-2 px-3" style="background-color:#0F6E8C20;">
                        <i class="fa-solid fa-chart-simple text-[18px]" style="color:#0F6E8C;"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 uppercase">Avg Sale Value</p>
                </div>
                <div class="flex flex-col items-start gap-1">
                    <h2 class="text-2xl font-bold text-gray-800">${{ number_format($summary['avg_sale'], 2) }}</h2>
                    <div class="flex items-center gap-1 text-xs">
                        <span
                            class="font-semibold {{ $summary['avg_trend'] === 'up' ? 'text-green-500' : 'text-red-500' }} flex items-center gap-0.5">
                            <i class="fa-solid fa-arrow-trend-{{ $summary['avg_trend'] }}"></i>
                            {{ $summary['avg_change'] }}
                        </span>
                        <span class="text-gray-600">vs previous period</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-3 rounded-md shadow-xs border border-gray-300/40 flex flex-col justify-between h-32">
                <div class="flex items-center gap-2">
                    <div class="rounded-md p-2 px-3" style="background-color:#F59E0B20;">
                        <i class="fa-solid fa-box-open text-[18px]" style="color:#D97706;"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 uppercase">Items Sold</p>
                </div>
                <div class="flex flex-col items-start gap-1">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $summary['items_sold'] }}</h2>
                    <div class="flex items-center gap-1 text-xs">
                        <span
                            class="font-semibold {{ $summary['items_trend'] === 'up' ? 'text-green-500' : 'text-red-500' }} flex items-center gap-0.5">
                            <i class="fa-solid fa-arrow-trend-{{ $summary['items_trend'] }}"></i>
                            {{ $summary['items_change'] }}
                        </span>
                        <span class="text-gray-600">vs previous period</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-md shadow-sm border border-gray-200">
            <div class="flex items-center gap-6 md:gap-10 border-b border-gray-200 px-4 pt-3">
                <button class="report-tab text-sm font-semibold text-[#0F6E8C] border-b-2 border-[#0F6E8C] pb-3"
                    data-tab="sales">
                    Sales Trend
                </button>
                <button
                    class="report-tab text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent pb-3"
                    data-tab="items">
                    Top Items
                </button>
                <button
                    class="report-tab text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent pb-3"
                    data-tab="payment">
                    Payment Report
                </button>
                <button
                    class="report-tab text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent pb-3"
                    data-tab="staff">
                    Cashier Report
                </button>
                <button
                    class="report-tab text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent pb-3"
                    data-tab="inventory">
                    Inventory
                </button>
            </div>

            <!-- ============== SALES TREND TAB ============== -->
            <div id="tab-sales" class="report-panel p-4">
                <div class="relative min-w-0 mb-5" style="height: 260px;">
                    <canvas id="revenueTrendChart"></canvas>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                <th class="pb-2 pr-4 font-medium">Date</th>
                                <th class="pb-2 px-4 font-medium text-center">Transactions</th>
                                <th class="pb-2 px-4 font-medium text-center">Items Sold</th>
                                <th class="pb-2 px-4 font-medium text-right">Avg Sale</th>
                                <th class="pb-2 pl-4 font-medium text-right">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($dailySales as $row)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 pr-4 text-gray-800 font-medium">
                                        {{ \Carbon\Carbon::parse($row['date'])->format('M d, Y') }}</td>
                                    <td class="py-3 px-4 text-center text-gray-600">{{ $row['transactions'] }}</td>
                                    <td class="py-3 px-4 text-center text-gray-600">{{ $row['items_sold'] }}</td>
                                    <td class="py-3 px-4 text-right text-gray-600">
                                        ${{ number_format($row['avg_sale'], 2) }}</td>
                                    <td class="py-3 pl-4 text-right font-semibold text-gray-800">
                                        ${{ number_format($row['revenue'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ============== TOP ITEMS TAB ============== -->
            <div id="tab-items" class="report-panel p-4 hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                <th class="pb-2 pr-4 font-medium w-10">Rank</th>
                                <th class="pb-2 px-4 font-medium">Product</th>
                                <th class="pb-2 px-4 font-medium">Category</th>
                                <th class="pb-2 px-4 font-medium text-center">Qty Sold</th>
                                <th class="pb-2 px-4 font-medium text-right">Revenue</th>
                                <th class="pb-2 pl-4 font-medium w-40">Share</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($topItems as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 pr-4">
                                        <span
                                            class="text-sm font-bold {{ $item['rank'] === 1 ? 'text-yellow-500' : 'text-gray-500' }}">#{{ $item['rank'] }}</span>
                                    </td>
                                    <td class="py-3 px-4 font-medium text-gray-800">{{ $item['name'] }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $item['category'] }}</td>
                                    <td class="py-3 px-4 text-center text-gray-600">{{ $item['qty_sold'] }}</td>
                                    <td class="py-3 px-4 text-right font-semibold text-gray-800">
                                        ${{ number_format($item['revenue'], 2) }}</td>
                                    <td class="py-3 pl-4">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 h-1.5 bg-gray-200 rounded-full">
                                                <div class="h-1.5 bg-[#0F6E8C] rounded-full"
                                                    style="width: {{ $item['percent'] }}%;"></div>
                                            </div>
                                            <span
                                                class="text-xs text-gray-400 w-8 text-right">{{ $item['percent'] }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ============== PAYMENT REPORT TAB ============== -->
            <div id="tab-payment" class="report-panel p-4 hidden">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="md:w-64 shrink-0">
                        <div class="relative min-w-0" style="height: 220px;">
                            <canvas id="paymentReportChart"></canvas>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                    <th class="pb-2 pr-4 font-medium">Payment Method</th>
                                    <th class="pb-2 px-4 font-medium text-center">Transactions</th>
                                    <th class="pb-2 px-4 font-medium text-right">Amount</th>
                                    <th class="pb-2 pl-4 font-medium w-40">Share</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($payments as $payment)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-3 pr-4">
                                            <span class="flex items-center gap-2 font-medium text-gray-800">
                                                <span class="w-2.5 h-2.5 rounded-full"
                                                    style="background-color: {{ $payment['color'] }};"></span>
                                                {{ $payment['method'] }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center text-gray-600">{{ $payment['transactions'] }}
                                        </td>
                                        <td class="py-3 px-4 text-right font-semibold text-gray-800">
                                            ${{ number_format($payment['amount'], 2) }}</td>
                                        <td class="py-3 pl-4">
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 h-1.5 bg-gray-200 rounded-full">
                                                    <div class="h-1.5 rounded-full"
                                                        style="width: {{ $payment['percent'] }}%; background-color: {{ $payment['color'] }};">
                                                    </div>
                                                </div>
                                                <span
                                                    class="text-xs text-gray-400 w-8 text-right">{{ $payment['percent'] }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ============== SALESPERSON TAB ============== -->
            <div id="tab-staff" class="report-panel p-4 hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                <th class="pb-2 pr-4 font-medium">Salesperson</th>
                                <th class="pb-2 px-4 font-medium text-center">Transactions</th>
                                <th class="pb-2 px-4 font-medium">Top Item</th>
                                <th class="pb-2 px-4 font-medium text-right">Revenue</th>
                                <th class="pb-2 pl-4 font-medium w-40">Share</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($salespeople as $person)
                                @php
                                    $initials = collect(explode(' ', $person['name']))
                                        ->map(fn($n) => strtoupper($n[0]))
                                        ->take(2)
                                        ->implode('');
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 pr-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-[#0F6E8C] flex items-center justify-center text-[11px] font-semibold text-white shrink-0">
                                                {{ $initials }}
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $person['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-center text-gray-600">{{ $person['transactions'] }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $person['top_item'] }}</td>
                                    <td class="py-3 px-4 text-right font-semibold text-gray-800">
                                        ${{ number_format($person['revenue'], 2) }}</td>
                                    <td class="py-3 pl-4">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 h-1.5 bg-gray-200 rounded-full">
                                                <div class="h-1.5 bg-[#0F6E8C] rounded-full"
                                                    style="width: {{ $person['percent'] }}%;"></div>
                                            </div>
                                            <span
                                                class="text-xs text-gray-400 w-8 text-right">{{ $person['percent'] }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ============== INVENTORY TAB ============== -->
            <div id="tab-inventory" class="report-panel p-4 hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-5">
                    <div class="bg-gray-50 rounded-md p-3 border border-gray-200">
                        <p class="text-xs text-gray-500 mb-1">Total Stock Value</p>
                        <p class="text-xl font-bold text-gray-800">
                            ${{ number_format($inventorySummary['total_stock_value']) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-md p-3 border border-gray-200">
                        <p class="text-xs text-gray-500 mb-1">Low Stock Items</p>
                        <p class="text-xl font-bold text-amber-600">{{ $inventorySummary['low_stock'] }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-md p-3 border border-gray-200">
                        <p class="text-xs text-gray-500 mb-1">Out of Stock</p>
                        <p class="text-xl font-bold text-red-600">{{ $inventorySummary['out_of_stock'] }}</p>
                    </div>
                </div>

                <h4 class="text-xs font-semibold text-gray-600 uppercase mb-2">Stock Value by Category</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                <th class="pb-2 pr-4 font-medium">Category</th>
                                <th class="pb-2 px-4 font-medium text-center">Products</th>
                                <th class="pb-2 px-4 font-medium text-center">Units in Stock</th>
                                <th class="pb-2 pl-4 font-medium text-right">Stock Value</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($stockByCategory as $row)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 pr-4 font-medium text-gray-800">{{ $row['category'] }}</td>
                                    <td class="py-3 px-4 text-center text-gray-600">{{ $row['products'] }}</td>
                                    <td class="py-3 px-4 text-center text-gray-600">{{ $row['total_stock'] }}</td>
                                    <td class="py-3 pl-4 text-right font-semibold text-gray-800">
                                        ${{ number_format($row['stock_value'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ---------- TAB SWITCHING ----------
            const tabs = document.querySelectorAll('.report-tab');
            const panels = document.querySelectorAll('.report-panel');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => {
                        t.classList.remove('text-[#0F6E8C]', 'border-[#0F6E8C]',
                            'font-semibold');
                        t.classList.add('text-gray-500', 'font-medium',
                            'border-transparent');
                    });
                    tab.classList.add('text-[#0F6E8C]', 'border-[#0F6E8C]', 'font-semibold');
                    tab.classList.remove('text-gray-500', 'font-medium', 'border-transparent');

                    panels.forEach(p => p.classList.add('hidden'));
                    document.getElementById('tab-' + tab.dataset.tab).classList.remove('hidden');
                });
            });

            // ---------- REVENUE TREND CHART ----------
            const revenueCanvas = document.getElementById('revenueTrendChart');
            const existing = Chart.getChart(revenueCanvas);
            if (existing) existing.destroy();

            const ctx = revenueCanvas.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 220);
            gradient.addColorStop(0, 'rgba(15, 110, 140, 0.25)');
            gradient.addColorStop(1, 'rgba(15, 110, 140, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($trend['labels']),
                    datasets: [{
                        label: 'Revenue',
                        data: @json($trend['revenue']),
                        borderColor: '#0F6E8C',
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3,
                        pointBackgroundColor: '#0F6E8C',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 1.5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    resizeDelay: 100,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: (ctx) => '$' + ctx.parsed.y.toLocaleString()
                            }
                        },
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#9ca3af',
                                font: {
                                    size: 11
                                }
                            },
                            border: {
                                display: false
                            },
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#9ca3af',
                                font: {
                                    size: 11
                                },
                                callback: (val) => '$' + (val / 1000) + 'k',
                            },
                            grid: {
                                color: '#eef0f2',
                                borderDash: [4, 4]
                            },
                            border: {
                                display: false
                            },
                        }
                    }
                }
            });
            // ---------- PAYMENT REPORT DONUT CHART ----------
            const paymentCanvas = document.getElementById('paymentReportChart');
            const existingPayment = Chart.getChart(paymentCanvas);
            if (existingPayment) existingPayment.destroy();

            new Chart(paymentCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: @json(collect($payments)->pluck('method')),
                    datasets: [{
                        data: @json(collect($payments)->pluck('amount')),
                        backgroundColor: @json(collect($payments)->pluck('color')),
                        borderWidth: 0,
                        cutout: '68%',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    resizeDelay: 100,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => ctx.label + ': $' + ctx.parsed.toLocaleString()
                            }
                        },
                    }
                }
            });
        });
    </script>
@endsection
