@extends('layouts.app')

@section('content')
    <div class="p-6 mx-auto space-y-6">

        {{-- Header Segment --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-base font-bold tracking-tight text-gray-900 dark:text-zinc-100 uppercase">Notifications</h1>
                <p class="text-xs text-gray-500 dark:text-zinc-400 mt-0.5">Authorize or decline pending system inventory
                    operations</p>
            </div>

            <div class="flex gap-2">
                <div
                    class="flex items-center gap-2 px-2 rounded-md bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800">
                    <x-heroicon-o-calendar class="w-4 h-4 text-gray-500 dark:text-zinc-400" />
                    <select id="daysFilter" onchange="window.location.href='?days='+this.value"
                        class="text-xs border-none bg-transparent focus:ring-0 p-2 text-gray-700 dark:text-zinc-200 dark:bg-zinc-900 dark:border-zinc-700">
                        <option value="7" {{ request('days') == 7 ? 'selected' : '' }}
                            class="dark:bg-zinc-900 dark:text-zinc-200">Last 7 days</option>
                        <option value="30" {{ request('days') == 30 || !request('days') ? 'selected' : '' }}
                            class="dark:bg-zinc-900 dark:text-zinc-200">Last 30 days</option>
                        <option value="90" {{ request('days') == 90 ? 'selected' : '' }}
                            class="dark:bg-zinc-900 dark:text-zinc-200">Last 90 days</option>
                        <option value="all" {{ request('days') == 'all' ? 'selected' : '' }}
                            class="dark:bg-zinc-900 dark:text-zinc-200">All Time</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Stock Requests Feed --}}
        <div>
            <h2 class="text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-wider mb-4">Stock Requests Feed
            </h2>

            @if ($stockRequests->isEmpty())
                {{-- Premium Empty State Segment --}}
                <div
                    class="bg-white dark:bg-zinc-900 rounded-xl border border-gray-200/80 dark:border-zinc-800 p-16 text-center shadow-sm">
                    <div
                        class="w-12 h-12 mx-auto mb-3 bg-gray-100 dark:bg-zinc-800 rounded-full flex items-center justify-center text-gray-400 dark:text-zinc-500">
                        <x-heroicon-o-inbox class="w-6 h-6" />
                    </div>
                    <p class="text-xs font-bold text-gray-800 dark:text-zinc-200 uppercase tracking-wider">All caught up</p>
                    <p class="text-xs text-gray-400 dark:text-zinc-500 mt-1">No pending stock requests require
                        authorization.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($stockRequests as $group => $requests)
                        {{-- Date Block Title Header --}}
                        <div class="flex items-center gap-3">
                            <h2 class="text-xs font-bold text-gray-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ $group }}
                            </h2>
                            <span
                                class="text-[10px] font-semibold text-gray-500 dark:text-zinc-400 bg-gray-200/80 dark:bg-zinc-800/90 px-2 py-0.5 rounded-full">
                                {{ count($requests) }}
                            </span>
                            <div class="flex-1 h-px bg-gray-200 dark:bg-zinc-800/80"></div>

                        </div>
                        @foreach ($requests as $req)
                            @php
                                $cashierStock = \App\Models\CashierStock::where('cashier_id', $req->cashier_id)
                                    ->where('product_id', $req->product_id)
                                    ->first();
                                $cashierRemaining = $cashierStock
                                    ? $cashierStock->allocated_quantity - $cashierStock->sold_quantity
                                    : 0;

                                // Condition logic for styles
                                $isLoss = $req->status === 'loss_reported';
                                $isNewProduct = !$req->product_id;

                                $cardBg = $isLoss
                                    ? 'bg-rose-50/30 dark:bg-rose-950/20 border-l-rose-500 dark:border-l-rose-500'
                                    : ($isNewProduct
                                        ? 'bg-amber-50/20 dark:bg-amber-950/20 border-l-amber-500 dark:border-l-amber-500'
                                        : 'bg-blue-50/60 dark:bg-blue-900/10 border-l-blue-500 dark:border-l-blue-400');
                            @endphp

                            <div
                                class="rounded-r-lg border-l-md border border-gray-200/70 dark:border-zinc-800 border-l-4 {{ $cardBg }} p-4 shadow-sm transition-all hover:shadow-md">
                                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

                                    {{-- Main Content Info --}}
                                    <div class="flex items-start gap-4 flex-1 min-w-0">
                                        {{-- Product Thumbnail --}}
                                        <div class="relative flex-shrink-0">
                                            <div
                                                class="w-14 h-14 rounded-lg bg-gray-100 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 overflow-hidden flex items-center justify-center">
                                                @if (!empty($req->product->image))
                                                    <img src="{{ $req->product->image }}" alt="{{ $req->product->name }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <img src="https://res.cloudinary.com/dexr27qho/image/upload/v1782723706/8fc9e618-ca35-4366-a173-ae4d15ec0aef_vyjksv.png"
                                                        alt="Placeholder" class="w-full h-full object-cover">
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Request Details --}}
                                        <div class="flex-1 min-w-0 space-y-1">
                                            {{-- Top Tag & Cashier --}}
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span
                                                    class="text-xs font-bold text-gray-900 dark:text-zinc-100">{{ $req->cashier->name }}</span>

                                                {{-- Condition Badges --}}
                                                @if ($isLoss)
                                                    <span
                                                        class="px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-rose-100 dark:bg-rose-900/50 text-rose-700 dark:text-red-200">
                                                        Loss Report
                                                    </span>
                                                @elseif ($isNewProduct)
                                                    <span
                                                        class="px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300">
                                                        New Product
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-cyan-100 dark:bg-cyan-950/60 text-[#0F6E8C] dark:text-cyan-300">
                                                        Restock Request
                                                    </span>
                                                @endif

                                                <span
                                                    class="text-[11px] text-gray-400 dark:text-zinc-400 bg-gray-50 dark:bg-zinc-800 rounded-sm py-[1px] px-2">REQ
                                                    #{{ $req->id }}</span>
                                                <span class="text-[10px] text-gray-400 dark:text-zinc-500">•
                                                    {{ $req->created_at->diffForHumans() }}</span>
                                            </div>

                                            {{-- Quantity & Target Product Text --}}
                                            <p class="text-xs text-gray-700 dark:text-zinc-300 leading-snug">
                                                @if ($isLoss)
                                                    Reported loss of <span
                                                        class="font-bold text-rose-600 dark:text-rose-400">{{ $req->quantity_requested }}x</span>
                                                    <span
                                                        class="font-semibold text-gray-900 dark:text-zinc-100">{{ $req->product->name ?? ($req->product_name ?? 'Unknown') }}</span>
                                                @elseif (!$isNewProduct)
                                                    Requested restock of <span
                                                        class="font-bold text-[#0F6E8C] dark:text-cyan-400">{{ $req->quantity_requested }}x</span>
                                                    <span
                                                        class="font-semibold text-gray-900 dark:text-zinc-100">{{ $req->product->name ?? 'Unknown' }}</span>
                                                @else
                                                    Requested new product: <span
                                                        class="font-semibold text-gray-900 dark:text-zinc-100">{{ $req->product_name }}</span>
                                                @endif
                                            </p>

                                            {{-- Inventory Meta --}}
                                            @if (!$isLoss)
                                                <div
                                                    class="flex items-center gap-3 text-[11px] text-gray-500 dark:text-zinc-400 pt-0.5">
                                                    <span>Warehouse Stock: <strong
                                                            class="text-gray-800 dark:text-zinc-200">{{ \App\Models\Product::find($req->product_id)->stock_quantity ?? 'None' }}</strong></span>
                                                    <span>|</span>
                                                    <span>Cashier Holds: <strong
                                                            class="text-gray-800 dark:text-zinc-200">{{ $cashierRemaining }}</strong></span>
                                                </div>
                                            @else
                                                <p
                                                    class="text-[11px] font-semibold text-rose-600 dark:text-rose-400 flex items-center gap-1 pt-0.5">
                                                    <i class="fa-solid fa-triangle-exclamation"></i> Stock reduction request
                                                    requires review
                                                </p>
                                            @endif

                                            {{-- Notes --}}
                                            @if ($req->cashier_notes)
                                                <p
                                                    class="text-[11px] italic text-gray-500 dark:text-zinc-400 bg-gray-50 dark:bg-zinc-800/60 p-1.5 rounded border border-gray-100 dark:border-zinc-800 mt-1 flex items-start gap-1.5 max-w-md text-wrap break-words">
                                                    <x-heroicon-o-chat-bubble-bottom-center-text
                                                        class="w-3.5 h-3.5 text-gray-400 shrink-0 mt-0.5" />
                                                    <span class="break-words min-w-0">"{{ $req->cashier_notes }}"</span>
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Action Operations Panel --}}
                                    @if (!$isLoss)
                                        <div
                                            class="flex flex-wrap items-center gap-2 pt-3 lg:pt-0 border-t lg:border-t-0 border-gray-100 dark:border-zinc-800/60">
                                            {{-- Approval Form --}}
                                            @if ($isNewProduct)
                                                <form action="{{ route('admin.notifications.approve', $req->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-3.5 py-1.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-md shadow-sm transition">
                                                        Approve
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.notifications.approve', $req->id) }}"
                                                    method="POST" class="flex items-center gap-1.5">
                                                    @csrf
                                                    <input type="number" name="quantity"
                                                        value="{{ $req->quantity_requested }}" min="1"
                                                        max="{{ $req->product->stock_quantity ?? 0 }}"
                                                        class="w-14 text-xs text-center font-bold border border-gray-300 dark:border-zinc-700 rounded-md py-1 bg-white dark:bg-zinc-800 text-gray-800 dark:text-zinc-200 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">

                                                    @if (($req->product->stock_quantity ?? 0) <= 0)
                                                        <button type="button" disabled
                                                            class="px-3 py-1.5 text-xs font-semibold text-zinc-400 bg-zinc-200 dark:bg-zinc-800 rounded-md cursor-not-allowed">
                                                            Out of Stock
                                                        </button>
                                                    @elseif(($req->product->stock_quantity ?? 0) < $req->quantity_requested)
                                                        <button type="submit"
                                                            class="px-3 py-1.5 text-xs font-semibold text-white bg-amber-500 hover:bg-amber-600 rounded-md shadow-sm transition">
                                                            Partial ({{ $req->product->stock_quantity }})
                                                        </button>
                                                    @else
                                                        <button type="submit"
                                                            class="px-3.5 py-1.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-md shadow-sm transition">
                                                            Approve
                                                        </button>
                                                    @endif
                                                </form>
                                            @endif

                                            <div class="hidden sm:block w-px h-5 bg-gray-200 dark:bg-zinc-800 mx-1"></div>

                                            {{-- Reject Form --}}
                                            <form action="{{ route('admin.notifications.reject', $req->id) }}"
                                                method="POST" class="flex items-center gap-1.5">
                                                @csrf
                                                <select name="reason"
                                                    class="text-xs font-medium border border-gray-300 dark:border-zinc-700 rounded-md px-2 py-1 bg-white dark:bg-zinc-800 text-gray-700 dark:text-zinc-200 focus:outline-none">
                                                    <option value="Insufficient stock">Insufficient stock</option>
                                                    <option value="Product discontinued">Discontinued</option>
                                                    <option value="Awaiting supplier">Awaiting supplier</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                <button type="submit"
                                                    class="px-3 py-1.5 text-xs font-semibold text-rose-600 dark:text-rose-100 bg-red-200 dark:bg-rose-600 hover:bg-rose-50 dark:hover:bg-rose-700 border border-rose-200 dark:border-rose-900 rounded-md transition">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
