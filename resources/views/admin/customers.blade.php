 @extends('layouts.app')

 @php
     use App\Helpers\CustomerData;
     $summaryCards = CustomerData::getAdminSummary();
 @endphp

 @section('content')
     <div class="w-full p-5 bg-gray-100/80 dark:bg-black transition-colors duration-300" x-data="customerPage()">
         {{-- <x-skeleton.userCustomers> --}}

         @include('admin.partials.customers.header-cards')

         @include('admin.partials.customers.filters-table')

         @include('cashier.partials.customer.customer-detail')

         @include('cashier.partials.pos.receipt')
         {{-- </x-skeleton.userCustomers> --}}
     </div>
     @include('admin.partials.customers.scripts')
 @endsection
