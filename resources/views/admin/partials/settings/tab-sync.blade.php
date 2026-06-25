<!-- BACKUP & SYNC -->
<div id="settings-sync" class="settings-panel hidden">
    <h3 class="text-sm font-semibold text-gray-800 dark:text-zinc-100 mb-1">Backup & Sync</h3>
    <p class="text-xs text-gray-400 dark:text-zinc-500 mb-5">Status of offline data sync between the mobile cashier app
        and this server</p>

    <div class="max-w-2xl">
        <div
            class="flex items-center justify-between border border-gray-200 dark:border-zinc-700 rounded-md px-4 py-3 mb-4">
            <div class="flex items-center gap-3">
                <span
                    class="w-2.5 h-2.5 rounded-full {{ $sync['connection'] === 'online' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                <div>
                    <p class="text-sm font-medium text-gray-800 dark:text-zinc-200">
                        {{ $sync['connection'] === 'online' ? 'Online' : 'Offline' }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-zinc-500">Last synced
                        {{ \Carbon\Carbon::parse($sync['last_synced'])->diffForHumans() }}</p>
                </div>
            </div>
            <button
                class="px-3 py-1.5 text-xs font-semibold border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800 text-gray-700 dark:text-zinc-300 transition">
                <i class="fa-solid fa-rotate mr-1"></i> Sync Now
            </button>
        </div>

        <div
            class="flex items-center justify-between border border-gray-200 dark:border-zinc-700 rounded-md px-4 py-3 mb-4">
            <div>
                <p class="text-sm font-medium text-gray-800 dark:text-zinc-200">Auto Sync</p>
                <p class="text-[11px] text-gray-400 dark:text-zinc-500">Automatically sync when the device reconnects to
                    the internet</p>
            </div>
            <button type="button"
                class="settings-toggle relative inline-flex items-center h-5 w-9 rounded-full transition {{ $sync['auto_sync'] ? 'bg-[#0F6E8C]' : 'bg-gray-300 dark:bg-zinc-700' }}">
                <span
                    class="toggle-dot inline-block h-3.5 w-3.5 transform bg-white rounded-full transition {{ $sync['auto_sync'] ? 'translate-x-5' : 'translate-x-1' }}"></span>
            </button>
        </div>

        <div class="border border-gray-200 dark:border-zinc-700 rounded-md px-4 py-3">
            <p class="text-sm font-medium text-gray-800 dark:text-zinc-200">Pending Records</p>
            <p class="text-[11px] text-gray-400 dark:text-zinc-500 mb-2">Sales/inventory changes made offline, waiting
                to sync</p>
            @if ($sync['pending_records'] > 0)
                <span
                    class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">{{ $sync['pending_records'] }}
                    pending</span>
            @else
                <span
                    class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400">All
                    synced</span>
            @endif
        </div>
    </div>
</div>
