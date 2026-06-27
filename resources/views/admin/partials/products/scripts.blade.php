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

    function productPage() {

        let _isSubmitting = false;

        return {

            categoryProducts: [],
            search: '',
            open: false,
            editMode: false,
            submitting: false,
            selectedCategoryId: null,
            pendingName: '',



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
                image_url: '',
                image_file: null,
                image_preview: '',
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
                    image_url: '',
                    image_file: null,
                    image_preview: '',
                };
            },

            handleImageFile(event) {
                const file = event.target.files[0];
                if (!file) return;
                this.form.image_file = file;
                this.form.image_preview = URL.createObjectURL(file);
                this.form.image_url = ''; // clear url if file chosen
            },

            clearSearch() {
                this.search = '';
            },

            openAdd() {
                _isSubmitting = false
                this.editMode = false;
                this.submitting = false; // ← reset
                this.categoryProducts = [];
                this.selectedCategoryId = null;
                this.pendingName = '';
                this.form = this.emptyForm();
                this.open = true;
            },

            openEdit(product) {
                this.editMode = true;
                this.submitting = false;
                this.categoryProducts = [];
                this.selectedCategoryId = product.category_id ?? null;
                this.pendingName = product.name ?? '';

                this.form = {
                    id: product.id ?? null,
                    code: product.code ?? '',
                    name: '',
                    category_code: product.category?.code ?? '',
                    barcode: product.barcode ?? '',
                    price: product.selling_price ?? null,
                    stock: product.stock_quantity ?? null,
                    status: product.status ?? 'active',
                    uoms: [],
                    image_url: product.image ?? '',
                    image_file: null,
                    image_preview: '',
                };

                this.open = true;

                if (!this.form.category_code) return;

                fetch(`/admin/products/by-category?category_code=${this.form.category_code}`)
                    .then(res => res.json())
                    .then(data => {
                        this.categoryProducts = Array.isArray(data.products) ? data.products : [];
                        this.selectedCategoryId = data.category_id ?? null;
                        this.form.name = this.pendingName;
                    })
                    .catch(() => {
                        this.categoryProducts = [];
                        this.form.name = this.pendingName;
                    });
            },

            closePanel() {
                this.open = false;
            },

            loadProducts() {
                this.form.name = '';
                this.selectedCategoryId = null;

                if (!this.form.category_code) return;

                fetch(`/admin/products/by-category?category_code=${this.form.category_code}`)
                    .then(res => res.json())
                    .then(data => {
                        this.categoryProducts = Array.isArray(data.products) ? data.products : [];
                        this.selectedCategoryId = data.category_id ?? null;
                    })
                    .catch(() => {
                        this.categoryProducts = [];
                    });
            },

            autoFillDetails() {
                const selected = this.categoryProducts.find(p => p.name === this.form.name);
                if (!selected) return;
                this.form.price = selected.selling_price ?? null;
            },

            submitForm() {
                if (_isSubmitting) {
                    console.log('Blocked duplicate submit');
                    return;
                }
                _isSubmitting = true;
                this.submitting = true;

                const url = this.editMode ? `/admin/products/${this.form.id}` : `/admin/products`;

                const fd = new FormData();
                fd.append('name', this.form.name);
                fd.append('category_id', this.selectedCategoryId);
                fd.append('selling_price', this.form.price);
                fd.append('stock_quantity', this.form.stock);
                fd.append('status', this.form.status);

                if (this.form.image_file) {
                    fd.append('image_file', this.form.image_file);
                } else if (this.form.image_url) {
                    fd.append('image_url', this.form.image_url);
                }

                if (this.editMode) fd.append('_method', 'PUT');

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: fd
                    })
                    .then(res => {
                        if (!res.ok) return res.text().then(t => {
                            throw new Error(t);
                        });
                        return res.json();
                    })
                    .then(data => {
                        if (data && data.id) {
                            _isSubmitting = false;
                            window.location.href = window.location.pathname;
                        }
                    })
                    .catch(err => {
                        _isSubmitting = false;
                        this.submitting = false;
                        alert('Error: ' + err.message);
                    });
            },

            
        };
    }
</script>
