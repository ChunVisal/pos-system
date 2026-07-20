@extends('layouts.cashier')

@section('content')
    <div class="p-6" x-data="notificationPage()">
        {{-- Elegant Header Segment --}}
        <div class="mb-6">
            <h1 class="text-base font-bold tracking-tight text-gray-900 dark:text-zinc-100 uppercase">Notifications</h1>
            <p class="text-xs text-gray-500 dark:text-zinc-500 mt-1">Review and monitor status updates for your stock
                requests</p>
        </div>

        @if ($notifications->isEmpty())
            {{-- Empty State Layout with SVG Illustration --}}
            <div
                class="bg-white dark:bg-zinc-900 rounded-md border border-gray-100 dark:border-zinc-800/80 p-16 text-center shadow-sm">
                <div
                    class="w-14 h-14 mx-auto mb-4 bg-gray-50 dark:bg-zinc-800/50 border border-gray-100 dark:border-zinc-800 rounded-full flex items-center justify-center">
                    <x-heroicon-o-bell-slash class="w-6 h-6 text-gray-800 dark:text-zinc-200" />
                </div>
                <p class="text-sm font-bold text-gray-800 dark:text-zinc-200 uppercase tracking-wider">No notifications yet
                </p>
                <p class="text-xs text-gray-500 dark:text-zinc-500 mt-1">We'll alert you here when your stock requests
                    change status.</p>
            </div>
        @else
            {{-- Premium Styled Notifications Feed Container --}}
            <div class="  overflow-hidden">
                @foreach ($notifications as $notif)
                    <div
                        class="bg-white dark:bg-zinc-900 rounded-xs shadow-sm border border-gray-100 dark:border-zinc-800/80 divide-y divide-gray-100 dark:divide-zinc-800/40 my-2 flex items-start gap-4 px-5 py-4 transition-colors">

                        {{-- Image Thumbnail Box with Embedded Indicator Ring --}}
                        <div class=" relative flex-shrink-0">
                            <div
                                class="w-[65px] h-[65px] rounded-sm bg-gray-100 dark:bg-zinc-850 border border-gray-200/60 dark:border-zinc-800 overflow-hidden flex items-center justify-center">
                                @if (!empty($notif->product->image))
                                    <img src="{{ $notif->product->image }}" alt="{{ $notif->product->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <img src="https://res.cloudinary.com/dexr27qho/image/upload/v1782723706/8fc9e618-ca35-4366-a173-ae4d15ec0aef_vyjksv.png"
                                        alt="Placeholder" class="w-full h-full object-cover">
                                @endif
                            </div>

                            {{-- Dynamic Action Status Badges using Heroicons --}}
                            <div
                                class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full flex items-center justify-center border-2 border-white dark:border-zinc-900
                                {{ $notif->status === 'approved' ? 'bg-green-500' : ($notif->status === 'rejected' ? 'bg-red-500' : 'bg-amber-500') }}">
                                @if ($notif->status === 'approved')
                                    <x-heroicon-s-check class="w-3 h-3 text-white" />
                                @elseif($notif->status === 'rejected')
                                    <x-heroicon-s-x-mark class="w-3 h-3 text-white" />
                                @else
                                    <x-heroicon-s-clock class="w-3 h-3 text-white" />
                                @endif
                            </div>
                        </div>

                        {{-- Container Card Structure --}}
                        <div
                            class=" relative pl-3 border-l-2 py-0.5 flex-1 min-w-0
{{ $notif->status === 'approved' ? 'border-emerald-500' : '' }}
{{ $notif->status === 'rejected' ? 'border-red-500' : '' }}
{{ $notif->status === 'on_hold' || $notif->status === 'pending' ? 'border-amber-500' : '' }}">

                            {{-- Header Row: Quantity, Name, and Type --}}
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-1.5 text-sm">
                                    {{-- Slim Badge on Right --}}
                                    <span
                                        class="text-[13px] font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                                        {{ $notif->product_id ? 'Restock' : 'New Products' }}
                                    </span>

                                    <span class="font-extrabold text-gray-900 dark:text-zinc-100">
                                        {{ $notif->quantity_requested }}x
                                    </span>
                                    <span class="font-medium text-gray-700 dark:text-zinc-300 truncate">
                                        {{ $notif->product->name ?? ($notif->product_name ?? 'Unknown') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Info Subtext Line --}}
                            <div
                                class="flex items-center justify-between gap-2 mt-1 text-xs text-gray-400 dark:text-zinc-500">
                                <div class="flex items-center gap-1.5 truncate">
                                    @if ($notif->status === 'approved')
                                        <span
                                            class="text-emerald-600 dark:text-emerald-500 text-xs font-bold">Approved</span>
                                        @if ($notif->quantity_approved)
                                            <span class="font-medium">({{ $notif->quantity_approved }} sent)</span>
                                        @endif
                                    @elseif($notif->status === 'rejected')
                                        <span class="text-red-500 dark:text-red-400 font-bold truncate">
                                            Rejected: {{ $notif->dispute_reason ?? 'Disputed' }}
                                        </span>
                                    @elseif($notif->status === 'on_hold')
                                        <span class="text-amber-600 dark:text-amber-500 font-bold">On Hold</span>
                                    @else
                                        <span class="text-amber-600 dark:text-amber-500 font-bold">Pending</span>
                                    @endif

                                    <span>&bull;</span>
                                    <span>{{ $notif->created_at->diffForHumans() }}</span>
                                </div>
                            </div>


                            {{-- Action Anchor --}}
                            @if ($notif->status === 'approved')
                                <button @click="returnStock({{ $notif->id }})"
                                    class="text-[14px] mt-2 font-medium text-red-500 hover:text-red-600 dark:text-red-400 transition-colors shrink-0">
                                    Report Loss
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
                </>
        @endif


        {{-- Return Stock Slideover --}}
        <div x-show="returnOpen" x-cloak class="fixed inset-0 z-50 overflow-hidden" style="display: none;">
            {{-- Backdrop with premium fade transition --}}
            <div @click="returnOpen = false" x-show="returnOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="absolute inset-0 bg-black/40 dark:bg-black/60 backdrop-blur-sm">
            </div>

            {{-- Slideover Panel with fluid horizontal translate translation --}}
            <div @click.stop x-show="returnOpen"
                x-transition:enter="transition ease-out duration-350 cubic-bezier(0.16, 1, 0.3, 1)"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-250 cubic-bezier(0.16, 1, 0.3, 1)"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                class="absolute right-0 top-0 h-full w-full max-w-md bg-white dark:bg-zinc-900 border-l border-gray-100 dark:border-zinc-800 shadow-2xl flex flex-col">

                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 dark:border-zinc-800/80">
                    <div>
                        <h3 class="text-md font-bold text-gray-900 dark:text-zinc-100">Report
                            Broken Stock</h3>
                        <p class="text-[12px] text-gray-500 dark:text-zinc-500 mt-0.5">Submit product issues or defect
                            details to operations</p>
                    </div>
                    <button @click="returnOpen = false"
                        class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-50 dark:hover:bg-zinc-800/50 text-gray-500 dark:text-zinc-500 hover:text-gray-900 dark:hover:text-zinc-100 transition-colors">
                        <x-heroicon-s-x-mark class="w-4 h-4" />
                    </button>
                </div>

                {{-- Scrollable content body --}}
                <div class="flex-1 overflow-y-auto px-6 py-5 space-y-5">
                    {{-- Product field (Readonly Style) --}}
                    <div>
                        <label
                            class="block text-[12px] font-bold text-gray-500 dark:text-zinc-500 uppercase tracking-wider mb-1.5">Product</label>
                        <div class="relative">
                            <input type="text" x-model="returnForm.product_name" readonly
                                class="w-full text-xs font-semibold border border-gray-200 dark:border-zinc-800/80 rounded-md px-3 py-2 bg-gray-50 dark:bg-zinc-800/40 text-gray-700 dark:text-zinc-300 pointer-events-none">
                            <x-heroicon-s-lock-closed
                                class="w-3.5 h-3.5 absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-zinc-500/80" />
                        </div>
                    </div>

                    {{-- Quantity input field --}}
                    <div>
                        <label
                            class="block text-[12px] font-bold text-gray-500 dark:text-zinc-500 uppercase tracking-wider mb-1.5">Quantity
                            Lost</label>
                        <input type="number" x-model="returnForm.quantity" min="1"
                            class="w-full text-xs font-semibold border border-gray-250 dark:border-zinc-800/80 rounded-md px-3 py-2 bg-white dark:bg-zinc-950 text-gray-900 dark:text-zinc-100 focus:outline-none focus:border-red-500 dark:focus:border-red-500/80 transition-colors">
                    </div>

                    {{-- Reason select field --}}
                    <div>
                        <label
                            class="block text-[12px] font-bold text-gray-500 dark:text-zinc-500 uppercase tracking-wider mb-1.5">Reason
                            of Dispute</label>
                        <div class="relative">
                            <select x-model="returnForm.reason"
                                class="w-full text-xs font-semibold border border-gray-250 dark:border-zinc-800/80 rounded-md pl-3 pr-8 py-2 bg-white dark:bg-zinc-950 text-gray-900 dark:text-zinc-100 focus:outline-none focus:border-red-500 dark:focus:border-red-500/80 appearance-none transition-colors">
                                <option value="">Select reason</option>
                                <option value="Damaged">Damaged / Broken on arrival</option>
                                <option value="Defective">Defective / Not working</option>
                                <option value="Missing">Missing items</option>
                                <option value="Theft">Stolen / Theft</option>
                                <option value="Accident">Accident (dropped, spilled)</option>
                                <option value="Other">Other</option>
                            </select>
                            <x-heroicon-o-chevron-down
                                class="w-3.5 h-3.5 absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-zinc-500 pointer-events-none" />
                        </div>
                    </div>
                </div>

                {{-- Footers action controllers --}}
                <div
                    class="px-6 py-5 border-t border-gray-100 dark:border-zinc-800/80 flex gap-3 bg-gray-50/50 dark:bg-zinc-900/40">
                    <button @click="returnOpen = false"
                        class="flex-1 py-2 text-xs font-semibold border border-gray-250 dark:border-zinc-800 rounded-md bg-white dark:bg-zinc-900 hover:bg-gray-50 dark:hover:bg-zinc-800/60 text-gray-700 dark:text-zinc-300 transition-colors">
                        Cancel
                    </button>
                    <button @click="submitReturn()" :disabled="!returnForm.reason || !returnForm.quantity"
                        class="flex-[2] py-2 text-xs  text-white bg-red-600 dark:bg-red-700 hover:bg-red-700 dark:hover:bg-red-800 rounded-md transition-colors disabled:opacity-50 disabled:pointer-events-none shadow-sm shadow-red-500/10">
                        Confirm Report Loss
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function notificationPage() {
        return {
            returnOpen: false,
            returnForm: {
                request_id: null,
                product_name: '',
                quantity: 1,
                reason: ''
            },

            returnStock(requestId) {

                // find notification and open slideover
                const notif = @json($notifications).find(n => n.id === requestId);
                if (!notif) return;
                this.returnForm = {
                    request_id: requestId,
                    product_name: notif.product.name,
                    quantity: 1,
                    reason: '',
                };
                this.returnOpen = true;
            },

            submitReturn() {
                fetch('/cashier/stock-return', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.returnForm)
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert(data.message);
                        this.returnOpen = false;
                        window.location.reload();
                    });
            },
        };
    }
</script>
