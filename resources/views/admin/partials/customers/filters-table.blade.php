<div class="flex flex-wrap gap-2 mb-4">
    @foreach ($segments as $segment)
        <button
            class="segment-filter px-3 py-1.5 text-xs font-medium rounded-full border transition
            {{ $segment['active'] ? 'bg-[#0F6E8C] text-white border-[#0F6E8C]' : 'bg-white dark:bg-zinc-900 text-gray-600 dark:text-zinc-400 border-gray-300 dark:border-zinc-700 hover:bg-gray-50 dark:hover:bg-zinc-800' }}">
            {{ $segment['label'] }}
            <span class="ml-1 {{ $segment['active'] ? 'text-white/70' : 'text-gray-400 dark:text-zinc-500' }}">(
                {{ $segment['count'] }} )</span>
        </button>
    @endforeach
</div>

<div class="rounded-md shadow-xs border border-gray-200 dark:border-zinc-800/60 flex flex-wrap items-center gap-3 mb-4">
    <div class="relative flex-1 min-w-[200px]">
        <i
            class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 text-xs"></i>
        <input type="text" placeholder="Search by name, email, or phone..."
            class="w-full pl-8 pr-3 py-1.5 text-xs bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200 placeholder-gray-400 dark:placeholder-zinc-500">
    </div>
    <div class="relative">
        <select
            class="appearance-none text-xs bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
            <option value="" class="bg-white dark:bg-zinc-900">All Segments</option>
            <option value="regular" class="bg-white dark:bg-zinc-900">Regular</option>
            <option value="vip" class="bg-white dark:bg-zinc-900">VIP</option>
            <option value="new" class="bg-white dark:bg-zinc-900">New</option>
            <option value="inactive" class="bg-white dark:bg-zinc-900">Inactive</option>
        </select>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor"
            class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </div>
    <div class="relative">
        <select
            class="appearance-none text-xs bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
            <option value="" class="bg-white dark:bg-zinc-900">Sort By</option>
            <option value="recent" class="bg-white dark:bg-zinc-900">Most Recent</option>
            <option value="spent" class="bg-white dark:bg-zinc-900">Highest Spent</option>
            <option value="orders" class="bg-white dark:bg-zinc-900">Most Orders</option>
        </select>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor"
            class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </div>
</div>

<div class="bg-white dark:bg-zinc-900 p-4 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800/60">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr
                    class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800">
                    <th class="pb-2 pr-4 font-medium">Customer</th>
                    <th class="pb-2 px-4 font-medium">Segment</th>
                    <th class="pb-2 px-4 font-medium text-center">Orders</th>
                    <th class="pb-2 px-4 font-medium text-right">Total Spent</th>
                    <th class="pb-2 px-4 font-medium">Last Order</th>
                    <th class="pb-2 pl-4 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                @forelse($customers as $customer)
                    @php
                        $initials = collect(explode(' ', $customer['name']))
                            ->map(fn($n) => strtoupper($n[0]))
                            ->take(2)
                            ->implode('');
                        $segmentColors = [
                            'vip' => [
                                'bg' => 'bg-yellow-50 dark:bg-yellow-900/30',
                                'text' => 'text-yellow-600 dark:text-yellow-400',
                            ],
                            'regular' => [
                                'bg' => 'bg-blue-50 dark:bg-blue-900/30',
                                'text' => 'text-blue-600 dark:text-blue-400',
                            ],
                            'new' => [
                                'bg' => 'bg-green-50 dark:bg-green-900/30',
                                'text' => 'text-green-600 dark:text-green-400',
                            ],
                            'inactive' => [
                                'bg' => 'bg-gray-50 dark:bg-zinc-800',
                                'text' => 'text-gray-500 dark:text-zinc-400',
                            ],
                        ];
                        $segmentClass = $segmentColors[$customer['segment']] ?? $segmentColors['regular'];
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition cursor-pointer"
                        @click="viewCustomer(@json($customer))">
                        <td class="py-3 pr-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center text-xs font-semibold text-white shrink-0"
                                    style="background: linear-gradient(135deg, #0F6E8C, #1a8aa8);">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-zinc-200">{{ $customer['name'] }}</p>
                                    <p class="text-xs text-gray-400 dark:text-zinc-500">{{ $customer['email'] }}</p>
                                    <p class="text-xs text-gray-400 dark:text-zinc-500">{{ $customer['phone'] }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span
                                class="px-2 py-0.5 text-[11px] font-semibold rounded-full {{ $segmentClass['bg'] }} {{ $segmentClass['text'] }}">
                                {{ ucfirst($customer['segment']) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center text-gray-600 dark:text-zinc-400">{{ $customer['orders'] }}
                        </td>
                        <td class="py-3 px-4 text-right font-semibold text-gray-800 dark:text-zinc-200">
                            ${{ number_format($customer['total_spent'], 2) }}</td>
                        <td class="py-3 px-4 text-gray-500 dark:text-zinc-400 text-xs">
                            {{ \Carbon\Carbon::parse($customer['last_order'])->format('M d, Y') }}</td>
                        <td class="py-3 pl-4">
                            <div class="flex items-center justify-end gap-3">
                                <button @click.stop="openEdit(@json($customer))"
                                    class="text-gray-400 dark:text-zinc-500 hover:text-[#0F6E8C] dark:hover:text-[#4a9eb8]"
                                    title="Edit">
                                    <x-heroicon-s-pencil-square class="w-4 h-4" />
                                </button>
                                <button @click.stop="deleteCustomer(@json($customer))"
                                    class="text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300"
                                    title="Delete">
                                    <x-heroicon-s-trash class="w-4 h-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-400 dark:text-zinc-500 text-sm">No
                            customers found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-200 dark:border-zinc-800">
        <p class="text-xs text-gray-500 dark:text-zinc-400">Showing 1-10 of 48 customers</p>
        <div class="flex items-center gap-1">
            <button
                class="px-3 py-1 text-xs border border-gray-300 dark:border-zinc-700 rounded-md text-gray-600 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-800 transition">Previous</button>
            <button class="px-3 py-1 text-xs bg-[#0F6E8C] text-white rounded-md">1</button>
            <button
                class="px-3 py-1 text-xs border border-gray-300 dark:border-zinc-700 rounded-md text-gray-600 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-800 transition">2</button>
            <button
                class="px-3 py-1 text-xs border border-gray-300 dark:border-zinc-700 rounded-md text-gray-600 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-800 transition">3</button>
            <button
                class="px-3 py-1 text-xs border border-gray-300 dark:border-zinc-700 rounded-md text-gray-600 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-800 transition">Next</button>
        </div>
    </div>
</div>
