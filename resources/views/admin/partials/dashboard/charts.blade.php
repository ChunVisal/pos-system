{{-- ============================================================
     Dashboard › Charts
     Sales Overview (line) + Payment breakdown (donut)
     ============================================================ --}}
<div class="flex gap-4 w-full min-w-0">

    {{-- ── Sales Overview (line chart) ── --}}
    <div
        class="w-2/3 min-w-0 bg-white dark:bg-zinc-900 rounded-2xl shadow-sm p-5 overflow-hidden border border-gray-200 dark:border-zinc-800/50">

        <div class="flex items-center justify-between mb-2">
            <h3 class="text-[15px] font-semibold text-gray-800 dark:text-zinc-100">Sales Overview</h3>
            <button type="button" class="text-gray-400 dark:text-zinc-500 hover:text-gray-600 dark:hover:text-zinc-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <circle cx="12" cy="5" r="1.6" />
                    <circle cx="12" cy="12" r="1.6" />
                    <circle cx="12" cy="19" r="1.6" />
                </svg>
            </button>
        </div>

        <div class="relative min-w-0" style="height: 180px;">
            <canvas id="salesOverviewChart"></canvas>

            {{-- Floating tooltip --}}
            <div id="salesTooltip"
                class="hidden absolute -translate-x-1/2 -translate-y-full bg-gray-900 dark:bg-zinc-800 text-white dark:text-zinc-100 text-xs rounded-lg px-3 py-2 shadow-lg whitespace-nowrap pointer-events-none border border-transparent dark:border-zinc-700">
                <div class="text-gray-300 dark:text-zinc-400 text-[11px] leading-tight">June 2023</div>
                <div class="font-semibold text-[13px] leading-tight">16,5K</div>
                <div
                    class="absolute left-1/2 -bottom-1 -translate-x-1/2 w-2 h-2 bg-gray-900 dark:bg-zinc-800 rotate-45 border-r border-b border-transparent dark:border-zinc-700">
                </div>
            </div>
        </div>
    </div>

    {{-- ── Payment Breakdown (donut chart) ── --}}
    <div
        class="w-1/3 min-w-0 bg-white dark:bg-zinc-900 rounded-2xl shadow-sm p-5 overflow-hidden border border-gray-200 dark:border-zinc-800/50">

        <div class="flex items-center justify-between mb-2">
            <h3 class="text-[15px] font-semibold text-gray-800 dark:text-zinc-100">Payment</h3>
            <button type="button"
                class="text-gray-400 dark:text-zinc-500 hover:text-gray-600 dark:hover:text-zinc-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <circle cx="12" cy="5" r="1.6" />
                    <circle cx="12" cy="12" r="1.6" />
                    <circle cx="12" cy="19" r="1.6" />
                </svg>
            </button>
        </div>

        <div class="relative min-w-0" style="height: 150px;">
            <canvas id="paymentChart"></canvas>
        </div>

        <div class="flex items-center justify-center gap-4 mt-2">
            <span class="flex items-center gap-2 text-[11px] text-gray-600 dark:text-zinc-400">
                <span class="w-2.5 h-2.5 rounded-full" style="background:#a262e0"></span> Cash
            </span>
            <span class="flex items-center gap-2 text-[11px] text-gray-600 dark:text-zinc-400">
                <span class="w-2.5 h-2.5 rounded-full" style="background:#c9a3ec"></span> Credit/Debit
            </span>
            <span class="flex items-center gap-2 text-[11px] text-gray-600 dark:text-zinc-400">
                <span class="w-2.5 h-2.5 rounded-full" style="background:#e9d9f8"></span> KHQR
            </span>
        </div>
    </div>

</div>

