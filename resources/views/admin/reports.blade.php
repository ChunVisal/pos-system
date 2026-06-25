@extends('layouts.app')

@php
    use App\Helpers\ReportData;
    $summary = ReportData::getSummary();
    $summaryCards = ReportData::getSummaryCards();
    $trend = ReportData::getRevenueTrend();
    $dailySales = ReportData::getDailySales();
    $topItems = ReportData::getTopItems();
    $salespeople = ReportData::getSalesBySalesperson();
    $payments = ReportData::getPaymentBreakdown();
    $inventorySummary = ReportData::getInventorySummary();
    $stockByCategory = ReportData::getStockByCategory();
@endphp

@section('content')
    <div class="w-full p-5 bg-gray-100/80 dark:bg-black transition-colors duration-300">
        <x-skeleton.reports>
            @include('admin.partials.reports.header-cards')
            @include('admin.partials.reports.tabs')
            @include('admin.partials.reports.tab-sales')
            @include('admin.partials.reports.tab-items')
            @include('admin.partials.reports.tab-payment')
            @include('admin.partials.reports.tab-cashier')
            @include('admin.partials.reports.tab-inventory')
            @include('admin.partials.reports.scripts')
        </x-skeleton.reports>
    </div>
@endsection
