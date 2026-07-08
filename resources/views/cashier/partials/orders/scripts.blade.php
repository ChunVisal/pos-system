<script>
    function orderPage() {
        return {
            orderDetailOpen: false,
            receiptOpen: false,
            receiptData: {},
            lastOrder: {},

            viewOrder(id) {
                fetch(`/cashier/orders/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        const order = data.order;
                        this.receiptData = {
                            order_number: order.order_number,
                            items: order.items.map(i => ({
                                id: i.id,
                                name: i.name,
                                price: i.price,
                                qty: i.quantity,
                            })),
                            subtotal: order.subtotal,
                            tax: order.tax,
                            total: order.total,
                            payment_method: order.payment?.method,
                            amount_received: order.payment?.amount_received || order.total,
                            change: order.payment?.change || 0,
                            customer: order.customer ? {
                                name: order.customer.name
                            } : null,
                        };
                        this.lastOrder = {
                            order_number: order.order_number
                        };
                        this.receiptOpen = true;
                    });
            },
        };
    }
</script>
