@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800">POS - Point of Sale</h1>
        <p class="text-gray-600 mt-2">Welcome, {{ auth()->user()->name }}!</p>
        
        <div class="mt-6 text-center py-12">
            <p class="text-gray-500">Products will appear here</p>
            <p class="text-sm text-gray-400">This is the cashier POS screen</p>
        </div>
    </div>
</div>
@endsection