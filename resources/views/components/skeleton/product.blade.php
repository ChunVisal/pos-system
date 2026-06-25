<!-- resources/views/components/skeleton/product-skeleton.blade.php -->
<div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 500)" x-cloak>

    <!-- SKELETON LOADING (shown when loading = true) -->
    <div x-show="loading" x-transition:leave="transition-opacity duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="space-y-4">
            <!-- Title -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="h-8 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-4 w-48 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-1"></div>
                </div>
                <div class="flex items-center gap-2 mt-3 sm:mt-0">
                    <div class="h-10 w-28 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-10 w-28 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                </div>
            </div>

            <!-- Filter Row -->
            <div
                class="bg-white dark:bg-zinc-900 p-3 rounded-md shadow-xs border border-gray-200 dark:border-zinc-800/60">
                <div class="flex flex-wrap items-center gap-3">
                    <div class="h-9 w-48 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-9 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-9 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="h-9 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse ml-auto"></div>
                </div>
            </div>

            <!-- Table -->
            <div
                class="bg-white dark:bg-zinc-900 rounded-md shadow-sm border border-gray-200 dark:border-zinc-800/60 overflow-hidden">
                <div class="overflow-x-auto p-4">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-zinc-800">
                                <th class="pb-3 pr-4">
                                    <div class="h-4 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                                </th>
                                <th class="pb-3 px-4">
                                    <div class="h-4 w-20 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                                </th>
                                <th class="pb-3 px-4">
                                    <div class="h-4 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                                </th>
                                <th class="pb-3 px-4">
                                    <div class="h-4 w-12 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                                </th>
                                <th class="pb-3 px-4">
                                    <div class="h-4 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                                </th>
                                <th class="pb-3 pl-4 text-right">
                                    <div class="h-4 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse ml-auto">
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-zinc-800/50">
                            @for ($i = 0; $i < 8; $i++)
                                <tr>
                                    <td class="py-3 pr-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse">
                                            </div>
                                            <div>
                                                <div
                                                    class="h-4 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse">
                                                </div>
                                                <div
                                                    class="h-3 w-24 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse mt-1">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="h-6 w-16 bg-gray-200 dark:bg-zinc-700 rounded-full animate-pulse">
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="h-4 w-20 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="h-4 w-12 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="h-4 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                                    </td>
                                    <td class="py-3 pl-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <div class="h-8 w-8 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse">
                                            </div>
                                            <div class="h-8 w-8 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="flex items-center justify-between p-4 border-t border-gray-200 dark:border-zinc-800">
                    <div class="h-4 w-32 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                    <div class="flex items-center gap-1">
                        <div class="h-8 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="h-8 w-8 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="h-8 w-8 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="h-8 w-8 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
                        <div class="h-8 w-16 bg-gray-200 dark:bg-zinc-700 rounded animate-pulse"></div>
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
