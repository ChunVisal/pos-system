<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleFilter = document.getElementById('roleFilter');
        const statusFilter = document.getElementById('statusFilter');
        const emptyRow = document.getElementById('noUsersRow');

        function filterTable() {
            const roleValue = roleFilter.value;
            const statusValue = statusFilter.value;

            const rows = document.querySelectorAll('tbody tr');
            let anyVisible = false;

            rows.forEach(function(row) {
                // Skip empty state row
                const firstCell = row.querySelector('td');
                if (firstCell && firstCell.getAttribute('colspan')) return;

                const cells = row.querySelectorAll('td');
                if (cells.length < 6) return;

                // Role is in cells[1] - get the span text
                const roleSpan = cells[1]?.querySelector('span');
                const roleText = roleSpan ? roleSpan.textContent.trim().toLowerCase() : '';

                // Status is in cells[2] - get the span text  
                const statusSpan = cells[2]?.querySelector('span');
                const statusText = statusSpan ? statusSpan.textContent.trim().toLowerCase() : '';

                const roleMatch = !roleValue || roleText === roleValue;
                const statusMatch = !statusValue || statusText === statusValue;

                if (roleMatch && statusMatch) {
                    row.style.display = '';
                    anyVisible = true;
                } else {
                    row.style.display = 'none';
                }
            });
            if (emptyRow) emptyRow.style.display = anyVisible ? 'none' : '';
        }

        roleFilter.addEventListener('change', filterTable);
        statusFilter.addEventListener('change', filterTable);

        // searching filter 
        $(document).ready(function() {
            let searchTimer;

            $('#search').on('input', function() {
                clearTimeout(searchTimer);
                const query = $(this).val();
                $('#clearSearch').toggle(query.length > 0);

                searchTimer = setTimeout(function() {
                    $.get('{{ route('admin.users') }}', {
                        search: query,
                        ajax: 1
                    }, function(data) {
                        $('#usersTableBody').html(data.html);
                    });
                }, 400);
            });

            $('#clearSearch').on('click', function() {
                $('#search').val('').trigger('input');
            });
        });
    });
</script>