{{-- ── Chart JS ── --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDarkMode = document.documentElement.classList.contains('dark');
        const labelColor = '#787878';

        // ── Sales Overview Line Chart ──────────────────────────────────
        const salesCtx = document.getElementById('salesOverviewChart').getContext('2d');
        const gradient = salesCtx.createLinearGradient(0, 0, 0, 180);
        gradient.addColorStop(0, 'rgba(249, 115, 22, 0.25)');
        gradient.addColorStop(1, 'rgba(249, 115, 22, 0)');

        const labels = ['May', '', 'Jun', '', 'Jul', '', 'Aug', '', 'Sep', '', 'Oct', '', 'Nov', ''];
        const data = [20000, 14000, 14500, 10000, 15500, 19000, 22000, 18500, 16500, 15500, 12000, 23000, 15500,
            11000
        ];
        const highlightIndex = 8;

        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    data,
                    borderColor: '#f97316',
                    borderWidth: 2.5,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.35,
                    pointRadius: (ctx) => ctx.dataIndex === highlightIndex ? 5 : 0,
                    pointHoverRadius: 5,
                    pointBackgroundColor: '#f97316',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: false
                    },
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: labelColor,
                            font: {
                                size: 11
                            },
                            autoSkip: false
                        },
                        border: {
                            display: false
                        },
                    },
                    y: {
                        min: 0,
                        max: 25000,
                        ticks: {
                            stepSize: 5000,
                            color: labelColor,
                            font: {
                                size: 11
                            },
                            callback: (v) => v === 0 ? '0' : (v / 1000) + 'k'
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.15)',
                            borderDash: [4, 4]
                        },
                        border: {
                            display: false
                        },
                    },
                },
            },
            plugins: [{
                id: 'staticTooltipPositioner',
                afterDraw(chart) {
                    const point = chart.getDatasetMeta(0).data[highlightIndex];
                    const tooltip = document.getElementById('salesTooltip');
                    if (point && tooltip) {
                        tooltip.style.left = point.x + 'px';
                        tooltip.style.top = (point.y - 10) + 'px';
                        tooltip.classList.remove('hidden');
                    }
                },
            }],
        });

        // ── Payment Donut Chart ────────────────────────────────────────
        const paymentCtx = document.getElementById('paymentChart').getContext('2d');
        const paymentData = [55, 30, 15];
        const paymentColors = ['#a262e0', '#c9a3ec', '#e9d9f8'];

        new Chart(paymentCtx, {
            type: 'doughnut',
            data: {
                labels: ['Cash', 'Credit/Debit', 'QRIS'],
                datasets: [{
                    data: paymentData,
                    backgroundColor: paymentColors,
                    borderWidth: 0,
                    cutout: '68%',
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: 28
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true
                    }
                },
            },
            plugins: [{
                id: 'donutLeaderLabels',
                afterDraw(chart) {
                    const {
                        ctx,
                        chartArea
                    } = chart;
                    const meta = chart.getDatasetMeta(0);
                    const cx = (chartArea.left + chartArea.right) / 2;
                    const cy = (chartArea.top + chartArea.bottom) / 2;

                    ctx.save();
                    ctx.font = '600 12px sans-serif';
                    ctx.fillStyle = isDarkMode ? '#e4e4e7' : '#374151';
                    ctx.strokeStyle = isDarkMode ? '#52525b' : '#9ca3af';
                    ctx.lineWidth = 1;

                    meta.data.forEach((arc, i) => {
                        const angle = (arc.startAngle + arc.endAngle) / 2;
                        const outerR = arc.outerRadius;
                        const startX = cx + Math.cos(angle) * outerR;
                        const startY = cy + Math.sin(angle) * outerR;
                        const midX = cx + Math.cos(angle) * (outerR + 16);
                        const midY = cy + Math.sin(angle) * (outerR + 16);
                        const dir = Math.cos(angle) >= 0 ? 1 : -1;
                        const endX = midX + dir * 14;

                        ctx.beginPath();
                        ctx.moveTo(startX, startY);
                        ctx.lineTo(midX, midY);
                        ctx.lineTo(endX, midY);
                        ctx.stroke();

                        ctx.textAlign = dir === 1 ? 'left' : 'right';
                        ctx.textBaseline = 'middle';
                        ctx.fillText(paymentData[i], endX + dir * 4, midY);
                    });
                    ctx.restore();
                },
            }],
        });
    });
</script>
