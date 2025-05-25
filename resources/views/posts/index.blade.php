@extends('layouts.app')

@section('title', 'Blog Posts')

@section('header')
    <h1 class="text-3xl font-bold text-gray-900">Blog Posts</h1>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Filter Panel (Collapsible) -->
        <div x-data="{ open: false }" class="mb-8 bg-white shadow rounded-lg overflow-hidden">
            <div class="p-4 flex justify-between items-center bg-gray-50 border-b">
                <h2 class="text-lg font-medium text-gray-900">Advanced Filters</h2>
                <button @click="open = !open" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span x-text="open ? 'Hide Filters' : 'Show Filters'">Show Filters</span>
                    <svg x-bind:class="{'rotate-180': open}" class="ml-1 h-4 w-4 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            
            <div x-show="open" x-transition class="p-4">
                <form id="filter-form" action="{{ route('posts.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Categories Filter -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Categories</label>
                            <select id="category" name="category[]" class="form-multiselect block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" multiple>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" {{ in_array($category->slug, (array)request('category')) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Tags Filter -->
                        <div>
                            <label for="tag" class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                            <select id="tag" name="tag[]" class="form-multiselect block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" multiple>
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->slug }}" {{ in_array($tag->slug, (array)request('tag')) ? 'selected' : '' }}>
                                        {{ $tag->name }} ({{ $tag->posts_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Date Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label for="date_from" class="sr-only">From</label>
                                    <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="From">
                                </div>
                                <div>
                                    <label for="date_to" class="sr-only">To</label>
                                    <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="To">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Search posts...">
                        </div>
                        
                        <!-- Sort By -->
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                            <select id="sort" name="sort" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            </select>
                        </div>
                        
                        @auth
                            <!-- Filter Preset Actions -->
                            <div x-data="{ showPresets: false }">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Presets</label>
                                <div class="flex space-x-2">
                                    <button @click.prevent="showPresets = !showPresets" type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                                        </svg>
                                        Load Preset
                                    </button>
                                    <button id="save-preset-btn" type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z" />
                                        </svg>
                                        Save Current
                                    </button>
                                </div>
                                
                                <!-- Preset Dropdown -->
                                <div x-show="showPresets" @click.away="showPresets = false" class="mt-2 origin-top-right absolute z-10 bg-white rounded-md shadow-lg p-2">
                                    <!-- Would be populated dynamically with user's saved presets -->
                                    <p class="text-gray-500 text-sm mb-2">Your Saved Presets</p>
                                    <a href="{{ route('filter-presets.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                        Manage Presets
                                    </a>
                                </div>
                            </div>
                        @endauth
                    </div>
                    
                    <div class="mt-6 flex justify-between">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Apply Filters
                        </button>
                        <a href="{{ route('posts.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Clear Filters
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Active Filters Display -->
        @php
            $hasFilters = request()->hasAny(['category', 'tag', 'search', 'date_from', 'date_to', 'sort']);
        @endphp
        
        @if($hasFilters)
            <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1 md:flex md:justify-between">
                        <p class="text-sm text-blue-700">
                            Active filters: 
                            @if(request('search'))
                                <span class="font-medium">Search: "{{ request('search') }}"</span>
                            @endif
                            
                            @if(request('category'))
                                <span class="font-medium">Categories: {{ implode(', ', (array)request('category')) }}</span>
                            @endif
                            
                            @if(request('tag'))
                                <span class="font-medium">Tags: {{ implode(', ', (array)request('tag')) }}</span>
                            @endif
                            
                            @if(request('date_from') || request('date_to'))
                                <span class="font-medium">
                                    Date: 
                                    {{ request('date_from') ? request('date_from') : 'Any' }} 
                                    to 
                                    {{ request('date_to') ? request('date_to') : 'Any' }}
                                </span>
                            @endif
                            
                            @if(request('sort') && request('sort') != 'latest')
                                <span class="font-medium">Sort: {{ ucfirst(request('sort')) }}</span>
                            @endif
                        </p>
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
                            <img class="h-10 w-10 rounded-full" src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $post->user->name }}">
                            <div class="ml-3">
                                <a href="{{ route('authors.show', $post->user->id) }}" class="text-sm font-medium text-gray-900 hover:underline">{{ $post->user->name }}</a>
                            </div>
                        </div>
                        
                        @if($post->tags->count() > 0)
                            <div class="mt-4 flex flex-wrap">
                                @foreach($post->tags as $tag)
                                    <a href="{{ route('posts.index', ['tag' => $tag->slug]) }}" class="mr-2 mb-2 inline-block bg-gray-100 hover:bg-gray-200 rounded-full px-3 py-1 text-xs font-semibold text-gray-700">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 py-20 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No posts found</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new post.</p>
                    <div class="mt-6">
                        <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            New Post
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    </div>
    
    <!-- Modal for saving filter preset -->
    <div x-data="{ open: false }" @keydown.escape.window="open = false" x-show="open" class="fixed z-10 inset-0 overflow-y-auto" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="preset-form" action="{{ route('filter-presets.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Save Filter Preset
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Save your current filters as a preset for easy access later.
                                    </p>
                                    <div class="mt-4">
                                        <label for="preset-name" class="block text-sm font-medium text-gray-700">Preset Name</label>
                                        <input type="text" name="name" id="preset-name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="My Custom Filter" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Save Preset
                        </button>
                        <button @click="open = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        // Initialize the save preset button
        const savePresetBtn = document.getElementById('save-preset-btn');
        if (savePresetBtn) {
            savePresetBtn.addEventListener('click', () => {
                Alpine.store('modal').open = true;
            });
        }
        
        // Store for modal state
        Alpine.store('modal', {
            open: false
        });
    });
</script>
@endsection 