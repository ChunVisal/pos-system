<!-- AUDIT LOG TAB -->
<div id="tab-audit" class="activity-panel hidden">
    <!-- Audit Filters -->
    <div class="flex flex-wrap items-center gap-2 mb-4">
        <div class="relative flex-1 min-w-[180px]">
            <i
                class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 text-xs"></i>
            <input type="text" placeholder="Search audit records..."
                class="w-full pl-8 pr-3 py-1.5 text-xs bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200 placeholder-gray-400 dark:placeholder-zinc-500">
        </div>
        <div class="relative">
            <select
                class="appearance-none text-xs bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
                <option value="" class="bg-white dark:bg-zinc-900">All Action Types</option>
                <option value="create" class="bg-white dark:bg-zinc-900">Create</option>
                <option value="update" class="bg-white dark:bg-zinc-900">Update</option>
                <option value="delete" class="bg-white dark:bg-zinc-900">Delete</option>
                <option value="login" class="bg-white dark:bg-zinc-900">Login</option>
                <option value="logout" class="bg-white dark:bg-zinc-900">Logout</option>
                <option value="export" class="bg-white dark:bg-zinc-900">Export</option>
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
                <option value="" class="bg-white dark:bg-zinc-900">All IP Addresses</option>
                @foreach ($auditLogs->pluck('ip')->unique() as $ip)
                    <option value="{{ $ip }}" class="bg-white dark:bg-zinc-900">{{ $ip }}</option>
                @endforeach
            </select>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor"
                class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </div>
    </div>

    <!-- Audit Log Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr
                    class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800">
                    <th class="pb-2 pr-4 font-medium">Time</th>
                    <th class="pb-2 px-4 font-medium">User</th>
                    <th class="pb-2 px-4 font-medium">Action</th>
                    <th class="pb-2 px-4 font-medium">Target</th>
                    <th class="pb-2 px-4 font-medium">IP Address</th>
                    <th class="pb-2 px-4 font-medium">Changes</th>
                    <th class="pb-2 pl-4 font-medium text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                @foreach ($auditLogs as $log)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition">
                        <td class="py-3 pr-4 text-gray-500 dark:text-zinc-400 text-xs whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($log['timestamp'])->format('M d, Y H:i') }}
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-[10px] font-semibold text-white shrink-0"
                                    style="background: linear-gradient(135deg, #0F6E8C, #1a8aa8);">
                                    {{ $log['initials'] }}
                                </div>
                                <span class="font-medium text-gray-800 dark:text-zinc-200">{{ $log['user'] }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span
                                class="px-2 py-0.5 text-[11px] font-semibold rounded-full
                                {{ $log['action_type'] === 'create'
                                    ? 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400'
                                    : ($log['action_type'] === 'update'
                                        ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'
                                        : ($log['action_type'] === 'delete'
                                            ? 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400'
                                            : 'bg-gray-50 dark:bg-zinc-800 text-gray-500 dark:text-zinc-400')) }}">
                                {{ ucfirst($log['action_type']) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-gray-600 dark:text-zinc-400">
                            <span class="text-xs">{{ $log['target'] }}</span>
                            <span class="text-[10px] text-gray-400 dark:text-zinc-500 block">{{ $log['module'] }}</span>
                        </td>
                        <td class="py-3 px-4 text-gray-500 dark:text-zinc-400 text-xs">{{ $log['ip'] }}</td>
                        <td class="py-3 px-4">
                            <button @click="viewChanges(@json($log))"
                                class="text-xs text-[#0F6E8C] hover:underline">
                                View Changes
                            </button>
                        </td>
                        <td class="py-3 pl-4 text-right">
                            <span
                                class="px-2 py-0.5 text-[11px] font-semibold rounded-full
                                {{ $log['status'] === 'success'
                                    ? 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400'
                                    : 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400' }}">
                                {{ ucfirst($log['status']) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-200 dark:border-zinc-800">
        <p class="text-xs text-gray-500 dark:text-zinc-400">Showing 1-10 of 384 audit records</p>
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
