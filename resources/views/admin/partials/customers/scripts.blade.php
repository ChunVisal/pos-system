<script>
    function customerPage() {
        return {
            open: false,
            editMode: false,
            viewOpen: false,
            viewCustomerData: {},
            form: {
                id: null,
                name: '',
                email: '',
                phone: '',
                address: '',
                segment: 'regular',
                loyalty_points: 0,
            },

            emptyForm() {
                return {
                    id: null,
                    name: '',
                    email: '',
                    phone: '',
                    address: '',
                    segment: 'regular',
                    loyalty_points: 0,
                };
            },

            openAdd() {
                this.editMode = false;
                this.form = this.emptyForm();
                this.open = true;
            },

            openEdit(customer) {
                this.editMode = true;
                this.form = {
                    id: customer.id ?? null,
                    name: customer.name ?? '',
                    email: customer.email ?? '',
                    phone: customer.phone ?? '',
                    address: customer.address ?? '',
                    segment: customer.segment ?? 'regular',
                    loyalty_points: customer.loyalty_points ?? 0,
                };
                this.open = true;
            },

            viewCustomer(customer) {
                const segmentColors = {
                    vip: 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400',
                    regular: 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400',
                    new: 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400',
                    inactive: 'bg-gray-50 dark:bg-zinc-800 text-gray-500 dark:text-zinc-400',
                };
                const segmentLabels = {
                    vip: 'VIP',
                    regular: 'Regular',
                    new: 'New',
                    inactive: 'Inactive',
                };
                const initials = customer.name.split(' ').map(n => n[0].toUpperCase()).slice(0, 2).join('');

                this.viewCustomerData = {
                    ...customer,
                    initials: initials,
                    segmentClass: segmentColors[customer.segment] || segmentColors.regular,
                    segmentLabel: segmentLabels[customer.segment] || 'Regular',
                    recent_orders: customer.recent_orders || [{
                            id: '001',
                            date: 'Nov 25, 2023',
                            amount: 156.50,
                            status: 'Completed'
                        },
                        {
                            id: '002',
                            date: 'Nov 18, 2023',
                            amount: 89.00,
                            status: 'Completed'
                        },
                    ]
                };
                this.viewOpen = true;
            },

            openEditFromView() {
                this.closeView();
                this.openEdit(this.viewCustomerData);
            },

            closePanel() {
                this.open = false;
            },

            closeView() {
                this.viewOpen = false;
            },

            deleteCustomer(customer) {
                if (confirm(`Are you sure you want to delete ${customer.name}?`)) {
                    console.log('Deleting customer:', customer);
                    // Implement delete logic
                }
            },

            submitForm() {
                console.log('Submitting customer:', this.form);
                this.closePanel();
            },
        }
    }
</script>
