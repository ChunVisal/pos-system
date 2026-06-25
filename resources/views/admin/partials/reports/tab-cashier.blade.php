<!-- SALESPERSON TAB -->
<div id="tab-staff" class="report-panel p-4 hidden">
    <div class="tab-container">
        <table class="w-full text-sm">
            <thead>
                <tr
                    class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800">
                    <th class="pb-2 pr-4 font-medium">Salesperson</th>
                    <th class="pb-2 px-4 font-medium text-center">Transactions</th>
                    <th class="pb-2 px-4 font-medium">Top Item</th>
                    <th class="pb-2 px-4 font-medium text-right">Revenue</th>
                    <th class="pb-2 pl-4 font-medium w-40">Share</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                @foreach ($salespeople as $person)
                    @php
                        $initials = collect(explode(' ', $person['name']))
                            ->map(fn($n) => strtoupper($n[0]))
                            ->take(2)
                            ->implode('');
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition">
                        <td class="py-3 pr-4">
                            <div class="flex w-12 h-12 items-center gap-3">
                                <div
                                    class="w-full h-full rounded-full bg-[#0F6E8C] flex items-center justify-center text-[11px] font-semibold text-white shrink-0">
                                    {{ $initials }}
                                </div>
                                <span class="whitespace-nowrap font-medium text-gray-800 dark:text-zinc-200">{{ $person['name'] }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-center text-gray-600 dark:text-zinc-400">{{ $person['transactions'] }}
                        </td>
                        <td class="py-3 px-4 text-gray-600 dark:text-zinc-400">{{ $person['top_item'] }}</td>
                        <td class="py-3 px-4 text-right font-semibold text-gray-800 dark:text-zinc-200">
                            ${{ number_format($person['revenue'], 2) }}</td>
                        <td class="py-3 pl-4">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-1.5 bg-gray-200 dark:bg-zinc-800 rounded-full">
                                    <div class="h-1.5 bg-[#0F6E8C] rounded-full"
                                        style="width: {{ $person['percent'] }}%;"></div>
                                </div>
                                <span
                                    class="text-xs text-gray-400 dark:text-zinc-500 w-8 text-right">{{ $person['percent'] }}%</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
