<!-- Tab Navigation -->
<div class="bg-white dark:bg-zinc-900 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800/60">
    <div class="flex items-center gap-3 border-b border-gray-200 dark:border-zinc-800 px-4 pt-3 overflow-x-auto">
        <button
            class="activity-tab flex items-center gap-2 text-sm font-semibold text-[#0F6E8C] border-b-2 border-[#0F6E8C] pb-3 px-2 whitespace-nowrap"
            data-tab="activity">
            <i class="fa-solid fa-bolt"></i> Activity Log
        </button>
        <button
            class="activity-tab flex items-center gap-2 text-sm font-medium text-gray-500 dark:text-zinc-400 hover:text-gray-700 dark:hover:text-zinc-300 border-b-2 border-transparent pb-3 px-2 whitespace-nowrap"
            data-tab="audit">
            <i class="fa-solid fa-clipboard-list"></i> Audit Log
        </button>
        <button
            class="activity-tab flex items-center gap-2 text-sm font-medium text-gray-500 dark:text-zinc-400 hover:text-gray-700 dark:hover:text-zinc-300 border-b-2 border-transparent pb-3 px-2 whitespace-nowrap"
            data-tab="changes">
            <i class="fa-solid fa-code-compare"></i> Change History
        </button>
        <div class="flex-1"></div>
        <div class="flex items-center gap-2 pb-2">
            <div class="relative">
                <select
                    class="appearance-none text-xs bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
                    <option value="24h" class="bg-white dark:bg-zinc-900">Last 24 Hours</option>
                    <option value="7d" class="bg-white dark:bg-zinc-900" selected>Last 7 Days</option>
                    <option value="30d" class="bg-white dark:bg-zinc-900">Last 30 Days</option>
                    <option value="90d" class="bg-white dark:bg-zinc-900">Last 90 Days</option>
                    <option value="custom" class="bg-white dark:bg-zinc-900">Custom Range</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor"
                    class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
        </div>
    </div>

    <div class="p-4">
        @include('admin.partials.activity.tab-activity')
        @include('admin.partials.activity.tab-audit')
        @include('admin.partials.activity.tab-changes')
    </div>
</div>
