<!-- PAYMENT REPORT TAB -->
<div id="tab-payment" class="report-panel p-4 hidden">
    <div class="flex flex-col md:flex-row gap-6">
        <div class="md:w-64 shrink-0">
            <div class="relative min-w-0" style="height: 220px;">
                <canvas id="paymentReportChart"></canvas>
            </div>
        </div>
        <div class="flex-1 min-w-0">
            <table class="w-full text-sm">
                <thead>
                    <tr
                        class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800">
                        <th class="pb-2 pr-4 font-medium">Payment Method</th>
                        <th class="pb-2 px-4 font-medium text-center">Transactions</th>
                        <th class="pb-2 px-4 font-medium text-right">Amount</th>
                        <th class="pb-2 pl-4 font-medium w-40">Share</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                    @foreach ($payments as $payment)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition">
                            <td class="py-3 pr-4">
                                <span class="flex items-center gap-2 font-medium text-gray-800 dark:text-zinc-200">
                                    <span class="w-2.5 h-2.5 rounded-full"
                                        style="background-color: {{ $payment['color'] }};"></span>
                                    {{ $payment['method'] }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center text-gray-600 dark:text-zinc-400">
                                {{ $payment['transactions'] }}</td>
                            <td class="py-3 px-4 text-right font-semibold text-gray-800 dark:text-zinc-200">
                                ${{ number_format($payment['amount'], 2) }}</td>
                            <td class="py-3 pl-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 h-1.5 bg-gray-200 dark:bg-zinc-800 rounded-full">
                                        <div class="h-1.5 rounded-full"
                                            style="width: {{ $payment['percent'] }}%; background-color: {{ $payment['color'] }};">
                                        </div>
                                    </div>
                                    <span
                                        class="text-xs text-gray-400 dark:text-zinc-500 w-8 text-right">{{ $payment['percent'] }}%</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
