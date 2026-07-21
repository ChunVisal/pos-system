{{-- LEFT: Products (75%) --}}
<div class="flex flex-col h-full">
    <div class="flex items-center justify-between mb-4 gap-4">

        {{-- Title - Left --}}
        <div class="flex items-center gap-1 shrink-0">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-zinc-100">Products</h2>
            <span class="text-sm text-gray-500 dark:text-zinc-500 pt-0.5">({{ $totalAllocated }} items available)</span>
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
            {{-- Held Carts Dropdown Section --}}
            <div x-show="heldCartsList.length > 0" class="relative" x-data="{ open: false }">

                {{-- Trigger Button --}}
                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-3 py-2 rounded-full text-xs font-bold text-gray-800 dark:text-zinc-200 bg-gray-100 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 hover:bg-gray-200 dark:hover:bg-zinc-700 transition-colors">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-pause text-gray-600 dark:text-zinc-400 text-[11px]"></i>
                        <span>Held Orders</span>
                        <span
                            class="px-2.5 py-1 text-[10px] font-bold text-gray-100 bg-gray-700 dark:bg-zinc-600 rounded-full"
                            x-text="heldCartsList.length"></span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] px-1 rounded-full text-gray-500 dark:text-zinc-400 transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''"></i>
                </button>

                {{-- Dropdown Menu Container --}}
                <div x-show="open" @click.outside="open = false" x-cloak
                    class="absolute right-0 mt-1 w-[380px] sm:w-[420px] bg-white dark:bg-zinc-700 rounded-lg shadow-xl z-30 overflow-hidden max-h-72 overflow-y-auto divide-y divide-gray-100 dark:divide-zinc-800">

                    <template x-for="cart in heldCartsList" :key="cart.id">
                        <div
                            class="group flex items-center justify-between p-3.5 hover:bg-gray-50 dark:hover:bg-zinc-800/60 transition-colors">

                            {{-- Left Info Block --}}
                            <div class="flex-1 min-w-0 pr-3">
                                {{-- Top Row: Customer Name & Item Badge --}}
                                <div class="flex items-center gap-2">
                                    <p class="text-xs font-bold text-gray-900 dark:text-white truncate">
                                        <span x-text="cart.note || 'Note to remember'"></span>
                                    </p>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-zinc-200 shrink-0"
                                        x-text="cart.items.length + ' items'"></span>
                                </div>

                                {{-- Timestamp --}}
                                <div
                                    class="flex items-center gap-1.5 mt-1 text-[12px] text-gray-400 dark:text-zinc-300">
                                    <i class="fa-regular fa-clock text-[9px]"></i>
                                    <span x-text="cart.createdAt"></span>
                                </div>
                            </div>

                            {{-- Right Actions Block --}}
                            <div class="flex items-center gap-2 shrink-0">
                                {{-- Note Edit Button --}}
                                <button @click="cart.note = prompt('Add note:', cart.note || '')" title="Edit Note"
                                    class="p-2 text-gray-400 dark:text-zinc-300 hover:text-gray-700 dark:hover:text-zinc-200 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded-md transition-colors">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>

                                {{-- Resume Button --}}
                                <button @click="resumeCart(cart); open = false"
                                    class="px-3 py-1.5 text-xs font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/60 hover:bg-blue-100 dark:hover:bg-blue-900/80 border border-blue-200 dark:border-blue-800/80 rounded-md transition-colors shadow-sm">
                                    Resume
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    {{-- Category Cards - Horizontal Scroll --}}
    <div class="tab-container overflow-x-auto pb-2 shrink-0">
        <div class="flex gap-4">

            {{-- "All Products" Reset Card --}}
            <div @click="selectedCategory = 'all'"
                :class="selectedCategory === 'all' ? 'border-[#1063a2]/30 bg-blue-50/50 dark:bg-zinc-800' :
                    'border-gray-200 dark:border-zinc-800 bg-white dark:bg-zinc-900'"
                class="w-32 h-32 p-3 border flex-shrink-0 hover:shadow-md transition-all cursor-pointer relative overflow-hidden flex flex-col items-center justify-center">
                <img src='{{ asset('images/allmenu.png') }}' class="object-cover h-full" alt="">
                <p class="text-sm font-medium text-gray-800 dark:text-zinc-100 mt-1">All Items</p>
            </div>

            {{-- Loop Through DB Categories --}}
            @foreach ($categories as $category)
                <div @click="selectedCategory = {{ $category->id }}"
                    :class="selectedCategory === {{ $category->id }} ?
                        'border-[#1063a2]/30 bg-blue-50/50 dark:bg-zinc-800' :
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
            <div class="bg-gray-200/50 dark:bg-zinc-900  col-span-full flex flex-col items-center justify-center py-12">
                <div class="rounded-full bg-gray-100 dark:bg-zinc-800 p-4 mb-4">
                    <x-heroicon-o-shopping-bag class="w-10 h-10 text-gray-400 dark:text-zinc-600" />
                </div>
                <h4 class="text-base font-semibold text-gray-800 dark:text-zinc-200">Product Not Exist</h4>
                <p class="text-xs text-center text-gray-500 dark:text-zinc-400 max-w-[200px] mt-1">
                    There are currently no products registered in this category.
                </p>
            </div>
        @endforelse

    </div>
</div>
