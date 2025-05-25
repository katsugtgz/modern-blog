@extends('layouts.app')

@section('title', 'Edit Category')

@section('header')
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">Edit Category</h1>
    </div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Admin Navigation -->
        <nav class="flex mb-6 space-x-4" aria-label="Admin navigation">
            <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 text-sm font-medium text-indigo-700 bg-indigo-100 rounded-md">
                Categories
            </a>
            <a href="{{ route('admin.tags.index') }}" class="px-3 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-md hover:text-gray-900 hover:bg-gray-200">
                Tags
            </a>
        </nav>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" class="form-input block w-full rounded-md" value="{{ old('name', $category->name) }}" required autofocus>
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                            <div class="mt-1">
                                <input type="text" name="slug" id="slug" class="form-input block w-full rounded-md" value="{{ old('slug', $category->slug) }}">
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Leave blank to auto-generate from name</p>
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description (optional)</label>
                            <div class="mt-1">
                                <textarea name="description" id="description" rows="4" class="form-textarea block w-full rounded-md">{{ old('description', $category->description) }}</textarea>
                            </div>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Usage Info -->
                        <div class="bg-gray-50 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-700">
                                        This category is currently used in <strong>{{ $category->posts->count() }}</strong> {{ Str::plural('post', $category->posts->count()) }}.
                                        @if($category->posts->count() > 0)
                                            <a href="{{ route('categories.show', $category->slug) }}" class="font-medium text-indigo-600 hover:text-indigo-500" target="_blank">
                                                View posts
                                            </a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <div class="flex">
                            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                Cancel
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" class="ml-3" onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" {{ $category->posts->count() > 0 ? 'disabled' : '' }}>
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Slug Generation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            const originalSlug = "{{ $category->slug }}";
            let userEditedSlug = false;

            // Mark as user edited if the initial slug is different from auto-generated
            slugInput.addEventListener('input', function() {
                userEditedSlug = true;
            });

            nameInput.addEventListener('input', function() {
                // Only auto-generate if user hasn't manually edited the slug
                // and if it's still the original value
                if (!userEditedSlug && slugInput.value === originalSlug) {
                    slugInput.value = nameInput.value
                        .toLowerCase()
                        .replace(/[^\w\s-]/g, '') // Remove special chars
                        .replace(/\s+/g, '-')     // Replace spaces with hyphens
                        .replace(/--+/g, '-')     // Replace multiple hyphens with single hyphen
                        .trim();                  // Trim whitespace
                }
            });
        });
    </script>
@endsection 