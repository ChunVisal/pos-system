@extends('layouts.cashier')

@section('content')
    <div class="flex gap-4" x-data="posPage()">
        {{-- LEFT: Products 75% --}}
        <div class="flex-1 min-w-0 py-5 pl-5 pr-3 ">
            @include('cashier.partials.pos.product-grid')
        </div>

        {{-- RIGHT: Cart 25% - Sticky --}}
        <div class="w-[25%] min-w-[280px] flex-shrink-0">
            <div class="sticky top-20">
                @include('cashier.partials.pos.cart-panel')
            </div>
        </div>
    </div>
@endsection

@push('head-scripts')
    @include('cashier.partials.pos.scripts')
@endpush
