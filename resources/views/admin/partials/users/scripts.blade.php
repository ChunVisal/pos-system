<script>
    function userPage() {
        return {
            open: false,
            editMode: false,
            form: {
                id: null,
                name: '',
                email: '',
                role: '',
                password: '',
                password_confirmation: '',
                status: 'active',
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
                };
                this.open = true;
            },

            closePanel() {
                this.open = false;
            },

            submitForm() {
                console.log('Submitting user:', this.form);
                this.closePanel();
            },
        }
    }
</script>
