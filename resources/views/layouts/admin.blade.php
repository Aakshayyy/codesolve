<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin - {{ config('app.name', 'CodeSolve') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-950 transition-colors duration-200">
        <div class="min-h-screen flex flex-col">
            <!-- Navigation -->
            @include('layouts.navigation')

            <div class="flex-grow flex flex-col md:flex-row max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 gap-8">
                <!-- Admin Sidebar -->
                <aside class="w-full md:w-64 shrink-0">
                    <div class="bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-850 rounded-3xl p-5 shadow-sm space-y-2">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3 mb-3">Admin Actions</div>
                        
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-650 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                            <span>📊 Dashboard Overview</span>
                        </a>

                        <a href="{{ route('admin.problems.index') }}" 
                           class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.problems.*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-650 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                            <span>📝 Manage Problems</span>
                        </a>

                        <a href="{{ route('admin.contests.index') }}" 
                           class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.contests.*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-650 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                            <span>🏆 Manage Contests</span>
                        </a>

                        <a href="{{ route('admin.users') }}" 
                           class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.users') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-650 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                            <span>👥 Manage Users</span>
                        </a>

                        <a href="{{ route('admin.submissions') }}" 
                           class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.submissions') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-650 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                            <span>💻 System Submissions</span>
                        </a>
                    </div>
                </aside>

                <!-- Admin Main Content -->
                <main class="flex-grow">
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-2xl text-sm font-semibold">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-950/20 border border-rose-100 dark:border-rose-900/30 text-rose-600 dark:text-rose-400 rounded-2xl text-sm font-semibold">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
