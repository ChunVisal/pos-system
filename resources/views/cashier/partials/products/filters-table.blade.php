{{-- resources/views/cashier/partials/products/filters-table.blade.php --}}


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
</div>

{{-- Table --}}
<div
    class="bg-white dark:bg-zinc-900 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800/60 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr
                class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800">
                <th class="py-3 pl-4 pr-2 font-medium">Product</th>
                <th class="py-3 px-2 font-medium">Category</th>
                <th class="py-3 px-2 font-medium text-center">Allocated</th>
                <th class="py-3 px-2 font-medium text-center">Sold</th>
                <th class="py-3 px-2 font-medium text-center">Remaining</th>
                <th class="py-3 px-2 font-medium text-right">Price</th>
                <th class="py-3 px-2 font-medium text-right">Revenue</th>
                <th class="py-3 px-2 font-medium">Last Drop</th>
                <th class="py-3 pr-4 pl-2 font-medium text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition">
                    <td class="py-3 pl-4 pr-2">
                        <div class="flex items-center gap-3">
                            <img src="{{ $product->image ?? 'https://res.cloudinary.com/dexr27qho/image/upload/v1782723706/8fc9e618-ca35-4366-a173-ae4d15ec0aef_vyjksv.png' }}"
                                class="w-10 h-10 rounded-md object-cover bg-gray-100 dark:bg-zinc-800 shrink-0">
                            <div class="min-w-0">
                                <p class="font-medium text-gray-800 dark:text-zinc-200 truncate max-w-[200px]">
                                    {{ $product->name }}</p>
                                <p class="text-[11px] text-gray-400">{{ $product->code }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-2 text-xs text-gray-500 dark:text-zinc-400">{{ $product->category_name }}</td>
                    <td class="py-3 px-2 text-center font-medium">{{ $product->allocated }}</td>
                    <td class="py-3 px-2 text-center text-red-500 font-medium">{{ $product->sold }}</td>
                    <td class="py-3 px-2 text-center font-bold text-green-600">{{ $product->remaining }}</td>
                    <td class="py-3 px-2 text-right font-semibold text-[#0F6E8C]">
                        ${{ number_format($product->selling_price, 2) }}</td>
                    <td class="py-3 px-2 text-right font-semibold text-purple-600">
                        ${{ number_format($product->revenue, 2) }}</td>
                    <td class="py-3 px-2 text-xs text-gray-500">
                        {{ $product->last_drop ? $product->last_drop->format('M d, Y') : '-' }}</td>
                    <td class="py-3 pr-4 pl-2 text-center">
                        <span
                            class="px-2 py-0.5 text-[10px] rounded-full font-medium
                {{ $product->remaining > 5
                    ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                    : ($product->remaining > 0
                        ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400'
                        : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400') }}">
                            {{ $product->remaining > 5 ? 'In Stock' : ($product->remaining > 0 ? 'Low' : 'Out') }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-16">...</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    function productSearch() {
        return {
            searchQuery: '',
            products: @json($products),

            searchProducts() {
                fetch(`/cashier/products?search=${encodeURIComponent(this.searchQuery)}&ajax=1`)
                    .then(res => res.json())
                    .then(data => this.products = data.products);
            },
        };
    }
</script>
