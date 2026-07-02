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
            <button class="flex items-center gap-3 cursor-pointer" @click="openDetail({{ $user->id }})">
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
                    <i class="fa-solid fa-pen"></i>
                </button>
                <button onclick="deleteUser({{ $user->id }}, this)" class="text-red-500 hover:text-red-600"
                    title="Delete">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </td>

        <td class="pl-2 pb-1">
            <input type="checkbox" class="bulk-checkbox rounded border-gray-300 dark:border-zinc-600 cursor-pointer"
                data-id="{{ $user->id }}" onchange="updateBulkBar()">
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center py-16">
            <div class="flex flex-col items-center justify-center">
                <div class="w-16 h-16 mb-4 bg-gray-100 dark:bg-zinc-800 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400 dark:text-zinc-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-gray-700 dark:text-zinc-300 mb-1">No users found
                </h3>
                <p class="text-xs text-gray-400 dark:text-zinc-500">Try adjusting your filters</p>
            </div>
        </td>
    </tr>
@endforelse
