<!-- Title -->
<div class="mb-4">
    <h1 class="text-xl font-bold text-gray-800 dark:text-zinc-100">Settings</h1>
    <p class="text-xs text-gray-500 dark:text-zinc-400">Configure your store, payments, and system preferences</p>
</div>

<!-- Tabs -->
<div class="bg-white dark:bg-zinc-900 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800/60">
    <div
        class="tab-container flex items-center gap-6 border-b border-gray-200 dark:border-zinc-800 px-4 pt-3 scrollbar-hide overflow-x-auto">
        <button
            class="settings-tab flex items-center gap-2 text-sm font-semibold text-[#0F6E8C] border-b-2 border-[#0F6E8C] pb-3 whitespace-nowrap"
            data-tab="profile">
            <i class="fa-solid fa-store"></i> Store Profile
        </button>
        <button
            class="settings-tab flex items-center gap-2 text-sm font-medium text-gray-500 dark:text-zinc-400 hover:text-gray-700 dark:hover:text-zinc-300 border-b-2 border-transparent pb-3 whitespace-nowrap"
            data-tab="tax">
            <i class="fa-solid fa-coins"></i> Tax & Currency
        </button>
        <button
            class="settings-tab flex items-center gap-2 text-sm font-medium text-gray-500 dark:text-zinc-400 hover:text-gray-700 dark:hover:text-zinc-300 border-b-2 border-transparent pb-3 whitespace-nowrap"
            data-tab="receipt">
            <i class="fa-solid fa-receipt"></i> Receipt
        </button>
        <button
            class="settings-tab flex items-center gap-2 text-sm font-medium text-gray-500 dark:text-zinc-400 hover:text-gray-700 dark:hover:text-zinc-300 border-b-2 border-transparent pb-3 whitespace-nowrap"
            data-tab="payments">
            <i class="fa-solid fa-credit-card"></i> Payment Methods
        </button>
        <button
            class="settings-tab flex items-center gap-2 text-sm font-medium text-gray-500 dark:text-zinc-400 hover:text-gray-700 dark:hover:text-zinc-300 border-b-2 border-transparent pb-3 whitespace-nowrap"
            data-tab="notifications">
            <i class="fa-solid fa-bell"></i> Notifications
        </button>
        <button
            class="settings-tab flex items-center gap-2 text-sm font-medium text-gray-500 dark:text-zinc-400 hover:text-gray-700 dark:hover:text-zinc-300 border-b-2 border-transparent pb-3 whitespace-nowrap"
            data-tab="sync">
            <i class="fa-solid fa-rotate"></i> Backup & Sync
        </button>
        <button
            class="settings-tab flex items-center gap-2 text-sm font-medium text-gray-500 dark:text-zinc-400 hover:text-gray-700 dark:hover:text-zinc-300 border-b-2 border-transparent pb-3 whitespace-nowrap"
            data-tab="security">
            <i class="fa-solid fa-lock"></i> Security
        </button>
    </div>

    <div class="p-5">
        @include('admin.partials.settings.tab-profile')
        @include('admin.partials.settings.tab-tax')
        @include('admin.partials.settings.tab-receipt')
        @include('admin.partials.settings.tab-payments')
        @include('admin.partials.settings.tab-notifications')
        @include('admin.partials.settings.tab-sync')
        @include('admin.partials.settings.tab-security')
    </div>
</div>
