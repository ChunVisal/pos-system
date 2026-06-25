<!-- ACTIVITY LOG TAB -->
<div id="tab-activity" class="activity-panel">
    <!-- Activity Filters -->
    <div class="flex flex-wrap items-center gap-6 mb-4">
        <div class="relative flex-1 min-w-[180px]">
            <i
                class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 text-xs"></i>
            <input type="text" placeholder="Search activities..."
                class="w-full pl-8 pr-3 py-1.5 text-xs bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200 placeholder-gray-400 dark:placeholder-zinc-500">
        </div>
        <div class="relative">
            <select
                class="appearance-none text-xs bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
                <option value="" class="bg-white dark:bg-zinc-900">All Users</option>
                @foreach ($activities->pluck('user')->unique() as $user)
                    <option value="{{ $user }}" class="bg-white dark:bg-zinc-900">{{ $user }}</option>
                @endforeach
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
                <option value="" class="bg-white dark:bg-zinc-900">All Actions</option>
                @foreach ($events as $event)
                    <option value="{{ $event }}" class="bg-white dark:bg-zinc-900">{{ ucfirst($event) }}</option>
                @endforeach
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
                <option value="" class="bg-white dark:bg-zinc-900">All Modules</option>
                @foreach ($modules as $module)
                    <option value="{{ $module }}" class="bg-white dark:bg-zinc-900">{{ ucfirst($module) }}
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

    <!-- Activity Timeline -->
    <div class="space-y-4">
        @foreach ($activities->groupBy('date') as $date => $dayActivities)
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-xs font-semibold text-gray-500 dark:text-zinc-400">{{ $date }}</span>
                    <div class="flex-1 h-px bg-gray-200 dark:bg-zinc-800"></div>
                    <span class="text-[10px] text-gray-400 dark:text-zinc-500">{{ count($dayActivities) }}
                        activities</span>
                </div>

                @foreach ($dayActivities as $activity)
                    <div
                        class="flex items-start gap-3 py-3 border-b border-gray-100 dark:border-zinc-800/50 hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition px-2 rounded-md">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold text-white shrink-0 mt-0.5"
                            style="background: linear-gradient(135deg, {{ $activity['color'] ?? '#0F6E8C' }}, {{ $activity['color'] ?? '#0F6E8C' }});">
                            {{ $activity['initials'] }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span
                                    class="font-medium text-gray-800 dark:text-zinc-200 text-sm">{{ $activity['user'] }}</span>
                                <span class="text-xs text-gray-500 dark:text-zinc-400">{{ $activity['action'] }}</span>
                                <span class="text-xs font-semibold text-[#0F6E8C]">{{ $activity['module'] }}</span>
                                @if (isset($activity['entity']))
                                    <span
                                        class="text-xs text-gray-400 dark:text-zinc-500">"{{ $activity['entity'] }}"</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-3 mt-0.5">
                                <span class="text-xs text-gray-400 dark:text-zinc-500">{{ $activity['time'] }}</span>
                                @if (isset($activity['details']))
                                    <span class="text-xs text-gray-400 dark:text-zinc-500">·</span>
                                    <span
                                        class="text-xs text-gray-400 dark:text-zinc-500">{{ $activity['details'] }}</span>
                                @endif
                                <span class="ml-auto">
                                    <span
                                        class="px-2 py-0.5 text-[10px] font-medium rounded-full 
                                        {{ $activity['status'] === 'success'
                                            ? 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400'
                                            : ($activity['status'] === 'warning'
                                                ? 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400'
                                                : 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400') }}">
                                        {{ ucfirst($activity['status']) }}
                                    </span>
                                </span>
                            </div>
                        </div>
                        <button @click="viewActivity(@json($activity))"
                            class="text-gray-400 dark:text-zinc-500 hover:text-[#0F6E8C] dark:hover:text-[#4a9eb8] shrink-0">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <!-- Load More -->
    <div class="text-center mt-6">
        <button
            class="px-6 py-2 text-xs font-semibold text-[#0F6E8C] border border-[#0F6E8C] rounded-md hover:bg-[#0F6E8C]/10 transition">
            Load More Activities
        </button>
    </div>
</div>
