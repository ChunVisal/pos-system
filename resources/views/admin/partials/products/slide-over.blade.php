{{-- ============================================================
     Products › Add / Edit Slide-Over Panel
     Right-side drawer for creating or editing a product.
     Controlled by Alpine x-data="productPage()" on the page root.
     Expects: $categories — from ProductData::getCategories()
     ============================================================ --}}
<div x-show="open" x-cloak class="fixed inset-0 z-50" style="display: none;">

    {{-- Backdrop --}}
    <div x-show="open" x-transition.opacity @click="closePanel()"
        class="absolute inset-0 bg-gray-900/40 dark:bg-black/60"></div>

    {{-- Panel --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
        class="absolute right-0 top-0 h-full w-full max-w-md bg-white dark:bg-zinc-900 shadow-xl flex flex-col border-l border-gray-200 dark:border-zinc-800">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-zinc-800">
            <h2 class="text-base font-semibold text-gray-800 dark:text-zinc-100"
                x-text="editMode ? 'Edit Product' : 'Add Product'"></h2>
            <button @click="closePanel()"
                class="text-gray-400 dark:text-zinc-500 hover:text-gray-600 dark:hover:text-zinc-300">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        {{-- Form body (scrollable) --}}
        <form @submit.prevent="submitForm()" class="flex-1 overflow-y-auto px-5 py-4 space-y-5">

            {{-- Product Name --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Product Name</label>
                <input type="text" x-model="form.name" required placeholder="e.g. AMD Ryzen 5 7600X"
                    class="w-full text-sm bg-white dark:bg-zinc-800 text-gray-900 dark:text-zinc-100 border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] placeholder-gray-400 dark:placeholder-zinc-500">
            </div>

            {{-- Product Code + Category --}}
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Product Code</label>
                    <input type="text" x-model="form.code" :disabled="editMode" placeholder="Auto-generated"
                        class="w-full text-sm border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 bg-gray-50 dark:bg-zinc-800/50 text-gray-900 dark:text-zinc-100 disabled:text-gray-400 dark:disabled:text-zinc-600 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] placeholder-gray-400 dark:placeholder-zinc-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Category</label>
                    <div class="relative">
                        <select x-model="form.category_code" required
                            class="appearance-none w-full text-sm bg-white dark:bg-zinc-800 text-gray-900 dark:text-zinc-100 border border-gray-300 dark:border-zinc-700 rounded-md pl-3 pr-8 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                            <option value="">Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category['code'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor"
                            class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-zinc-500 pointer-events-none">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Barcode --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Barcode</label>
                <div class="flex gap-2">
                    <input type="text" x-model="form.barcode" placeholder="Scan or enter barcode"
                        class="flex-1 text-sm bg-white dark:bg-zinc-800 text-gray-900 dark:text-zinc-100 border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] placeholder-gray-400 dark:placeholder-zinc-500">
                    <button type="button"
                        class="px-3 border border-gray-300 dark:border-zinc-700 rounded-md text-gray-500 dark:text-zinc-400 hover:bg-gray-50 dark:hover:bg-zinc-800">
                        <i class="fa-solid fa-barcode"></i>
                    </button>
                </div>
            </div>

            {{-- Price + Stock --}}
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Base Price
                        ($)</label>
                    <input type="number" step="0.01" x-model.number="form.price" required placeholder="0.00"
                        class="w-full text-sm bg-white dark:bg-zinc-800 text-gray-900 dark:text-zinc-100 border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] placeholder-gray-400 dark:placeholder-zinc-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400 mb-1">Stock
                        Quantity</label>
                    <input type="number" x-model.number="form.stock" required placeholder="0"
                        class="w-full text-sm bg-white dark:bg-zinc-800 text-gray-900 dark:text-zinc-100 border border-gray-300 dark:border-zinc-700 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] placeholder-gray-400 dark:placeholder-zinc-500">
                </div>
            </div>

            {{-- Status toggle --}}
            <div class="flex items-center justify-between">
                <label class="block text-xs font-medium text-gray-600 dark:text-zinc-400">Status</label>
                <button type="button" @click="form.status = form.status === 'active' ? 'inactive' : 'active'"
                    class="relative inline-flex items-center h-6 w-11 rounded-full transition"
                    :class="form.status === 'active' ? 'bg-[#0F6E8C]' : 'bg-gray-300 dark:bg-zinc-700'">
                    <span class="inline-block h-4 w-4 transform bg-white rounded-full transition"
                        :class="form.status === 'active' ? 'translate-x-6' : 'translate-x-1'"></span>
                </button>
            </div>

            {{-- UOM Section --}}
            <div class="pt-3 border-t border-gray-200 dark:border-zinc-800">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-semibold text-gray-700 dark:text-zinc-300">Units of Measure
                        (UOM)</label>
                    <button type="button" @click="addUomRow()"
                        class="text-xs text-[#0F6E8C] font-medium hover:underline">
                        <i class="fa-solid fa-plus mr-1"></i>Add UOM
                    </button>
                </div>
                <p class="text-[11px] text-gray-400 dark:text-zinc-500 mb-3">
                    e.g. Piece, Box of 10, Carton of 50 — each with its own price
                </p>

                <div class="space-y-2">
                    <template x-for="(uom, index) in form.uoms" :key="index">
                        <div
                            class="flex items-end gap-2 bg-gray-50 dark:bg-zinc-800/50 border border-gray-200 dark:border-zinc-700 rounded-md p-2">
                            <div class="flex-1">
                                <label
                                    class="block text-[10px] text-gray-500 dark:text-zinc-400 mb-1">Description</label>
                                <input type="text" x-model="uom.description" placeholder="Piece"
                                    class="w-full text-xs bg-white dark:bg-zinc-800 text-gray-900 dark:text-zinc-100 border border-gray-300 dark:border-zinc-700 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] placeholder-gray-400 dark:placeholder-zinc-500">
                            </div>
                            <div class="w-20">
                                <label class="block text-[10px] text-gray-500 dark:text-zinc-400 mb-1">Qty/Unit</label>
                                <input type="number" x-model.number="uom.quantity_per_unit" placeholder="1"
                                    class="w-full text-xs bg-white dark:bg-zinc-800 text-gray-900 dark:text-zinc-100 border border-gray-300 dark:border-zinc-700 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] placeholder-gray-400 dark:placeholder-zinc-500">
                            </div>
                            <div class="w-24">
                                <label class="block text-[10px] text-gray-500 dark:text-zinc-400 mb-1">Price
                                    ($)</label>
                                <input type="number" step="0.01" x-model.number="uom.price" placeholder="0.00"
                                    class="w-full text-xs bg-white dark:bg-zinc-800 text-gray-900 dark:text-zinc-100 border border-gray-300 dark:border-zinc-700 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C] placeholder-gray-400 dark:placeholder-zinc-500">
                            </div>
                            <button type="button" @click="removeUomRow(index)"
                                class="text-gray-400 dark:text-zinc-500 hover:text-red-500 dark:hover:text-red-400 pb-1.5"
                                title="Remove">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </div>
                    </template>

                    <p x-show="form.uoms.length === 0" class="text-xs text-gray-400 dark:text-zinc-500 italic">No
                        additional UOMs added.</p>
                </div>
            </div>

        </form>

        {{-- Footer --}}
        <div class="flex items-center justify-end gap-3 px-5 py-4 border-t border-gray-200 dark:border-zinc-800">
            <button @click="closePanel()" type="button"
                class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-zinc-300 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-800">
                Cancel
            </button>
            <button @click="submitForm()" type="button"
                class="px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972]">
                <span x-text="editMode ? 'Save Changes' : 'Save Product'"></span>
            </button>
        </div>

    </div>
</div>
