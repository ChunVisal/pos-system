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
            receiptData: {},
            receiptOpen: false,
            lastOrder: {},
            submitting: false,

            // Customer
            customerOpen: false,
            customerSearch: '',
            customerResults: [],
            customerForm: {
                name: '',
                phone: '',
                email: ''
            },
            selectedCustomer: null,
            customerSaved: false,

            get subtotal() {
                return this.cartItems.reduce((sum, i) => sum + (i.price * i.qty), 0);
            },
            get tax() {
                return this.subtotal * 0.005;
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
                const currentQty = existing ? existing.qty : 0;
                const maxStock = product.stock; // ← Already passed in the object

                if (currentQty >= maxStock) {

                    return;
                }

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
                const item = this.cartItems[index];
                if (item.qty >= item.stock) {
                    return;
                }
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
                if (this.cartItems.length === 0) return;
                // Reset customer
                this.selectedCustomer = null;
                this.customerSaved = false;
                this.customerForm = {
                    name: '',
                    phone: '',
                    email: ''
                };
                this.customerSearch = '';
                this.customerResults = [];

                this.checkoutOpen = true;
                this.amountReceived = 0;
                this.change = 0;
                this.paymentMethod = 'cash';
            },
            calculateChange() {
                this.change = Math.max(0, this.amountReceived - this.total);
            },


            searchCustomers() {
                if (this.customerSearch.length < 2) {
                    this.customerResults = [];
                    return;
                }
                fetch(`/cashier/customers/search?q=${encodeURIComponent(this.customerSearch)}`)
                    .then(res => res.json())
                    .then(data => this.customerResults = data);
            },

            selectCustomer(cust) {
                this.selectedCustomer = cust;
                this.customerForm = {
                    name: cust.name,
                    phone: cust.phone,
                    email: cust.email || ''
                };
                this.customerResults = [];
                this.customerSearch = '';
            },

            saveCustomer() {
                if (!this.customerForm.name || !this.customerForm.phone) return;

                const url = this.selectedCustomer ? `/cashier/customers/${this.selectedCustomer.id}` :
                    '/cashier/customers';
                const method = this.selectedCustomer ? 'PUT' : 'POST';
                console.log('Saving to:', url, 'Method:', method);
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            ...this.customerForm,
                            _method: method
                        })
                    })
                    .then(res => {
                        if (!res.ok) {
                            return res.json().then(err => {
                                throw new Error(err.message || Object.values(err.errors).flat().join(', '));
                            });
                        }
                        return res.json();
                    })
                    .then(data => {
                        this.selectedCustomer = data.customer;
                        this.customerOpen = false;
                        this.customerSaved = true;
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Error saving customer');
                    });
            },

            processPayment() {
                if (this.paymentMethod === 'cash' && (!this.amountReceived || parseFloat(this.amountReceived) < this
                        .total)) {
                    alert('Insufficient amount');
                    return;
                }

                this.submitting = true;

                fetch('{{ route('cashier.checkout') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            items: this.cartItems.map(i => ({
                                id: i.id,
                                qty: i.qty
                            })),
                            payment_method: this.paymentMethod,
                            total: this.total,
                            amount_received: this.paymentMethod === 'cash' ? parseFloat(this
                                .amountReceived) : this.total,
                            subtotal: this.subtotal,
                            tax: this.tax,
                            customer_id: this.selectedCustomer?.id || null,
                        })
                    })
                    .then(res => {
                        return res.json();
                    })
                    .then(data => {
                        this.submitting = false;
                        if (data.success) {
                            this.receiptData = {
                                order_number: data.order.order_number,
                                items: [...this.cartItems],
                                subtotal: this.subtotal,
                                tax: this.tax,
                                total: data.order.total,
                                payment_method: this.paymentMethod,
                                amount_received: this.amountReceived,
                                change: data.order.change,
                                customer: this.selectedCustomer ? {
                                    ...this.selectedCustomer
                                } : null,
                            }; // ← Close receiptData here

                            // Reset customer - OUTSIDE receiptData
                            this.selectedCustomer = null;
                            this.customerSaved = false;
                            this.customerForm = {
                                name: '',
                                phone: '',
                                email: ''
                            };

                            this.lastOrder = data.order;
                            this.checkoutOpen = false;
                            this.receiptOpen = true;

                            this.cartItems = [];
                            this.amountReceived = '';
                            this.change = 0;
                        }
                    })
                    .catch(err => {
                        this.submitting = false;
                        alert('Network error. Please try again.');
                        console.error(err);
                    });
            },

            // Add these to your posPage or checkout component
            appendAmount(num) {
                if (!this.amountReceived) this.amountReceived = '';
                this.amountReceived += num;
                this.calculateChange();
            },

            backspaceAmount() {
                if (this.amountReceived) {
                    this.amountReceived = this.amountReceived.toString().slice(0, -1);
                    this.calculateChange();
                }
            },
            calculateChange() {
                const received = parseFloat(this.amountReceived) || 0;
                this.change = Math.max(0, received - this.total);
            },

            // KHQR Timer
            timer: 300,
            timerInterval: null,

            startTimer() {
                this.timer = 300;
                clearInterval(this.timerInterval);
                this.timerInterval = setInterval(() => {
                    if (this.timer > 0) this.timer--;
                    else clearInterval(this.timerInterval);
                }, 1000);
            },

            formatTime(seconds) {
                const m = Math.floor(seconds / 60);
                const s = seconds % 60;
                return m + ':' + String(s).padStart(2, '0');
            },

            openTestReceipt() {
                this.receiptData = {
                    order_number: 'INV-00001',
                    items: [{
                            id: 1,
                            name: 'RTX 4070 Graphics Card',
                            price: 599,
                            qty: 1
                        },
                        {
                            id: 2,
                            name: 'Corsair 32GB RAM',
                            price: 89,
                            qty: 2
                        },
                        {
                            id: 3,
                            name: 'Samsung 1TB SSD',
                            price: 79,
                            qty: 1
                        },
                    ],
                    subtotal: 856.00,
                    tax: 85.60,
                    total: 941.60,
                    payment_method: 'cash',
                    amount_received: 1000.00,
                    change: 58.40,
                };
                this.receiptOpen = true;
            },
        };
    }
</script>
