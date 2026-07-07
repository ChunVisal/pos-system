@extends('layouts.app')

@section('content')
    <div class="w-full p-5 bg-gray-100/80 dark:bg-black transition-colors duration-300">

        <x-skeleton-loader>

            @include('admin.partials.dashboard.header-cards')

            @include('admin.partials.dashboard.charts')

            @include('admin.partials.dashboard.table')

        </x-skeleton-loader>

    </div>
@endsection

@include('admin.partials.dashboard.scripts')
