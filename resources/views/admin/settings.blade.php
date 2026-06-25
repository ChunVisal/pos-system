@extends('layouts.app')

@php
    use App\Helpers\SettingsData;
    $profile = SettingsData::getStoreProfile();
    $taxCurrency = SettingsData::getTaxCurrency();
    $receipt = SettingsData::getReceiptSettings();
    $paymentMethods = SettingsData::getPaymentMethods();
    $notifications = SettingsData::getNotificationSettings();
    $sync = SettingsData::getSyncStatus();
@endphp

@section('content')
    <div class="w-full p-5 bg-gray-100/80 dark:bg-black transition-colors duration-300">
        <x-skeleton.settings>
            @include('admin.partials.settings.header-tabs')
            @include('admin.partials.settings.scripts')
        </x-skeleton.settings>
    </div>
@endsection
