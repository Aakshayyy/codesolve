<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CodeSolve - Online Coding Practice & Competitive Programming</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-950 transition-colors duration-200">
        <!-- Hero Section with Animated background -->
        <div class="relative overflow-hidden min-h-screen flex flex-col justify-between">
            <!-- Background grids/blobs -->
            <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden opacity-30 dark:opacity-40">
                <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-blue-500 blur-3xl"></div>
                <div class="absolute top-1/2 -left-40 w-96 h-96 rounded-full bg-indigo-500 blur-3xl"></div>
                <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
            </div>

            <!-- Header -->
            <header class="relative z-10 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <a href="/" class="flex items-center space-x-2">
                    <span class="font-extrabold text-2xl tracking-tight bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 bg-clip-text text-transparent font-outfit">
                        CodeSolve
                    </span>
                </a>

                <div class="flex items-center space-x-6">
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="{{ route('theory.index') }}" class="text-sm font-semibold text-gray-750 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Theory</a>
                        <a href="{{ route('problems.index') }}" class="text-sm font-semibold text-gray-750 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Problems</a>
                        <a href="{{ route('contests.index') }}" class="text-sm font-semibold text-gray-750 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Contests</a>
                        <a href="{{ route('leaderboard') }}" class="text-sm font-semibold text-gray-750 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Leaderboard</a>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Dark mode toggle -->
                        <button @click="darkMode = !darkMode" class="p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-150 dark:hover:bg-gray-900 rounded-lg transition-colors">
                            <svg x-show="darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" clip-rule="evenodd" />
                            </svg>
                            <svg x-show="!darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                            </svg>
                        </button>

                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-750 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">Log in</a>
                            <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition-all duration-200 shadow-md shadow-blue-500/20">Register</a>
                        @endauth
                    </div>
                </div>
            </header>

            <!-- Hero Main -->
            <main class="relative z-10 flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl text-center space-y-8">
                    <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-blue-550/10 text-blue-600 dark:text-blue-400 text-xs font-semibold uppercase tracking-wider border border-blue-500/10">
                        <span>🚀 Unleash Your Coding Potential</span>
                    </div>

                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight font-outfit text-gray-900 dark:text-white leading-tight">
                        Solve Problems. Build Skills. <br>
                        <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-400 dark:via-indigo-400 dark:to-purple-400 bg-clip-text text-transparent">
                            Conquer Contests.
                        </span>
                    </h1>

                    <p class="max-w-2xl mx-auto text-lg sm:text-xl text-gray-650 dark:text-gray-450 leading-relaxed">
                        CodeSolve is the ultimate playground for competitive programmers and coding enthusiasts. Complete with real-time compilers, contests, discussions, and leaderboards.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('theory.index') }}" class="w-full sm:w-auto text-center text-white bg-gradient-to-r from-blue-650 to-indigo-650 hover:from-blue-705 hover:to-indigo-705 px-8 py-3.5 rounded-xl font-semibold shadow-lg shadow-indigo-500/20 transition-all duration-200 animate-pulse-slow">
                            Learn Theory Academy
                        </a>
                        <a href="{{ route('problems.index') }}" class="w-full sm:w-auto text-center text-gray-700 dark:text-gray-250 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-850 px-8 py-3.5 rounded-xl font-semibold transition-all duration-200">
                            Explore Problems
                        </a>
                        <a href="{{ route('contests.index') }}" class="w-full sm:w-auto text-center text-gray-700 dark:text-gray-250 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-850 px-8 py-3.5 rounded-xl font-semibold transition-all duration-200">
                            Join Contests
                        </a>
                    </div>

                    <!-- Statistics grid -->
                    <div class="pt-12 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-3xl mx-auto">
                        <div class="p-6 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
                            <span class="block text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">100+</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">Coding Problems</span>
                        </div>
                        <div class="p-6 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
                            <span class="block text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">4+</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">Languages Supported</span>
                        </div>
                        <div class="p-6 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
                            <span class="block text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Active</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">Contests & Hubs</span>
                        </div>
                        <div class="p-6 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
                            <span class="block text-3xl font-extrabold text-gray-900 dark:text-white font-outfit">Global</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">Weekly Leaderboard</span>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="relative z-10 py-8 border-t border-gray-200 dark:border-gray-900 text-center text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-950">
                <p>&copy; {{ date('Y') }} CodeSolve. Built with Laravel and AlpineJS.</p>
            </footer>
        </div>
    </body>
</html>
