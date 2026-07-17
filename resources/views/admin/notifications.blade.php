@extends('layouts.app')

@section('content')
    <div class="p-6 max-w-6xl mx-auto">

        {{-- Elegant Header Segment --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-base font-bold tracking-tight text-gray-900 dark:text-zinc-100 uppercase">Notifications</h1>
                <p class="text-xs text-gray-400 dark:text-zinc-500 mt-1">Authorize or decline pending system inventory
                    operations</p>
            </div>

            @if ($pendingCount > 0)
                <div
                    class="inline-flex items-center gap-1.5 self-start sm:self-auto px-2.5 py-1 rounded-full text-xs font-bold tracking-wider uppercase bg-red-50 dark:bg-red-950/30 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-950/40">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    <span>{{ $pendingCount }} Action Required</span>
                </div>
            @endif
        </div>

        {{-- Stock Requests Section --}}
        <div class="mb-8">
            <h2 class="text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider mb-4">Stock Requests Feed
            </h2>

            @if ($stockRequests->isEmpty())
                {{-- Premium Empty State Segment --}}
                <div
                    class="bg-white dark:bg-zinc-900 rounded-md border border-gray-100 dark:border-zinc-800/80 p-16 text-center shadow-sm">
                    <div
                        class="w-14 h-14 mx-auto mb-4 bg-gray-50 dark:bg-zinc-800/50 border border-gray-100 dark:border-zinc-800 rounded-full flex items-center justify-center">
                        <x-heroicon-o-inbox class="w-6 h-6 text-gray-400 dark:text-zinc-500" />
                    </div>
                    <p class="text-xs font-bold text-gray-800 dark:text-zinc-200 uppercase tracking-wider">All caught up</p>
                    <p class="text-[11px] text-gray-400 dark:text-zinc-500 mt-1">No pending stock requests require
                        authorization.</p>
                </div>
            @else
                {{-- Admin Requests Feed Wrapper --}}
                <div
                    class="bg-white dark:bg-zinc-900 rounded-md shadow-sm border border-gray-100 dark:border-zinc-800/80 divide-y divide-gray-100 dark:divide-zinc-800/40 overflow-hidden">
                    @foreach ($stockRequests as $req)
                        @php
                            $cashierStock = \App\Models\CashierStock::where('cashier_id', $req->cashier_id)
                                ->where('product_id', $req->product_id)
                                ->first();
                            $cashierRemaining = $cashierStock
                                ? $cashierStock->allocated_quantity - $cashierStock->sold_quantity
                                : 0;
                        @endphp
                        <div
                            class="flex flex-col lg:flex-row lg:items-center justify-between p-5 gap-5 hover:bg-gray-50/40 dark:hover:bg-zinc-800/20 transition-colors">

                            {{-- Info Block: Product Image, Cashier Identity, and Request Details --}}
                            <div class="flex items-start gap-4 flex-1 min-w-0">
                                {{-- Image Thumbnail Frame --}}
                                <div class="relative flex-shrink-0">
                                    <div
                                        class="w-[60px] h-[60px] rounded-md bg-gray-100 dark:bg-zinc-850 border border-gray-200/60 dark:border-zinc-800 overflow-hidden flex items-center justify-center">
                                        @if (!empty($req->product->image))
                                            <img src="{{ $req->product->image }}" alt="{{ $req->product->name }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <img src="https://res.cloudinary.com/dexr27qho/image/upload/v1782723706/8fc9e618-ca35-4366-a173-ae4d15ec0aef_vyjksv.png"
                                                alt="Placeholder" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    {{-- Stack Icon Badge overlay --}}
                                    <div
                                        class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-[#0F6E8C] flex items-center justify-center border-2 border-white dark:border-zinc-900">
                                        <x-heroicon-s-clock class="w-2.5 h-2.5 text-white" />
                                    </div>
                                </div>

                                {{-- Text Meta Layout --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-800 dark:text-zinc-200 leading-snug">
                                        <span
                                            class="font-bold text-gray-900 dark:text-zinc-100">{{ $req->cashier->name }}</span>
                                        @if ($req->product_id)
                                            requested restock of
                                            <span
                                                class="font-bold text-[#0F6E8C] dark:text-[#1389af]">{{ $req->quantity_requested }}x</span>
                                        @else
                                            requested new product: {{ $req->product_name }}
                                        @endif
                                        <span
                                            class="font-bold text-gray-900 dark:text-zinc-100">{{ $req->product->name ?? ($req->product_name ?? 'Unknown') }}"</span>
                                    </p>

                                    <p class="text-[12px] text-gray-500 mt-0.5">
                                        Warehouse:
                                        {{ \App\Models\Product::find($req->product_id)->stock_quantity ?? 'N/A' }} |
                                        Cashier has: {{ $cashierRemaining }}
                                    </p>

                                    </p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span
                                            class="text-[10px] text-gray-400 dark:text-zinc-500 font-bold uppercase tracking-wider bg-gray-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">
                                            Req #{{ $req->id }}
                                        </span>
                                        <span class="text-[10px] text-gray-400 dark:text-zinc-500 font-medium">
                                            {{ $req->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    @if ($req->cashier_notes)
                                        <p
                                            class="text-[12px] text-gray-600 dark:text-zinc-300 mt-0.5 flex items-center gap-1">
                                            <x-heroicon-o-chat-bubble-bottom-center-text
                                                class="inline w-3 h-3 text-gray-400 mr-1" />
                                            "{{ $req->cashier_notes }}"
                                        </p>
                                    @endif

                                </div>
                            </div>

                            {{-- Admin Action Operations Area (Forms) --}}
                            <div
                                class="flex flex-wrap items-center gap-3 bg-gray-50/50 dark:bg-zinc-950/20 p-3 lg:p-0 rounded-md lg:bg-transparent lg:dark:bg-transparent">

                                {{-- Approval Form Component --}}
                                <form action="{{ route('admin.notifications.approve', $req->id) }}" method="POST"
                                    class="flex items-center gap-2">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $req->quantity_requested }}"
                                        min="1"
                                        max="{{ $req->product_id ? $req->product->stock_quantity ?? 0 : $req->quantity_requested }}"
                                        class="w-16 text-xs text-center border rounded px-2 py-1 dark:text-gray-200 bg-white dark:bg-zinc-800">

                                    @if (($req->product->stock_quantity ?? 0) <= 0)
                                        <button type="button" disabled
                                            class="px-3 py-1.5 text-xs font-medium text-white dark:text-zinc-900 bg-gray-400 rounded-md cursor-not-allowed">
                                            Out of Stock
                                        </button>
                                    @elseif(($req->product->stock_quantity ?? 0) < $req->quantity_requested)
                                        <button type="submit"
                                            class="px-3 py-1.5 text-xs font-medium text-white bg-amber-500 rounded-md hover:bg-amber-600">
                                            Partial ({{ $req->product->stock_quantity ?? 0 }} available)
                                        </button>
                                    @else
                                        <button type="submit"
                                            class="px-3 py-1.5 text-xs font-medium text-white bg-green-500 rounded-md hover:bg-green-600">
                                            Approve
                                        </button>
                                    @endif
                                </form>

                                <div class="hidden sm:block w-[1px] h-6 bg-gray-200 dark:bg-zinc-800"></div>

                                {{-- Rejection Form Component --}}
                                <form action="{{ route('admin.notifications.reject', $req->id) }}" method="POST"
                                    class="flex items-center gap-2 flex-1 sm:flex-initial">
                                    @csrf
                                    <div class="relative min-w-[130px]">
                                        <select name="reason"
                                            class="w-full text-xs font-medium border border-gray-300 dark:border-zinc-700 rounded-md pl-2 pr-6 py-1.5 bg-white dark:bg-zinc-800 text-gray-800 dark:text-zinc-200 focus:outline-none focus:border-red-500 appearance-none">
                                            <option value="Insufficient stock">Insufficient stock</option>
                                            <option value="Product discontinued">Discontinued</option>
                                            <option value="Awaiting supplier">Awaiting supplier</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <x-heroicon-o-chevron-down
                                            class="w-3 h-3 absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" />
                                    </div>
                                    <button type="submit"
                                        class="px-4 py-1.5 h-[29px] text-[11px] font-bold text-white bg-red-600 hover:bg-red-700 rounded-md transition-colors uppercase tracking-wider whitespace-nowrap">
                                        Reject
                                    </button>
                                </form>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
