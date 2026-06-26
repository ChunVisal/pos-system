@extends('layouts.app')

@php
    $categories = \App\Models\Categories::all();
    $products = \App\Models\Product::with('category')
        ->when(request('search'), function ($q) {
            $search = request('search');

            $q->where('name', 'like', "%$search%")
                ->orWhere('code', 'like', "%$search%")
                ->orWhere('barcode', 'like', "%$search%");
        })
        ->get();
@endphp

@section('content')
    @include('admin.partials.products.scripts')
    <div class="w-full p-5 bg-gray-100/80 dark:bg-black transition-colors duration-300" x-data="productPage()">

        {{-- <x-skeleton.product> --}}

            @include('admin.partials.products.header-filters')
            @include('admin.partials.products.slide-over')

        {{-- </x-skeleton.product> --}}
    </div>
@endsection
