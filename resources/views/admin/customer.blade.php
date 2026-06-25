 @extends('layouts.app')

 @php
     use App\Helpers\CustomerData;
     $summary = CustomerData::getSummary();
     $customers = CustomerData::getCustomers();
     $segments = CustomerData::getSegments();
 @endphp

 @section('content')
     <div class="w-full p-5 bg-gray-100/80 dark:bg-black transition-colors duration-300" x-data="customerPage()">
         <x-skeleton.userCustomers>

             @include('admin.partials.customers.header-cards')

             @include('admin.partials.customers.filters-table')

             @include('admin.partials.customers.slide-over')

             @include('admin.partials.customers.detail-panel')

         </x-skeleton.userCustomers>
     </div>
     @include('admin.partials.customers.scripts')
 @endsection
