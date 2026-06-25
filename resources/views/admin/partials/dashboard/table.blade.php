{{-- ============================================================
     Dashboard › Top Products / Top Categories (tabbed table)
     Expects: $topProducts   — from DashboardData::getTopProducts()
              $topCategories — from DashboardData::getTopCategories()
     ============================================================ --}}
<div class="bg-white dark:bg-zinc-900 p-4 mt-4 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800">

    {{-- ── Tab Header ── --}}
    <div class="flex flex-wrap items-center gap-3 mb-4 border-b border-gray-200 dark:border-zinc-800 pb-2">
        <div class="flex items-center gap-6">
            <button class="text-sm font-semibold text-[#0F6E8C] transition" id="tabProducts">
                Top Products
            </button>
            <button
                class="text-sm font-medium text-gray-500 dark:text-zinc-400 hover:text-gray-600 dark:hover:text-zinc-300 transition"
                id="tabCategories">
                Top Categories
            </button>
        </div>

        <div class="flex items-center gap-3 ml-auto">
            <div class="relative">
                <i
                    class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 text-xs"></i>
                <input type="text" id="searchInput" placeholder="Search..."
                    class="pl-8 pr-3 py-1 text-xs bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
            </div>
            <a href="#" class="text-xs text-[#0F6E8C] hover:underline font-medium whitespace-nowrap"
                id="viewAllLink">View All Products →</a>
        </div>
    </div>

    {{-- ── Products Table ── --}}
    <div id="productsTable">
        <table class="w-full text-sm">
            <thead>
                <tr
                    class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800">
                    <th class="pb-2 font-medium w-10">
                        <span class="bg-gray-200/70 dark:bg-zinc-800 px-3 py-1 mr-2 rounded">No</span>
                    </th>
                    <th class="pb-2 font-medium">Product</th>
                    <th class="pb-2 font-medium w-20 text-right">Price</th>
                    <th class="pb-2 font-medium w-16 text-center">Sold</th>
                    <th class="pb-2 font-medium w-24 text-right">Revenue</th>
                    <th class="pb-2 font-medium w-36">Rank</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                @forelse($topProducts as $product)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition">
                        <td class="py-3">
                            <span
                                class="text-sm font-bold {{ $product['rank'] === 1 ? 'text-yellow-500' : ($product['rank'] === 2 ? 'text-p' : ($product['rank'] === 3 ? 'text-brown-200 dark:text-gray-300' : 'text-gray-500 dark:text-zinc-500')) }}">
                                #{{ $product['rank'] }}
                            </span>
                        </td>
                        <td class="py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gray-200 dark:bg-zinc-800 rounded overflow-hidden shrink-0">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxolXBpybqOuVoJXLQE2SB0buq-Gq48WnKnB0h9AD5hKYyruRDcNa0ZNXJ&s=10"
                                        alt="{{ $product['name'] }}" class="w-full h-full object-cover">
                                </div>
                                <span class="font-medium text-gray-800 dark:text-zinc-200">{{ $product['name'] }}</span>
                            </div>
                        </td>
                        <td class="py-3 text-right text-gray-600 dark:text-zinc-400">
                            ${{ number_format($product['price'], 2) }}</td>
                        <td class="py-3 text-center text-gray-600 dark:text-zinc-400">{{ $product['sold'] }}</td>
                        <td class="py-3 text-right font-medium text-gray-800 dark:text-zinc-200 pr-2">
                            ${{ number_format($product['revenue']) }}</td>
                        <td class="py-3 w-48">
                            <div class="flex items-center gap-2">
                                <div class="w-48 h-2 bg-gray-200 dark:bg-zinc-800 rounded-l-full">
                                    <div class="h-2 bg-[#0F6E8C] rounded-l-full"
                                        style="width: {{ $product['percent'] }}%;"></div>
                                </div>
                                <span
                                    class="text-xs text-gray-400 dark:text-zinc-500 w-8 text-right">{{ $product['percent'] }}%</span>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-400 dark:text-zinc-500 text-sm">No products
                            found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── Categories Table (hidden by default) ── --}}
    <div id="categoriesTable" class="hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr
                        class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800">
                        <th class="pb-2 font-medium w-10">
                            <span class="bg-gray-200/70 dark:bg-zinc-800 px-3 py-1 mr-2 rounded">No</span>
                        </th>
                        <th class="pb-2 font-medium">Category</th>
                        <th class="pb-2 font-medium w-20 text-right">Products</th>
                        <th class="pb-2 font-medium w-24 text-right">Revenue</th>
                        <th class="pb-2 font-medium w-36">Rank</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                    @forelse($topCategories as $category)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition">
                            <td class="py-3">
                                <span
                                    class="text-sm font-bold {{ $category['rank'] === 1 ? 'text-yellow-500' : ($category['rank'] === 2 ? 'text-p' : ($category['rank'] === 3 ? 'text-brown-200' : 'text-gray-500 dark:text-zinc-500')) }}">
                                    #{{ $category['rank'] }}
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-12 h-12 bg-[#0F6E8C]/10 dark:bg-[#0F6E8C]/20 rounded flex items-center justify-center shrink-0">
                                        <i class="fa-solid {{ $category['icon'] }} text-[#0F6E8C]"></i>
                                    </div>
                                    <span
                                        class="font-medium text-gray-800 dark:text-zinc-200">{{ $category['name'] }}</span>
                                </div>
                            </td>
                            <td class="py-3 text-right text-gray-600 dark:text-zinc-400">{{ $category['products'] }}
                            </td>
                            <td class="py-3 text-right font-medium text-gray-800 dark:text-zinc-200">
                                ${{ number_format($category['revenue']) }}</td>
                            <td class="py-3 w-48 ml-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-48 flex-1 h-2 bg-gray-200 dark:bg-zinc-800 rounded-l-full">
                                        <div class="h-2 bg-[#0F6E8C] rounded-l-full"
                                            style="width: {{ $category['percent'] }}%;"></div>
                                    </div>
                                    <span
                                        class="text-xs text-gray-400 dark:text-zinc-500 w-8 text-right">{{ $category['percent'] }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-400 dark:text-zinc-500 text-sm">No
                                categories found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ── Tab switching + search JS ── --}}
