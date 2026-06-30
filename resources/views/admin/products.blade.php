@extends('layouts.app')

@php
    $categories = \App\Models\Categories::withCount([
        'products as total_stock' => function ($q) {
            $q->select(\DB::raw('sum(stock_quantity)'));
        },
    ])->get();
    $products = \App\Models\Product::with('category')
        ->when(request('search'), function ($q) {
            $search = request('search');

            $q->where('name', 'like', "%$search%")
                ->orWhere('code', 'like', "%$search%")
                ->orWhere('barcode', 'like', "%$search%")
                ->orWhereHas('category', function ($cat) use ($search) {
                    $cat->where('name', 'like', '%' . $search . '%');
                });
        })
        ->with('category')
        ->get();
@endphp

@section('content')
    @include('admin.partials.products.scripts')
    <div class="w-full p-5 bg-gray-100/80 dark:bg-black transition-colors duration-300" x-data="productPage()">

        <x-skeleton.product>

        @include('admin.partials.products.header-filters')
        @include('admin.partials.products.slide-over')

        </x-skeleton.product>
    </div>
@endsection
