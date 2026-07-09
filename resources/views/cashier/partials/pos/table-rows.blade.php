<div x-show="selectedCategory === 'all' || selectedCategory === {{ $product->category_id }}"
    class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 overflow-hidden hover:shadow-md transition-all group flex flex-col rounded-sm h-full">
    {{-- Image --}}
    <div class="w-full h-[160px] bg-gray-50 dark:bg-zinc-600 overflow-hidden">
        <img src="{{ $product->image ?? 'https://res.cloudinary.com/dexr27qho/image/upload/v1782723706/8fc9e618-ca35-4366-a173-ae4d15ec0aef_vyjksv.png' }}"
            alt="{{ $product->name }}" class="w-full h-full object-cover">
    </div>

    {{-- Content --}}
    <div class="p-3 flex flex-col flex-1 h-full">
        <p class="text-sm font-medium text-gray-800 dark:text-zinc-100">{{ $product->name }}</p>
        <p class="text-xs mb-1 font-semibold text-gray-600 dark:text-zinc-300">{{ $product->category->name }}</p>
        <span
            class="w-fit mb-3 text-[10px] font-mono text-gray-600 dark:text-zinc-100 bg-gray-100 dark:bg-zinc-600 px-1.5 py-0.5 rounded z-10">{{ $product->code }}</span>

        <div class="mt-auto flex items-center justify-between pt-2 border-t border-gray-100 dark:border-zinc-800">
            <span
                class="text-sm font-bold text-green-600 dark:text-green-400">${{ number_format($product->selling_price, 2) }}</span>
            <span class="text-xs text-gray-500">Qty: <label
                    class="font-semibold">{{ $product->available_stock  }}</label></span>
        </div>

        {{-- Add to Cart --}}
        <div class="mt-2 pt-1.5 border-t border-gray-100 dark:border-zinc-800">
            <button
                @click="addToCart({ id: {{ $product->id }}, name: '{{ addslashes($product->name) }}', price: {{ $product->selling_price }}, image: '{{ $product->image }}',  stock: {{ $product->available_stock }} })"
                x-show="!cartItems.find(i => i.id === {{ $product->id }})"
                class="w-full py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972] transition flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-plus text-[10px]"></i> Add to Cart
            </button>

            <div x-show="cartItems.find(i => i.id === {{ $product->id }})" x-cloak class="flex items-center gap-2">
                <button @click="decreaseQty(cartItems.findIndex(i => i.id === {{ $product->id }}))"
                    class="flex-1 py-2 bg-red-200 dark:bg-red-900/90 text-red-600 dark:text-gray-100 rounded-md text-sm font-bold">-</button>
                <span x-text="cartItems.find(i => i.id === {{ $product->id }})?.qty || 0"
                    class="text-base text-gray-800 dark:text-gray-200 font-bold min-w-[24px] text-center"></span>
                <button
                    @click="addToCart({ id: {{ $product->id }}, name: '{{ addslashes($product->name) }}', price: {{ $product->selling_price }}, image: '{{ $product->image }}',  stock: {{ $product->available_stock  }} })"
                    class="flex-1 py-2 bg-green-200 dark:bg-green-700/50 text-green-600 dark:text-green-100 rounded-md text-sm font-bold">+</button>
            </div>
        </div>
    </div>
</div>