<script>
    const tabProducts = document.getElementById('tabProducts');
    const tabCategories = document.getElementById('tabCategories');
    const productsTable = document.getElementById('productsTable');
    const categoriesTable = document.getElementById('categoriesTable');
    const viewAllLink = document.getElementById('viewAllLink');

    function switchTab(tab) {
        const isProducts = tab === 'products';

        tabProducts.classList.toggle('text-[#0F6E8C]', isProducts);
        tabProducts.classList.toggle('font-semibold', isProducts);
        tabProducts.classList.toggle('text-gray-500', !isProducts);
        tabProducts.classList.toggle('dark:text-zinc-400', !isProducts);
        tabProducts.classList.toggle('font-medium', !isProducts);

        tabCategories.classList.toggle('text-[#0F6E8C]', !isProducts);
        tabCategories.classList.toggle('font-semibold', !isProducts);
        tabCategories.classList.toggle('text-gray-500', isProducts);
        tabCategories.classList.toggle('dark:text-zinc-400', isProducts);
        tabCategories.classList.toggle('font-medium', isProducts);

        productsTable.classList.toggle('hidden', !isProducts);
        categoriesTable.classList.toggle('hidden', isProducts);

        viewAllLink.textContent = isProducts ? 'View All Products →' : 'View All Categories →';
        viewAllLink.href = isProducts ? '#products' : '#categories';
    }

    tabProducts.addEventListener('click', () => switchTab('products'));
    tabCategories.addEventListener('click', () => switchTab('categories'));

    document.getElementById('searchInput').addEventListener('keyup', function() {
        const search = this.value.toLowerCase();
        const activeTab = productsTable.classList.contains('hidden') ? 'categories' : 'products';
        const rows = document.querySelectorAll(
            activeTab === 'products' ? '#productsTable tbody tr' : '#categoriesTable tbody tr'
        );
        rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(search) ? '' : 'none';
        });
    });
</script>
