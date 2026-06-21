@extends('layouts.app')

@php
    use App\Helpers\InventoryData;
    $summary = InventoryData::getSummary();
    $summaryCards = InventoryData::getSummaryCards();
    $items = InventoryData::getStockItems();
    $movements = InventoryData::getMovements();
    $trend = InventoryData::getMovementTrend();
    $categories = \App\Helpers\ProductData::getCategories();
@endphp

@section('content')
    <div class="w-full p-5" x-data="inventoryPage()">

        <!-- Title + Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">

            <div>
                <h1 class="text-xl font-bold text-gray-800">Inventory</h1>
                <p class="text-xs text-gray-500">Track stock levels and movement across your catalog</p>
            </div>
            <div class="flex items-center gap-2">
                <div
                    class="bg-white flex items-center text-xs gap-2 px-3 py-2 border border-gray-300/90 rounded-md hover:bg-gray-50 transition cursor-pointer">
                    <i class="fa-regular fa-calendar text-gray-800"></i>
                    <span class="text-xs text-gray-700">Nov 19, 2023 - Nov 26, 2023</span>
                    <i class="fa-solid fa-chevron-down text-gray-700"></i>
                </div>
                <button
                    class="bg-white inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50 transition">
                    <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
                    Export
                </button>
            </div>
        </div>

        <!-- Stock Movement Chart + Summary Cards -->
        <div class="flex gap-2 w-full min-w-0 mb-4">

            <!-- Stock Movement Overview (chart) -->
            <div class="w-[65%] min-w-0 bg-white rounded-md shadow-sm border border-gray-200 p-4">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800">Stock Movement Overview</h3>
                        <p class="text-xs text-gray-400">Stock In vs Stock Out — last 7 days</p>
                    </div>
                    <div class="flex items-center gap-3 text-[11px] text-gray-500">
                        <span class="flex items-center gap-1.5"><span
                                class="w-2.5 h-2.5 rounded-full bg-[#10B981]"></span>Stock In</span>
                        <span class="flex items-center gap-1.5"><span
                                class="w-2.5 h-2.5 rounded-full bg-[#EF4444]"></span>Stock Out</span>
                    </div>
                </div>
                <div class="relative min-w-0" style="height: 260px;">
                    <canvas id="movementTrendChart"></canvas>
                </div>
            </div>
            <!-- Summary Cards (2 col x 2 row, stretches to match chart card height) -->
            <div class="w-[35%] min-w-0 grid grid-cols-2 grid-rows-2 gap-2">
                @foreach ($summaryCards as $card)
                    <div
                        class="bg-white p-3 rounded-md shadow-xs border border-gray-300/40 flex flex-col justify-between relative overflow-hidden">
                        <div class="flex flex-col items-start gap-1.5 xl:flex-row xl:items-center 2xl:gap-2">
                            <div class="rounded-md p-2 px-3 shrink-0"
                                style="background-color: {{ $card['iconBg'] === 'transparent' ? 'transparent' : $card['iconBg'] . '20' }};">
                                <i class="{{ $card['icon'] }} text-[16px]" style="color: {{ $card['iconColor'] }};"></i>
                            </div>
                            <p class="text-[11px] font-semibold text-gray-600 uppercase leading-tight">{{ $card['title'] }}
                            </p>
                        </div>
                        <div class="flex flex-col items-start gap-1 ">
                            <h2 class="text-xl font-bold text-gray-800">{{ $card['value'] }}</h2>
                            <div class="flex items-start gap-1 text-[12px]">
                                <span
                                    class="font-semibold {{ $card['trend'] === 'up' ? 'text-green-500' : 'text-red-500' }} flex items-center gap-0.5">
                                    <i class="fa-solid fa-arrow-trend-{{ $card['trend'] }}"></i> {{ $card['percentage'] }}
                                </span>
                                <span class="text-gray-500 whitespace-nowrap">{{ $card['period'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <!-- Filters -->
        <div class=" flex flex-wrap items-center gap-3 mb-4">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" placeholder="Search by product name or code..."
                    class="w-full pl-8 pr-3 py-1.5 text-xs border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
            </div>
            <div class="relative">
                <select
                    class="bg-white appearance-none text-xs border border-gray-300 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category['code'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
                <x-heroicon-o-chevron-down
                    class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" />
            </div>
            <div class="relative">
                <select
                    class="bg-white appearance-none text-xs border border-gray-300 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                    <option value="">All Stock Status</option>
                    <option value="low">Low Stock</option>
                    <option value="out">Out of Stock</option>
                    <option value="normal">In Stock</option>
                </select>
                <x-heroicon-o-chevron-down
                    class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" />
            </div>
            <button @click="openAdjust()"
                class="inline-flex items-center gap-2 px-4 py-1.5 text-xs font-medium text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">
                <i class="fa-solid fa-plus"></i> Stock Adjustment
            </button>
        </div>

        <!-- Stock Table -->
        <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200 mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs text-gray-500 border-b border-gray-200 whitespace-nowrap">
                            <th class="pb-2 pr-4 font-medium">Product</th>
                            <th class="pb-2 px-4 font-medium">Category</th>
                            <th class="pb-2 px-4 font-medium text-center">Current Stock</th>
                            <th class="pb-2 px-4 font-medium text-center">Reorder Level</th>
                            <th class="pb-2 px-4 font-medium text-center">Status</th>
                            <th class="pb-2 px-4 font-medium">Last Updated</th>
                            <th class="pb-2 pl-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($items as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 pr-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxolXBpybqOuVoJXLQE2SB0buq-Gq48WnKnB0h9AD5hKYyruRDcNa0ZNXJ&s=10"
                                            class="w-12 h-12  bg-[#0F6E8C]/10 rounded-xs items-center justify-center shrink-0" />
                                        <div>
                                            <p class="font-medium text-gray-800 line-clamp-3">{{ $item['name'] }}</p>
                                            <p class="text-xs text-gray-400">{{ $item['code'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 pl-4 text-gray-600  whitespace-nowrap">{{ $item['category_name'] }}</td>
                                <td class="py-3 text-center font-semibold text-gray-800">{{ $item['stock'] }}</td>
                                <td class="py-3 text-center text-gray-500">{{ $item['reorder_level'] }}</td>
                                <td class="py-3 text-center whitespace-nowrap">
                                    @if ($item['stock'] <= 0)
                                        <span
                                            class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-red-50 text-red-600">Out
                                            of stock</span>
                                    @elseif($item['stock'] < $item['reorder_level'])
                                        <span
                                            class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-amber-50 text-amber-600">Low
                                            stock</span>
                                    @else
                                        <span
                                            class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-green-50 text-green-600">In
                                            stock</span>
                                    @endif
                                </td>
                                <td class="py-3 pl-4 text-gray-500 text-xs">
                                    {{ \Carbon\Carbon::parse($item['last_updated'])->format('M d, Y') }}</td>
                                <td class="py-3">
                                    <div class="flex items-center justify-end gap-3">
                                        <button @click='openAdjust(@json($item))'
                                            class="text-gray-400 hover:text-[#0F6E8C]" title="Adjust Stock">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-400 text-sm">No inventory items found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ============== STOCK ADJUSTMENT SLIDE-OVER PANEL ============== -->
        <div x-show="open" x-cloak class="fixed inset-0 z-50" style="display: none;">
            <div x-show="open" x-transition.opacity @click="closePanel()" class="absolute inset-0 bg-gray-900/40"></div>

            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-xl flex flex-col">

                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-800">Stock Adjustment</h2>
                    <button @click="closePanel()" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form @submit.prevent="submitForm()" class="flex-1 overflow-y-auto px-5 py-4 space-y-5">

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Product</label>
                        <div class="relative">
                            <select x-model="form.product_code" required
                                class=" appearance-none w-full text-sm border border-gray-300 rounded-md pl-3 pr-8 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                                <option value="">Select product</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item['code'] }}">{{ $item['name'] }} ({{ $item['code'] }})
                                    </option>
                                @endforeach
                            </select>
                            <x-heroicon-o-chevron-down
                                class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-2">Movement Type</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" @click="form.type = 'in'"
                                class="flex i   tems-center justify-center gap-2 py-2 rounded-md text-xs font-semibold border transition"
                                :class="form.type === 'in' ? 'bg-green-50 border-green-300 text-green-700' :
                                    'border-gray-300 text-gray-500 hover:bg-gray-50'">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 19.5V4.5m0 0L5.25 11.25M12 4.5l6.75 6.75" />
                                </svg>
                                Stock In
                            </button>
                            <button type="button" @click="form.type = 'out'"
                                class="flex items-center justify-center gap-2 py-2 rounded-md text-xs font-semibold border transition"
                                :class="form.type === 'out' ? 'bg-red-50 border-red-300 text-red-700' :
                                    'border-gray-300 text-gray-500 hover:bg-gray-50'">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
                                </svg>
                                Stock Out
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Quantity</label>
                        <input type="number" min="1" x-model.number="form.quantity" required placeholder="0"
                            class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                        <p class="text-[11px] text-gray-400 mt-1" x-show="currentStock !== null">
                            Current stock: <span x-text="currentStock" class="font-medium text-gray-600"></span>
                        </p>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Reason</label>
                        <div class="relative">
                            <select x-model="form.reason" required
                                class="appearance-none w-full text-sm border border-gray-300 rounded-md pl-3 pr-8 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                                <option value="">Select reason</option>
                                <option value="Restock">Restock</option>
                                <option value="Return">Customer Return</option>
                                <option value="Damaged">Damaged / Defective</option>
                                <option value="Correction">Stock Count Correction</option>
                                <option value="Other">Other</option>
                            </select>
                            <x-heroicon-o-chevron-down
                                class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Notes (optional)</label>
                        <textarea x-model="form.notes" rows="3" placeholder="Add any additional notes..."
                            class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]"></textarea>
                    </div>

                </form>

                <div class="flex items-center justify-end gap-3 px-5 py-4 border-t border-gray-200">
                    <button @click="closePanel()" type="button"
                        class="px-4 py-2 text-xs font-semibold text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                        Cancel
                    </button>
                    <button @click="submitForm()" type="button"
                        class="px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972]">
                        Save Adjustment
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trendCanvas = document.getElementById('movementTrendChart');
            const existingTrend = Chart.getChart(trendCanvas);
            if (existingTrend) existingTrend.destroy();

            new Chart(trendCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($trend['labels']),
                    datasets: [{
                            label: 'Stock In',
                            data: @json($trend['stock_in']),
                            backgroundColor: '#10B981',
                            borderRadius: 4,
                            barPercentage: 0.6,
                            categoryPercentage: 0.6,
                        },
                        {
                            label: 'Stock Out',
                            data: @json($trend['stock_out']),
                            backgroundColor: '#EF4444',
                            borderRadius: 4,
                            barPercentage: 0.6,
                            categoryPercentage: 0.6,
                        },
                    ]
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
                            intersect: false
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
                                stepSize: 5
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
        });
    </script>

    <script>
        function inventoryPage() {
            return {
                open: false,
                stockMap: {{ \Illuminate\Support\Js::from(collect($items)->pluck('stock', 'code')) }},
                form: {
                    product_code: '',
                    type: 'in',
                    quantity: null,
                    reason: '',
                    notes: '',
                },

                get currentStock() {
                    return this.form.product_code ? (this.stockMap[this.form.product_code] ?? null) : null;
                },

                openAdjust(item = null) {
                    this.form = {
                        product_code: item ? item.code : '',
                        type: 'in',
                        quantity: null,
                        reason: '',
                        notes: '',
                    };
                    this.open = true;
                },

                closePanel() {
                    this.open = false;
                },

                submitForm() {
                    // Wire this up to your controller route, e.g.:
                    // fetch('/inventory/adjust', { method: 'POST', headers: {...}, body: JSON.stringify(this.form) })
                    //     .then(...).then(() => { this.closePanel(); /* refresh table */ });
                    console.log('Submitting stock adjustment:', this.form);
                    this.closePanel();
                },
            }
        }
    </script>
@endsection
