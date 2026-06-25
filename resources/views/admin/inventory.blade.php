@extends('layouts.app')

@php
    $categories = \App\Models\Categories::all();
    $products = \App\Models\Product::with('category')->get();

    // Keep your other mock helper data so charts/movements don't break
    use App\Helpers\InventoryData;
    $summary = InventoryData::getSummary();
    $summaryCards = InventoryData::getSummaryCards();
    $movements = InventoryData::getMovements();
    $trend = InventoryData::getMovementTrend();
@endphp

@section('content')
    <div class="w-full p-5 bg-gray-100/80 dark:bg-black transition-colors duration-300" x-data="inventoryPage()">
        <x-skeleton.inventory>
            @include('admin.partials.inventory.header-charts-cards')
            @include('admin.partials.inventory.filters-table')
            @include('admin.partials.inventory.slide-over')
            @include('admin.partials.inventory.scripts')
        </x-skeleton.inventory>
    </div>
@endsection
