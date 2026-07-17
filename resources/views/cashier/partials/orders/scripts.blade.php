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
                                price: parseFloat(i.price) || 0,
                                qty: i.quantity,
                            })),
                            subtotal: parseFloat(order.subtotal) || 0,
                            tax: parseFloat(order.tax) || 0,
                            total: parseFloat(order.total) || 0,
                            discount: parseFloat(order.discount) || 0,
                            vip_discount: parseFloat(order.vip_discount) || 0,
                            is_vip: order.is_vip || false,
                            payment_method: order.payment?.method,
                            amount_received: parseFloat(order.payment?.amount_received) || parseFloat(order
                                .total) || 0,
                            change: parseFloat(order.payment?.change) || 0,
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
