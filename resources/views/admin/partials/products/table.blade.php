{{-- ============================================================
     Products › Table
     Product rows with stock badges, status, edit/delete actions
     Expects: $products — from live Product model collection
     ============================================================ --}}
<div class="bg-white dark:bg-zinc-900 p-4 rounded-md shadow-xs border border-gray-200 dark:border-zinc-800/60">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr
                    class="text-left text-xs text-gray-500 dark:text-zinc-400 border-b border-gray-200 dark:border-zinc-800">
                    <th class="pb-2 pr-4 font-medium">Product</th>
                    <th class="pb-2 px-4 font-medium">Category</th>
                    <th class="pb-2 px-4 font-medium text-right">Price</th>
                    <th class="pb-2 px-4 font-medium text-center">Stock</th>
                    <th class="pb-2 px-4 font-medium">Barcode</th>
                    <th class="pb-2 px-4 font-medium text-center">Status</th>
                    <th class="pb-2 pl-4 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/30 transition">

                        {{-- Product name + code --}}
                        <td class="py-3 pr-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $product->image ?? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxolXBpybqOuVoJXLQE2SB0buq-Gq48WnKnB0h9AD5hKYyruRDcNa0ZNXJ&s=10' }}"
                                    class="w-12 h-12 bg-[#0F6E8C]/10 dark:bg-[#0F6E8C]/20 rounded-xs shrink-0 object-cover" />
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-zinc-200 line-clamp-3">
                                        {{ $product->name }}</p>
                                    <p class="text-xs text-gray-400 dark:text-zinc-500">{{ $product->code }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Category --}}
                        <td class="py-3 px-4 text-gray-600 dark:text-zinc-400">
                            {{ $product->category->name ?? 'Unassigned' }}
                        </td>

                        {{-- Price --}}
                        <td class="py-3 px-4 text-right font-medium text-gray-800 dark:text-zinc-200">
                            ${{ number_format($product->selling_price, 2) }}
                        </td>

                        {{-- Stock badge --}}
                        <td class="py-3 text-center whitespace-nowrap">
                            @if ($product->stock_quantity <= 0)
                                <span
                                    class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400">
                                    Out of stock
                                </span>
                            @elseif($product->stock_quantity < $product->low_stock_threshold)
                                <span
                                    class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400">
                                    {{ $product->stock_quantity }} Low
                                </span>
                            @else
                                <span
                                    class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-green-50 dark:bg-green-950/40 text-green-600 dark:text-green-400">
                                    {{ $product->stock_quantity }}
                                </span>
                            @endif
                        </td>

                        {{-- Barcode --}}
                        <td class="py-3 pr-4 text-gray-500 dark:text-zinc-500 text-xs">
                            {{ $product->barcode ?? '-' }}
                        </td>

                        {{-- Status badge --}}
                        <td class="py-3 text-center">
                            <span
                                class="px-2 py-0.5 text-[11px] font-semibold rounded-full
                                {{ $product->status === 'active'
                                    ? 'bg-green-50 dark:bg-green-950/40 text-green-600 dark:text-green-400'
                                    : 'bg-gray-100 dark:bg-zinc-800 text-gray-500 dark:text-zinc-500' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="py-3">
                            <div class="flex items-center justify-end gap-3">
                                <button @click='openEdit(@json($product))'
                                    class="text-gray-400 dark:text-zinc-500 hover:text-[#0F6E8C] dark:hover:text-[#0F6E8C]"
                                    title="Edit">
                                    <x-heroicon-m-pencil-square class="w-4 h-4" />
                                </button>
                                <button
                                    class="text-red-500 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300"
                                    title="Delete">
                                    <x-heroicon-m-trash class="w-4 h-4" />
                                </button>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-400 dark:text-zinc-500 text-sm">
                            No products found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
