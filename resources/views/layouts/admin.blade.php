<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ dark: true }" :class="dark ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Modern Blog') }} - Admin Dashboard - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div x-data="{ sidebarOpen: false, postsDropdownOpen: false }" class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div :class="{'translate-x-0 ease-out': sidebarOpen, '-translate-x-full ease-in': !sidebarOpen}" 
            class="fixed inset-y-0 left-0 z-30 w-64 transition duration-300 transform bg-gray-800 dark:bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
            
            <!-- Sidebar content -->
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-between px-4 py-5">
                    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-white">
                        {{ config('app.name') }} Admin
                    </a>
                    <button @click="sidebarOpen = false" class="p-2 rounded-md lg:hidden text-white hover:text-gray-200 hover:bg-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-2 py-4 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-100 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('home') }}" class="flex items-center px-4 py-2 text-gray-100 rounded-md hover:bg-gray-700">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span>View Site</span>
                    </a>

                    <!-- Posts dropdown -->
                    <div class="space-y-1">
                        <button @click="postsDropdownOpen = !postsDropdownOpen" class="flex items-center justify-between px-4 py-2 w-full text-gray-100 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.posts.*') ? 'bg-gray-700' : '' }}">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                <span>Posts</span>
                            </div>
                            <svg :class="postsDropdownOpen ? 'rotate-90' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        
                        <div x-show="postsDropdownOpen" class="pl-12 space-y-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 rounded-md hover:bg-gray-700">Drafts</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 rounded-md hover:bg-gray-700">Scheduled</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 rounded-md hover:bg-gray-700">Published</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 rounded-md hover:bg-gray-700">Newsletters</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 rounded-md hover:bg-gray-700">Paid-members only</a>
                        </div>
                    </div>

                    <a href="#" class="flex items-center px-4 py-2 text-gray-100 rounded-md hover:bg-gray-700">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                        </svg>
                        <span>Pages</span>
                    </a>

                    <a href="{{ route('admin.tags.index') }}" class="flex items-center px-4 py-2 text-gray-100 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.tags.*') ? 'bg-gray-700' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span>Tags</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-2 text-gray-100 rounded-md hover:bg-gray-700">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>Members</span>
                        <span class="px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-gray-800 bg-gray-200 rounded-full">25</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-2 text-gray-100 rounded-md hover:bg-gray-700">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Offers</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-2 text-gray-100 rounded-md hover:bg-gray-700">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>Ghost(Pro)</span>
                    </a>
                </nav>
                
                <!-- User profile and theme toggle -->
                <div class="px-4 py-5 border-t border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img class="h-10 w-10 rounded-full object-cover" 
                                src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=7F9CF5&background=EBF4FF' }}" 
                                alt="{{ Auth::user()->name }}">
                            <div class="ml-3">
                                <div class="text-sm font-medium text-white">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-400">Admin</div>
                            </div>
                        </div>
                        
                        <!-- Dark/Light Mode Toggle -->
                        <button @click="dark = !dark" class="p-2 rounded-full text-gray-300 hover:text-white hover:bg-gray-700">
                            <svg x-show="dark" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                            </svg>
                            <svg x-show="!dark" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top header -->
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-md text-gray-600 dark:text-gray-300 lg:hidden focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            <h1 class="ml-2 lg:ml-0 text-xl font-semibold text-gray-800 dark:text-white">@yield('page-title', 'Dashboard')</h1>
                        </div>
                        
                        <div class="flex items-center">
                            <form method="POST" action="{{ route('logout') }}" class="ml-4">
                                @csrf
                                <button type="submit" class="flex items-center text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white focus:outline-none">
                                    <span class="mr-2">Logout</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main content area -->
            <main class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-900 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html> 