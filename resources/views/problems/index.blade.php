<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight font-outfit">
            {{ __('Coding Problems') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <!-- Filters Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-150 dark:border-gray-850 shadow-sm space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Filters</h3>
                        
                        <!-- Search Form -->
                        <form action="{{ route('problems.index') }}" method="GET" class="space-y-4">
                            <!-- Search -->
                            <div class="space-y-1.5">
                                <label for="search" class="text-xs font-bold text-gray-400 uppercase tracking-wider">Search</label>
                                <div class="relative">
                                    <input type="text" name="search" id="search" placeholder="Search problems..." value="{{ request('search') }}"
                                           class="w-full pl-4 pr-10 py-2.5 bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white" />
                                    <button type="submit" class="absolute right-3 top-3 text-gray-400 hover:text-gray-650">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Difficulty -->
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Difficulty</label>
                                <select name="difficulty" onchange="this.form.submit()" class="w-full py-2.5 bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white">
                                    <option value="">All Difficulties</option>
                                    <option value="easy" {{ request('difficulty') === 'easy' ? 'selected' : '' }}>Easy</option>
                                    <option value="medium" {{ request('difficulty') === 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="hard" {{ request('difficulty') === 'hard' ? 'selected' : '' }}>Hard</option>
                                </select>
                            </div>

                            <!-- Completion Status -->
                            @auth
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Status</label>
                                <select name="status" onchange="this.form.submit()" class="w-full py-2.5 bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white">
                                    <option value="">All</option>
                                    <option value="solved" {{ request('status') === 'solved' ? 'selected' : '' }}>Solved</option>
                                    <option value="unsolved" {{ request('status') === 'unsolved' ? 'selected' : '' }}>Unsolved</option>
                                </select>
                            </div>
                            @endauth

                            <!-- Active Tag -->
                            @if(request('tag'))
                                <input type="hidden" name="tag" value="{{ request('tag') }}">
                            @endif

                            <div class="flex gap-2">
                                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl text-sm transition-colors shadow-md shadow-blue-500/10">
                                    Apply Filters
                                </button>
                                <a href="{{ route('problems.index') }}" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-bold flex items-center justify-center transition-colors">
                                    Clear
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Tags Box -->
                    <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-150 dark:border-gray-850 shadow-sm space-y-4">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Topics</h3>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ request()->fullUrlWithQuery(['tag' => null]) }}" 
                               class="text-xs font-semibold px-3 py-1.5 rounded-xl transition-colors {{ !request('tag') ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-105 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-750' }}">
                                All Topics
                            </a>
                            @foreach($tags as $tag)
                                <a href="{{ request()->fullUrlWithQuery(['tag' => $tag->slug]) }}" 
                                   class="text-xs font-semibold px-3 py-1.5 rounded-xl transition-colors {{ request('tag') === $tag->slug ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-105 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-750' }}">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Problems List -->
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-150 dark:border-gray-850 shadow-sm space-y-6">
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-400 font-semibold">{{ $problems->total() }} Problems Found</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-555 dark:text-gray-400">
                                <thead>
                                    <tr class="text-xs text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800">
                                        <th class="py-3 px-4 font-semibold w-12 text-center">Status</th>
                                        <th class="py-3 px-4 font-semibold">Title</th>
                                        <th class="py-3 px-4 font-semibold">Tags</th>
                                        <th class="py-3 px-4 font-semibold w-24">Difficulty</th>
                                        <th class="py-3 px-4 font-semibold w-32">Points</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-105 dark:divide-gray-800">
                                    @forelse($problems as $problem)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                            <td class="py-4 px-4 text-center">
                                                @auth
                                                    @if(isset($userSolveStatus[$problem->id]))
                                                        @if($userSolveStatus[$problem->id] === 'solved')
                                                            <span class="text-emerald-500 text-base" title="Solved">
                                                                ✔
                                                            </span>
                                                        @else
                                                            <span class="text-amber-500 text-base" title="Attempted">
                                                                ⚠
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="text-gray-300 dark:text-gray-700">&mdash;</span>
                                                    @endif
                                                @else
                                                    <span class="text-gray-300 dark:text-gray-700">&mdash;</span>
                                                @endauth
                                            </td>
                                            <td class="py-4 px-4 font-bold text-gray-900 dark:text-white">
                                                <a href="{{ route('problems.show', $problem->slug) }}" class="hover:text-blue-600 transition-colors">
                                                    {{ $problem->title }}
                                                </a>
                                            </td>
                                            <td class="py-4 px-4">
                                                <div class="flex flex-wrap gap-1.5">
                                                    @foreach($problem->tags as $tag)
                                                        <span class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md">
                                                            {{ $tag->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="py-4 px-4">
                                                @if($problem->difficulty === 'easy')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 uppercase tracking-wide">
                                                        Easy
                                                    </span>
                                                @elseif($problem->difficulty === 'medium')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 uppercase tracking-wide">
                                                        Medium
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 uppercase tracking-wide">
                                                        Hard
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-4 font-mono font-semibold text-xs text-gray-500 dark:text-gray-400">
                                                @if($problem->difficulty === 'easy')
                                                    10 Points
                                                @elseif($problem->difficulty === 'medium')
                                                    20 Points
                                                @else
                                                    30 Points
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-10 text-gray-400">
                                                No coding problems found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        {{ $problems->links() }}

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
