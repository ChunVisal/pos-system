<!-- STORE PROFILE -->
<div id="settings-profile" class="settings-panel">
    <h3 class="text-sm font-semibold text-gray-800 dark:text-zinc-100 mb-1">Store Profile</h3>
    <p class="text-xs text-gray-400 dark:text-zinc-500 mb-5">Basic information shown on receipts and reports</p>

    <div class="flex items-center gap-4 mb-5">
        <div class="w-16 h-16 rounded-md bg-[#0F6E8C]/10 dark:bg-[#0F6E8C]/20 flex items-center justify-center">
            <i class="fa-solid fa-store text-2xl text-[#0F6E8C]"></i>
        </div>
        <div>
            <button type="button"
                class="px-3 py-1.5 text-xs font-semibold border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800 text-gray-700 dark:text-zinc-300 transition">
                Upload Logo
            </button>
            <p class="text-[11px] text-gray-400 dark:text-zinc-500 mt-1">PNG or JPG, recommended 200x200px</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl">
        <div>
            <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Store Name</label>
            <input type="text" value="{{ $profile['store_name'] }}"
                class="w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Phone</label>
            <input type="text" value="{{ $profile['phone'] }}"
                class="w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Email</label>
            <input type="email" value="{{ $profile['email'] }}"
                class="w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
        </div>
        <div class="sm:col-span-2">
            <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Address</label>
            <input type="text" value="{{ $profile['address'] }}"
                class="w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
        </div>
    </div>

    <div class="mt-5">
        <button
            class="px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">Save
            Changes</button>
    </div>
</div>
