<!-- resources/views/components/skeleton/product-skeleton.blade.php -->
<div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 500)" x-cloak>

    <!-- SKELETON LOADING (shown when loading = true) -->
    <div x-show="loading" x-transition:leave="transition-opacity duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="p-1">
        <!-- Title -->
        <div class="mb-3">
            <div class="h-8 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
            <div class="h-4 w-56 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-1"></div>
        </div>

        <!-- Big Box -->
        <div class="bg-white dark:bg-zinc-900 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800/60">
            <!-- Tabs -->
            <div class="border-b border-gray-200 dark:border-zinc-800 p-4">
                <div class="flex items-center gap-2 overflow-x-auto">
                    @for ($i = 0; $i < 7; $i++)
                        <div class="h-9 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse shrink-0"></div>
                    @endfor
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="space-y-6">
                    <!-- Section Header -->
                    <div>
                        <div class="h-6 w-40 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="h-4 w-64 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-1"></div>
                    </div>

                    <!-- Logo Upload -->
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div>
                            <div class="h-9 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            <div class="h-3 w-40 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-1"></div>
                        </div>
                    </div>

                    <!-- Form Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-2xl">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="{{ $i >= 2 ? 'md:col-span-2' : '' }}">
                                <div class="h-4 w-24 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mb-1"></div>
                                <div class="h-10 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                            </div>
                        @endfor
                    </div>

                    <!-- Save Button -->
                    <div class="h-10 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
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
