{{-- Title Row --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
    <div>
        <h1 class="text-xl font-bold text-gray-800 dark:text-zinc-100">Products</h1>
        <p class="text-xs text-gray-500 dark:text-zinc-400">Manage your PC component catalog and stock</p>
        <div class="flex gap-4 mt-1">
            <span class="text-xs text-gray-600 dark:text-zinc-300">
                Total Products: <strong>{{ $products->count() }}</strong>
            </span>
            <span class="text-xs text-gray-600 dark:text-zinc-300">
                Total Stock: <strong>{{ $products->sum('stock_quantity') }}</strong>
            </span>
        </div>
    </div>
    <div class="items-center flex gap-4">
        <button @click="openAdd()"
            class="mt-3 sm:mt-0 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-p rounded-md hover:bg-[#0c5972] transition">
            <i class="fa-solid fa-plus"></i> Add Product
        </button>
        <div class="flex items-center border border-gray-300 dark:border-zinc-700 rounded-md overflow-hidden">
            <button @click="viewMode = 'table'; localStorage.setItem('productViewMode', 'table')"
                :class="viewMode === 'table' ? 'bg-p text-white' :
                    'bg-white dark:bg-zinc-900 text-gray-500 dark:text-zinc-400'"
                class="px-3 py-2 transition">
                <x-heroicon-m-list-bullet class="w-4 h-4" />
            </button>
            <button @click="viewMode = 'grid'; localStorage.setItem('productViewMode', 'grid')"
                :class="viewMode === 'grid' ? 'bg-p text-white' :
                    'bg-white dark:bg-zinc-900 text-gray-500 dark:text-zinc-400'"
                class="px-3 py-2 transition">
                <x-heroicon-m-squares-2x2 class="w-4 h-4" />
            </button>
        </div>
    </div>
</div>

{{-- Filter Bar --}}
<div class="flex flex-wrap items-center gap-3 mb-4">

    {{-- Search --}}
    <div class="relative flex-1 min-w-[200px]">
        <i
            class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 text-xs"></i>
        <input id="search" type="text" value="{{ request('search') }}"
            placeholder="Search by name, categories, code, or barcode..."
            class="w-full pl-8 pr-8 py-1.5 text-xs bg-white dark:bg-zinc-900 text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md focus:outline-none focus:ring-1 focus:ring-p placeholder-gray-400 dark:placeholder-zinc-500">
        <button type="button" id="clearSearch" style="display:none;"
            class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 z-10">
            ✕
        </button>
    </div>

    {{-- Category --}}
    <div class="relative">
        <select id="categoryFilter"
            class="bg-white dark:bg-zinc-900 bg-none appearance-none text-xs text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-p cursor-pointer">
            <option value="all">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->name }}">
                    {{ $category->name }} ({{ (int) $category->total_stock }})
                </option>
            @endforeach
        </select>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor"
            class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </div>

    {{-- Status --}}
    <div class="relative">
        <select id="statusFilter"
            class="bg-white dark:bg-zinc-900 appearance-none text-xs text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-p cursor-pointer">
            <option value="all">All Status</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor"
            class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </div>

    {{-- Stock --}}
    <div class="relative">
        <select id="stockFilter"
            class="bg-white dark:bg-zinc-900 appearance-none text-xs text-gray-800 dark:text-zinc-200 border border-gray-300 dark:border-zinc-800 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-p cursor-pointer">
            <option value="all">All Stock</option>
            <option value="out">Out of Stock</option>
            <option value="low">Low Stock</option>
            <option value="in">In Stock</option>
        </select>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor"
            class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </div>

    {{-- Bulk Action Bar --}}
    <div id="bulkBar" style="display:none;"
        class="flex items-center justify-between pl-4 bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/60 rounded-md">
        <span class="text-xs text-red-600 dark:text-red-400 font-medium mr-4">
            <span id="bulkCount">0</span> selected
        </span>
        <div class="flex items-center">
            <button onclick="bulkDelete()"
                class="px-3 py-[4.5px] text-[12px] font-medium text-white bg-red-500 hover:bg-red-600 transition">
                Delete Selected
            </button>
            <button onclick="cancelBulkMode()"
                class="px-3 py-[4.5px] text-[12px] font-medium text-gray-600 dark:text-zinc-300 border border-gray-300 dark:border-zinc-600 rounded-r-md">
                Cancel
            </button>
        </div>
    </div>

</div>

{{-- Table --}}
<div class="bg-white dark:bg-zinc-900 p-4 rounded-md shadow-xs border border-gray-200 dark:border-zinc-800/60">
    <div class="overflow-x-auto">
        <div x-show="viewMode === 'table'">
            <table class="w-full text-sm    ">
                <thead>
                    <tr
                        class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800">
                        <th class="pb-2 pr-4 font-medium">Product</th>
                        <th class="pb-2 px-4 font-medium">Category</th>
                        <th class="pb-2 px-4 font-medium text-right">Price</th>
                        <th class="pb-2 px-4 font-medium text-center">Stock</th>
                        <th class="pb-2 px-4 font-medium">Barcode</th>
                        <th class="pb-2 px-4 font-medium text-center">Status</th>
                        <th class="pb-2 px-4 font-medium">Date</th>
                        <th class="pb-2 pl-4 font-medium text-right">Actions</th>
                        <th class="pb-2 px-4 font-medium">
                            <input type="checkbox" id="selectAll" onchange="toggleAllCheckboxes(this)"
                                class="rounded border-gray-300 dark:border-zinc-600 cursor-pointer">
                        </th>
                    </tr>
                </thead>
                <tbody id="productsTableBody" class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                    @include('admin.partials.products.table-rows')
                </tbody>
                {{-- Empty state for category filter --}}
                <tr id="noCategoryRow" class="" style="display:none;">
                    <td colspan="6" class="text-center py-5">
                        <div class=" flex flex-col items-center justify-center">
                            <div
                                class="w-16 h-16 mb-4 bg-gray-100 dark:bg-zinc-800 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400 dark:text-zinc-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-700 dark:text-zinc-300 mb-1">No products
                                found</h3>
                            <p class="text-xs text-gray-400 dark:text-zinc-500">Get started by adding your first
                                product.</p>
                            <button @click="openAdd()"
                                class="mt-4 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">
                                <i class="fa-solid fa-plus text-[10px]"></i> Add Your First Product
                            </button>
                        </div>
                    </td>
                </tr>
            </table>

        </div>
    </div>

    {{-- Grid View --}}
    <div id="productsGridBody" x-show="viewMode === 'grid'">
        @include('admin.partials.products.grid')
    </div>
</div>
