<!-- ADD / EDIT USER SLIDE-OVER PANEL -->
<div x-show="open" x-cloak class="fixed inset-0 z-50" style="display: none;">
    <div x-show="open" x-transition.opacity @click="closePanel()"
        class="absolute inset-0 bg-gray-900/40 dark:bg-black/60"></div>

    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
        class="absolute right-0 top-0 h-full w-full max-w-md bg-white dark:bg-zinc-900 shadow-xl flex flex-col">

        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-zinc-800">
            <h2 class="text-base font-semibold text-gray-800 dark:text-zinc-100"
                x-text="editMode ? 'Edit User' : 'Add User'"></h2>
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
                <input type="email" x-model="form.email" required placeholder="name@bluetech.com"
                    class="w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200 placeholder-gray-400 dark:placeholder-zinc-500">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Role</label>
                <div class="relative">
                    <select x-model="form.role" required
                        class="appearance-none w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md pl-3 pr-8 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200">
                        <option value="" class="bg-white dark:bg-zinc-900">Select role</option>
                        <option value="admin" class="bg-white dark:bg-zinc-900">Admin</option>
                        <option value="cashier" class="bg-white dark:bg-zinc-900">Cashier</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor"
                        class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">
                        Password <span x-show="editMode"
                            class="text-gray-400 dark:text-zinc-500 normal-case font-normal">(leave blank to
                            keep)</span>
                    </label>
                    <input type="password" x-model="form.password" :required="!editMode" placeholder="••••••••"
                        class="w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200 placeholder-gray-400 dark:placeholder-zinc-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Confirm
                        Password</label>
                    <input type="password" x-model="form.password_confirmation" :required="!editMode"
                        placeholder="••••••••"
                        class="w-full text-sm bg-transparent border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] text-gray-800 dark:text-zinc-200 placeholder-gray-400 dark:placeholder-zinc-500">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400">Status</label>
                <button type="button" @click="form.status = form.status === 'active' ? 'inactive' : 'active'"
                    class="relative inline-flex items-center h-6 w-11 rounded-full transition"
                    :class="form.status === 'active' ? 'bg-[#0F6E8C]' : 'bg-gray-300 dark:bg-zinc-700'">
                    <span class="inline-block h-4 w-4 transform bg-white rounded-full transition"
                        :class="form.status === 'active' ? 'translate-x-6' : 'translate-x-1'"></span>
                </button>
            </div>

        </form>

        <div class="flex items-center justify-end gap-3 px-5 py-4 border-t border-gray-200 dark:border-zinc-800">
            <button @click="closePanel()" type="button"
                class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-zinc-300 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
                Cancel
            </button>
            <button @click="submitForm()" type="button"
                class="px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">
                <span x-text="editMode ? 'Save Changes' : 'Save User'"></span>
            </button>
        </div>
    </div>
</div>
