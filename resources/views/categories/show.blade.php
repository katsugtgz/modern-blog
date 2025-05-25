@extends('layouts.app')

@section('title', "Posts in category: {$category->name}")

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Category: {{ $category->name }}</h1>
            <p class="mt-1 text-sm text-gray-600">Showing {{ $posts->total() }} {{ Str::plural('post', $posts->total()) }}</p>
        </div>
        <a href="{{ route('posts.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            Back to All Posts
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Category Description -->
        @if($category->description)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-100 rounded-md p-2">
                            <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-lg leading-6 font-medium text-gray-900">About this category</h2>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                {{ $category->description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Posts Grid -->
        <div class="grid gap-6 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
            @forelse($posts as $post)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('posts.show', $post->slug) }}">
                        <div class="relative h-48">
                            <img class="w-full h-full object-cover" src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3603&q=80' }}" alt="{{ $post->title }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-70"></div>
                            <div class="absolute bottom-0 left-0 p-4">
                                <span class="inline-block bg-indigo-600 rounded-full px-3 py-1 text-sm font-semibold text-white mr-2 mb-2">
                                    {{ $post->category->name }}
                                </span>
                            </div>
                        </div>
                    </a>
                    <div class="p-4">
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-2">
                            <span>{{ $post->published_at->format('M d, Y') }}</span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                {{ $post->view_count }}
                            </span>
                        </div>
                        <a href="{{ route('posts.show', $post->slug) }}" class="block">
                            <h3 class="text-xl font-semibold text-gray-900 hover:text-indigo-600 transition duration-300">{{ $post->title }}</h3>
                            <p class="mt-2 text-gray-600 line-clamp-3">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}</p>
                        </a>
                        <div class="flex items-center mt-4">
                            <img class="h-8 w-8 rounded-full object-cover" src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $post->user->name }}">
                            <div class="ml-2">
                                <p class="text-sm font-medium text-gray-900">{{ $post->user->name }}</p>
                            </div>
                        </div>
                        
                        @if($post->tags->isNotEmpty())
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($post->tags as $tag)
                                    <a href="{{ route('tags.show', $tag->slug) }}" class="inline-block bg-gray-200 rounded-full px-3 py-1 text-xs font-semibold text-gray-700 hover:bg-gray-300 transition duration-200">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white shadow rounded-lg p-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No posts found</h3>
                    <p class="mt-1 text-sm text-gray-500">There are no posts in this category yet.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
@endsection 