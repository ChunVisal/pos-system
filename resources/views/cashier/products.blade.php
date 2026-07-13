@extends('layouts.cashier')

@section('content')
    <div class="p-5" x-data="productPage()">
        @include('cashier.partials.products.header-cards')
        @include('cashier.partials.products.filters-table')
        @include('cashier.partials.products.request-stock')
    </div>
@endsection
