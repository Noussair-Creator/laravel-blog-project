<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                <!-- Card Header -->
                <div class="p-6 sm:px-10 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $category->name }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Category Details
                            </p>
                        </div>
                        <a href="{{ route('admin.categories.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Back to List
                        </a>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6 sm:px-10 bg-white dark:bg-gray-800">
                    <!-- Description Section -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Description</h4>
                        <p class="mt-2 text-gray-600 dark:text-gray-400 leading-relaxed">
                            {{ $category->description ?? 'No description provided.' }}
                        </p>
                    </div>

                    <!-- Stats Section -->
                    <div
                        class="grid grid-cols-1 md:grid-cols-3 gap-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Total Posts</h4>
                            <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ $category->posts_count }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Created At</h4>
                            <p class="mt-1 text-lg text-gray-900 dark:text-white">
                                {{ $category->created_at->format('M j, Y') }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Last Updated</h4>
                            <p class="mt-1 text-lg text-gray-900 dark:text-white">
                                {{ $category->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
