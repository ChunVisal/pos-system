<script>
    function productPage() {
        return {

            searchQuery: '',
            requestOpen: false,
            requestSearch: '',
            requestForm: {
                product_id: '',
                product_name: '',
                quantity: 1
            },
            products: @json($products),

            get filteredRequestProducts() {
                const q = (this.requestSearch || '').toLowerCase();
                return this.products.filter(p =>
                    (p.remaining || 0) <= 5 &&
                    (!q || (p.name || '').toLowerCase().includes(q))
                );
            },

            submitRequest() {
                fetch('/cashier/stock-request', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.requestForm)
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert(data.message);
                        this.requestOpen = false;
                        this.requestForm = {
                            product_id: '',
                            product_name: '',
                            quantity: 1
                        };
                    });
            },

            searchProducts() {
                fetch(`/cashier/products?search=${encodeURIComponent(this.searchQuery)}&ajax=1`)
                    .then(res => res.json())
                    .then(data => this.products = data.products);
            },

        }
    }
</script>
