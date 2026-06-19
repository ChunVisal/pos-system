@extends('layouts.app')

@php
    use App\Helpers\InventoryData;
    $summary = InventoryData::getSummary();
    $items = InventoryData::getStockItems();
    $movements = InventoryData::getMovements();
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
            <div class="flex items-center gap-2 mt-3 sm:mt-0">
                <button
                    class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Export
                </button>
                <button @click="openAdjust()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">
                    <i class="fa-solid fa-plus"></i> Stock Adjustment
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
            <div class="bg-white p-3 rounded-md shadow-xs border border-gray-300/40 flex flex-col justify-between h-28">
                <div class="flex items-center gap-2">
                    <div class="rounded-md p-2 px-3" style="background-color:#0F6E8C20;">
                        <i class="fa-solid fa-cube text-[18px]" style="color:#0F6E8C;"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 uppercase">Total Products</p>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $summary['total_products'] }}</h2>
            </div>

            <div class="bg-white p-3 rounded-md shadow-xs border border-gray-300/40 flex flex-col justify-between h-28">
                <div class="flex items-center gap-2">
                    <div class="rounded-md p-2 px-3" style="background-color:#F59E0B20;">
                        <i class="fa-solid fa-triangle-exclamation text-[18px]" style="color:#D97706;"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 uppercase">Low Stock</p>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $summary['low_stock'] }}</h2>
            </div>

            <div class="bg-white p-3 rounded-md shadow-xs border border-gray-300/40 flex flex-col justify-between h-28">
                <div class="flex items-center gap-2">
                    <div class="rounded-md p-2 px-3" style="background-color:#EF444420;">
                        <i class="fa-solid fa-circle-xmark text-[18px]" style="color:#EF4444;"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 uppercase">Out of Stock</p>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $summary['out_of_stock'] }}</h2>
            </div>

            <div class="bg-white p-3 rounded-md shadow-xs border border-gray-300/40 flex flex-col justify-between h-28">
                <div class="flex items-center gap-2">
                    <div class="rounded-md p-2 px-3" style="background-color:#10B98120;">
                        <i class="fa-solid fa-sack-dollar text-[18px]" style="color:#10B981;"></i>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 uppercase">Stock Value</p>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">${{ number_format($summary['total_value']) }}</h2>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white p-3 rounded-md shadow-xs border border-gray-300/40 flex flex-wrap items-center gap-3 mb-4">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" placeholder="Search by product name or code..."
                    class="w-full pl-8 pr-3 py-1.5 text-xs border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
            </div>
            <div class="relative">
                <select
                    class="appearance-none text-xs border border-gray-300 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category['code'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor"
                    class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
            <div class="relative">
                <select
                    class="appearance-none text-xs border border-gray-300 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                    <option value="">All Stock Status</option>
                    <option value="low">Low Stock</option>
                    <option value="out">Out of Stock</option>
                    <option value="normal">In Stock</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor"
                    class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
        </div>

        <!-- Stock Table -->
        <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200 mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
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
                                        <div
                                            class="w-10 h-10 bg-[#0F6E8C]/10 rounded-md flex items-center justify-center shrink-0">
                                            <i class="fa-solid fa-microchip text-[#0F6E8C]"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $item['name'] }}</p>
                                            <p class="text-xs text-gray-400">{{ $item['code'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-gray-600">{{ $item['category_name'] }}</td>
                                <td class="py-3 px-4 text-center font-semibold text-gray-800">{{ $item['stock'] }}</td>
                                <td class="py-3 px-4 text-center text-gray-500">{{ $item['reorder_level'] }}</td>
                                <td class="py-3 px-4 text-center">
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
                                <td class="py-3 px-4 text-gray-500 text-xs">
                                    {{ \Carbon\Carbon::parse($item['last_updated'])->format('M d, Y') }}</td>
                                <td class="py-3 pl-4">
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

        <!-- Recent Stock Movements -->
        <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-800 mb-3">Recent Stock Movements</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                            <th class="pb-2 pr-4 font-medium">Product</th>
                            <th class="pb-2 px-4 font-medium text-center">Type</th>
                            <th class="pb-2 px-4 font-medium text-center">Quantity</th>
                            <th class="pb-2 px-4 font-medium">Reason</th>
                            <th class="pb-2 px-4 font-medium">By</th>
                            <th class="pb-2 pl-4 font-medium text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($movements as $movement)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 pr-4">
                                    <p class="font-medium text-gray-800">{{ $movement['product_name'] }}</p>
                                    <p class="text-xs text-gray-400">{{ $movement['product_code'] }}</p>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if ($movement['type'] === 'in')
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 text-[11px] font-semibold rounded-full bg-green-50 text-green-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 19.5V4.5m0 0L5.25 11.25M12 4.5l6.75 6.75" />
                                            </svg>
                                            Stock In
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 text-[11px] font-semibold rounded-full bg-red-50 text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
                                            </svg>
                                            Stock Out
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center font-medium text-gray-800">{{ $movement['quantity'] }}
                                </td>
                                <td class="py-3 px-4 text-gray-600">{{ $movement['reason'] }}</td>
                                <td class="py-3 px-4 text-gray-600">{{ $movement['user'] }}</td>
                                <td class="py-3 pl-4 text-right text-gray-500 text-xs">
                                    {{ \Carbon\Carbon::parse($movement['date'])->format('M d, g:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-400 text-sm">No stock movements found
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
                                class="appearance-none w-full text-sm border border-gray-300 rounded-md pl-3 pr-8 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                                <option value="">Select product</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item['code'] }}">{{ $item['name'] }} ({{ $item['code'] }})
                                    </option>
                                @endforeach
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor"
                                class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-2">Movement Type</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" @click="form.type = 'in'"
                                class="flex items-center justify-center gap-2 py-2 rounded-md text-xs font-semibold border transition"
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
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor"
                                class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
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
