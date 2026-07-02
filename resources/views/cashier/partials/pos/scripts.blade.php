<script>
    document.addEventListener('DOMContentLoaded', function() {
        // searching filter 
        $(document).ready(function() {
            let searchTimer;

            $('#search').on('input', function() {
                clearTimeout(searchTimer);
                const query = $(this).val();
                $('#clearSearch').toggle(query.length > 0);

                searchTimer = setTimeout(function() {
                    $.get('{{ route('cashier.pos') }}', {
                        search: query,
                        ajax: 1
                    }, function(data) {
                        $('#productGridContainer').html(data);
                    });
                }, 400);
            });

            $('#clearSearch').on('click', function() {
                $('#search').val('').trigger('input');
            });
        });
    });

    function posPage() {
        return {
            selectedCategory: 'all',
            categoryMap: @json($categoryCounts),
            cartItems: [],
            checkoutOpen: false,
            paymentMethod: 'cash',
            amountReceived: 0,
            change: 0,
            submitting: false,

            get subtotal() {
                return this.cartItems.reduce((sum, i) => sum + (i.price * i.qty), 0);
            },
            get tax() {
                return this.subtotal * 0.10;
            },
            get total() {
                return this.subtotal + this.tax;
            },

            hasProducts() {
                if (this.selectedCategory === 'all') return true;
                return (this.categoryMap[this.selectedCategory] || 0) > 0;
            },

            addToCart(product) {
                const existing = this.cartItems.find(i => i.id === product.id);
                if (existing) {
                    existing.qty++;
                } else {
                    this.cartItems.push({
                        ...product,
                        qty: 1
                    });
                }
            },
            increaseQty(index) {
                this.cartItems[index].qty++;
            },
            decreaseQty(index) {
                if (this.cartItems[index].qty > 1) this.cartItems[index].qty--;
                else this.cartItems.splice(index, 1);
            },
            removeItem(index) {
                this.cartItems.splice(index, 1);
            },
            openCheckout() {
                this.checkoutOpen = true;
            },
        };
    }
</script>
