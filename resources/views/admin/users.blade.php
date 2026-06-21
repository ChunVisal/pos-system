@extends('layouts.app')

@php
    use App\Helpers\UserData;
    $summaryCards = UserData::getSummaryCards();
    $users = UserData::getUsers();
@endphp

@section('content')
    <div class="w-full p-5" x-data="userPage()">

        <!-- Title + Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Users</h1>
                <p class="text-xs text-gray-500">Manage admin and cashier accounts</p>
            </div>
            <div class="flex items-center gap-2 mt-3 sm:mt-0">
                <button @click="openAdd()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-p rounded-md hover:bg-[#0c5972] transition">
                    <i class="fa-solid fa-plus"></i> Add User
                </button>
                <button
                    class="bg-white inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Export
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
            @foreach ($summaryCards as $card)
                <div
                    class="bg-white p-3 rounded-md shadow-xs border border-gray-300/40 flex flex-col justify-between relative overflow-hidden h-32">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="rounded-md p-2 px-3"
                                style="background-color: {{ $card['iconBg'] === 'transparent' ? 'transparent' : $card['iconBg'] . '20' }};">
                                <i class="{{ $card['icon'] }} text-[18px]" style="color: {{ $card['iconColor'] }};"></i>
                            </div>
                            <p class="text-xs font-semibold text-gray-600 uppercase">{{ $card['title'] }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start gap-1">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $card['value'] }}</h2>
                        <div class="flex items-center gap-1 text-xs">
                            <span
                                class="font-semibold {{ $card['trend'] === 'up' ? 'text-green-500' : 'text-red-500' }} flex items-center gap-0.5">
                                <i class="fa-solid fa-arrow-trend-{{ $card['trend'] }}"></i> {{ $card['percentage'] }}
                            </span>
                            <span class="text-gray-600">{{ $card['period'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Filters -->
        <div class="bg-white p-3 rounded-md shadow-xs border border-gray-300/40 flex flex-wrap items-center gap-3 mb-4">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" placeholder="Search by name or email..."
                    class="w-full pl-8 pr-3 py-1.5 text-xs border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
            </div>
            <div class="relative">
                <select
                    class="appearance-none text-xs border border-gray-300 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="cashier">Cashier</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor"
                    class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
            <div class="relative">
                <select
                    class="appearance-none text-xs border border-gray-300 rounded-md pl-3 pr-8 py-1.5 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor"
                    class="w-3.5 h-3.5 absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs text-gray-500 border-b border-gray-200">
                            <th class="pb-2 pr-4 font-medium">User</th>
                            <th class="pb-2 px-4 font-medium">Role</th>
                            <th class="pb-2 px-4 font-medium text-center">Status</th>
                            <th class="pb-2 px-4 font-medium">Last Login</th>
                            <th class="pb-2 pl-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                            @php
                                $initials = collect(explode(' ', $user['name']))
                                    ->map(fn($n) => strtoupper($n[0]))
                                    ->take(2)
                                    ->implode('');
                                $avatarColor = $user['role'] === 'admin' ? '#8B5CF6' : '#0F6E8C';
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 pr-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-xs font-semibold text-white shrink-0"
                                            style="background-color: {{ $avatarColor }};">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $user['name'] }}</p>
                                            <p class="text-xs text-gray-400">{{ $user['email'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span
                                        class="px-2 py-0.5 text-[11px] font-semibold rounded-full {{ $user['role'] === 'admin' ? 'bg-purple-50 text-purple-600' : 'bg-[#0F6E8C]/10 text-[#0F6E8C]' }}">
                                        {{ ucfirst($user['role']) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span
                                        class="px-2 py-0.5 text-[11px] font-semibold rounded-full {{ $user['status'] === 'active' ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                        {{ ucfirst($user['status']) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-gray-500 text-xs">
                                    {{ \Carbon\Carbon::parse($user['last_login'])->format('M d, g:i A') }}</td>
                                <td class="py-3 pl-4">
                                    <div class="flex items-center justify-end gap-3">
                                        <button @click='openEdit(@json($user))'
                                            class="text-gray-400 hover:text-[#0F6E8C]" title="Edit">
                                            <x-heroicon-s-pencil-square class="w-4 h-4" />
                                        </button>
                                        <button class="text-red-500 hover:text-red-600" title="Delete">
                                            <x-heroicon-s-trash class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-400 text-sm">No users found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ============== ADD / EDIT USER SLIDE-OVER PANEL ============== -->
        <div x-show="open" x-cloak class="fixed inset-0 z-50" style="display: none;">
            <div x-show="open" x-transition.opacity @click="closePanel()" class="absolute inset-0 bg-gray-900/40"></div>

            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-xl flex flex-col">

                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-800" x-text="editMode ? 'Edit User' : 'Add User'"></h2>
                    <button @click="closePanel()" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form @submit.prevent="submitForm()" class="flex-1 overflow-y-auto px-5 py-4 space-y-5">

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Full Name</label>
                        <input type="text" x-model="form.name" required placeholder="e.g. Sokha Chan"
                            class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Email Address</label>
                        <input type="email" x-model="form.email" required placeholder="name@bluetech.com"
                            class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Role</label>
                        <div class="relative">
                            <select x-model="form.role" required
                                class="appearance-none w-full text-sm border border-gray-300 rounded-md pl-3 pr-8 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                                <option value="">Select role</option>
                                <option value="admin">Admin</option>
                                <option value="cashier">Cashier</option>
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor"
                                class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Password <span x-show="editMode" class="text-gray-400 normal-case font-normal">(leave
                                    blank to keep)</span>
                            </label>
                            <input type="password" x-model="form.password" :required="!editMode" placeholder="••••••••"
                                class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Confirm Password</label>
                            <input type="password" x-model="form.password_confirmation" :required="!editMode"
                                placeholder="••••••••"
                                class="w-full text-sm border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#0F6E8C]">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-medium text-gray-600">Status</label>
                        <button type="button" @click="form.status = form.status === 'active' ? 'inactive' : 'active'"
                            class="relative inline-flex items-center h-6 w-11 rounded-full transition"
                            :class="form.status === 'active' ? 'bg-[#0F6E8C]' : 'bg-gray-300'">
                            <span class="inline-block h-4 w-4 transform bg-white rounded-full transition"
                                :class="form.status === 'active' ? 'translate-x-6' : 'translate-x-1'"></span>
                        </button>
                    </div>

                </form>

                <div class="flex items-center justify-end gap-3 px-5 py-4 border-t border-gray-200">
                    <button @click="closePanel()" type="button"
                        class="px-4 py-2 text-xs font-semibold text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                        Cancel
                    </button>
                    <button @click="submitForm()" type="button"
                        class="px-4 py-2 text-xs font-semibold text-white bg-[#0F6E8C] rounded-md hover:bg-[#0c5972]">
                        <span x-text="editMode ? 'Save Changes' : 'Save User'"></span>
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script>
        function userPage() {
            return {
                open: false,
                editMode: false,
                form: {
                    id: null,
                    name: '',
                    email: '',
                    role: '',
                    password: '',
                    password_confirmation: '',
                    status: 'active',
                },

                emptyForm() {
                    return {
                        id: null,
                        name: '',
                        email: '',
                        role: '',
                        password: '',
                        password_confirmation: '',
                        status: 'active',
                    };
                },

                openAdd() {
                    this.editMode = false;
                    this.form = this.emptyForm();
                    this.open = true;
                },

                openEdit(user) {
                    this.editMode = true;
                    this.form = {
                        id: user.id ?? null,
                        name: user.name ?? '',
                        email: user.email ?? '',
                        role: user.role ?? '',
                        password: '',
                        password_confirmation: '',
                        status: user.status ?? 'active',
                    };
                    this.open = true;
                },

                closePanel() {
                    this.open = false;
                },

                submitForm() {
                    // Wire this up to your controller route, e.g.:
                    // const url = this.editMode ? `/users/${this.form.id}` : '/users';
                    // const method = this.editMode ? 'PUT' : 'POST';
                    // fetch(url, { method, headers: {...}, body: JSON.stringify(this.form) })
                    //     .then(...).then(() => { this.closePanel(); /* refresh table */ });
                    console.log('Submitting user:', this.form);
                    this.closePanel();
                },
            }
        }
    </script>
@endsection
