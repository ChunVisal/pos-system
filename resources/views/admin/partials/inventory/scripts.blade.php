<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDarkMode = document.documentElement.classList.contains('dark');

        const trendCanvas = document.getElementById('movementTrendChart');
        const existingTrend = Chart.getChart(trendCanvas);
        if (existingTrend) existingTrend.destroy();

        new Chart(trendCanvas.getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($trend['labels']),
                datasets: [{
                    label: 'Stock In',
                    data: @json($trend['stock_in']),
                    backgroundColor: '#10B981',
                    borderRadius: 4,
                    barPercentage: 0.6,
                    categoryPercentage: 0.6,
                }, {
                    label: 'Stock Out',
                    data: @json($trend['stock_out']),
                    backgroundColor: '#EF4444',
                    borderRadius: 4,
                    barPercentage: 0.6,
                    categoryPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                resizeDelay: 100,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#787878',
                            font: {
                                size: 11
                            }
                        },
                        border: {
                            display: false
                        },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#787878',
                            font: {
                                size: 11
                            },
                            stepSize: 5
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.15)',
                            borderDash: [4, 4]
                        },
                        border: {
                            display: false
                        },
                    }
                }
            }
        });
    });
</script>

<script>
    function inventoryPage() {
        return {
            open: false,
            stockMap: {{ \Illuminate\Support\Js::from($products->pluck('stock_quantity', 'code')) }},

            form: {
                product_code: '',
                type: 'in',
                quantity: null,
                reason: '',
                notes: '',
            },

            get currentStock() {
                return this.form.product_code ? (this.stockMap[this.form.product_code] ?? null) : null;
            },

            openAdjust(item = null) {
                this.form = {
                    product_code: item ? item.code : '',
                    type: 'in',
                    quantity: null,
                    reason: '',
                    notes: '',
                };
                this.open = true;
            },

            closePanel() {
                this.open = false;
            },

            submitForm() {
                console.log('Submitting stock adjustment:', this.form);
                this.closePanel();
            },
        }
    }
</script>
