<div x-show="requestOpen" x-cloak class="fixed inset-0 z-50" style="display: none;">
    <div @click="requestOpen = false" class="absolute inset-0 bg-black/50"></div>
    <div @click.stop class="absolute right-0 top-0 h-full w-full max-w-md bg-white dark:bg-zinc-900 shadow-xl flex flex-col">
        
        <div class="flex items-center justify-between px-5 py-4 border-b">
            <h3 class="text-base font-semibold">Request Restock</h3>
            <button @click="requestOpen = false">✕</button>
        </div>

        <div class="flex-1 overflow-y-auto px-5 py-4 space-y-4">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Product</label>
                <select x-model="requestForm.product_id" class="w-full text-sm border rounded-lg px-3 py-2">
                    <option value="">Select product</option>
                    @foreach($products->where('remaining', '<=', 5) as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->remaining }} left)</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Quantity Needed</label>
                <input type="number" x-model="requestForm.quantity" min="1" class="w-full text-sm border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Note (optional)</label>
                <textarea x-model="requestForm.notes" rows="2" class="w-full text-sm border rounded-lg px-3 py-2"></textarea>
            </div>
        </div>

        <div class="px-5 py-4 border-t flex gap-3">
            <button @click="requestOpen = false" class="flex-1 py-2 text-xs border rounded-lg">Cancel</button>
            <button @click="submitRequest()" :disabled="!requestForm.product_id || !requestForm.quantity"
                class="flex-[2] py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-lg disabled:opacity-50">
                Submit Request
            </button>
        </div>
    </div>
</div>s