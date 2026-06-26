<script>
    // ── Filter table ──────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', function() {
        var categoryFilter = document.getElementById('categoryFilter');
        var statusFilter = document.getElementById('statusFilter');
        var stockFilter = document.getElementById('stockFilter');
        var emptyRow = document.getElementById('noCategoryRow');

        function filterTable() {
            var categoryVal = categoryFilter ? categoryFilter.value : 'all';
            var statusVal = statusFilter ? statusFilter.value : 'all';
            var stockVal = stockFilter ? stockFilter.value : 'all';

            var anyVisible = false;

            document.querySelectorAll('tbody tr').forEach(function(row) {
                if (row === emptyRow) return;

                var cells = row.getElementsByTagName('td');
                if (cells.length < 6) return;

                var catText = cells[1].textContent.trim();
                var stockText = cells[3].textContent.trim();
                var statusText = cells[5].textContent.trim();

                var categoryMatch = (categoryVal === 'all' || catText === categoryVal);
                var statusMatch = (statusVal === 'all' || statusText === statusVal);

                var stockMatch = true;
                if (stockVal === 'out') stockMatch = stockText.includes('Out');
                else if (stockVal === 'low') stockMatch = stockText.includes('Low');
                else if (stockVal === 'in') stockMatch = !stockText.includes('Out') && !stockText
                    .includes('Low');

                if (categoryMatch && statusMatch && stockMatch) {
                    row.style.display = '';
                    anyVisible = true;
                } else {
                    row.style.display = 'none';
                }
            });

            if (emptyRow) emptyRow.style.display = anyVisible ? 'none' : '';
        }

        if (categoryFilter) categoryFilter.addEventListener('change', filterTable);
        if (statusFilter) statusFilter.addEventListener('change', filterTable);
        if (stockFilter) stockFilter.addEventListener('change', filterTable);
    });

    // ── Delete product ────────────────────────────────────────────
    function deleteProduct(id, button) {
        if (!confirm('Are you sure you want to delete this product?')) return;

        fetch('/admin/products/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(function(response) {
                if (response.ok) button.closest('tr').remove();
            })
            .catch(console.error);
    }

    // ── Alpine component ──────────────────────────────────────────
    function productPage() {
        return {
            search: '',
            open: false,
            editMode: false,
            categoryProducts: [],
            selectedCategoryId: null,

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

            clearSearch() {
                this.search = '';
            },

            openAdd() {
                this.editMode = false;
                this.categoryProducts = [];
                this.selectedCategoryId = null;
                this.form = this.emptyForm();
                this.open = true;
            },

            openEdit(product) {
                this.editMode = true;
                this.submitting = false;
                this.categoryProducts = [];
                this.selectedCategoryId = product.category_id ?? null;

                this.form = {
                    id: product.id ?? null,
                    code: product.code ?? '',
                    name: product.name ?? '',
                    category_code: product.category?.code ?? '',
                    barcode: product.barcode ?? '',
                    price: product.selling_price ?? null,
                    stock: product.stock_quantity ?? null,
                    status: product.status ?? 'active',
                    uoms: [],
                };

                // Pre-load products for the category dropdown
                if (this.form.category_code) {
                    fetch(`/admin/products/by-category?category_code=${this.form.category_code}`)
                        .then(res => res.json())
                        .then(data => {
                            this.categoryProducts = Array.isArray(data.products) ? data.products : [];
                            this.selectedCategoryId = data.category_id ?? null;
                        });
                }

                this.open = true;
            },
            closePanel() {
                this.open = false;
            },

            loadProducts() {
                this.form.name = '';
                this.form.code = '';
                this.form.barcode = '';
                this.categoryProducts = [];
                this.selectedCategoryId = null;

                if (!this.form.category_code) return;

                fetch(`/admin/products/by-category?category_code=${this.form.category_code}`)
                    .then(res => res.json())
                    .then(data => {
                        // data = { category_id: 1, products: [...] }
                        this.categoryProducts = Array.isArray(data.products) ? data.products : [];
                        this.selectedCategoryId = data.category_id ?? null;
                    });
            },

            autoFillDetails() {
                const selected = this.categoryProducts.find(p => p.name === this.form.name);
                if (!selected) return;

                // Generate new unique code instead of reusing existing
                const prefix = this.form.category_code.replace('CAT-', '');
                const rand = Math.floor(Math.random() * 90000) + 10000;
                this.form.code = ''; // ← backend generates this
                this.form.barcode = '';
                this.form.price = selected.selling_price ?? null;
            },

            generateBarcode() {
                this.form.barcode = 'BC' + Math.floor(Math.random() * 1_000_000_000);
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
                if (this.submitting) return; // ← block double calls
                this.submitting = true;

                const url = this.editMode ? `/admin/products/${this.form.id}` : `/admin/products`;
                const method = this.editMode ? 'PUT' : 'POST';

                const payload = {
                    name: this.form.name,
                    category_id: this.selectedCategoryId,
                    selling_price: this.form.price,
                    stock_quantity: this.form.stock,
                    status: this.form.status,
                };

                fetch(url, {
                        method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => {
                        if (!res.ok) return res.text().then(text => {
                            throw new Error(text);
                        });
                        return res.json();
                    })
                    .then(data => {
                        if (data && data.id) {
                            window.location.href = window.location.pathname;
                        }
                    })
                    .catch(err => {
                        this.submitting = false; // ← reset on error so user can retry
                        alert('Error: ' + err.message);
                    });
            },
        };
    }
</script>
