<div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 500)" x-cloak>

    <!-- SKELETON LOADING (shown when loading = true) -->
    <div x-show="loading" x-transition:leave="transition-opacity duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="space-y-6">
            <!-- Title -->
            <div>
                <div class="h-8 w-48 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                <div class="h-4 w-64 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-2"></div>
            </div>

            <!-- Stats Cards - 4 cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-4">
                    <div class="h-4 w-24 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-8 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-2"></div>
                </div>
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-4">
                    <div class="h-4 w-24 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-8 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-2"></div>
                </div>
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-4">
                    <div class="h-4 w-24 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-8 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-2"></div>
                </div>
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-4">
                    <div class="h-4 w-24 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-8 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-2"></div>
                </div>
            </div>

            <!-- Graph & Right Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- Graph -->
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-6">
                    <div class="h-6 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mb-4"></div>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <div class="h-4 w-8 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            <div class="h-4 w-8 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            <div class="h-4 w-8 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            <div class="h-4 w-8 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            <div class="h-4 w-8 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            <div class="h-4 w-8 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        </div>
                        <div class="flex items-end space-x-2 h-32">
                            <div class="w-full bg-gray-200 dark:bg-zinc-700 rounded-t h-20 animate-pulse"></div>
                            <div class="w-full bg-gray-200 dark:bg-zinc-700 rounded-t h-28 animate-pulse"></div>
                            <div class="w-full bg-gray-200 dark:bg-zinc-700 rounded-t h-16 animate-pulse"></div>
                            <div class="w-full bg-gray-200 dark:bg-zinc-700 rounded-t h-24 animate-pulse"></div>
                            <div class="w-full bg-gray-200 dark:bg-zinc-700 rounded-t h-32 animate-pulse"></div>
                            <div class="w-full bg-gray-200 dark:bg-zinc-700 rounded-t h-18 animate-pulse"></div>
                        </div>
                    </div>
                </div>

                <!-- Right Grid - 2x2 -->
                <div class="grid grid-cols-2 grid-rows-2 gap-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-4">
                        <div class="h-4 w-20 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="h-6 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-2"></div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-4">
                        <div class="h-4 w-20 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="h-6 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-2"></div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-4">
                        <div class="h-4 w-20 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="h-6 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-2"></div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-4">
                        <div class="h-4 w-20 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="h-6 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-2"></div>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-4">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div class="h-10 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-10 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-10 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-10 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-10 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow overflow-hidden">
                <!-- Table Header -->
                <div class="grid grid-cols-6 gap-4 p-4 bg-gray-50 dark:bg-zinc-800">
                    <div class="h-4 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-4 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-4 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-4 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-4 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-4 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                </div>

                <!-- Table Rows -->
                <div class="divide-y divide-gray-200 dark:divide-zinc-800">
                    @for ($i = 0; $i < 8; $i++)
                        <div class="grid grid-cols-6 gap-4 p-4">
                            <div class="h-6 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            <div class="h-6 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            <div class="h-6 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            <div class="h-6 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            <div class="h-6 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            <div class="h-6 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        </div>
                    @endfor
                </div>

                <!-- Pagination -->
                <div class="flex justify-between items-center p-4 border-t border-gray-200 dark:border-zinc-800">
                    <div class="h-4 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="flex space-x-2">
                        <div class="h-8 w-20 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="h-8 w-20 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ACTUAL CONTENT (shown when loading = false) -->
    <div x-show="!loading" x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100">
        {{ $slot }}
    </div>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
