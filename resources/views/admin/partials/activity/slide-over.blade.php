<!-- ACTIVITY DETAIL MODAL -->
<div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
    <div x-show="modalOpen" x-transition.opacity @click="modalOpen = false"
        class="absolute inset-0 bg-gray-900/60 dark:bg-black/70"></div>

    <div x-show="modalOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white dark:bg-zinc-900 rounded-lg shadow-xl max-w-md w-full mx-4 p-6">

        <button @click="modalOpen = false"
            class="absolute right-4 top-4 text-gray-400 dark:text-zinc-500 hover:text-gray-600 dark:hover:text-zinc-300">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold text-white"
                style="background: linear-gradient(135deg, {{ $selectedActivity['color'] ?? '#0F6E8C' }}, {{ $selectedActivity['color'] ?? '#0F6E8C' }});">
                <span x-text="selectedActivity.initials || 'U'"></span>
            </div>
            <div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-zinc-100"
                    x-text="selectedActivity.user || 'User'"></h3>
                <p class="text-xs text-gray-500 dark:text-zinc-400" x-text="selectedActivity.time || ''"></p>
            </div>
        </div>

        <div class="space-y-3">
            <div class="flex items-center gap-2">
                <span class="text-xs font-medium text-gray-500 dark:text-zinc-400">Action:</span>
                <span class="text-sm text-gray-800 dark:text-zinc-200" x-text="selectedActivity.action || ''"></span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-medium text-gray-500 dark:text-zinc-400">Module:</span>
                <span class="text-sm text-[#0F6E8C] font-semibold" x-text="selectedActivity.module || ''"></span>
            </div>
            <template x-if="selectedActivity.entity">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-medium text-gray-500 dark:text-zinc-400">Entity:</span>
                    <span class="text-sm text-gray-700 dark:text-zinc-300"
                        x-text="selectedActivity.entity || ''"></span>
                </div>
            </template>
            <template x-if="selectedActivity.details">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-medium text-gray-500 dark:text-zinc-400">Details:</span>
                    <span class="text-sm text-gray-600 dark:text-zinc-400"
                        x-text="selectedActivity.details || ''"></span>
                </div>
            </template>
            <div class="flex items-center gap-2">
                <span class="text-xs font-medium text-gray-500 dark:text-zinc-400">Status:</span>
                <span class="px-2 py-0.5 text-[11px] font-semibold rounded-full"
                    :class="selectedActivity.status === 'success' ?
                        'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400' :
                        (selectedActivity.status === 'warning' ?
                            'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400' :
                            'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400')"
                    x-text="selectedActivity.status ? selectedActivity.status.charAt(0).toUpperCase() + selectedActivity.status.slice(1) : ''">
                </span>
            </div>
        </div>
    </div>
</div>
