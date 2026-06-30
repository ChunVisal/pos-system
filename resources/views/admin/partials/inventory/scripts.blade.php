<script>
    document.addEventListener('DOMContentLoaded', function() {

        $(document).ready(function() {
            let searchTimer;

            $('#search').on('input', function() {
                clearTimeout(searchTimer);
                const query = $(this).val();
                $('#clearSearch').toggle(query.length > 0);

                searchTimer = setTimeout(function() {
                    $.get('{{ route('admin.inventory') }}', {
                        search: query,
                        ajax: 1
                    }, function(data) {
                        $('#InventoryTable').html(data.table);
                    });
                }, 400); // debounce 400ms
            });

            $('#clearSearch').on('click', function() {
                $('#search').val('').trigger('input');
            });
        });

        var categoryFilter = document.getElementById('categoryFilter');
        var stockFilter = document.getElementById('stockFilter');
        var emptyRow = document.getElementById('noCategoryRow');

        function filterTable() {
            var categoryVal = categoryFilter ? categoryFilter.value : '';
            var stockVal = stockFilter ? stockFilter.value : 'all';
            var anyVisible = false;

            document.querySelectorAll('tbody tr').forEach(function(row) {
                if (row === emptyRow) return;
                var cells = row.getElementsByTagName('td');
                if (cells.length < 6) return;

                var catText = cells[1].textContent.trim();
                var stockText = cells[4].textContent.trim();

                var categoryMatch = (categoryVal === '' || catText === categoryVal);
                var stockMatch = true;
                if (stockVal === 'out') stockMatch = stockText.includes('Out');
                else if (stockVal === 'low') stockMatch = stockText.includes('Low');
                else if (stockVal === 'normal') stockMatch = !stockText.includes('Out') && !stockText
                    .includes('Low');

                if (categoryMatch && stockMatch) {
                    row.style.display = '';
                    anyVisible = true;
                } else {
                    row.style.display = 'none';
                }
            });

            if (emptyRow) emptyRow.style.display = anyVisible ? 'none' : '';
        }

        if (categoryFilter) categoryFilter.addEventListener('change', filterTable);
        if (stockFilter) stockFilter.addEventListener('change', filterTable);
    });

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
                minBarLength: 3,
            }, {
                label: 'Stock Out',
                data: @json($trend['stock_out']),
                backgroundColor: '#EF4444',
                borderRadius: 4,
                barPercentage: 0.6,
                categoryPercentage: 0.6,
                minBarLength: 3,
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

    // If there's a search query, scroll to search bar
    @if (request('search'))
        document.addEventListener('DOMContentLoaded', function() {
            const searchEl = document.getElementById('searchSection');
            if (searchEl) {
                setTimeout(() => {
                    searchEl.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    document.getElementById('search').focus();
                }, 100);
            }
        });
    @endif
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
                if (this.submitting) return;
                this.submitting = true;

                fetch('{{ route('admin.inventory.adjust') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.form)
                    })
                    .then(res => res.json().then(data => ({
                        ok: res.ok,
                        data
                    })))
                    .then(({
                        ok,
                        data
                    }) => {
                        this.submitting = false;
                        if (!ok) {
                            alert(data.error || 'Something went wrong');
                            return;
                        }
                        this.stockMap[this.form.product_code] = data.new_stock;
                        this.closePanel();
                        window.location.reload();
                    })
                    .catch(err => {
                        this.submitting = false;
                        alert('Error: ' + err.message);
                    });
            },
        }
    }
</script>
