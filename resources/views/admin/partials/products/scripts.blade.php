{{-- ============================================================
     Products › Alpine JS
     productPage() component — controls the slide-over panel,
     form state, UOM rows, and form submission.
     ============================================================ --}}
<script>
    function productPage() {
        return {
            open: false,
            editMode: false,

            form: {
                id: null,
                code: '',
                name: '',
                category_code: '',
                barcode: '',
                price: null,
                stock: null,
                status: 'active',
                uoms: [],
            },

            emptyForm() {
                return {
                    id: null,
                    code: '',
                    name: '',
                    category_code: '',
                    barcode: '',
                    price: null,
                    stock: null,
                    status: 'active',
                    uoms: [],
                };
            },

            openAdd() {
                this.editMode = false;
                this.form = this.emptyForm();
                this.open = true;
            },

            openEdit(product) {
                this.editMode = true;
                this.form = {
                    id: product.id ?? null,
                    code: product.code ?? '',
                    name: product.name ?? '',
                    category_code: product.category_code ?? '',
                    barcode: product.barcode ?? '',
                    price: product.price ?? null,
                    stock: product.stock ?? null,
                    status: product.status ?? 'active',
                    uoms: (product.uoms ?? []).map(u => ({
                        description: u.description ?? '',
                        quantity_per_unit: u.quantity_per_unit ?? 1,
                        price: u.price ?? null,
                    })),
                };
                this.open = true;
            },

            closePanel() {
                this.open = false;
            },

            addUomRow() {
                this.form.uoms.push({
                    description: '',
                    quantity_per_unit: 1,
                    price: null
                });
            },

            removeUomRow(index) {
                this.form.uoms.splice(index, 1);
            },

            submitForm() {
                console.log('Submitting product:', this.form);
                this.closePanel();
            },
        };
    }
</script>
