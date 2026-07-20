@extends('layouts.cashier')
@php

    use App\Helpers\OrderData;
    $summaryCards = OrderData::getSummaryCards();
@endphp

@section('content')
    <div x-data="orderPage()">
        <div class="p-5">
            @include('cashier.partials.orders.header-cards')
            @include('cashier.partials.orders.filters-table')
            @include('cashier.partials.orders.refund')
        </div>
        @include('cashier.partials.pos.receipt')
    </div>

    @push('head-scripts')
        @include('cashier.partials.orders.scripts')
    @endpush
@endsection
