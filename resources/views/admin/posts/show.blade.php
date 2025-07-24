<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                <!-- Feature Image -->
                <img class="w-full h-96 object-cover"
                    src="{{ $post->feature_image ? asset('storage/' . $post->feature_image) : asset('images/default_post_image.png') }}"
                    alt="{{ $post->title }}">

                <div class="p-6 sm:px-10">
                    <!-- Post Header -->
                    <div class="pb-6 border-b border-gray-200 dark:border-gray-700">
                        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white">
                            {{ $post->title }}
                        </h1>
                        <div class="mt-4 flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <p>
                                By <span
                                    class="font-semibold text-gray-700 dark:text-gray-200">{{ $post->user->name }}</span>
                            </p>
                            <span class="mx-2">&bull;</span>
                            <p>
                                In <a href="#"
                                    class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">{{ $post->category->name }}</a>
                            </p>
                            <span class="mx-2">&bull;</span>
                            <p>
                                {{ $post->created_at->format('F j, Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Post Content -->
                    <div class="mt-6 prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <!-- Action Buttons Footer -->
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-4">
                        <a href="{{ route('admin.posts.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none">
                            Back to List
                        </a>
                        <a href="{{ route('admin.posts.edit', $post) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Edit Post
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
