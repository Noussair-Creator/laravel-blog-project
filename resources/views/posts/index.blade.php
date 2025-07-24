<x-blog-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('The Blog') }}
            </h2>
            @can('create', App\Models\Post::class)
                <a href="{{ route('posts.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Create New Post
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="text-center m-10">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 dark:text-white tracking-tight">From the
                    Blog</h1>
            </div>

            <!-- Posts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($posts as $post)
                    <article class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg flex flex-col">
                        <!-- Post Image -->
                        <a href="{{ route('posts.show', $post) }}">
                            <img class="w-full h-64 object-cover hover:opacity-90 transition-opacity duration-300"
                                src="{{ $post->feature_image ? asset('storage/' . $post->feature_image) : asset('images/default_post_image.png') }}"
                                alt="{{ $post->title }}">
                        </a>

                        <!-- Card Body -->
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex-grow">
                                <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 uppercase">
                                    {{ $post->category->name }}</p>
                                <a href="{{ route('posts.show', $post) }}" class="block mt-2">
                                    <h3
                                        class="text-2xl font-bold text-gray-900 dark:text-white group-hover:text-gray-600 dark:group-hover:text-gray-300">
                                        {{ $post->title }}</h3>
                                </a>
                                {{-- By setting a fixed height and hiding overflow, we ensure all cards have a uniform height --}}
                                <p class="mt-4 text-base text-gray-500 dark:text-gray-400 h-24 overflow-hidden">
                                    {{ Str::limit($post->content, 150) }}
                                </p>
                            </div>

                            <!-- Card Footer -->
                            <div class="mt-6 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        {{-- This is the updated avatar logic --}}
                                        @if ($post->user->avatar)
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ asset('storage/' . $post->user->avatar) }}"
                                                alt="{{ $post->user->name }}">
                                        @else
                                            <div
                                                class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center font-bold text-gray-500">
                                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $post->user->name }}
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            {{ $post->created_at->format('M j, Y') }}</p>
                                    </div>
                                </div>
                                <!-- Edit/Delete buttons only for authorized users -->
                                <div class="flex items-center space-x-2">
                                    @can('update', $post)
                                        <a href="{{ route('posts.edit', $post) }}"
                                            class="text-sm font-medium text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Edit</a>
                                    @endcan
                                    @can('delete', $post)
                                        <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-sm font-medium text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400 text-lg">No posts available yet.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination Links -->
            <div class="mt-16">
                {{ $posts->links() }}
            </div>

        </div>
    </div>
</x-blog-layout>
