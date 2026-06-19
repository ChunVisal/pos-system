@extends('layouts.app')

@php
    use App\Helpers\ProductData;
    $products = ProductData::getProducts();
    $categories = ProductData::getCategories();
@endphp

@section('content')
    <div class="w-full p-5" x-data="productPage()">

        <!-- Title + Add Button -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Products</h1>
                <p class="text-xs text-gray-500">Manage your PC component catalog and stock</p>
            </div>
            <div class="items-center flex gap-4">
                <button @click="openAdd()"
                    class="mt-3 sm:mt-0 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition">
                    <i class="fa-solid fa-plus"></i> Add Product
                </button>
                <button
                    class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50 transition">
                    <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
                    Export
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class=" flex flex-wrap items-center gap-3 mb-4">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" placeholder="Search by name, code, or barcode..."
                    class="w-full pl-8 pr-3 py-1.5 text-xs border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
            </div>
            <div class="relative">
                <select
                    class="bg-white appearance-none text-xs border border-gray-300 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category['code'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor"
                    class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
            <div class="relative">
                <select
                    class="bg-white appearance-none text-xs border border-gray-300 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor"
                    class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
            <div class="relative">
                <select
                    class="bg-white appearance-none text-xs border border-gray-300 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                    <option value="">All Stock</option>
                    <option value="low">Low Stock</option>
                    <option value="out">Out of Stock</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor"
                    class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                            <th class="pb-2 pr-4 font-medium">Product</th>
                            <th class="pb-2 px-4 font-medium">Category</th>
                            <th class="pb-2 px-4 font-medium text-right">Price</th>
                            <th class="pb-2 px-4 font-medium text-center">Stock</th>
                            <th class="pb-2 px-4 font-medium">Barcode</th>
                            <th class="pb-2 px-4 font-medium text-center">Status</th>
                            <th class="pb-2 pl-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 pr-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-[#0F6E8C]/10 rounded-xs flex items-center justify-center">
                                            <img class="w-12 h-12  object-cover"
                                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxolXBpybqOuVoJXLQE2SB0buq-Gq48WnKnB0h9AD5hKYyruRDcNa0ZNXJ&s=10" />
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $product['name'] }}</p>
                                            <p class="text-xs text-gray-400">{{ $product['code'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-gray-600">{{ $product['category_name'] }}</td>
                                <td class="py-3 px-4 text-right font-medium text-gray-800">
                                    ${{ number_format($product['price'], 2) }}</td>
                                <td class="py-3 text-center whitespace-nowrap ">
                                    @if ($product['stock'] <= 0)
                                        <span
                                            class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-red-50 text-red-600">Out
                                            of stock</span>
                                    @elseif($product['stock'] < 10)
                                        <span
                                            class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-amber-50 text-amber-600">{{ $product['stock'] }}
                                            Low</span>
                                    @else
                                        <span
                                            class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-green-50 text-green-600">{{ $product['stock'] }}</span>
                                    @endif
                                </td>
                                <td class="py-3 pr-4 text-gray-500 text-xs">{{ $product['barcode'] ?? '-' }}</td>
                                <td class="py-3 text-center">
                                    <span
                                        class="px-2 py-0.5 text-[11px] font-semibold rounded-full {{ $product['status'] === 'active' ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                        {{ ucfirst($product['status']) }}
                                    </span>
                                </td>
                                <td class="py-3 ">
                                    <div class="flex items-center justify-end gap-3">
                                        <button @click='openEdit(@json($product))'
                                            class="text-gray-400 hover:text-[#0F6E8C]" title="Edit">
                                            <x-heroicon-m-pencil-square class="w-4 h-4" />
                                        </button>

                                        <button class=" text-red-500 hover:text-red-600 title="Delete">
                                            <x-heroicon-m-trash class="w-4 h-4" />
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-gray-400 text-sm">No products found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ============== ADD / EDIT SLIDE-OVER PANEL ============== -->
        <div x-show="open" x-cloak class="fixed inset-0 z-50" style="display: none;">
            <!-- backdrop -->
            <div x-show="open" x-transition.opacity @click="closePanel()" class="absolute inset-0 bg-gray-900/40"></div>

            <!-- panel -->
            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-xl flex flex-col">

                <!-- header -->
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-800" x-text="editMode ? 'Edit Product' : 'Add Product'">
                    </h2>
                    <button @click="closePanel()" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- form body (scrollable) -->
                <form @submit.prevent="submitForm()" class="flex-1 overflow-y-auto px-5 py-4 space-y-5">

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Product Name</label>
                        <input type="text" x-model="form.name" required placeholder="e.g. AMD Ryzen 5 7600X"
                            class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Product Code</label>
                            <input type="text" x-model="form.code" :disabled="editMode" placeholder="Auto-generated"
                                class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 bg-gray-50 disabled:text-gray-400 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Category</label>
                            <div class="relative">
                                <select x-model="form.category_code" required
                                    class="appearance-none w-full text-sm border border-gray-300 rounded-md pl-3 pr-8 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                                    <option value="">Select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category['code'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor"
                                    class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Barcode</label>
                        <div class="flex gap-2">
                            <input type="text" x-model="form.barcode" placeholder="Scan or enter barcode"
                                class="flex-1 text-sm border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                            <button type="button"
                                class="px-3 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-50"
                                title="Scan barcode">
                                <i class="fa-solid fa-barcode"></i>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Base Price ($)</label>
                            <input type="number" step="0.01" x-model.number="form.price" required placeholder="0.00"
                                class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Stock Quantity</label>
                            <input type="number" x-model.number="form.stock" required placeholder="0"
                                class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-medium text-gray-600">Status</label>
                        <button type="button" @click="form.status = form.status === 'active' ? 'inactive' : 'active'"
                            class="relative inline-flex items-center h-6 w-11 rounded-full transition"
                            :class="form.status === 'active' ? 'bg-[#0F6E8C]' : 'bg-gray-300'">
                            <span class="inline-block h-4 w-4 transform bg-white rounded-full transition"
                                :class="form.status === 'active' ? 'translate-x-6' : 'translate-x-1'"></span>
                        </button>
                    </div>

                    <!-- Units of Measure -->
                    <div class="pt-3 border-t border-gray-200">
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-xs font-semibold text-gray-700">Units of Measure (UOM)</label>
                            <button type="button" @click="addUomRow()"
                                class="text-xs text-[#0F6E8C] font-medium hover:underline">
                                <i class="fa-solid fa-plus mr-1"></i>Add UOM
                            </button>
                        </div>
                        <p class="text-[11px] text-gray-400 mb-3">e.g. Piece, Box of 10, Carton of 50 — each with its own
                            price</p>

                        <div class="space-y-2">
                            <template x-for="(uom, index) in form.uoms" :key="index">
                                <div class="flex items-end gap-2 bg-gray-50 border border-gray-200 rounded-md p-2">
                                    <div class="flex-1">
                                        <label class="block text-[10px] text-gray-500 mb-1">Description</label>
                                        <input type="text" x-model="uom.description" placeholder="Piece"
                                            class="w-full text-xs border border-gray-300 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                                    </div>
                                    <div class="w-20">
                                        <label class="block text-[10px] text-gray-500 mb-1">Qty/Unit</label>
                                        <input type="number" x-model.number="uom.quantity_per_unit" placeholder="1"
                                            class="w-full text-xs border border-gray-300 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                                    </div>
                                    <div class="w-24">
                                        <label class="block text-[10px] text-gray-500 mb-1">Price ($)</label>
                                        <input type="number" step="0.01" x-model.number="uom.price"
                                            placeholder="0.00"
                                            class="w-full text-xs border border-gray-300 rounded px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                                    </div>
                                    <button type="button" @click="removeUomRow(index)"
                                        class="text-gray-400 hover:text-red-500 pb-1.5" title="Remove">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </template>

                            <p x-show="form.uoms.length === 0" class="text-xs text-gray-400 italic">No additional UOMs
                                added.</p>
                        </div>
                    </div>

                </form>

                <!-- footer -->
                <div class="flex items-center justify-end gap-3 px-5 py-4 border-t border-gray-200">
                    <button @click="closePanel()" type="button"
                        class="px-4 py-2 text-xs font-semibold text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                        Cancel
                    </button>
                    <button @click="submitForm()" type="button"
                        class="px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972]">
                        <span x-text="editMode ? 'Save Changes' : 'Save Product'"></span>
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script>
        function productPage() {
            return {
                open: false,
                editMode: false,
                form: {
                    id: null,
                    code: '',
                    name: '',
                    category_code: '',
                    barcode: '',
                    price: null,
                    stock: null,
                    status: 'active',
                    uoms: [],
                },

                emptyForm() {
                    return {
                        id: null,
                        code: '',
                        name: '',
                        category_code: '',
                        barcode: '',
                        price: null,
                        stock: null,
                        status: 'active',
                        uoms: [],
                    };
                },

                openAdd() {
                    this.editMode = false;
                    this.form = this.emptyForm();
                    this.open = true;
                },

                openEdit(product) {
                    this.editMode = true;
                    this.form = {
                        id: product.id ?? null,
                        code: product.code ?? '',
                        name: product.name ?? '',
                        category_code: product.category_code ?? '',
                        barcode: product.barcode ?? '',
                        price: product.price ?? null,
                        stock: product.stock ?? null,
                        status: product.status ?? 'active',
                        uoms: (product.uoms ?? []).map(u => ({
                            description: u.description ?? '',
                            quantity_per_unit: u.quantity_per_unit ?? 1,
                            price: u.price ?? null,
                        })),
                    };
                    this.open = true;
                },

                closePanel() {
                    this.open = false;
                },

                addUomRow() {
                    this.form.uoms.push({
                        description: '',
                        quantity_per_unit: 1,
                        price: null
                    });
                },

                removeUomRow(index) {
                    this.form.uoms.splice(index, 1);
                },

                submitForm() {
                    console.log('Submitting product:', this.form);
                    this.closePanel();
                },
            }
        }
    </script>
@endsection
