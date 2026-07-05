 <script>
     function customerPage() {
         return {
             filterSegment: '',
             searchQuery: '',
             sortBy: 'recent',
             customers: @json($customers),

             customerDetailOpen: false,
             customerProfile: {},
             customerOrders: [],

             openCustomerDetail(customerId) {
                 fetch(`/cashier/customers/${customerId}`, {
                         headers: {
                             'Accept': 'application/json',
                         }
                     })
                     .then(res => res.json())
                     .then(data => {
                         this.customerProfile = data.customer;
                         this.customerOrders = data.orders;
                         this.customerDetailOpen = true;
                     });
             },

             get filteredCustomers() {
                 let result = [...this.customers];

                 // Filter by segment
                 if (this.filterSegment) {
                     result = result.filter(c => c.segment === this.filterSegment);
                 }

                 // Search
                 if (this.searchQuery) {
                     const q = this.searchQuery.toLowerCase();
                     result = result.filter(c =>
                         c.name.toLowerCase().includes(q) ||
                         c.phone.includes(q) ||
                         c.email.toLowerCase().includes(q)
                     );
                 }

                 // Sort
                 if (this.sortBy === 'spent') {
                     result.sort((a, b) => (b.total_spent || 0) - (a.total_spent || 0));
                 } else if (this.sortBy === 'orders') {
                     result.sort((a, b) => b.total_orders - a.total_orders);
                 } else {
                     result.sort((a, b) => new Date(b.last_order_at || 0) - new Date(a.last_order_at || 0));
                 }

                 return result;
             },

             filterCustomers() {},
             viewOrders(customer) {
                 alert('Orders for ' + customer.name + '\nTotal: ' + customer.total_orders + ' orders');
             }
         };
     }
 </script>
