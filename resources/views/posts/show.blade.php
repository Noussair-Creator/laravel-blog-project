<x-blog-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Post Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                <img class="w-full h-96 object-cover"
                    src="{{ $post->feature_image ? asset('storage/' . $post->feature_image) : asset('images/default_post_image.png') }}"
                    alt="{{ $post->title }}">

                <div class="p-6 sm:px-10">
                    <!-- Post Header -->
                    <div class="pb-6 border-b border-gray-200 dark:border-gray-700">
                        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white">
                            {{ $post->title }}
                        </h1>
                        <div class="mt-6 flex items-center">
                            <div class="flex-shrink-0">
                                {{-- Updated avatar logic for post author --}}
                                @if ($post->user->avatar)
                                    <img class="h-12 w-12 rounded-full object-cover"
                                        src="{{ asset('storage/' . $post->user->avatar) }}"
                                        alt="{{ $post->user->name }}">
                                @else
                                    <div
                                        class="h-12 w-12 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center font-bold text-gray-500 text-xl">
                                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $post->user->name }}</p>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
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
                        </div>
                    </div>

                    <!-- Post Content -->
                    <div class="mt-6 prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <!-- Action Buttons Footer -->
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-4">
                        <a href="{{ route('posts.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none">
                            Back to List
                        </a>
                        @can('update', $post)
                            <a href="{{ route('posts.edit', $post) }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Edit Post
                            </a>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Comments Section Card -->
            <div id="comments" class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-10">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">Comments
                        ({{ $post->comments->count() }})</h3>

                    <!-- Add Comment Form -->
                    @auth
                        <div class="mt-6">
                            <form action="{{ route('comments.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <div>
                                    <x-input-label for="content" :value="__('Leave a comment')" class="sr-only" />
                                    <textarea id="content" name="content" rows="4"
                                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                        placeholder="What are your thoughts?">{{ old('content') }}</textarea>
                                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                                </div>
                                <div class="mt-4">
                                    <x-primary-button>
                                        {{ __('Post Comment') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="mt-6 text-gray-500 dark:text-gray-400">
                            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:underline">Log in</a>
                            to post a comment.
                        </div>
                    @endauth

                    <!-- Existing Comments -->
                    <div class="mt-8 -my-6 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($post->comments as $comment)
                            <div class="py-6">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        {{-- This is the updated avatar logic for comments --}}
                                        @if ($comment->user->avatar)
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ asset('storage/' . $comment->user->avatar) }}"
                                                alt="{{ $comment->user->name }}">
                                        @else
                                            <div
                                                class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center font-bold text-gray-500">
                                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $comment->user->name }}
                                        </p>
                                        <p class="mt-1 text-gray-700 dark:text-gray-300">
                                            {{ $comment->content }}
                                        </p>
                                        <div
                                            class="mt-2 flex items-center space-x-4 text-xs text-gray-500 dark:text-gray-400">
                                            <span>{{ $comment->created_at->diffForHumans() }}</span>
                                            @can('delete', $comment)
                                                <span class="text-gray-300 dark:text-gray-600"
                                                    aria-hidden="true">&middot;</span>
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="font-medium text-red-600 hover:underline dark:text-red-400 dark:hover:underline focus:outline-none">Delete</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="py-6 text-gray-500 dark:text-gray-400">No comments yet. Be the first to share your
                                thoughts!</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-blog-layout>
