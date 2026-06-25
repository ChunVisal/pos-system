<div x-show="open" x-cloak class="fixed inset-0 z-50" style="display: none;">
    <div x-show="open" x-transition.opacity @click="closePanel()"
        class="absolute inset-0 bg-gray-900/40 dark:bg-black/60"></div>

    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
        class="absolute right-0 top-0 h-full w-full max-w-md bg-white dark:bg-zinc-900 shadow-xl flex flex-col">

        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-zinc-800">
            <h2 class="text-base font-semibold text-gray-800 dark:text-zinc-100"
                x-text="editMode ? 'Edit Customer' : 'Add Customer'"></h2>
            <button @click="closePanel()"
                class="text-gray-400 dark:text-zinc-500 hover:text-gray-600 dark:hover:text-zinc-300">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form @submit.prevent="submitForm()" class="flex-1 overflow-y-auto px-5 py-4 space-y-5">
            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Full Name</label>
                <input type="text" x-model="form.name" required placeholder="e.g. Sokha Chan"
                    class="w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200 placeholder-gray-400 dark:placeholder-zinc-500">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Email Address</label>
                <input type="email" x-model="form.email" required placeholder="customer@email.com"
                    class="w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200 placeholder-gray-400 dark:placeholder-zinc-500">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Phone Number</label>
                <input type="tel" x-model="form.phone" placeholder="+855 12 345 678"
                    class="w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200 placeholder-gray-400 dark:placeholder-zinc-500">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Address</label>
                <textarea x-model="form.address" rows="2" placeholder="Street, City, Country"
                    class="w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200 placeholder-gray-400 dark:placeholder-zinc-500"></textarea>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Customer Segment</label>
                <div class="relative">
                    <select x-model="form.segment" required
                        class="appearance-none w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md pl-3 pr-8 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
                        <option value="regular" class="bg-white dark:bg-zinc-900">Regular</option>
                        <option value="vip" class="bg-white dark:bg-zinc-900">VIP</option>
                        <option value="new" class="bg-white dark:bg-zinc-900">New</option>
                        <option value="inactive" class="bg-white dark:bg-zinc-900">Inactive</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor"
                        class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400">Loyalty Points</label>
                <div class="flex items-center gap-3">
                    <button type="button" @click="form.loyalty_points = Math.max(0, form.loyalty_points - 10)"
                        class="text-gray-400 dark:text-zinc-500 hover:text-gray-600 dark:hover:text-zinc-300">
                        <i class="fa-solid fa-minus-circle text-lg"></i>
                    </button>
                    <span class="text-lg font-bold text-gray-800 dark:text-zinc-100 w-12 text-center"
                        x-text="form.loyalty_points"></span>
                    <button type="button" @click="form.loyalty_points = form.loyalty_points + 10"
                        class="text-gray-400 dark:text-zinc-500 hover:text-gray-600 dark:hover:text-zinc-300">
                        <i class="fa-solid fa-plus-circle text-lg"></i>
                    </button>
                </div>
            </div>
        </form>

        <div class="flex items-center justify-end gap-3 px-5 py-4 border-t border-gray-200 dark:border-zinc-800">
            <button @click="closePanel()" type="button"
                class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-zinc-300 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
                Cancel
            </button>
            <button @click="submitForm()" type="button"
                class="px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">
                <span x-text="editMode ? 'Save Changes' : 'Add Customer'"></span>
            </button>
        </div>
    </div>
</div>
