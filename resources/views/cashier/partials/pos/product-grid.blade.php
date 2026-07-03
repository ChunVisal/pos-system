{{-- LEFT: Products (75%) --}}
<div class="flex flex-col h-full">
    <div class="flex items-center justify-between mb-4 gap-4">

        {{-- Title - Left --}}
        <div class="flex items-center gap-1 shrink-0">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-zinc-100">Products</h2>
            <span class="text-sm text-gray-500 dark:text-zinc-500 pt-0.5">({{ count($products) }} total)</span>
        </div>

        {{-- Search + Barcode --}}
        <div class="flex items-center gap-3 flex-1 max-w-xl">
            <div class="relative flex-1">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-zinc-400"></i>
                <input id="search" type="text" value="{{ request('search') }}" type="search"
                    placeholder="Search products, categories, code..."
                    class="w-full pl-9 pr-4 py-2 border border-gray-400 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-gray-900 dark:text-zinc-100 rounded-full text-sm outline-none">
                <button type="button" id="clearSearch" style="display:none;"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 z-10">
                    ✕
                </button>
            </div>
            <button @click="$dispatch('trigger-scan')"
                class="px-4 py-2 bg-[#0F6E8C] text-white rounded-full hover:bg-[#0c5972] transition flex items-center gap-2 text-sm font-medium whitespace-nowrap shrink-0 shadow-sm">
                <i class="bi bi-upc-scan text-base"></i>
                <span class="hidden sm:inline">Scan</span>
            </button>
        </div>
    </div>

    {{-- Category Cards - Horizontal Scroll --}}
    <div class="tab-container overflow-x-auto pb-2 shrink-0">
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
                            class="absolute top-2 right-2 w-6 h-6 flex items-center justify-center rounded-full bg-gray-100 dark:bg-zinc-500 text-[11px] font-bold text-gray-700 dark:text-zinc-300">
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

    {{-- DYNAMIC BEAUTIFUL EMPTY STATE DESIGN WITH BLADE HEROICONS --}}
    <div x-show="!hasProducts()" x-cloak
        class="mt-8 w-full py-16 flex flex-col items-center justify-center rounded-sm text-center p-6 transition-all">
        <div class=" rounded-full text-gray-400 dark:text-zinc-500 mb-4 w-16 h-16 flex items-center justify-center">
            <x-heroicon-o-cube-transparent class="w-8 h-8 text-gray-400 dark:text-zinc-500" />
        </div>
        <h3 class="text-base font-semibold text-gray-800 dark:text-zinc-200">No Products Found</h3>
        <p class="text-xs text-gray-500 dark:text-zinc-400 max-w-xs mt-1">
            This specific component category doesn't have any items registered in stock yet.
        </p>
    </div>

    {{-- Products Grid Mapping Frame --}}
    <div id="productGridContainer" x-show="hasProducts()"
        class="mt-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">

        @forelse($products as $product)
            @include('cashier.partials.pos.table-rows')
        @empty
        @endforelse

    </div>
</div>
