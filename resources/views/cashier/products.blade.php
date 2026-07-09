@extends('layouts.cashier')

@section('content')
    <div class="p-5">
        @include('cashier.partials.products.header-cards')
        @include('cashier.partials.products.filters-table')
    </div>
@endsection
