@extends('layouts.app')

@php
    use App\Helpers\DashboardData;
    $cards = DashboardData::getCards();
    $topProducts = DashboardData::getTopProducts();
    $topCategories = DashboardData::getTopCategories();
@endphp

@section('content')
    <div class="w-full p-5">
        <!-- Title + Filter -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Dashboard</h1>
                <p class="text-xs text-gray-500">Welcome back, {{ auth()->user()->name }}</p>
            </div>
            <div class="flex items-center gap-3 mt-3 sm:mt-0">
                <div
                    class="bg-white flex items-center text-xs gap-2 px-3 py-2 border border-gray-300/90 rounded-md hover:bg-gray-50 transition cursor-pointer">
                    <i class="fa-regular fa-calendar text-gray-800"></i>
                    <span class="text-xs text-gray-700">Nov 19, 2023 - Nov 26, 2023</span>
                    <i class="fa-solid fa-chevron-down text-gray-700"></i>
                </div>
                <button class="bg-white text-gray-600 flex text-center gap-2 px-3 py-2 text-xs border border-gray-300/90 rounded-md hover:bg-gray-50 transition">
                    <x-heroicon-o-arrow-down-tray class="w-4 h-4" /> Export
                </button>
            </div>
        </div>

        <!-- 4 Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
            @foreach ($cards as $card)
                <div
                    class="bg-white p-3 rounded-md shadow-xs border border-gray-300/40 flex flex-col justify-between relative overflow-hidden h-32">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="rounded-md p-2 px-3"
                                style="background-color: {{ $card['iconBg'] === 'transparent' ? 'transparent' : $card['iconBg'] . '20' }};">
                                <i class="{{ $card['icon'] }} text-[18px]" style="color: {{ $card['iconColor'] }};"></i>
                            </div>
                            <p class="text-xs font-semibold text-gray-600 uppercase">{{ $card['title'] }}</p>
                        </div>
                        <button class="text-gray-600 hover:text-gray-600">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                    </div>
                    <div class="flex flex-col items-start gap-1">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $card['value'] }}</h2>
                        <div class="flex items-center gap-1 text-xs">
                            <span
                                class="font-semibold {{ $card['trend'] === 'up' ? 'text-green-500' : 'text-red-500' }} flex items-center gap-0.5">
                                <i class="fa-solid fa-arrow-trend-{{ $card['trend'] }}"></i> {{ $card['percentage'] }}
                            </span>
                            <span class="text-gray-600">{{ $card['period'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        <div class="flex gap-4 w-full min-w-0">

            {{-- ============== SALES OVERVIEW (line chart) ============== --}}
            <div class="w-2/3 min-w-0 bg-white rounded-2xl shadow-sm p-5 overflow-hidden">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-[15px] font-semibold text-gray-900">Sales Overview</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <circle cx="12" cy="5" r="1.6" />
                            <circle cx="12" cy="12" r="1.6" />
                            <circle cx="12" cy="19" r="1.6" />
                        </svg>
                    </button>
                </div>
                {{-- fixed pixel height is required here — Chart.js + an unbounded
             flex container causes an infinite resize loop that breaks the page --}}
                <div class="relative min-w-0" style="height: 180px;">
                    <canvas id="salesOverviewChart"></canvas>
                    {{-- floating tooltip, positioned by JS to sit above the highlighted point --}}
                    <div id="salesTooltip"
                        class="hidden absolute -translate-x-1/2 -translate-y-full bg-gray-900 text-white text-xs rounded-lg px-3 py-2 shadow-lg whitespace-nowrap pointer-events-none">
                        <div class="text-gray-300 text-[11px] leading-tight">June 2023</div>
                        <div class="font-semibold text-[13px] leading-tight">16,5K</div>
                        <div class="absolute left-1/2 -bottom-1 -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45"></div>
                    </div>
                </div>
            </div>

            {{-- ============== PAYMENT (donut chart) ============== --}}
            <div class="w-1/3 min-w-0 bg-white rounded-2xl shadow-sm p-5 overflow-hidden">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-[15px] font-semibold text-gray-900">Payment</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <circle cx="12" cy="5" r="1.6" />
                            <circle cx="12" cy="12" r="1.6" />
                            <circle cx="12" cy="19" r="1.6" />
                        </svg>
                    </button>
                </div>
                <div class="relative min-w-0" style="height: 150px;">
                    <canvas id="paymentChart"></canvas>
                </div>
                <div class="flex items-center justify-center gap-4 mt-2">
                    <span class="flex items-center gap-2 text-[11px] text-gray-600">
                        <span class="w-2.5 h-2.5 rounded-full" style="background:#a262e0"></span> Cash
                    </span>
                    <span class="flex items-center gap-2 text-[11px] text-gray-600">
                        <span class="w-2.5 h-2.5 rounded-full" style="background:#c9a3ec"></span> Credit/Debit
                    </span>
                    <span class="flex items-center gap-2 text-[11px] text-gray-600">
                        <span class="w-2.5 h-2.5 rounded-full" style="background:#e9d9f8"></span> KHQR
                    </span>
                </div>
            </div>

        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // ---------- SALES OVERVIEW LINE CHART ----------
                const salesCtx = document.getElementById('salesOverviewChart').getContext('2d');

                const gradient = salesCtx.createLinearGradient(0, 0, 0, 180);
                gradient.addColorStop(0, 'rgba(249, 115, 22, 0.25)');
                gradient.addColorStop(1, 'rgba(249, 115, 22, 0)');

                const labels = ['May', '', 'Jun', '', 'Jul', '', 'Aug', '', 'Sep', '', 'Oct', '', 'Nov', ''];
                const data = [20000, 14000, 14500, 10000, 15500, 19000, 22000, 18500, 16500, 15500, 12000, 23000, 15500,
                    11000
                ];
                const highlightIndex = 8; // the "Sep / 16,5K" point

                const salesChart = new Chart(salesCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            borderColor: '#f97316',
                            borderWidth: 2.5,
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.35,
                            pointRadius: (ctx) => ctx.dataIndex === highlightIndex ? 5 : 0,
                            pointHoverRadius: 5,
                            pointBackgroundColor: '#f97316',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            }, // using the custom HTML tooltip instead
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
                                    },
                                    autoSkip: false,
                                },
                                border: {
                                    display: false
                                },
                            },
                            y: {
                                min: 0,
                                max: 25000,
                                ticks: {
                                    stepSize: 5000,
                                    color: '#9ca3af',
                                    font: {
                                        size: 11
                                    },
                                    callback: (val) => val === 0 ? '0' : (val / 1000) + 'k',
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
                    },
                    plugins: [{
                        // positions the custom HTML tooltip over the highlighted point
                        id: 'staticTooltipPositioner',
                        afterDraw: (chart) => {
                            const meta = chart.getDatasetMeta(0);
                            const point = meta.data[highlightIndex];
                            const tooltip = document.getElementById('salesTooltip');
                            if (point && tooltip) {
                                tooltip.style.left = point.x + 'px';
                                tooltip.style.top = (point.y - 10) + 'px';
                                tooltip.classList.remove('hidden');
                            }
                        }
                    }]
                });

                // ---------- PAYMENT DONUT CHART ----------
                const paymentCtx = document.getElementById('paymentChart').getContext('2d');

                const paymentData = [55, 30, 15]; // Cash, Credit/Debit, QRIS
                const paymentColors = ['#a262e0', '#c9a3ec', '#e9d9f8'];

                const paymentChart = new Chart(paymentCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Cash', 'Credit/Debit', 'QRIS'],
                        datasets: [{
                            data: paymentData,
                            backgroundColor: paymentColors,
                            borderWidth: 0,
                            cutout: '68%',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: 28
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: true
                            },
                        }
                    },
                    plugins: [{
                        // draws leader-line labels (e.g. "55", "30", "15") around the donut
                        id: 'donutLeaderLabels',
                        afterDraw(chart) {
                            const {
                                ctx,
                                chartArea
                            } = chart;
                            const meta = chart.getDatasetMeta(0);
                            const cx = (chartArea.left + chartArea.right) / 2;
                            const cy = (chartArea.top + chartArea.bottom) / 2;

                            ctx.save();
                            ctx.font = '600 12px sans-serif';
                            ctx.fillStyle = '#374151';
                            ctx.strokeStyle = '#9ca3af';
                            ctx.lineWidth = 1;

                            meta.data.forEach((arc, i) => {
                                const angle = (arc.startAngle + arc.endAngle) / 2;
                                const outerR = arc.outerRadius;

                                const startX = cx + Math.cos(angle) * outerR;
                                const startY = cy + Math.sin(angle) * outerR;
                                const midX = cx + Math.cos(angle) * (outerR + 16);
                                const midY = cy + Math.sin(angle) * (outerR + 16);
                                const dir = Math.cos(angle) >= 0 ? 1 : -1;
                                const endX = midX + dir * 14;

                                ctx.beginPath();
                                ctx.moveTo(startX, startY);
                                ctx.lineTo(midX, midY);
                                ctx.lineTo(endX, midY);
                                ctx.stroke();

                                ctx.textAlign = dir === 1 ? 'left' : 'right';
                                ctx.textBaseline = 'middle';
                                ctx.fillText(paymentData[i], endX + dir * 4, midY);
                            });

                            ctx.restore();
                        }
                    }]
                });
            });
        </script>
        <!-- Top Products / Top Categories with Tabs -->
        <div class="bg-white p-4 mt-4 rounded-md shadow-sm border border-gray-200">

            <!-- Header Row: Tabs + View All + Search -->
            <div class="flex flex-wrap items-center gap-3 mb-4 border-b border-gray-200 pb-2">
                <div class="flex items-center gap-6">
                    <button class="text-sm font-semibold text-[#0F6E8C] transition" id="tabProducts">
                        Top Products
                    </button>
                    <button class=" text-sm font-medium text-gray-500 hover:text-gray-600 transition" id="tabCategories">
                        Top Categories
                    </button>
                </div>

                <div class="flex items-center gap-3 ml-auto">
                    <div class="relative">
                        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" id="searchInput" placeholder="Search..."
                            class="pl-8 pr-3 py-1 text-xs border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                    </div>
                    <a href="#" class="text-xs text-[#0F6E8C] hover:underline font-medium whitespace-nowrap"
                        id="viewAllLink">View All Products →</a>
                </div>
            </div>

            <!-- Products Table -->
            <div id="productsTable">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                <th class="pb-2 font-medium w-10"><span
                                        class="bg-gray-200/70 px-3 py- mr-2  rounded">No</span>
                                </th>
                                <th class="pb-2 font-medium">Product</th>
                                <th class="pb-2 font-medium w-20 text-right">Price</th>
                                <th class="pb-2 font-medium w-16 text-center">Sold</th>
                                <th class="pb-2 font-medium w-24 text-right">Revenue</th>
                                <th class="pb-2 font-medium w-36">Rank</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($topProducts as $product)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3">
                                        <span
                                            class="text-sm font-bold {{ $product['rank'] === 1 ? 'text-yellow-500   ' : ($product['rank'] === 2 ? 'text-p' : ($product['rank'] === 3 ? 'text-brown-200' : 'text-gray-500')) }}">
                                            #{{ $product['rank'] }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 bg-gray-200 rounded overflow-hidden shrink-0">
                                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $product['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-right text-gray-600">${{ number_format($product['price'], 2) }}
                                    </td>
                                    <td class="py-3 text-center text-gray-600">{{ $product['sold'] }}</td>
                                    <td class="py-3 text-right font-medium text-gray-800 pr-2">
                                        ${{ number_format($product['revenue']) }}</td>
                                    <td class="py-3 w-48 ">
                                        <div class="flex items-center gap-2">
                                            <div class="w-48 h-2 bg-gray-200 rounded-l-full">
                                                <div class="h-2 bg-[#0F6E8C] rounded-l-full"
                                                    style="width: {{ $product['percent'] }}%;"></div>
                                            </div>
                                            <span
                                                class="text-xs text-gray-400 w-8 text-right">{{ $product['percent'] }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-400 text-sm">No products found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Categories Table (hidden by default) -->
            <div id="categoriesTable" class="hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                                <th class="pb-2 font-medium w-10"><span
                                        class="bg-gray-200/70 px-3 py- mr-2  rounded">No</span>
                                </th>
                                <th class="pb-2 font-medium">Category</th>
                                <th class="pb-2 font-medium w-20 text-right">Products</th>
                                <th class="pb-2 font-medium w-24 text-right">Revenue</th>
                                <th class="pb-2 font-medium w-36">Rank</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($topCategories as $category)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3">
                                        <span
                                            class="text-sm font-bold {{ $category['rank'] === 1 ? 'text-yellow-500' : ($category['rank'] === 2 ? 'text-p' : ($category['rank'] === 3 ? 'text-brown-200' : 'text-gray-500')) }}">
                                            #{{ $category['rank'] }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-12 h-12 bg-[#0F6E8C]/10 rounded flex items-center justify-center shrink-0">
                                                <i class="fa-solid {{ $category['icon'] }} text-[#0F6E8C]"></i>
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $category['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-right text-gray-600">{{ $category['products'] }}</td>
                                    <td class="py-3 text-right font-medium text-gray-800">
                                        ${{ number_format($category['revenue']) }}</td>
                                    <td class="py-3 w-48 ml-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-48 flex-1 h-2 bg-gray-200 rounded-l-full">
                                                <div class="h-2 bg-[#0F6E8C] rounded-l-full"
                                                    style="width: {{ $category['percent'] }}%;"></div>
                                            </div>
                                            <span
                                                class="text-xs text-gray-400 w-8 text-right">{{ $category['percent'] }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-400 text-sm">No categories found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <script>
            const tabProducts = document.getElementById('tabProducts');
            const tabCategories = document.getElementById('tabCategories');
            const productsTable = document.getElementById('productsTable');
            const categoriesTable = document.getElementById('categoriesTable');
            const viewAllLink = document.getElementById('viewAllLink');

            function switchTab(tab) {
                if (tab === 'products') {
                    tabProducts.classList.add('text-[#0F6E8C]', 'border-[#0F6E8C]', 'font-semibold');
                    tabProducts.classList.remove('text-gray-500', 'font-medium');
                    tabCategories.classList.remove('text-[#0F6E8C]', 'border-[#0F6E8C]', 'font-semibold');
                    tabCategories.classList.add('text-gray-500', 'font-medium');
                    productsTable.classList.remove('hidden');
                    categoriesTable.classList.add('hidden');
                    viewAllLink.textContent = 'View All Products →';
                    viewAllLink.href = '#products';
                } else {
                    tabCategories.classList.add('text-[#0F6E8C]', 'border-[#0F6E8C]', 'font-semibold');
                    tabCategories.classList.remove('text-gray-500', 'font-medium');
                    tabProducts.classList.remove('text-[#0F6E8C]', 'border-[#0F6E8C]', 'font-semibold');
                    tabProducts.classList.add('text-gray-500', 'font-medium');
                    categoriesTable.classList.remove('hidden');
                    productsTable.classList.add('hidden');
                    viewAllLink.textContent = 'View All Categories →';
                    viewAllLink.href = '#categories';
                }
            }

            tabProducts.addEventListener('click', () => switchTab('products'));
            tabCategories.addEventListener('click', () => switchTab('categories'));

            // Search functionality
            document.getElementById('searchInput').addEventListener('keyup', function() {
                const search = this.value.toLowerCase();
                const activeTab = productsTable.classList.contains('hidden') ? 'categories' : 'products';
                const rows = document.querySelectorAll(activeTab === 'products' ? '#productsTable tbody tr' :
                    '#categoriesTable tbody tr');
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(search) ? '' : 'none';
                });
            });
        </script>

    </div>
@endsection
