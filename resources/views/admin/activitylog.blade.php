@extends('layouts.app')

@php
    use App\Helpers\ActivityData;
    $summary = ActivityData::getSummary();
    $activities = ActivityData::getActivities();
    $auditLogs = ActivityData::getAuditLogs();
    $modules = ActivityData::getModules();
    $events = ActivityData::getEvents();
@endphp

@section('content')
    <div class="w-full p-5 bg-gray-100/80 dark:bg-black transition-colors duration-300" x-data="activityPage()">
        <x-skeleton.activity>
            @include('admin.partials.activity.header-cards')
            @include('admin.partials.activity.tabs-container')
            @include('admin.partials.activity.slide-over')
            @include('admin.partials.activity.scripts')
        </x-skeleton.activity>
    </div>
@endsection
