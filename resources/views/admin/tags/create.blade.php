@extends('layouts.app')

@section('title', 'Create Tag')

@section('header')
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">Create Tag</h1>
    </div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Admin Navigation -->
        <nav class="flex mb-6 space-x-4" aria-label="Admin navigation">
            <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-md hover:text-gray-900 hover:bg-gray-200">
                Categories
            </a>
            <a href="{{ route('admin.tags.index') }}" class="px-3 py-2 text-sm font-medium text-indigo-700 bg-indigo-100 rounded-md">
                Tags
            </a>
        </nav>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <form action="{{ route('admin.tags.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" class="form-input block w-full rounded-md" value="{{ old('name') }}" required autofocus>
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700">Slug (optional)</label>
                            <div class="mt-1">
                                <input type="text" name="slug" id="slug" class="form-input block w-full rounded-md" value="{{ old('slug') }}">
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Leave blank to auto-generate from name</p>
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <a href="{{ route('admin.tags.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Create Tag
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

            nameInput.addEventListener('input', function() {
                if (slugInput.value === '') {
                    // Only auto-generate if user hasn't manually entered a slug
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