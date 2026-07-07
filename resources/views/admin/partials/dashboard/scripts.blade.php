<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabProducts = document.getElementById('tabProducts');
        const tabCategories = document.getElementById('tabCategories');
        const tabCashier = document.getElementById('tabCashier');
        const productsTable = document.getElementById('productsTable');
        const categoriesTable = document.getElementById('categoriesTable');
        const viewAllLink = document.getElementById('viewAllLink');
        const searchInput = document.getElementById('searchInput');

        if (!tabProducts || !tabCategories || !tabCashier) return;

        function switchTab(tab) {
            const isProducts = tab === 'products';
            const isCategories = tab === 'categories';
            const isCashier = tab === 'cashier';

            tabProducts.classList.toggle('text-[#0F6E8C]', isProducts);
            tabProducts.classList.toggle('font-semibold', isProducts);
            tabProducts.classList.toggle('text-gray-500', !isProducts);
            tabProducts.classList.toggle('font-medium', !isProducts);

            tabCategories.classList.toggle('text-[#0F6E8C]', isCategories);
            tabCategories.classList.toggle('font-semibold', isCategories);
            tabCategories.classList.toggle('text-gray-500', !isCategories);
            tabCategories.classList.toggle('font-medium', !isCategories);

            tabCashier.classList.toggle('text-[#0F6E8C]', isCashier);
            tabCashier.classList.toggle('font-semibold', isCashier);
            tabCashier.classList.toggle('text-gray-500', !isCashier);
            tabCashier.classList.toggle('font-medium', !isCashier);

            productsTable.classList.toggle('hidden', !isProducts);
            categoriesTable.classList.toggle('hidden', !isCategories);
            cashierTable.classList.toggle('hidden', !isCashier);

            if (isProducts) {
                viewAllLink.textContent = 'View All Products →';
                viewAllLink.href = '{{ route('admin.products') }}';
            } else if (isCategories) {
                viewAllLink.textContent = 'View All Categories →';
                viewAllLink.href = '{{ route('admin.inventory') }}';
            } else {
                viewAllLink.textContent = 'View All Cashiers →';
                viewAllLink.href = '{{ route('admin.users') }}';
            }
        }

        tabProducts.addEventListener('click', () => switchTab('products'));
        tabCategories.addEventListener('click', () => switchTab('categories'));
        tabCashier.addEventListener('click', () => switchTab('cashier'));

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const search = this.value.toLowerCase();
                const activeTab = productsTable.classList.contains('hidden') ? 'categories' :
                    'products';
                const rows = document.querySelectorAll(activeTab === 'products' ?
                    '#productsTable tbody tr' : '#categoriesTable tbody tr');
                rows.forEach(row => {
                    row.style.display = row.textContent.toLowerCase().includes(search) ? '' :
                        'none';
                });
            });
        }
    });
</script>
