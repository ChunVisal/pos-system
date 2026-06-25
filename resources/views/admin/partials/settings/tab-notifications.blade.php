<!-- NOTIFICATIONS -->
<div id="settings-notifications" class="settings-panel hidden">
    <h3 class="text-sm font-semibold text-gray-800 dark:text-zinc-100 mb-1">Notifications</h3>
    <p class="text-xs text-gray-400 dark:text-zinc-500 mb-5">Choose what alerts you want to receive</p>

    <div class="max-w-2xl space-y-2">
        <div class="flex items-center justify-between border border-gray-200 dark:border-zinc-700 rounded-md px-4 py-3">
            <div>
                <p class="text-sm font-medium text-gray-800 dark:text-zinc-200">Low Stock Alerts</p>
                <p class="text-[11px] text-gray-400 dark:text-zinc-500">Notify when a product falls below its reorder
                    level</p>
            </div>
            <button type="button"
                class="settings-toggle relative inline-flex items-center h-5 w-9 rounded-full transition {{ $notifications['low_stock_alert'] ? 'bg-[#0F6E8C]' : 'bg-gray-300 dark:bg-zinc-700' }}">
                <span
                    class="toggle-dot inline-block h-3.5 w-3.5 transform bg-white rounded-full transition {{ $notifications['low_stock_alert'] ? 'translate-x-5' : 'translate-x-1' }}"></span>
            </button>
        </div>

        <div class="border border-gray-200 dark:border-zinc-700 rounded-md px-4 py-3">
            <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Low Stock Threshold</label>
            <input type="number" value="{{ $notifications['low_stock_threshold'] }}"
                class="w-32 text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
            <span class="text-xs text-gray-400 dark:text-zinc-500 ml-2">units remaining triggers an alert</span>
        </div>

        <div class="flex items-center justify-between border border-gray-200 dark:border-zinc-700 rounded-md px-4 py-3">
            <div>
                <p class="text-sm font-medium text-gray-800 dark:text-zinc-200">Email Alerts</p>
                <p class="text-[11px] text-gray-400 dark:text-zinc-500">Send alerts to the store email address</p>
            </div>
            <button type="button"
                class="settings-toggle relative inline-flex items-center h-5 w-9 rounded-full transition {{ $notifications['email_alerts'] ? 'bg-[#0F6E8C]' : 'bg-gray-300 dark:bg-zinc-700' }}">
                <span
                    class="toggle-dot inline-block h-3.5 w-3.5 transform bg-white rounded-full transition {{ $notifications['email_alerts'] ? 'translate-x-5' : 'translate-x-1' }}"></span>
            </button>
        </div>

        <div class="flex items-center justify-between border border-gray-200 dark:border-zinc-700 rounded-md px-4 py-3">
            <div>
                <p class="text-sm font-medium text-gray-800 dark:text-zinc-200">New Sale Notification</p>
                <p class="text-[11px] text-gray-400 dark:text-zinc-500">Notify admins on every completed sale</p>
            </div>
            <button type="button"
                class="settings-toggle relative inline-flex items-center h-5 w-9 rounded-full transition {{ $notifications['new_sale_alert'] ? 'bg-[#0F6E8C]' : 'bg-gray-300 dark:bg-zinc-700' }}">
                <span
                    class="toggle-dot inline-block h-3.5 w-3.5 transform bg-white rounded-full transition {{ $notifications['new_sale_alert'] ? 'translate-x-5' : 'translate-x-1' }}"></span>
            </button>
        </div>

        <div class="flex items-center justify-between border border-gray-200 dark:border-zinc-700 rounded-md px-4 py-3">
            <div>
                <p class="text-sm font-medium text-gray-800 dark:text-zinc-200">Daily Summary Email</p>
                <p class="text-[11px] text-gray-400 dark:text-zinc-500">Send a daily sales recap each morning</p>
            </div>
            <button type="button"
                class="settings-toggle relative inline-flex items-center h-5 w-9 rounded-full transition {{ $notifications['daily_summary'] ? 'bg-[#0F6E8C]' : 'bg-gray-300 dark:bg-zinc-700' }}">
                <span
                    class="toggle-dot inline-block h-3.5 w-3.5 transform bg-white rounded-full transition {{ $notifications['daily_summary'] ? 'translate-x-5' : 'translate-x-1' }}"></span>
            </button>
        </div>
    </div>

    <div class="mt-5">
        <button
            class="px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">Save
            Changes</button>
    </div>
</div>
