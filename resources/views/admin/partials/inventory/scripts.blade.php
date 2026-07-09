<script>
    function inventoryPage() {


        return {

            open: false,
            submitting: false,
            stockMap: {{ \Illuminate\Support\Js::from($products->pluck('stock_quantity', 'code')) }},
            thresholdMap: {{ \Illuminate\Support\Js::from($products->pluck('low_stock_threshold', 'code')) }},

            stockDropOpen: false,
            dropForm: {
                product_id: null,
                product_name: '',
                current_stock: 0,
                cashier_id: '',
                quantity: 1
            },
            cashierStocks: @json($cashierStocks ?? []),

            form: {
                product_code: '',
                type: 'in',
                quantity: null,
                low_stock_threshold: null,
                reason: '',
                notes: '',
            },

            get currentStock() {
                return this.form.product_code ? (this.stockMap[this.form.product_code] ?? null) : null;
            },

            get currentThreshold() {
                return this.form.product_code ? (this.thresholdMap[this.form.product_code] ?? null) : null;
            },

            openAdjust(item = null) {
                this.form = {
                    product_code: item ? item.code : '',
                    type: 'in',
                    quantity: null,
                    low_stock_threshold: item ? item.low_stock_threshold : null,
                    reason: '',
                    notes: '',
                };
                this.open = true;
            },

            closePanel() {
                this.open = false;
            },

            openStockDrop(product) {
                this.dropForm = {
                    product_id: product.id,
                    product_name: product.name,
                    current_stock: product.stock_quantity,
                    cashier_id: '',
                    quantity: 1,
                };
                this.stockDropOpen = true;
            },

            getCashierStock() {
                const stock = this.cashierStocks.find(s => s.product_id === this.dropForm.product_id && s.cashier_id ===
                    this.dropForm.cashier_id);
                return stock ? stock.allocated_quantity - stock.sold_quantity : 0;
            },

            submitDrop() {
                fetch('/admin/inventory/stock-drop', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify(this.dropForm)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.message);
                        }
                    });
            },

            submitForm() {
                if (this.submitting) return;

                if (!this.form.product_code) {
                    alert('Please select a product!');
                    return;
                }
                if (!this.form.reason) {
                    alert('Please select a reason!');
                    return;
                }

                this.submitting = true;

                fetch('{{ route('admin.inventory.adjust') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.form)
                    })
                    .then(res => res.json().then(data => ({
                        ok: res.ok,
                        data
                    })))
                    .then(({
                        ok,
                        data
                    }) => {
                        this.submitting = false;
                        if (!ok) {
                            alert(data.error || 'Something went wrong');
                            return;
                        }
                        this.stockMap[this.form.product_code] = data.new_stock;
                        this.closePanel();
                        window.location.reload();
                    })
                    .catch(err => {
                        this.submitting = false;
                        alert('Error: ' + err.message);
                    });
            },
        }
    }
</script>
