@extends('layouts.app')

@php
    use App\Helpers\UserData;
    $summaryCards = UserData::getSummaryCards();
    $users = UserData::getUsers();
@endphp

@section('content')
    <div class="w-full p-5 bg-gray-100/80 dark:bg-black transition-colors duration-300" x-data="userPage()">
        {{-- <x-skeleton.userCustomers> --}}
            @include('admin.partials.users.header-cards')
            @include('admin.partials.users.filters-table')
            @include('admin.partials.users.slide-over')
            @include('admin.partials.users.users-detail')
        {{-- </x-skeleton.userCustomers> --}}
    </div>

    @include('admin.partials.users.scripts')
@endsection
