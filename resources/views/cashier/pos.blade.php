@extends('layouts.cashier')

@php
    // Fetch categories with product counts, and get all active products
    $categories = \App\Models\Categories::withCount(['products as products_count'])->get();
    $products = \App\Models\Product::with('category')->where('status', 'active')->get();

    // Map category IDs to their product counts so JavaScript can check them instantly
    $categoryCounts = [];
    foreach ($categories as $cat) {
        $categoryCounts[$cat->id] = $cat->products_count;
    }
@endphp

@section('content')
    {{-- Main wrapper tracks the active selected category id --}}
    <div class="w-full p-5 min-h-screen" x-data="{
        selectedCategory: 'all',
        {{-- This checks if the active group has items using our raw JSON tracking map --}}
        categoryMap: {{ json_encode($categoryCounts) }},
        hasProducts() {
            if (this.selectedCategory === 'all') return true;
            return (this.categoryMap[this.selectedCategory] || 0) > 0;
        }
    }">

        {{-- POS Content --}}
        <div class="flex flex-col gap-4 w-full h-full">

            {{-- LEFT: Products (75%) --}}
            <div class="w-[75%] min-w-0 flex flex-col overflow-hidden">
                <div class="flex items-center justify-between mb-4 gap-4">

                    {{-- Title - Left --}}
                    <div class="flex items-center gap-1 shrink-0">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-zinc-100">Products</h2>
                        <span class="text-sm text-gray-500 dark:text-zinc-500 pt-0.5">({{ count($products) }} total)</span>
                    </div>

                    {{-- Search + Barcode --}}
                    <div class="flex items-center gap-3 flex-1 max-w-xl">
                        <div class="relative flex-1">
                            <i
                                class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-zinc-400"></i>
                            <input type="search" placeholder="Search products, categories, code..."
                                class="w-full pl-9 pr-4 py-2 border border-gray-400 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-gray-900 dark:text-zinc-100 rounded-full text-sm outline-none">
                        </div>
                        <button @click="$dispatch('trigger-scan')"
                            class="px-4 py-2 bg-[#0F6E8C] text-white rounded-full hover:bg-[#0c5972] transition flex items-center gap-2 text-sm font-medium whitespace-nowrap shrink-0 shadow-sm">
                            <i class="bi bi-upc-scan text-base"></i>
                            <span class="hidden sm:inline">Scan</span>
                        </button>
                    </div>
                </div>

                {{-- Category Cards - Horizontal Scroll --}}
                <div class="tab-container overflow-x-auto pb-2 scrollbar-hide">
                    <div class="flex gap-4">

                        {{-- "All Products" Reset Card --}}
                        <div @click="selectedCategory = 'all'"
                            :class="selectedCategory === 'all' ? 'border-[#1063a2]/30 bg-blue-50/50 dark:bg-zinc-600' :
                                'border-gray-200 dark:border-zinc-800 bg-white dark:bg-zinc-900'"
                            class="w-32 h-32 p-3 border flex-shrink-0 hover:shadow-md transition-all cursor-pointer relative overflow-hidden flex flex-col items-center justify-center">
                            <img src='{{ asset('images/allmenu.png') }}' class="object-cover h-full" alt="">
                            <p class="text-sm font-medium text-gray-800 dark:text-zinc-100 mt-1">All Items</p>
                        </div>

                        {{-- Loop Through DB Categories --}}
                        @foreach ($categories as $category)
                            <div @click="selectedCategory = {{ $category->id }}"
                                :class="selectedCategory === {{ $category->id }} ?
                                    'border-[#1063a2]/30 bg-blue-50/50 dark:bg-zinc-600' :
                                    'border-gray-200 dark:border-zinc-800 bg-white dark:bg-zinc-900'"
                                class="w-32 h-32 p-3 border flex-shrink-0 hover:shadow-md transition-all cursor-pointer relative overflow-hidden flex flex-col justify-between">

                                {{-- SVG Icon Layout --}}
                                <div class="w-full flex items-center justify-center mt-2">
                                    <div class="rounded-sm p-1 text-gray-700 dark:text-zinc-300">
                                        {!! $category->svg !!}
                                    </div>

                                    {{-- Product Counter Badge --}}
                                    <span
                                        class="absolute top-2 right-2 w-6 h-6 flex items-center justify-center rounded-full bg-gray-100 dark:bg-zinc-600 text-[11px] font-bold text-gray-700 dark:text-zinc-300">
                                        {{ $category->products_count }}
                                    </span>
                                </div>

                                <div class="items-center flex flex-col text-center">
                                    <p class="text-xs font-medium truncate w-full text-gray-800 dark:text-zinc-100">
                                        {{ $category->name }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Products Grid Component Scope --}}
                <div x-data="{
                    cart: {},
                    addToCart(productId) {
                        this.cart[productId] = (this.cart[productId] || 0) + 1
                    },
                    removeFromCart(productId) {
                        if (this.cart[productId]) {
                            this.cart[productId]--
                            if (this.cart[productId] <= 0) delete this.cart[productId]
                        }
                    },
                    getQuantity(productId) {
                        return this.cart[productId] || 0
                    }
                }">

                    {{-- DYNAMIC BEAUTIFUL EMPTY STATE DESIGN WITH BLADE HEROICONS --}}
                    <div x-show="!hasProducts()" x-cloak
                        class="mt-8 w-full py-16 flex flex-col items-center justify-center rounded-sm text-center p-6 transition-all">
                        <div
                            class=" rounded-full text-gray-400 dark:text-zinc-500 mb-4 w-16 h-16 flex items-center justify-center">
                            <x-heroicon-o-cube-transparent class="w-8 h-8 text-gray-400 dark:text-zinc-500" />
                        </div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-zinc-200">No Products Found</h3>
                        <p class="text-xs text-gray-500 dark:text-zinc-400 max-w-xs mt-1">
                            This specific component category doesn't have any items registered in stock yet.
                        </p>
                    </div>

                    {{-- Products Grid Mapping Frame --}}
                    <div x-show="hasProducts()"
                        class="mt-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                        @foreach ($products as $product)
                            <div x-show="selectedCategory === 'all' || selectedCategory === {{ $product->category_id }}"
                                class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 overflow-hidden hover:shadow-md transition-all relative group flex flex-col rounded-sm">

                                {{-- Product Code Badge --}}
                                <span
                                    class="absolute top-2 right-2 text-[10px] font-mono text-gray-600 dark:text-zinc-100 bg-gray-100 dark:bg-zinc-600 px-1.5 py-0.5 rounded z-10">
                                    {{ $product->code }}
                                </span>

                                {{-- Image Container --}}
                                <div class="w-full h-[140px] bg-gray-50 dark:bg-zinc-600 overflow-hidden">
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                </div>

                                {{-- Content Layout --}}
                                <div class="p-3 flex flex-col flex-1">
                                    <p
                                        class="text-sm font-medium text-gray-800 dark:text-zinc-100 line-clamp-2 min-h-[40px]">
                                        {{ $product->name }}
                                    </p>

                                    {{-- Pricing & Stock Metrics --}}
                                    <div
                                        class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100 dark:border-zinc-800">
                                        <span class="text-sm font-bold text-green-600 dark:text-green-400">
                                            ${{ number_format($product->selling_price, 2) }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            Qty: <label class="font-semibold">{{ $product->stock_quantity }}</label>
                                        </span>
                                    </div>

                                    {{-- Interaction Counter Buttons --}}
                                    <div class="mt-3 pt-2 border-t border-gray-50 dark:border-zinc-800">
                                        {{-- Standard Add Button --}}
                                        <button @click="addToCart({{ $product->id }})"
                                            x-show="getQuantity({{ $product->id }}) === 0"
                                            class="w-full py-1.5 text-xs font-medium text-white bg-[#1063a2] rounded hover:bg-[#0c4f82] transition flex items-center justify-center gap-1">
                                            <i class="bi bi-plus-lg"></i> Add to Order
                                        </button>

                                        {{-- Plus / Minus Counter Layout --}}
                                        <div x-show="getQuantity({{ $product->id }}) > 0"
                                            class="flex items-center justify-between">
                                            <button @click="removeFromCart({{ $product->id }})"
                                                class="px-2.5 py-1 bg-red-500 text-white rounded text-xs font-bold hover:bg-red-600">-</button>
                                            <span x-text="getQuantity({{ $product->id }})"
                                                class="text-xs font-bold text-gray-800 dark:text-zinc-100"></span>
                                            <button @click="addToCart({{ $product->id }})"
                                                class="px-2.5 py-1 bg-green-600 text-white rounded text-xs font-bold hover:bg-green-700">+</button>
                                        </div>
                                    </div> {{-- Closes Interaction Counter Buttons --}}

                                </div> {{-- Closes Content Layout --}}
                            </div> {{-- Closes Product Card Wrapper --}}
                        @endforeach
                    </div> {{-- Closes Grid Framework --}}

                </div> {{-- Closes Products Grid Component Scope --}}
            </div> {{-- Closes LEFT: Products (75%) --}}
        </div> {{-- Closes POS Content --}}
    </div> {{-- Closes Main Wrapper Div --}}
@endsection
