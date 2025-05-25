@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <article class="bg-white">
        <!-- Featured Image -->
        <div class="relative w-full h-96">
            <img 
                src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3603&q=80' }}" 
                alt="{{ $post->title }}"
                class="w-full h-full object-cover"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-70"></div>
            <div class="absolute bottom-0 left-0 w-full p-8">
                <div class="max-w-5xl mx-auto">
                    <div class="flex items-center mb-2">
                        <a href="{{ route('categories.show', $post->category->slug) }}" class="inline-block bg-indigo-600 rounded-full px-3 py-1 text-sm font-semibold text-white mr-2">
                            {{ $post->category->name }}
                        </a>
                        <span class="text-gray-200 text-sm">{{ $post->published_at->format('M d, Y') }}</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white">{{ $post->title }}</h1>
                    
                    <div class="flex items-center mt-6">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $post->user->name }}">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">{{ $post->user->name }}</p>
                            <div class="flex space-x-1 text-sm text-gray-200">
                                <span>{{ $post->reading_time }} min read</span>
                                <span aria-hidden="true">&middot;</span>
                                <span>{{ $post->view_count }} {{ Str::plural('view', $post->view_count) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Content -->
        <div class="max-w-4xl mx-auto px-4 py-10">
            <!-- Tags -->
            @if($post->tags->isNotEmpty())
                <div class="mb-8 flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 hover:bg-gray-300 transition duration-200">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif
            
            <!-- Post Content -->
            <div class="prose prose-lg max-w-none">
                {!! $post->content !!}
            </div>
            
            <!-- Author Bio -->
            <div class="mt-12 pt-10 border-t border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img class="h-16 w-16 rounded-full object-cover" src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $post->user->name }}">
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold text-gray-900">{{ $post->user->name }}</h3>
                        <p class="text-gray-600">{{ $post->user->bio ?? 'Author at ' . config('app.name') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Tags and Share -->
            <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-wrap gap-2">
                    @if($post->tags->isNotEmpty())
                        <span class="text-gray-600">Tags:</span>
                        @foreach($post->tags as $tag)
                            <a href="{{ route('tags.show', $tag->slug) }}" class="text-indigo-600 hover:text-indigo-900">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    @endif
                </div>
                
                <div class="mt-4 sm:mt-0 flex space-x-4">
                    <span class="text-gray-600">Share:</span>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('posts.show', $post->slug)) }}&text={{ urlencode($post->title) }}" target="_blank" class="text-blue-400 hover:text-blue-500">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.54 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.3 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16-1.9 1.47-4.3 2.35-6.9 2.35-.45 0-.9-.03-1.33-.08 2.46 1.58 5.38 2.5 8.5 2.5 10.23 0 15.8-8.47 15.8-15.8 0-.24 0-.48-.02-.72.67-.63 1.25-1.27 1.68-2.02z" />
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('posts.show', $post->slug)) }}" target="_blank" class="text-blue-600 hover:text-blue-700">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('posts.show', $post->slug)) }}&title={{ urlencode($post->title) }}" target="_blank" class="text-blue-700 hover:text-blue-800">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.7 3H4.3A1.3 1.3 0 003 4.3v15.4A1.3 1.3 0 004.3 21h15.4a1.3 1.3 0 001.3-1.3V4.3A1.3 1.3 0 0019.7 3zM8.339 18.338H5.667v-8.59h2.672v8.59zM7.004 8.574a1.548 1.548 0 11-.002-3.096 1.548 1.548 0 01.002 3.096zm11.335 9.764H15.67v-4.177c0-.996-.017-2.278-1.387-2.278-1.389 0-1.601 1.086-1.601 2.206v4.25h-2.667v-8.59h2.559v1.174h.037c.356-.675 1.227-1.387 2.526-1.387 2.703 0 3.203 1.779 3.203 4.092v4.71z" />
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Related Posts -->
            @if($relatedPosts->isNotEmpty())
                <div class="mt-12 pt-10 border-t border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Posts</h2>
                    <div class="grid md:grid-cols-2 gap-8">
                        @foreach($relatedPosts as $relatedPost)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <a href="{{ route('posts.show', $relatedPost->slug) }}">
                                    <div class="relative h-48">
                                        <img class="w-full h-full object-cover" src="{{ $relatedPost->featured_image ? asset('storage/' . $relatedPost->featured_image) : 'https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3603&q=80' }}" alt="{{ $relatedPost->title }}">
                                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-70"></div>
                                        <div class="absolute bottom-0 left-0 p-4">
                                            <span class="inline-block bg-indigo-600 rounded-full px-3 py-1 text-sm font-semibold text-white mr-2 mb-2">
                                                {{ $relatedPost->category->name }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                                <div class="p-4">
                                    <div class="flex items-center justify-between text-sm text-gray-500 mb-2">
                                        <span>{{ $relatedPost->published_at->format('M d, Y') }}</span>
                                    </div>
                                    <a href="{{ route('posts.show', $relatedPost->slug) }}" class="block">
                                        <h3 class="text-xl font-semibold text-gray-900 hover:text-indigo-600 transition duration-300">{{ $relatedPost->title }}</h3>
                                        <p class="mt-2 text-gray-600 line-clamp-2">{{ $relatedPost->excerpt ?? Str::limit(strip_tags($relatedPost->content), 150) }}</p>
                                    </a>
                                    
                                    @if($relatedPost->tags->isNotEmpty())
                                        <div class="mt-4 flex flex-wrap gap-2">
                                            @foreach($relatedPost->tags->take(3) as $tag)
                                                <a href="{{ route('tags.show', $tag->slug) }}" class="inline-block bg-gray-200 rounded-full px-3 py-1 text-xs font-semibold text-gray-700 hover:bg-gray-300 transition duration-200">
                                                    #{{ $tag->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Back to posts link -->
            <div class="mt-10">
                <a href="{{ route('posts.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to all posts
                </a>
            </div>
        </div>
    </article>
@endsection 