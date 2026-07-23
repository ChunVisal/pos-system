@extends('layouts.cashier')

@section('content')
    <div class="p-6 mx-auto space-y-6" x-data="notificationPage()">
        @include('cashier.partials.notifications.scripts')
        @include('cashier.partials.notifications.return-stock-slideover')

        {{-- Header & Days Filter Segment --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-base font-bold tracking-tight text-gray-900 dark:text-zinc-100 uppercase">Notifications</h1>
                <p class="text-xs text-gray-500 dark:text-zinc-400 mt-0.5">Review and monitor status updates for your stock
                    requests</p>
            </div>

            <div
                class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 shadow-sm self-start sm:self-auto">
                <x-heroicon-o-calendar class="w-4 h-4 text-gray-500 dark:text-zinc-400 shrink-0" />
                <select id="daysFilter" onchange="window.location.href='?days='+this.value"
                    class="text-xs font-medium border-none bg-transparent focus:ring-0 p-0 text-gray-700 dark:text-zinc-200 focus:outline-none cursor-pointer">
                    <option value="7" {{ request('days') == 7 ? 'selected' : '' }} class="dark:bg-zinc-900">Last 7 days
                    </option>
                    <option value="30" {{ request('days') == 30 || !request('days') ? 'selected' : '' }}
                        class="dark:bg-zinc-900">Last 30 days</option>
                    <option value="90" {{ request('days') == 90 ? 'selected' : '' }} class="dark:bg-zinc-900">Last 90
                        days</option>
                    <option value="all" {{ request('days') == 'all' ? 'selected' : '' }} class="dark:bg-zinc-900">All
                        Time</option>
                </select>
            </div>
        </div>

        @if ($notifications->isEmpty())
            {{-- Empty State Layout --}}
            <div
                class="bg-white dark:bg-zinc-900 rounded-xl border border-gray-200/80 dark:border-zinc-800 p-16 text-center shadow-sm">
                <div
                    class="w-14 h-14 mx-auto mb-3 bg-gray-50 dark:bg-zinc-800/50 border border-gray-100 dark:border-zinc-800 rounded-full flex items-center justify-center text-gray-400 dark:text-zinc-500">
                    <x-heroicon-o-bell-slash class="w-6 h-6 text-gray-600 dark:text-zinc-300" />
                </div>
                <p class="text-xs font-bold text-gray-800 dark:text-zinc-200 uppercase tracking-wider">No notifications yet
                </p>
                <p class="text-xs text-gray-400 dark:text-zinc-500 mt-1">We'll alert you here when your stock requests
                    change status.</p>
            </div>
        @else
            @php
                // Fallback grouping logic if $notifications isn't already grouped from controller
$groupedNotifications =
    is_array($notifications->first()) ||
    $notifications->first() instanceof \Illuminate\Support\Collection
        ? $notifications
        : $notifications->groupBy(function ($item) {
            $date = $item->created_at;
            if ($date->isToday()) {
                return 'Today';
            }
            if ($date->isYesterday()) {
                return 'Yesterday';
            }
            if ($date->greaterThanOrEqualTo(now()->subDays(7))) {
                return 'This Week';
            }
            return 'Older';
                        });
            @endphp

            <div class="space-y-8">
                @foreach ($groupedNotifications as $groupLabel => $items)
                    <div class="space-y-3">
                        {{-- Date Block Title Header --}}
                        <div class="flex items-center gap-3">
                            <h2 class="text-xs font-bold text-gray-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ $groupLabel }}
                            </h2> <span
                                class="text-[10px] font-semibold text-gray-500 dark:text-zinc-400 bg-gray-200/80 dark:bg-zinc-800/90 px-2 py-0.5 rounded-full">
                                {{ count($items) }}
                            </span>
                            <div class="flex-1 h-px bg-gray-200 dark:bg-zinc-800/80"></div>

                        </div>

                        {{-- Cards List --}}
                        <div class="space-y-3">
                            @foreach ($items as $notif)
                                @php
                                    $isApproved = $notif->status === 'approved';
                                    $isRejected = $notif->status === 'rejected';
                                    $isPending = in_array($notif->status, ['pending', 'on_hold']);

                                    $borderStyle = $isApproved
                                        ? 'bg-emerald-50/60 dark:bg-emerald-900/10 border-l-emerald-500 dark:border-l-emerald-400'
                                        : ($isRejected
                                            ? 'bg-amber-50/20 dark:bg-amber-950/20 border-l-amber-500 dark:border-l-amber-500'
                                            : 'bg-rose-50/30 dark:bg-rose-950/20 border-l-rose-500 dark:border-l-rose-500');
                                @endphp

                                <div
                                    class="bg-white dark:bg-zinc-900 rounded-r-lg border-l-md border border-gray-200/70 dark:border-zinc-800 border-l-4 {{ $borderStyle }} p-4 shadow-sm transition-all hover:shadow-md">
                                    <div class="flex items-start gap-4">

                                        {{-- Thumbnail Image Box --}}
                                        <div class="relative flex-shrink-0">
                                            <div
                                                class="w-14 h-14 rounded-lg bg-gray-100 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 overflow-hidden flex items-center justify-center">
                                                @if (!empty($notif->product->image))
                                                    <img src="{{ $notif->product->image }}"
                                                        alt="{{ $notif->product->name }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <img src="https://res.cloudinary.com/dexr27qho/image/upload/v1782723706/8fc9e618-ca35-4366-a173-ae4d15ec0aef_vyjksv.png"
                                                        alt="Placeholder" class="w-full h-full object-cover">
                                                @endif
                                            </div>

                                            {{-- Status Icon Indicator --}}
                                            <div
                                                class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center border-2 border-white dark:border-zinc-900 {{ $isApproved ? 'bg-emerald-500' : ($isRejected ? 'bg-rose-500' : 'bg-amber-500') }}">
                                                @if ($isApproved)
                                                    <x-heroicon-s-check class="w-3 h-3 text-white" />
                                                @elseif ($isRejected)
                                                    <x-heroicon-s-x-mark class="w-3 h-3 text-white" />
                                                @else
                                                    <x-heroicon-s-clock class="w-3 h-3 text-white" />
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Card Main Details --}}
                                        <div class="flex-1 min-w-0 space-y-1">
                                            {{-- Header Row --}}
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span
                                                    class="text-[10px] font-bold uppercase px-2 py-0.5 rounded bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400">
                                                    {{ $notif->product_id ? 'Restock' : 'New Product' }}
                                                </span>

                                                <span class="text-xs font-extrabold text-gray-900 dark:text-zinc-100">
                                                    {{ $notif->quantity_requested }}x
                                                </span>

                                                <span
                                                    class="text-xs font-semibold text-gray-800 dark:text-zinc-200 truncate">
                                                    {{ $notif->product->name ?? ($notif->product_name ?? 'Unknown Product') }}
                                                </span>
                                            </div>

                                            {{-- Status and Date Meta Row --}}
                                            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-zinc-400">
                                                @if ($isApproved)
                                                    <span
                                                        class="text-emerald-600 dark:text-emerald-400 font-bold">Approved</span>
                                                    @if ($notif->quantity_approved)
                                                        <span
                                                            class="text-[11px] text-gray-500">({{ $notif->quantity_approved }}
                                                            received)</span>
                                                    @endif
                                                @elseif ($isRejected)
                                                    <span class="text-rose-600 dark:text-rose-400 font-bold truncate">
                                                        Rejected: {{ $notif->dispute_reason ?? 'Disputed' }}
                                                    </span>
                                                @else
                                                    <span class="text-amber-600 dark:text-amber-400 font-bold">Pending
                                                        Approval</span>
                                                @endif

                                                <span>•</span>
                                                <span class="text-[11px] text-gray-400 dark:text-zinc-500">
                                                    {{ $notif->created_at->format('g:i A') }}
                                                    ({{ $notif->created_at->diffForHumans() }})
                                                </span>
                                            </div>

                                            {{-- Notes Section (With text wrap) --}}
                                            @if (!empty($notif->cashier_notes))
                                                <p
                                                    class="text-[11px] italic text-gray-500 dark:text-zinc-400 bg-gray-50 dark:bg-zinc-800/60 p-1.5 rounded border border-gray-100 dark:border-zinc-800 mt-1 flex items-start gap-1.5 max-w-md text-wrap break-words">
                                                    <x-heroicon-o-chat-bubble-bottom-center-text
                                                        class="w-3.5 h-3.5 text-gray-400 shrink-0 mt-0.5" />
                                                    <span class="break-words min-w-0">"{{ $notif->cashier_notes }}"</span>
                                                </p>
                                            @endif

                                            {{-- Action Button --}}
                                            @if ($isApproved)
                                                <div class="pt-1">
                                                    <button @click="returnStock({{ $notif->id }})"
                                                        class="inline-flex items-center gap-1 text-xs font-semibold text-rose-600 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300 transition-colors">
                                                        <x-heroicon-o-arrow-path-rounded-square class="w-3.5 h-3.5" />
                                                        <span>Report Loss</span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
