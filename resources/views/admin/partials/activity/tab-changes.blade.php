<!-- CHANGE HISTORY TAB -->
<div id="tab-changes" class="activity-panel hidden">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <div class="relative">
                <select
                    class="appearance-none text-xs bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
                    <option value="" class="bg-white dark:bg-zinc-900">All Entities</option>
                    <option value="product" class="bg-white dark:bg-zinc-900">Products</option>
                    <option value="order" class="bg-white dark:bg-zinc-900">Orders</option>
                    <option value="user" class="bg-white dark:bg-zinc-900">Users</option>
                    <option value="customer" class="bg-white dark:bg-zinc-900">Customers</option>
                    <option value="settings" class="bg-white dark:bg-zinc-900">Settings</option>
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
                    <option value="" class="bg-white dark:bg-zinc-900">All Users</option>
                    @foreach ($auditLogs->pluck('user')->unique() as $user)
                        <option value="{{ $user }}" class="bg-white dark:bg-zinc-900">{{ $user }}
                        </option>
                    @endforeach
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor"
                    class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
        </div>
        <button class="text-xs text-[#0F6E8C] hover:underline">View All Changes</button>
    </div>

    <!-- Change History Cards -->
    <div class="space-y-3">
        @php
            $changes = [
                [
                    'entity' => 'Product',
                    'name' => 'Organic Coffee Beans',
                    'field' => 'Price',
                    'old_value' => '$12.99',
                    'new_value' => '$14.99',
                    'user' => 'Sokha Chan',
                    'timestamp' => '2024-06-20 14:32',
                    'reason' => 'Supplier price increase',
                ],
                [
                    'entity' => 'Customer',
                    'name' => 'Dara Kim',
                    'field' => 'Segment',
                    'old_value' => 'Regular',
                    'new_value' => 'VIP',
                    'user' => 'Maly Touch',
                    'timestamp' => '2024-06-20 11:15',
                    'reason' => 'Reached 50 orders threshold',
                ],
                [
                    'entity' => 'Settings',
                    'name' => 'Tax Rate',
                    'field' => 'Value',
                    'old_value' => '10%',
                    'new_value' => '12%',
                    'user' => 'Sokha Chan',
                    'timestamp' => '2024-06-19 09:00',
                    'reason' => 'Government tax update',
                ],
            ];
        @endphp

        @foreach ($changes as $change)
            <div
                class="border border-gray-200 dark:border-zinc-700 rounded-md p-4 hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition">
                <div class="flex flex-wrap items-start justify-between gap-2">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-md flex items-center justify-center
                            {{ $change['entity'] === 'Product'
                                ? 'bg-blue-50 dark:bg-blue-900/30'
                                : ($change['entity'] === 'Customer'
                                    ? 'bg-green-50 dark:bg-green-900/30'
                                    : 'bg-purple-50 dark:bg-purple-900/30') }}">
                            <i
                                class="fa-solid 
                                {{ $change['entity'] === 'Product' ? 'fa-box' : ($change['entity'] === 'Customer' ? 'fa-user' : 'fa-gear') }} 
                                text-sm {{ $change['entity'] === 'Product'
                                    ? 'text-blue-600 dark:text-blue-400'
                                    : ($change['entity'] === 'Customer'
                                        ? 'text-green-600 dark:text-green-400'
                                        : 'text-purple-600 dark:text-purple-400') }}">
                            </i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span
                                    class="text-sm font-semibold text-gray-800 dark:text-zinc-200">{{ $change['name'] }}</span>
                                <span class="text-xs text-gray-400 dark:text-zinc-500">({{ $change['entity'] }})</span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-zinc-400">
                                {{ $change['field'] }} changed from <span
                                    class="line-through text-red-500">{{ $change['old_value'] }}</span>
                                to <span
                                    class="text-green-600 dark:text-green-400 font-semibold">{{ $change['new_value'] }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-xs text-gray-500 dark:text-zinc-400">{{ $change['user'] }}</p>
                        <p class="text-[10px] text-gray-400 dark:text-zinc-500">{{ $change['timestamp'] }}</p>
                    </div>
                </div>
                @if (isset($change['reason']))
                    <div
                        class="mt-2 text-xs text-gray-400 dark:text-zinc-500 bg-gray-50 dark:bg-zinc-800/30 rounded px-3 py-1.5">
                        <i class="fa-regular fa-comment mr-1"></i> {{ $change['reason'] }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
