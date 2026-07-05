@extends('layouts.cashier')

@php
    use App\Helpers\CustomerData;
    $summaryCards = CustomerData::getSummary();
@endphp

@section('content')
    <div class="w-full p-5" x-data="customerPage()">
        @include('cashier.partials.customer.header-cards')
        @include('cashier.partials.customer.filters-table')
        @include('cashier.partials.customer.customer-detail')
    </div>
    @push('head-scripts')
        @include('cashier.partials.customer.script')
    @endpush
@endsection
