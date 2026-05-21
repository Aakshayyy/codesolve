<x-app-layout>
    <style>
        .theory-prose {
            font-size: 0.95rem;
            line-height: 1.75;
        }
        .theory-prose h1 {
            font-size: 2.25rem;
            font-weight: 800;
            margin-top: 0;
            margin-bottom: 1.5rem;
            font-family: 'Outfit', sans-serif;
            letter-spacing: -0.025em;
        }
        .theory-prose h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 0.85rem;
            border-bottom: 1px solid rgba(156, 163, 175, 0.2);
            padding-bottom: 0.5rem;
            font-family: 'Outfit', sans-serif;
            letter-spacing: -0.01em;
        }
        .theory-prose h3 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            font-family: 'Outfit', sans-serif;
        }
        .theory-prose p {
            margin-bottom: 1.25rem;
            color: #374151;
        }
        .dark .theory-prose p {
            color: #d1d5db;
        }
        .theory-prose blockquote {
            border-left: 4px solid #3b82f6;
            padding-left: 1.25rem;
            margin: 1.5rem 0;
            color: #4b5563;
            font-style: italic;
            background-color: #eff6ff;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            border-radius: 0 0.5rem 0.5rem 0;
        }
        .dark .theory-prose blockquote {
            color: #9ca3af;
            background-color: rgba(59, 130, 246, 0.05);
        }
        .theory-prose code {
            background-color: #f1f5f9;
            color: #e11d48;
            padding: 0.15rem 0.4rem;
            border-radius: 0.375rem;
            font-size: 0.85em;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-weight: 600;
        }
        .dark .theory-prose code {
            background-color: #1e293b;
            color: #f43f5e;
        }
        .theory-prose pre {
            background-color: #0f172a;
            color: #f8fafc;
            padding: 1.25rem;
            border-radius: 0.75rem;
            overflow-x: auto;
            margin: 1.5rem 0;
            font-size: 0.85rem;
            line-height: 1.6;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            border: 1px solid #1e293b;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .theory-prose pre code {
            background-color: transparent !important;
            color: inherit !important;
            padding: 0 !important;
            font-size: inherit !important;
            font-weight: inherit !important;
        }
        .theory-prose ul {
            list-style-type: disc;
            padding-left: 1.5rem;
            margin-bottom: 1.25rem;
        }
        .theory-prose ol {
            list-style-type: decimal;
            padding-left: 1.5rem;
            margin-bottom: 1.25rem;
        }
        .theory-prose li {
            margin-bottom: 0.5rem;
            color: #4b5563;
        }
        .dark .theory-prose li {
            color: #9ca3af;
        }
        .theory-prose table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.75rem 0;
            font-size: 0.9rem;
        }
        .theory-prose th, .theory-prose td {
            border: 1px solid rgba(156, 163, 175, 0.2);
            padding: 0.75rem 1rem;
            text-align: left;
        }
        .theory-prose th {
            background-color: #f8fafc;
            font-weight: 700;
            color: #111827;
        }
        .dark .theory-prose th {
            background-color: #1e293b;
            color: #f9fafb;
        }
        .theory-prose td {
            color: #374151;
        }
        .dark .theory-prose td {
            color: #d1d5db;
        }
    </style>

    <div class="py-10 bg-gray-55 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Left Sidebar: Category Chapters Navigation -->
                <aside class="lg:col-span-3 space-y-6">
                    <div class="bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-850 rounded-3xl p-5 shadow-sm space-y-4">
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Learning Pathway</span>
                            <h3 class="text-lg font-bold font-outfit text-gray-900 dark:text-white">
                                {{ $categories[$activeCategory]['name'] }} Guides
                            </h3>
                        </div>

                        <!-- Chapters list -->
                        <nav class="space-y-1">
                            @foreach($categories[$activeCategory]['topics'] as $topicKey => $topicTitle)
                                <a href="{{ route('theory.topic', [$activeCategory, $topicKey]) }}"
                                   class="flex items-center space-x-2.5 px-3 py-2.5 rounded-xl text-xs font-bold transition-all
                                   {{ $activeTopic === $topicKey 
                                       ? 'bg-blue-600 text-white shadow-md shadow-blue-500/10' 
                                       : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $activeTopic === $topicKey ? 'bg-white' : 'bg-gray-300 dark:bg-gray-700' }}"></span>
                                    <span class="truncate">{{ $topicTitle }}</span>
                                </a>
                            @endforeach
                        </nav>

                        <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                            <a href="{{ route('theory.index') }}" class="inline-flex items-center space-x-1.5 text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">
                                <span>← Back to Pathways</span>
                            </a>
                        </div>
                    </div>
                </aside>

                <!-- Center Panel: The reading prose -->
                <main class="lg:col-span-6">
                    <div class="bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-850 rounded-3xl p-6 sm:p-8 shadow-sm">
                        <!-- Breadcrumbs -->
                        <div class="flex items-center space-x-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-6">
                            <a href="{{ route('theory.index') }}" class="hover:text-blue-550">Academy</a>
                            <span>/</span>
                            <a href="{{ route('theory.category', $activeCategory) }}" class="hover:text-blue-550">{{ $categories[$activeCategory]['name'] }}</a>
                            <span>/</span>
                            <span class="text-gray-600 dark:text-gray-350">{{ $topicTitle }}</span>
                        </div>

                        <!-- Parsed Content -->
                        <article class="theory-prose">
                            {!! $htmlContent !!}
                        </article>
                    </div>
                </main>

                <!-- Right Sidebar: Pathway togglers & Recommended Problems -->
                <aside class="lg:col-span-3 space-y-6">
                    <!-- Quick Switcher card -->
                    <div class="bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-850 rounded-3xl p-5 shadow-sm space-y-3">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Quick Switch Category</span>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach($categories as $key => $catData)
                                <a href="{{ route('theory.category', $key) }}"
                                   class="py-2 text-center rounded-xl text-[11px] font-bold border transition-colors
                                   {{ $activeCategory === $key
                                       ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 border-blue-200 dark:border-blue-800'
                                       : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                                    {{ $catData['name'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Recommended Problems map -->
                    <div class="bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-850 rounded-3xl p-5 shadow-sm space-y-4">
                        <div>
                            <span class="text-[10px] font-bold text-gray-450 uppercase tracking-wider">Recommended Practice</span>
                            <h3 class="text-sm font-bold font-outfit text-gray-900 dark:text-white">Apply Your Knowledge</h3>
                        </div>

                        @if($recommendedProblems->count() > 0)
                            <div class="space-y-3">
                                @foreach($recommendedProblems as $problem)
                                    <div class="p-3 border border-gray-105 dark:border-gray-800 rounded-2xl bg-gray-55 dark:bg-gray-950 flex flex-col justify-between space-y-2 hover:border-blue-200 dark:hover:border-blue-900/40 transition-colors">
                                        <div class="space-y-1">
                                            <a href="{{ route('problems.show', $problem->slug) }}" class="text-xs font-bold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 block truncate">
                                                {{ $problem->title }}
                                            </a>
                                            <div class="flex items-center space-x-2">
                                                @if($problem->difficulty === 'easy')
                                                    <span class="text-[9px] font-bold text-emerald-500 uppercase tracking-wide">Easy</span>
                                                @elseif($problem->difficulty === 'medium')
                                                    <span class="text-[9px] font-bold text-amber-500 uppercase tracking-wide">Medium</span>
                                                @else
                                                    <span class="text-[9px] font-bold text-rose-500 uppercase tracking-wide">Hard</span>
                                                @endif
                                                <span class="text-[9px] text-gray-400 font-semibold">&bull; {{ $problem->submissions()->count() }} submissions</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('problems.show', $problem->slug) }}" class="inline-flex items-center justify-center py-1.5 px-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold transition-colors">
                                            Solve Challenge →
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6">
                                <p class="text-xs text-gray-400">No practice problems mapped for this topic yet.</p>
                                <a href="{{ route('problems.index') }}" class="inline-block mt-3 text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">
                                    Browse All Problems
                                </a>
                            </div>
                        @endif
                    </div>
                </aside>

            </div>
        </div>
    </div>
</x-app-layout>
