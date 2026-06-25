<!-- resources/views/components/skeleton-loader.blade.php -->
@props([
    'loading' => true,
    'delay' => 500,
    'type' => 'default', // default, cards, table, profile, dashboard
    'rows' => 5,
    'columns' => 4,
])

<div x-data="{ loading: {{ $loading ? 'true' : 'false' }} }" x-init="if (loading) setTimeout(() => loading = false, {{ $delay }})">

    <!-- Loading State -->
    <div x-show="loading" x-transition:leave="transition-opacity duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        @if ($type === 'default')
            <!-- ========== DEFAULT SKELETON ========== -->
            <div class="space-y-4">
                <!-- Header -->
                <div class="flex items-center justify-between">
                    <div class="space-y-2">
                        <div class="h-8 w-48 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="h-4 w-64 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    </div>
                    <div class="h-10 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                </div>

                <!-- Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @for ($i = 0; $i < 4; $i++)
                        <div
                            class="h-32 bg-white dark:bg-zinc-900 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800 p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                                <div class="flex-1">
                                    <div class="h-4 w-20 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                                    <div class="h-3 w-12 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-1"></div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="h-8 w-24 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            </div>
                        </div>
                    @endfor
                </div>

                <!-- Table -->
                <div
                    class="bg-white dark:bg-zinc-900 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800 p-4">
                    <div class="space-y-3">
                        <div class="h-8 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        @for ($i = 0; $i < 5; $i++)
                            <div class="h-12 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        @endfor
                    </div>
                </div>
            </div>
        @elseif($type === 'cards')
            <!-- ========== CARDS SKELETON ========== -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ $columns }} gap-4">
                @for ($i = 0; $i < $columns; $i++)
                    <div
                        class="bg-white dark:bg-zinc-900 p-4 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-gray-200 dark:bg-zinc-700 rounded-full animate-pulse"></div>
                            <div class="flex-1">
                                <div class="h-4 w-24 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                                <div class="h-3 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-1"></div>
                            </div>
                        </div>
                        <div class="h-8 w-20 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="mt-3 flex items-center gap-2">
                            <div class="h-4 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            <div class="h-4 w-12 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        </div>
                    </div>
                @endfor
            </div>
        @elseif($type === 'table')
            <!-- ========== TABLE SKELETON ========== -->
            <div
                class="bg-white dark:bg-zinc-900 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800 overflow-hidden">
                <div class="p-4 border-b border-gray-200 dark:border-zinc-800">
                    <div class="flex items-center justify-between">
                        <div class="h-6 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="h-8 w-48 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    </div>
                </div>
                <div class="overflow-x-auto p-4">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-zinc-800">
                                @for ($i = 0; $i < 6; $i++)
                                    <th class="pb-3 px-2">
                                        <div class="h-4 w-20 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < $rows; $i++)
                                <tr class="border-b border-gray-100 dark:border-zinc-800/50">
                                    @for ($j = 0; $j < 6; $j++)
                                        <td class="py-3 px-2">
                                            <div class="h-4 w-24 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse">
                                            </div>
                                        </td>
                                    @endfor
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($type === 'profile')
            <!-- ========== PROFILE SKELETON ========== -->
            <div class="bg-white dark:bg-zinc-900 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800 p-6">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    <div class="w-24 h-24 bg-gray-200 dark:bg-zinc-700 rounded-full animate-pulse"></div>
                    <div class="flex-1 space-y-3">
                        <div class="h-8 w-48 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="h-4 w-64 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="flex gap-3">
                            <div class="h-6 w-20 bg-gray-200 dark:bg-zinc-700 rounded-full animate-pulse"></div>
                            <div class="h-6 w-20 bg-gray-200 dark:bg-zinc-700 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                    <div class="h-10 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="bg-gray-50 dark:bg-zinc-800/50 p-4 rounded-md">
                            <div class="h-4 w-24 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            <div class="h-8 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-2"></div>
                        </div>
                    @endfor
                </div>
            </div>
        @elseif($type === 'dashboard')
            <!-- ========== DASHBOARD SKELETON ========== -->
            <div class="space-y-4">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @for ($i = 0; $i < 4; $i++)
                        <div
                            class="bg-white dark:bg-zinc-900 p-4 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                                <div class="flex-1">
                                    <div class="h-4 w-20 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                                    <div class="h-7 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-1"></div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <!-- Chart & Payment -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div
                        class="lg:col-span-2 bg-white dark:bg-zinc-900 p-4 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800 h-64">
                        <div class="h-6 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mb-4"></div>
                        <div class="h-48 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    </div>
                    <div
                        class="bg-white dark:bg-zinc-900 p-4 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800 h-64">
                        <div class="h-6 w-24 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mb-4"></div>
                        <div class="h-40 bg-gray-200 dark:bg-zinc-700 rounded-full animate-pulse"></div>
                    </div>
                </div>

                <!-- Table -->
                <div
                    class="bg-white dark:bg-zinc-900 p-4 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-6 w-40 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="h-8 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    </div>
                    <div class="space-y-3">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="h-12 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        @endfor
                    </div>
                </div>
            </div>
        @elseif($type === 'form')
            <!-- ========== FORM SKELETON ========== -->
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800">
                <div class="h-8 w-48 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mb-2"></div>
                <div class="h-4 w-64 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mb-6"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @for ($i = 0; $i < 6; $i++)
                        <div class="{{ $i >= 4 ? 'md:col-span-2' : '' }}">
                            <div class="h-4 w-24 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mb-1"></div>
                            <div class="h-10 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        </div>
                    @endfor
                </div>

                <div class="mt-6 flex gap-3">
                    <div class="h-10 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-10 w-24 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                </div>
            </div>
        @elseif($type === 'settings')
            <!-- ========== SETTINGS SKELETON ========== -->
            <div class="bg-white dark:bg-zinc-900 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800">
                <div class="border-b border-gray-200 dark:border-zinc-800 p-4">
                    <div class="flex items-center gap-2">
                        @for ($i = 0; $i < 6; $i++)
                            <div class="h-8 w-24 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        @endfor
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="h-6 w-40 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-4 w-64 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>

                    @for ($i = 0; $i < 4; $i++)
                        <div
                            class="flex items-center justify-between border border-gray-200 dark:border-zinc-700 rounded-md p-4">
                            <div>
                                <div class="h-5 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                                <div class="h-3 w-48 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-1"></div>
                            </div>
                            <div class="h-6 w-12 bg-gray-200 dark:bg-zinc-700 rounded-full animate-pulse"></div>
                        </div>
                    @endfor
                </div>
            </div>
        @elseif($type === 'list')
            <!-- ========== LIST SKELETON ========== -->
            <div class="space-y-3">
                @for ($i = 0; $i < $rows; $i++)
                    <div
                        class="bg-white dark:bg-zinc-900 p-4 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800 flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-200 dark:bg-zinc-700 rounded-full animate-pulse"></div>
                        <div class="flex-1">
                            <div class="h-5 w-40 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            <div class="h-3 w-56 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-1"></div>
                        </div>
                        <div class="h-8 w-24 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    </div>
                @endfor
            </div>
        @elseif($type === 'chat')
            <!-- ========== CHAT SKELETON ========== -->
            <div
                class="bg-white dark:bg-zinc-900 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800 h-96 flex flex-col">
                <div class="p-4 border-b border-gray-200 dark:border-zinc-800 flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-200 dark:bg-zinc-700 rounded-full animate-pulse"></div>
                    <div class="flex-1">
                        <div class="h-5 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="h-3 w-24 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-1"></div>
                    </div>
                </div>
                <div class="flex-1 p-4 space-y-4 overflow-y-auto">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="flex {{ $i % 2 == 0 ? 'justify-start' : 'justify-end' }}">
                            <div class="max-w-[70%]">
                                <div
                                    class="h-12 w-48 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse {{ $i % 2 == 0 ? 'rounded-bl-none' : 'rounded-br-none' }}">
                                </div>
                                <div
                                    class="h-3 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-1 {{ $i % 2 == 0 ? 'ml-2' : 'mr-2 ml-auto' }}">
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="p-4 border-t border-gray-200 dark:border-zinc-800">
                    <div class="h-10 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                </div>
            </div>
        @endif
    </div>

    <!-- Content -->
    <div x-show="!loading" x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100">
        {{ $slot }}
    </div>
</div>
