@extends('layouts.guest')

@section('content')
<div class="h-screen w-screen flex items-center justify-center">

    <div class="w-full max-w-4xl grid grid-cols-1 sm:grid-cols-2 bg-white">
        
        <!-- LEFT -->
        <div class="p-10 flex flex-col justify-evenly">
            
            <!-- Logo -->
            <div class="flex items-center gap-3 mb-8">
                <img src="{{"images/logo.png"}}" 
                     alt="Logo" 
                     class="w-25 h-20 object-cover"
                     onerror="this.style.display='none'">
                <div>
                </div>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 text-sm px-4 py-2 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="mb-3">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#0F6E8C] text-sm"
                           placeholder="admin@blue.com" required autofocus>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Password</label>
                    <input type="password" name="password"
                           class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-[#0F6E8C] text-sm"
                           placeholder="••••••••" required>
                </div>

                <div class="flex items-center justify-between text-sm mb-5">
                    <label class="flex items-center text-gray-500">
                        <input type="checkbox" name="remember" class="mr-2 border-2 border-gray-400"> Remember
                    </label>
                    <a href="#" class="text-p text-sm">Forgot?</a>
                </div>

                <button type="submit" 
            id="submitBtn"
            class="w-full bg-p hover:bg-[#0E5A93] text-white font-semibold py-2 rounded transition text-sm flex items-center justify-center">
        <span id="btnText">Login</span>
        <svg id="btnSpinner" class="animate-spin h-5 w-5 text-white hidden ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </button>
            </form>
        </div>

        <div class="hidden p-10 sm:flex flex-col items-center justify-center">

                <div class="text-center mb-3">
                    <h3 class="text-2xl font-bold text-p mb-1 flex justify-center gap-1">
                        Blue <label class="text-gray-800">POS System</label>
                    </h3>

                    <p class="text-gray-500 text-xs max-w-sm">
                        Manage inventory, sales, reports and customers
                        from one centralized dashboard.
                    </p>
                </div>

                <img src="{{ asset('images/thumbnail.png') }}"
                     alt="POS Preview"
                     class="w-full max-w-sm object-cover"
                     onerror="this.style.display='none'">

            </div>
    </div>
</div>
@endsection

<script>
       document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');

        form.addEventListener('submit', function(e) {
            // Disable button
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            
            // Show spinner, hide text
            btnText.classList.add('hidden');
            btnSpinner.classList.remove('hidden');
        });
    });
</script>