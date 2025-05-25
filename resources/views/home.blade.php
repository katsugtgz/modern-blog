@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-indigo-700">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1521737852567-6949f3f9f2b5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="People working on laptops">
            <div class="absolute inset-0 bg-indigo-700 mix-blend-multiply" aria-hidden="true"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Modern Blog</h1>
            <p class="mt-6 text-xl text-indigo-100 max-w-3xl">Discover insightful articles, tutorials, and stories from our community of writers.</p>
            <div class="mt-10">
                <a href="{{ route('posts.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50">
                    Explore Blog
                </a>
                @guest
                    <a href="{{ route('register') }}" class="inline-flex items-center ml-4 px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Join the Community
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <!-- Latest Posts Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-10">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Latest Posts</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Fresh Content for You
                </p>
            </div>

            <div class="mt-12 grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
                @forelse($latestPosts as $post)
                    <div class="group relative bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <a href="{{ route('posts.show', $post->slug) }}">
                            <div class="relative h-48">
                                <img class="w-full h-full object-cover" src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3603&q=80' }}" alt="{{ $post->title }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300"></div>
                            </div>
                        </a>
                        <div class="p-6">
                            <div class="flex items-center text-sm mb-2">
                                <span class="text-indigo-600 bg-indigo-100 rounded-full px-3 py-1">{{ $post->category->name }}</span>
                                <span class="ml-auto text-gray-500">{{ $post->published_at->format('M d, Y') }}</span>
                            </div>
                            <a href="{{ route('posts.show', $post->slug) }}" class="block mt-2">
                                <h3 class="text-xl font-semibold text-gray-900 group-hover:text-indigo-600 transition duration-300">{{ $post->title }}</h3>
                                <p class="mt-3 text-base text-gray-500 line-clamp-2">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}</p>
                            </a>
                            <div class="mt-4 flex items-center">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full" src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $post->user->name }}">
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $post->user->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12">
                        <p class="text-gray-500">No posts found. Check back soon!</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('posts.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    View All Posts
                </a>
            </div>
        </div>
    </div>

    <!-- Popular Posts Section -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-10">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Popular Posts</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Community Favorites
                </p>
            </div>

            <div class="mt-12 space-y-6">
                @forelse($popularPosts as $post)
                    <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow duration-300">
                        <a href="{{ route('posts.show', $post->slug) }}" class="flex flex-col md:flex-row">
                            <div class="md:w-1/4 flex-shrink-0">
                                <img class="h-48 w-full object-cover md:h-full" src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3603&q=80' }}" alt="{{ $post->title }}">
                            </div>
                            <div class="p-6 md:w-3/4">
                                <div class="flex items-center text-sm mb-2">
                                    <span class="text-indigo-600 bg-indigo-100 rounded-full px-3 py-1">{{ $post->category->name }}</span>
                                    <span class="ml-3 text-gray-500">{{ $post->published_at->format('M d, Y') }}</span>
                                    <span class="ml-auto flex items-center text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $post->view_count }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 hover:text-indigo-600 transition duration-300">{{ $post->title }}</h3>
                                <p class="mt-3 text-base text-gray-500 line-clamp-2">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 200) }}</p>
                                <div class="mt-4 flex items-center">
                                    <div class="flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $post->user->name }}">
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $post->user->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <p class="text-gray-500">No popular posts yet. Check back soon!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Categories and Tags Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-10">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Browse By</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Categories and Tags
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Categories -->
                <div class="bg-gray-50 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Popular Categories</h3>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($categories as $category)
                            <a href="{{ route('categories.show', $category->slug) }}" class="flex items-center p-3 rounded-md hover:bg-indigo-50 transition-colors duration-200">
                                <span class="text-indigo-600 mr-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd" />
                                        <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z" />
                                    </svg>
                                </span>
                                <span class="text-gray-700">{{ $category->name }} <span class="text-gray-500 text-xs">({{ $category->posts_count }})</span></span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Tags -->
                <div class="bg-gray-50 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Popular Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <a href="{{ route('tags.show', $tag->slug) }}" class="bg-white hover:bg-indigo-50 text-indigo-600 rounded-full px-3 py-1 text-sm font-medium transition-colors duration-200">
                                #{{ $tag->name }} <span class="text-gray-500 text-xs">({{ $tag->posts_count }})</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-indigo-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Ready to dive in?</span>
                <span class="block text-indigo-200">Start your blogging journey today.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                @guest
                    <div class="inline-flex rounded-md shadow">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                            Create an Account
                        </a>
                    </div>
                @else
                    <div class="inline-flex rounded-md shadow">
                        <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                            Create a Post
                        </a>
                    </div>
                @endguest
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500">
                        Explore Posts
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection 