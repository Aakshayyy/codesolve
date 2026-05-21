<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight font-outfit">
            {{ __('CodeSolve Theory Academy') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-55 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <!-- Hero banner -->
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 rounded-3xl p-8 sm:p-12 text-white shadow-xl">
                <!-- Background shapes -->
                <div class="absolute -right-10 -bottom-10 w-60 h-60 rounded-full bg-white/10 blur-2xl"></div>
                <div class="absolute right-1/3 -top-10 w-40 h-40 rounded-full bg-white/10 blur-2xl"></div>
                
                <div class="relative z-10 max-w-2xl space-y-4">
                    <span class="inline-block px-3 py-1 rounded-full bg-white/20 text-xs font-bold uppercase tracking-wider">
                        📚 Conceptual Learning
                    </span>
                    <h1 class="text-3xl sm:text-5xl font-extrabold font-outfit tracking-tight">
                        Learn Theory. <br>Practice Instantly.
                    </h1>
                    <p class="text-sm sm:text-base text-blue-100 leading-relaxed max-w-lg">
                        Bridge the gap between coding concepts and execution. Select a path below to access GeeksforGeeks-style interactive tutorials mapped directly to our live problem catalog.
                    </p>
                </div>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($categories as $key => $cat)
                    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-150 dark:border-gray-850 shadow-sm p-6 sm:p-8 flex flex-col justify-between hover:shadow-md transition-shadow relative overflow-hidden group">
                        <!-- Top Accent Bar -->
                        <div class="absolute top-0 left-0 right-0 h-1.5 
                            @if($key === 'cpp') bg-blue-555 @elseif($key === 'java') bg-amber-500 @else bg-indigo-500 @endif">
                        </div>

                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-lg text-white shadow-md
                                    @if($key === 'cpp') bg-blue-600 shadow-blue-500/10 @elseif($key === 'java') bg-amber-600 shadow-amber-500/10 @else bg-indigo-600 shadow-indigo-500/10 @endif">
                                    {{ $cat['icon'] }}
                                </div>
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    {{ count($cat['topics']) }} Topics
                                </span>
                            </div>

                            <div class="space-y-2">
                                <h3 class="text-xl font-bold font-outfit text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $cat['name'] }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                                    {{ $cat['description'] }}
                                </p>
                            </div>

                            <!-- List preview of topics -->
                            <ul class="space-y-2.5 pt-2">
                                @foreach(array_slice($cat['topics'], 0, 4, true) as $tKey => $tTitle)
                                    <li class="flex items-center space-x-2 text-xs font-semibold text-gray-600 dark:text-gray-455">
                                        <span class="w-1.5 h-1.5 rounded-full 
                                            @if($key === 'cpp') bg-blue-500 @elseif($key === 'java') bg-amber-500 @else bg-indigo-500 @endif"></span>
                                        <span class="truncate">{{ $tTitle }}</span>
                                    </li>
                                @endforeach
                                @if(count($cat['topics']) > 4)
                                    <li class="text-[11px] font-bold text-gray-400 pl-3.5 italic">
                                        + {{ count($cat['topics']) - 4 }} more topics
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <div class="pt-8">
                            <a href="{{ route('theory.category', $key) }}" 
                               class="w-full inline-flex items-center justify-center px-5 py-3 rounded-xl font-bold text-sm transition-all duration-200 border
                               @if($key === 'cpp') bg-blue-50 dark:bg-blue-900/10 border-blue-100 dark:border-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white
                               @elseif($key === 'java') bg-amber-50 dark:bg-amber-900/10 border-amber-100 dark:border-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-600 hover:text-white
                               @else bg-indigo-50 dark:bg-indigo-900/10 border-indigo-100 dark:border-indigo-900/30 text-indigo-650 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white @endif">
                                Start Learning
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- FAQ/Guides section -->
            <div class="bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-850 rounded-3xl p-6 sm:p-8 space-y-6">
                <h3 class="text-lg font-bold font-outfit text-gray-900 dark:text-white">Why Learn Theory on CodeSolve?</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2 p-4 bg-gray-55 dark:bg-gray-950 rounded-2xl border border-gray-100 dark:border-gray-800">
                        <div class="text-lg">🎯</div>
                        <h4 class="font-bold text-sm text-gray-900 dark:text-white">Directly Mapped Problems</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Every single chapter features recommended practice challenges. Apply what you just read inside the sandbox immediately.
                        </p>
                    </div>
                    <div class="space-y-2 p-4 bg-gray-55 dark:bg-gray-950 rounded-2xl border border-gray-100 dark:border-gray-800">
                        <div class="text-lg">💡</div>
                        <h4 class="font-bold text-sm text-gray-900 dark:text-white">Interview Centric Guides</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Our concepts are filtered for quick review, covering typical technical round topics, complexities, and optimizations.
                        </p>
                    </div>
                    <div class="space-y-2 p-4 bg-gray-55 dark:bg-gray-950 rounded-2xl border border-gray-100 dark:border-gray-800">
                        <div class="text-lg">🛠</div>
                        <h4 class="font-bold text-sm text-gray-900 dark:text-white">Syntax Showcases</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Interactive code snippets demonstrate key templates, helper API structures, and optimal patterns in C++, Java, and DSA.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