<script>
    // OUTSIDE userPage() - at the top
    function deleteUser(id, button) {
        if (!confirm('Delete this user?')) return;
        fetch(`/admin/users/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            })
            .then(() => button.closest('tr').remove())
            .catch(err => alert('Error: ' + err.message));
    }

    // Remove toggleAllCheckboxes function - no longer needed

    function updateBulkBar() {
        const count = document.querySelectorAll('.bulk-checkbox:checked').length;
        const bar = document.getElementById('bulkBar');
        const countEl = document.getElementById('bulkCount');
        if (bar) bar.style.display = count > 0 ? 'flex' : 'none';
        if (countEl) countEl.textContent = count;
    }

    function cancelBulkMode() {
        document.querySelectorAll('.bulk-checkbox').forEach(cb => cb.checked = false);
        updateBulkBar();
    }

    function toggleAllCheckboxes(source) {
        document.querySelectorAll('.bulk-checkbox').forEach(cb => cb.checked = source.checked);
        updateBulkBar();
    }

    function bulkDeactivate() {
        const ids = [...document.querySelectorAll('.bulk-checkbox:checked')].map(cb => cb.dataset.id);
        if (!ids.length) return alert('Select users first!');
        if (!confirm(`Deactivate ${ids.length} users?`)) return;
        fetch('/admin/users/bulk-deactivate', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    ids
                })
            })
            .then(res => res.json())
            .then(() => window.location.reload())
            .catch(err => alert('Error: ' + err.message));
    }

    function bulkDelete() {
        const ids = [...document.querySelectorAll('.bulk-checkbox:checked')].map(cb => cb.dataset.id);
        if (!ids.length) return alert('Select users first!');
        if (!confirm(`Delete ${ids.length} users permanently?`)) return;
        fetch('/admin/users/bulk-delete', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    ids
                })
            })
            .then(res => res.json())
            .then(() => window.location.reload())
            .catch(err => alert('Error: ' + err.message));
    }


    function userPage() {
        return {
            open: false,
            editMode: false,
            showProfile: false,
            viewMode: 'edit',
            submitting: false,

            form: {
                id: null,
                name: '',
                email: '',
                role: '',
                password: '',
                password_confirmation: '',
                status: 'active',
                employee_id: '',
                phone: '',
                address: '',
                shift: '',
                pin: '',
                hire_date: '',
                salary: '',
            },

            users: @json($users),

            openDetail(userId) {
                const user = this.users.find(u => u.id == userId);
                if (!user) return;

                this.viewMode = 'detail';
                this.form = {
                    id: user.id,
                    name: user.name,
                    email: user.email,
                    role: user.role,
                    status: user.status,
                    employee_id: user.employee_id,
                    phone: user.phone,
                    address: user.address,
                    shift: user.shift,
                    pin: user.pin,
                    hire_date: user.hire_date,
                    salary: user.salary,
                    last_login: user.last_login,
                    is_online: user.is_online,
                    created_at: user.created_at,
                };
                this.showProfile = true;
                this.open = false;
            },

            emptyForm() {
                return {
                    id: null,
                    name: '',
                    email: '',
                    role: '',
                    password: '',
                    password_confirmation: '',
                    status: 'active',
                    employee_id: '',
                    phone: '',
                    address: '',
                    shift: '',
                    pin: '',
                    hire_date: '',
                    salary: '',
                };
            },

            openAdd() {
                this.editMode = false;
                this.form = this.emptyForm();
                this.open = true;
            },

            openEdit(user) {
                this.editMode = true;
                this.form = {
                    id: user.id ?? null,
                    name: user.name ?? '',
                    email: user.email ?? '',
                    role: user.role ?? '',
                    password: '',
                    password_confirmation: '',
                    status: user.status ?? 'active',
                    employee_id: user.employee_id ?? '',
                    phone: user.phone ?? '',
                    address: user.address ?? '',
                    shift: user.shift ?? '',
                    pin: user.pin ?? '',
                    hire_date: user.hire_date ?? '',
                    salary: user.salary ?? '',
                };
                this.open = true;
            },

            closePanel() {
                this.open = false;
                this.showProfile = false;
                this.viewMode = 'edit';
            },
            submitForm() {
                if (this.submitting) return;
                this.submitting = true;

                const isEdit = this.editMode;
                const url = isEdit ? `/admin/users/${this.form.id}` : '/admin/users';

                // Validate
                if (!this.form.name || !this.form.email || !this.form.role) {
                    alert('Please fill all required fields');
                    this.submitting = false;
                    return;
                }

                if (!isEdit && !this.form.password) {
                    alert('Password is required');
                    this.submitting = false;
                    return;
                }

                if (this.form.password && this.form.password !== this.form.password_confirmation) {
                    alert('Passwords do not match');
                    this.submitting = false;
                    return;
                }

                // Build data object
                const data = {
                    name: this.form.name,
                    email: this.form.email,
                    role: this.form.role,
                    password: this.form.password || undefined,
                    password_confirmation: this.form.password_confirmation || undefined,
                    status: this.form.status,
                    employee_id: this.form.employee_id || null,
                    phone: this.form.phone || null,
                    address: this.form.address || null,
                    shift: this.form.shift || null,
                    pin: this.form.pin || null,
                    hire_date: this.form.hire_date || null,
                    salary: this.form.salary || null,
                };

                // Remove undefined values
                Object.keys(data).forEach(key => {
                    if (data[key] === undefined) delete data[key];
                    if (data[key] === '') data[key] = null;
                });

                fetch(url, {
                        method: isEdit ? 'PUT' : 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(data),
                    })
                    .then(res => {
                        if (!res.ok) return res.json().then(err => {
                            throw new Error(JSON.stringify(err.errors || err.message || err));
                        });
                        return res.json();
                    })
                    .then(() => {
                        this.submitting = false; // ← ADD
                        window.location.reload();
                    })
                    .catch(err => {
                        this.submitting = false; // ← ADD
                        alert('Error: ' + err.message);
                    });
            },
        }
    }
</script>
