<script>
    function productPage() {
        return {
            requestOpen: false,
            requestForm: {
                product_id: '',
                quantity: 1,
                notes: ''
            },

            openRequest() {
                this.requestOpen = true;
            },

            submitRequest() {
                fetch('/cashier/stock-request', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify(this.requestForm)
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert(data.message);
                        this.requestOpen = false;
                    });
            },

            confirmReceipt(id) {
                fetch(`/cashier/stock-request/${id}/confirm`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert(data.message);
                        window.location.reload();
                    });
            },

            disputeDrop(id) {
                const reason = prompt('Reason:');
                if (!reason) return;
                fetch(`/cashier/stock-request/${id}/dispute`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            reason
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert(data.message);
                        window.location.reload();
                    });
            },
        }
    }
</script>
