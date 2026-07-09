@extends('layouts.app')

@section('content')
    <div class="w-full p-5 bg-gray-100/80 dark:bg-black transition-colors duration-300" x-data="inventoryPage()">
        <x-skeleton.inventory>
            @include('admin.partials.inventory.header-charts-cards')
            @include('admin.partials.inventory.filters-table')
            @include('admin.partials.inventory.slide-over')
            @include('admin.partials.inventory.stock-drop')
            @include('admin.partials.inventory.scripts')
        </x-skeleton.inventory>
    </div>
@endsection
