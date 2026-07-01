<!-- Filters -->
<div class="rounded-md shadow-xs border border-gray-200 dark:border-zinc-800/60 flex flex-wrap items-center gap-3 mb-4">
    <div class="relative flex-1 min-w-[200px]">
        <i
            class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 text-xs"></i>
        <input type="text" placeholder="Search by name or email..."
            class="w-full pl-8 pr-3 py-1.5 text-xs bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200 placeholder-gray-400 dark:placeholder-zinc-500">
    </div>
    <div class="relative">
        <select
            class="appearance-none text-xs bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
            <option value="" class="bg-white dark:bg-zinc-900">All Roles</option>
            <option value="admin" class="bg-white dark:bg-zinc-900">Admin</option>
            <option value="cashier" class="bg-white dark:bg-zinc-900">Cashier</option>
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
            <option value="" class="bg-white dark:bg-zinc-900">All Status</option>
            <option value="active" class="bg-white dark:bg-zinc-900">Active</option>
            <option value="inactive" class="bg-white dark:bg-zinc-900">Inactive</option>
        </select>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor"
            class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </div>
</div>

<!-- Users Table -->
<div class="bg-white dark:bg-zinc-900 p-4 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800/60">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr
                    class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800">
                    <th class="pb-2 pr-4 font-medium">User</th>
                    <th class="pb-2 px-4 font-medium">Role</th>
                    <th class="pb-2 px-4 font-medium text-center">Status</th>
                    <th class="pb-2 px-4 font-medium">Last Login</th>
                    <th class="pb-2 px-4 font-medium">Online</th>
                    <th class="pb-2 pl-4 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                @forelse($users as $user)
                    @php
                        $initials = collect(explode(' ', $user->name))
                            ->map(fn($n) => strtoupper($n[0]))
                            ->take(2)
                            ->implode('');
                        $avatarColor = $user->role === 'admin' ? '#8B5CF6' : '#0F6E8C';
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition">
                        <td class="py-3 pr-4">
                            <button class="flex items-center gap-3 cursor-pointer"
                                @click="openDetail({{ $user->id }})">
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-xs font-semibold text-white shrink-0"
                                        style="background-color: {{ $avatarColor }};">
                                        {{ $initials }}
                                    </div>
                                    @if ($user->is_online)
                                        <div
                                            class="w-3.5 h-3.5 bg-green-500 rounded-full absolute top-0 right-0 border-2 border-white dark:border-zinc-800">
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-col items-start">
                                    <p class="font-medium text-gray-800 dark:text-zinc-200">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-400 dark:text-zinc-500">{{ $user->email }}</p>
                                </div>
                            </button>
                        </td>
                        <td class="py-3 px-4">
                            <span
                                class="px-2 py-0.5 text-[11px] font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400' : 'bg-[#0F6E8C]/10 dark:bg-[#0F6E8C]/30 text-[#0F6E8C] dark:text-[#4a9eb8]' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span
                                class="px-2 py-0.5 text-[11px] font-semibold rounded-full {{ $user->status === 'active' ? 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400' : 'bg-gray-100 dark:bg-zinc-800 text-gray-500 dark:text-zinc-400' }}">
                                {{ $user->status === 'active' ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-xs text-gray-500">
                            {{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->diffForHumans() : 'Never' }}
                        </td>
                        <td class="py-3 px-4">
                            @if ($user->is_online)
                                <span
                                    class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-950 dark:text-green-400">Online</span>
                            @else
                                <span
                                    class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-500 dark:bg-zinc-800 dark:text-zinc-400">Offline</span>
                            @endif
                        </td>
                        <td class="py-3 pl-4">
                            <div class="flex items-center justify-end gap-3">
                                <button @click='openEdit(@json($user))'
                                    class="text-gray-400 dark:text-zinc-500 hover:text-[#0F6E8C]" title="Edit">
                                    <x-heroicon-s-pencil-square class="w-4 h-4" />
                                </button>
                                <button onclick="deleteUser({{ $user->id }}, this)"
                                    class="text-red-500 hover:text-red-600" title="Delete">
                                    <x-heroicon-s-trash class="w-4 h-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-400 text-sm">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
