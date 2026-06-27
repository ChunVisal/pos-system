<div x-show="open" x-cloak class="fixed inset-0 z-50" style="display: none;">

    <div x-show="open" x-transition.opacity @click="closePanel()"
        class="absolute inset-0 bg-gray-900/40 dark:bg-black/60"></div>

    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
        class="absolute right-0 top-0 h-full w-full max-w-md bg-white dark:bg-zinc-900 shadow-xl flex flex-col border-l border-gray-200 dark:border-zinc-800">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-zinc-800">
            <h2 class="text-base font-semibold text-gray-800 dark:text-zinc-100"
                x-text="editMode ? 'Edit Product' : 'Add Product'"></h2>
            <button @click="closePanel()" type="button"
                class="text-gray-400 dark:text-zinc-500 hover:text-gray-600 dark:hover:text-zinc-300">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        {{-- ONE form wrapping fields + footer --}}
        <form @submit.prevent="submitForm()" class="flex-1 flex flex-col overflow-hidden">

            {{-- Scrollable fields --}}
            <div class="flex-1 overflow-y-auto px-5 py-4 space-y-4">

                {{-- Category --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Category *</label>
                    <select x-model="form.category_code" @change="loadProducts()" required
                        class="w-full text-sm bg-white dark:bg-zinc-800 text-gray-900 dark:text-zinc-100 border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->code }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Product Name --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Product Name
                        *</label>
                    <select x-model="form.name" @change="autoFillDetails()" required :disabled="!form.category_code"
                        class="w-full text-sm bg-white dark:bg-zinc-800 text-gray-900 dark:text-zinc-100 border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] disabled:opacity-50">
                        <option value="">Select product</option>
                        <template x-for="product in categoryProducts" :key="product.id">
                            <option :value="product.name" x-text="product.name"></option>
                        </template>
                    </select>
                </div>

                {{-- Image --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Product Image</label>

                    {{-- Preview --}}
                    <div x-show="form.image_preview || form.image_url" class="mb-2 relative inline-block">
                        <img :src="form.image_preview || form.image_url"
                            class="h-24 w-24 object-cover rounded-md border border-gray-200 dark:border-zinc-700">
                        <button type="button"
                            @click="form.image_preview = ''; form.image_url = ''; form.image_file = null;"
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    {{-- URL Input --}}
                    <input type="url" x-model="form.image_url"
                        @input="form.image_preview = ''; form.image_file = null;" placeholder="Paste image URL..."
                        class="w-full text-sm bg-white dark:bg-zinc-800 text-gray-900 dark:text-zinc-100 border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] mb-2">

                    {{-- Divider --}}
                    <div class="flex items-center gap-2 mb-2">
                        <div class="flex-1 h-px bg-gray-200 dark:bg-zinc-700"></div>
                        <span class="text-xs text-gray-400 dark:text-zinc-500">or upload file</span>
                        <div class="flex-1 h-px bg-gray-200 dark:bg-zinc-700"></div>
                    </div>

                    {{-- File Upload --}}
                    <label
                        class="flex items-center justify-center gap-2 w-full px-3 py-2 border border-dashed border-gray-300 dark:border-zinc-600 rounded-md cursor-pointer hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
                        <i class="fa-solid fa-arrow-up-from-bracket text-gray-400 text-sm"></i>
                        <span class="text-xs text-gray-500 dark:text-zinc-400"
                            x-text="form.image_file ? form.image_file.name : 'Click to upload image'"></span>
                        <input type="file" accept="image/*" class="hidden" @change="handleImageFile($event)">
                    </label>
                </div>


                {{-- Price + Stock --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Price ($)
                            *</label>
                        <input type="number" step="0.01" x-model.number="form.price" required placeholder="0.00"
                            class="w-full text-sm bg-white dark:bg-zinc-800 text-gray-900 dark:text-zinc-100 border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Stock *</label>
                        <input type="number" x-model.number="form.stock" required placeholder="0"
                            class="w-full text-sm bg-white dark:bg-zinc-800 text-gray-900 dark:text-zinc-100 border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                    </div>
                </div>

                {{-- Status --}}
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400">Active</label>
                    <button type="button" @click="form.status = form.status === 'active' ? 'inactive' : 'active'"
                        class="relative inline-flex items-center h-6 w-11 rounded-full transition"
                        :class="form.status === 'active' ? 'bg-[#0F6E8C]' : 'bg-gray-300 dark:bg-zinc-700'">
                        <span class="inline-block h-4 w-4 transform bg-white rounded-full transition"
                            :class="form.status === 'active' ? 'translate-x-6' : 'translate-x-1'"></span>
                    </button>
                </div>

            </div>

            {{-- Footer inside the same form --}}
            <div class="flex items-center justify-end gap-3 px-5 py-4 border-t border-gray-200 dark:border-zinc-800">
                <button @click="closePanel()" type="button"
                    class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-zinc-300 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800">
                    Cancel
                </button>
                <button type="submit" :disabled="submitting"
                    class="px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] disabled:opacity-60 disabled:cursor-not-allowed flex items-center text-center gap-1">
                    <i x-show="submitting" class="fa-solid fa-spinner fa-spin"></i>
                    <span
                        x-text="submitting ? (editMode ? 'Saving...' : 'Adding...') : (editMode ? 'Save Changes' : 'Add Product')"></span>
                </button>
            </div>

        </form>{{-- ← only one closing form tag --}}

    </div>
</div>
