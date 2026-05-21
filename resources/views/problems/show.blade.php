<x-app-layout>
    <div class="h-[calc(100vh-64px)] bg-gray-55/30 dark:bg-gray-950 flex flex-col overflow-hidden" x-data="workspace()">
        <!-- Top Workspace Bar -->
        <div class="bg-white dark:bg-gray-900 border-b border-gray-150 dark:border-gray-850 px-6 py-3 shrink-0 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('problems.index') }}" class="p-1.5 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-lg font-bold font-outfit text-gray-900 dark:text-white">{{ $problem->title }}</h1>
                @if($contestId)
                    <span class="bg-indigo-50 dark:bg-indigo-950/40 text-indigo-650 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/30 text-xs font-bold px-2.5 py-0.5 rounded-full">
                        Contest Mode
                    </span>
                @endif
            </div>
            <div class="flex items-center space-x-3">
                <label for="language-select" class="sr-only">Select Language</label>
                <select id="language-select" x-model="language" @change="changeLanguage()" class="bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 text-sm font-semibold rounded-xl px-3 py-1.5 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-gray-200">
                    <option value="cpp">C++</option>
                    <option value="java">Java</option>
                    <option value="python">Python</option>
                    <option value="javascript">JavaScript</option>
                </select>
            </div>
        </div>

        <!-- Main Workspace split -->
        <div class="flex-grow flex flex-col md:flex-row overflow-hidden">
            <!-- Left Pane: Problem Details & Comments -->
            <div class="w-full md:w-1/2 flex flex-col border-r border-gray-150 dark:border-gray-850 h-full overflow-hidden bg-white dark:bg-gray-900">
                <!-- Tab Triggers -->
                <div class="flex border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50 shrink-0">
                    <button @click="tab = 'description'" :class="tab === 'description' ? 'border-blue-600 text-blue-600 dark:border-blue-400 dark:text-blue-400 bg-white dark:bg-gray-900' : 'border-transparent text-gray-400 dark:text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="flex-1 py-3 px-4 text-center border-b-2 font-bold text-sm transition-all">
                        Description
                    </button>
                    <button @click="tab = 'discussion'" :class="tab === 'discussion' ? 'border-blue-600 text-blue-600 dark:border-blue-400 dark:text-blue-400 bg-white dark:bg-gray-900' : 'border-transparent text-gray-400 dark:text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="flex-1 py-3 px-4 text-center border-b-2 font-bold text-sm transition-all">
                        Discussion ({{ $problem->comments->count() }})
                    </button>
                </div>

                <!-- Tab Content Pane -->
                <div class="flex-grow overflow-y-auto p-6 space-y-6">
                    <!-- Description Tab -->
                    <div x-show="tab === 'description'" class="space-y-6">
                        <div class="flex items-center space-x-3">
                            @if($problem->difficulty === 'easy')
                                <span class="bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-xs font-extrabold uppercase tracking-wider px-3 py-1 rounded-full">Easy</span>
                            @elseif($problem->difficulty === 'medium')
                                <span class="bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 text-xs font-extrabold uppercase tracking-wider px-3 py-1 rounded-full">Medium</span>
                            @else
                                <span class="bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 text-xs font-extrabold uppercase tracking-wider px-3 py-1 rounded-full">Hard</span>
                            @endif
                            <span class="text-xs text-gray-400 font-semibold">Time Limit: {{ $problem->time_limit }}ms &bull; Memory Limit: {{ $problem->memory_limit }}MB</span>
                        </div>

                        <!-- Description Details -->
                        <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-350 text-sm leading-relaxed whitespace-pre-line font-sans">
                            {!! e($problem->description) !!}
                        </div>

                        @if($problem->input_format)
                            <div class="space-y-2">
                                <h3 class="text-sm font-extrabold text-gray-900 dark:text-white uppercase tracking-wider">Input Format</h3>
                                <p class="text-sm text-gray-650 dark:text-gray-400 whitespace-pre-line">{{ $problem->input_format }}</p>
                            </div>
                        @endif

                        @if($problem->output_format)
                            <div class="space-y-2">
                                <h3 class="text-sm font-extrabold text-gray-900 dark:text-white uppercase tracking-wider">Output Format</h3>
                                <p class="text-sm text-gray-650 dark:text-gray-400 whitespace-pre-line">{{ $problem->output_format }}</p>
                            </div>
                        @endif

                        @if($problem->constraints)
                            <div class="space-y-2">
                                <h3 class="text-sm font-extrabold text-gray-900 dark:text-white uppercase tracking-wider">Constraints</h3>
                                <code class="block bg-gray-50 dark:bg-gray-950 border border-gray-150 dark:border-gray-850 text-xs p-3 rounded-xl font-mono text-gray-800 dark:text-gray-300">
                                    {{ $problem->constraints }}
                                </code>
                            </div>
                        @endif

                        <!-- Sample Test Cases -->
                        <div class="space-y-4">
                            <h3 class="text-sm font-extrabold text-gray-900 dark:text-white uppercase tracking-wider">Sample Cases</h3>
                            @foreach($problem->testCases as $index => $tc)
                                <div class="space-y-2 border border-gray-150 dark:border-gray-850 rounded-2xl p-4 bg-gray-50/50 dark:bg-gray-900/35">
                                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wide">Sample Case #{{ $index + 1 }}</div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-[10px] font-bold text-gray-400 uppercase mb-1">Input</div>
                                            <pre class="bg-white dark:bg-gray-950 border border-gray-150 dark:border-gray-850 p-2.5 rounded-xl font-mono text-xs text-gray-800 dark:text-gray-350 overflow-x-auto whitespace-pre">{{ $tc->input }}</pre>
                                        </div>
                                        <div>
                                            <div class="text-[10px] font-bold text-gray-400 uppercase mb-1">Expected Output</div>
                                            <pre class="bg-white dark:bg-gray-950 border border-gray-150 dark:border-gray-850 p-2.5 rounded-xl font-mono text-xs text-gray-800 dark:text-gray-350 overflow-x-auto whitespace-pre">{{ $tc->expected_output }}</pre>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Discussion / Comments Tab -->
                    <div x-show="tab === 'discussion'" class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Discussion</h3>

                        @auth
                            <!-- Comment box -->
                            <form action="{{ route('comments.store', $problem->slug) }}" method="POST" class="space-y-3">
                                @csrf
                                <textarea name="body" rows="3" placeholder="Join the discussion... write a comment or ask a question" required
                                          class="w-full border border-gray-200 dark:border-gray-800 rounded-xl p-3 bg-gray-50 dark:bg-gray-950 text-sm text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500"></textarea>
                                <button type="submit" class="bg-blue-650 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-xl text-sm transition-colors shadow-md">
                                    Post Comment
                                </button>
                            </form>
                        @else
                            <div class="p-4 bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/20 rounded-2xl text-center">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">You must be logged in to participate in the discussion.</p>
                                <a href="{{ route('login') }}" class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:underline">Log in or Register</a>
                            </div>
                        @endauth

                        <!-- Comments Tree -->
                        <div class="space-y-6 pt-4">
                            @php
                                $rootComments = $problem->comments->whereNull('parent_id');
                            @endphp

                            @forelse($rootComments as $comment)
                                <div class="border-l-2 border-gray-100 dark:border-gray-850 pl-4 space-y-4" x-data="{ replying: false }">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center space-x-3">
                                            @if($comment->user->profile_picture)
                                                <img src="{{ asset('storage/' . $comment->user->profile_picture) }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-xs uppercase">
                                                    {{ substr($comment->user->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <span class="text-xs font-bold text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                                <span class="text-[10px] text-gray-400">&bull; {{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>

                                        <!-- Delete action -->
                                        @if(Auth::check() && (Auth::id() === $comment->user_id || Auth::user()->isAdmin()))
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Delete this comment?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-rose-500 hover:underline">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-750 dark:text-gray-350 leading-relaxed">{{ $comment->body }}</p>

                                    <!-- Upvote & Reply buttons -->
                                    <div class="flex items-center space-x-4">
                                        <!-- Upvote Form -->
                                        @auth
                                            <button @click="upvoteComment({{ $comment->id }}, $el)" class="flex items-center space-x-1.5 text-xs font-semibold text-gray-400 hover:text-blue-550 transition-colors">
                                                <span>▲</span>
                                                <span>{{ $comment->upvotes()->count() }} Upvote(s)</span>
                                            </button>
                                            <button @click="replying = !replying" class="text-xs font-semibold text-gray-400 hover:text-blue-550 transition-colors">
                                                Reply
                                            </button>
                                        @else
                                            <span class="text-xs text-gray-400">▲ {{ $comment->upvotes()->count() }} Upvote(s)</span>
                                        @endauth
                                    </div>

                                    <!-- Reply Submit Box -->
                                    <div x-show="replying" class="pt-2">
                                        <form action="{{ route('comments.store', $problem->slug) }}" method="POST" class="space-y-3">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                            <textarea name="body" rows="2" placeholder="Write a reply..." required
                                                      class="w-full border border-gray-200 dark:border-gray-800 rounded-xl p-3 bg-gray-50 dark:bg-gray-950 text-sm text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500"></textarea>
                                            <div class="flex gap-2">
                                                <button type="submit" class="bg-blue-650 hover:bg-blue-700 text-white font-bold px-3.5 py-1.5 rounded-lg text-xs transition-colors shadow-md">
                                                    Submit Reply
                                                </button>
                                                <button type="button" @click="replying = false" class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-bold px-3.5 py-1.5 rounded-lg text-xs hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Nested Replies -->
                                    <div class="pl-6 space-y-4 pt-2 border-l border-gray-100 dark:border-gray-800">
                                        @foreach($comment->replies as $reply)
                                            <div class="space-y-2">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex items-center space-x-2">
                                                        @if($reply->user->profile_picture)
                                                            <img src="{{ asset('storage/' . $reply->user->profile_picture) }}" alt="Avatar" class="w-6 h-6 rounded-full object-cover">
                                                        @else
                                                            <div class="w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-[9px] uppercase">
                                                                {{ substr($reply->user->name, 0, 1) }}
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <span class="text-xs font-bold text-gray-900 dark:text-white">{{ $reply->user->name }}</span>
                                                            <span class="text-[9px] text-gray-400">&bull; {{ $reply->created_at->diffForHumans() }}</span>
                                                        </div>
                                                    </div>

                                                    @if(Auth::check() && (Auth::id() === $reply->user_id || Auth::user()->isAdmin()))
                                                        <form action="{{ route('comments.destroy', $reply->id) }}" method="POST" onsubmit="return confirm('Delete this reply?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-[10px] text-rose-500 hover:underline">Delete</button>
                                                        </form>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-gray-700 dark:text-gray-350 leading-relaxed">{{ $reply->body }}</p>
                                                
                                                <!-- Reply Upvotes -->
                                                @auth
                                                    <button @click="upvoteComment({{ $reply->id }}, $el)" class="flex items-center space-x-1.5 text-[10px] font-semibold text-gray-400 hover:text-blue-550 transition-colors">
                                                        <span>▲</span>
                                                        <span>{{ $reply->upvotes()->count() }} Upvote(s)</span>
                                                    </button>
                                                @else
                                                    <span class="text-[10px] text-gray-400">▲ {{ $reply->upvotes()->count() }} Upvote(s)</span>
                                                @endauth
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <p class="text-center py-8 text-sm text-gray-400">No discussions yet. Be the first to ask a question!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Pane: Code Editor Workspace -->
            <div class="w-full md:w-1/2 flex flex-col h-full overflow-hidden" :class="darkMode ? 'bg-gray-900' : 'bg-gray-50'">
                <!-- Monaco Editor container -->
                <div class="flex-grow relative h-0">
                    <div id="editor-container" class="absolute inset-0 w-full h-full"></div>
                </div>

                <!-- Action Bar & Results Drawer -->
                <div class="shrink-0 flex flex-col border-t transition-colors duration-200" :class="darkMode ? 'bg-[#1e1e1e] border-gray-800' : 'bg-white border-gray-200'">
                    <!-- Drawer Header / Custom Input Selection -->
                    <div class="px-4 py-2 border-b flex items-center justify-between" :class="darkMode ? 'border-gray-800' : 'border-gray-200'">
                        <label class="flex items-center space-x-2 text-xs font-bold text-gray-400 cursor-pointer">
                            <input type="checkbox" x-model="useCustomInput" class="rounded border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-blue-500 focus:ring-blue-500" />
                            <span>Use Custom Input</span>
                        </label>
                        <div class="flex space-x-2">
                            <template x-if="verdictStatus">
                                <span class="text-xs font-bold font-mono px-2 py-0.5 rounded-md" :class="verdictColor">
                                    Verdict: <span x-text="verdictStatus"></span>
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- Custom Input text box -->
                    <div x-show="useCustomInput" class="p-4" x-transition>
                        <label for="custom-input-box" class="sr-only">Custom Input Data</label>
                        <textarea id="custom-input-box" x-model="customInput" placeholder="Stdin input data here..." rows="3"
                                  class="w-full rounded-xl p-3 text-xs font-mono focus:ring-blue-500"
                                  :class="darkMode ? 'bg-[#151515] border-gray-800 text-gray-300' : 'bg-white border-gray-200 text-gray-800'"></textarea>
                    </div>

                    <!-- Output console -->
                    <div x-show="consoleOpen" class="max-h-60 overflow-y-auto p-4 space-y-3 font-mono text-xs border-b select-text"
                         :class="darkMode ? 'bg-[#151515] border-gray-805 text-gray-300' : 'bg-white border-gray-200 text-gray-800'">
                        <div class="flex items-center justify-between border-b pb-2" :class="darkMode ? 'border-gray-800' : 'border-gray-200'">
                            <span class="font-bold text-gray-400">Console Log / Results</span>
                            <button @click="consoleOpen = false" class="text-gray-500 hover:text-gray-300 dark:hover:text-white">Close</button>
                        </div>

                        <!-- Pending status spinner -->
                        <template x-if="executing">
                            <div class="flex items-center space-x-2.5 py-4">
                                <svg class="animate-spin h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span>Running/compiling your code against test cases...</span>
                            </div>
                        </template>

                        <!-- Final execution details -->
                        <template x-if="!executing && consoleOutput">
                            <div class="space-y-3">
                                <div>
                                    <span class="text-gray-400">Verdict:</span>
                                    <span class="font-bold font-mono px-2 py-0.5 rounded-md" :class="verdictColor" x-text="verdictStatus"></span>
                                    <span class="text-gray-500 ml-2" x-text="executionTime ? `(${executionTime} ms)` : ''"></span>
                                </div>
                                <template x-if="compileOutput">
                                    <div class="space-y-1 bg-red-950/20 border border-red-900/30 p-3 rounded-xl">
                                        <div class="font-bold text-rose-500">Compilation Logs / Stderr:</div>
                                        <pre class="whitespace-pre-wrap overflow-x-auto text-[11px] text-rose-300" x-text="compileOutput"></pre>
                                    </div>
                                </template>
                                <template x-if="!compileOutput">
                                    <div class="space-y-2">
                                        <div>
                                            <div class="text-[10px] font-bold text-gray-450 uppercase mb-1">Standard Output:</div>
                                            <pre class="border p-2.5 rounded-xl whitespace-pre-wrap overflow-x-auto text-gray-800"
                                                 :class="darkMode ? 'bg-gray-950 border-gray-800 text-gray-200' : 'bg-gray-50 border-gray-200 text-gray-800'" x-text="consoleOutput"></pre>
                                        </div>
                                        <template x-if="expectedOutput">
                                            <div>
                                                <div class="text-[10px] font-bold text-gray-450 uppercase mb-1">Expected Output:</div>
                                                <pre class="border p-2.5 rounded-xl whitespace-pre-wrap overflow-x-auto text-gray-450"
                                                     :class="darkMode ? 'bg-gray-950 border-gray-800 text-gray-400' : 'bg-gray-50 border-gray-200 text-gray-600'" x-text="expectedOutput"></pre>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>

                    <!-- Bottom Buttons row -->
                    <div class="px-6 py-4 flex items-center justify-between transition-colors duration-200" :class="darkMode ? 'bg-[#1e1e1e]' : 'bg-gray-50'">
                        <div>
                            <button @click="consoleOpen = !consoleOpen" class="text-xs font-semibold px-3 py-2 rounded-xl transition-colors border"
                                    :class="darkMode ? 'text-gray-400 hover:text-white bg-gray-800 border-gray-700' : 'text-gray-600 hover:text-gray-900 bg-white border-gray-200'">
                                Toggle Console
                            </button>
                        </div>
                        <div class="flex space-x-3">
                            @auth
                                <button @click="runCode()" :disabled="executing" class="font-bold px-5 py-2.5 rounded-xl text-sm transition-colors border disabled:opacity-50"
                                        :class="darkMode ? 'bg-gray-800 hover:bg-gray-700 text-white border-gray-700' : 'bg-white hover:bg-gray-100 text-gray-750 border-gray-300'">
                                    Run Code
                                </button>
                                <button @click="submitCode()" :disabled="executing" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl text-sm transition-colors shadow-lg shadow-blue-500/10 disabled:opacity-50">
                                    Submit Solution
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="bg-blue-650 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl text-sm transition-all shadow-md">
                                    Log in to Code
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monaco Editor Loader & Custom workspace JS script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.39.0/min/vs/loader.min.js"></script>
    <script>
        function workspace() {
            return {
                tab: 'description',
                language: 'cpp',
                useCustomInput: false,
                customInput: '',
                consoleOpen: false,
                executing: false,
                consoleOutput: '',
                expectedOutput: '',
                compileOutput: '',
                verdictStatus: '',
                verdictColor: 'bg-gray-800 text-gray-400',
                defaultTemplates: @json($defaultCodes),

                init() {
                    // Monaco Loading
                    require.config({ paths: { vs: 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.39.0/min/vs' } });
                    require(['vs/editor/editor.main'], () => {
                        window.editor = monaco.editor.create(document.getElementById('editor-container'), {
                            value: this.defaultTemplates[this.language],
                            language: 'cpp',
                            theme: this.darkMode ? 'vs-dark' : 'vs',
                            automaticLayout: true,
                            minimap: { enabled: false },
                            fontSize: 14,
                            lineHeight: 22,
                            padding: { top: 12 },
                            fontFamily: 'Fira Code, Cascadia Code, JetBrains Mono, Courier New, monospace',
                            quickSuggestions: {
                                other: true,
                                comments: true,
                                strings: true
                            },
                            suggestOnTriggerCharacters: true,
                            parameterHints: {
                                enabled: true
                            },
                            snippetSuggestions: 'inline',
                            wordBasedSuggestions: 'allDocuments',
                            tabCompletion: 'on'
                        });

                        // Watch dark mode to update Monaco theme dynamically
                        this.$watch('darkMode', val => {
                            if (window.editor) {
                                monaco.editor.setTheme(val ? 'vs-dark' : 'vs');
                            }
                        });
                    });
                },

                changeLanguage() {
                    if (window.editor) {
                        const codeVal = window.editor.getValue();
                        // If editor has default contents of some language, replace it with new language template
                        const languages = ['cpp', 'java', 'python', 'javascript'];
                        let isDefault = false;
                        for (let lang of languages) {
                            if (codeVal.trim() === this.defaultTemplates[lang].trim()) {
                                isDefault = true;
                                break;
                            }
                        }
                        
                        if (isDefault || codeVal.trim() === '') {
                            window.editor.setValue(this.defaultTemplates[this.language]);
                        }

                        // Map select value to Monaco models
                        let modelLang = this.language;
                        if (this.language === 'cpp') modelLang = 'cpp';
                        if (this.language === 'java') modelLang = 'java';
                        if (this.language === 'python') modelLang = 'python';
                        if (this.language === 'javascript') modelLang = 'javascript';

                        const model = window.editor.getModel();
                        monaco.editor.setModelLanguage(model, modelLang);
                    }
                },

                runCode() {
                    if (!window.editor) return;
                    this.executing = true;
                    this.consoleOpen = true;
                    this.consoleOutput = '';
                    this.compileOutput = '';
                    this.expectedOutput = '';
                    this.verdictStatus = 'Pending';
                    this.verdictColor = 'bg-gray-800 text-gray-400';

                    const codeVal = window.editor.getValue();
                    
                    fetch("{{ route('problems.run', $problem->slug) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            language: this.language,
                            code: codeVal,
                            input: this.useCustomInput ? this.customInput : @json($problem->testCases->first() ? $problem->testCases->first()->input : '')
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.executing = false;
                        this.executionTime = data.execution_time;

                        if (data.status === 'Compile Error') {
                            this.compileOutput = data.stderr || 'Compiler error occurred.';
                            this.verdictStatus = 'Compilation Error';
                            this.verdictColor = 'bg-red-500/10 text-red-500';
                            this.consoleOutput = 'Code failed to compile.';
                        } else if (data.status === 'Runtime Error') {
                            this.compileOutput = data.stderr || 'Runtime exception thrown.';
                            this.verdictStatus = 'Runtime Error';
                            this.verdictColor = 'bg-rose-500/10 text-rose-500';
                            this.consoleOutput = 'Execution threw a runtime error.';
                        } else if (data.status === 'Time Limit Exceeded') {
                            this.verdictStatus = 'Time Limit Exceeded';
                            this.verdictColor = 'bg-amber-500/10 text-amber-500';
                            this.consoleOutput = 'Code exceeded time limits.';
                        } else {
                            this.consoleOutput = data.stdout || '(Empty Output)';
                            this.expectedOutput = data.expected_output || '';
                            
                            if (data.status === 'Success') {
                                if (this.useCustomInput) {
                                    this.verdictStatus = 'Success';
                                    this.verdictColor = 'bg-emerald-500/10 text-emerald-500';
                                } else {
                                    const actual = (data.stdout || '').trim();
                                    const expected = (data.expected_output || '').trim();
                                    if (actual === expected) {
                                        this.verdictStatus = 'Success';
                                        this.verdictColor = 'bg-emerald-500/10 text-emerald-500';
                                    } else {
                                        this.verdictStatus = 'Wrong Answer';
                                        this.verdictColor = 'bg-rose-500/10 text-rose-500';
                                    }
                                }
                            } else {
                                this.verdictStatus = data.status || 'Wrong Answer';
                                this.verdictColor = 'bg-rose-500/10 text-rose-500';
                            }
                        }
                    })
                    .catch(err => {
                        this.executing = false;
                        this.verdictStatus = 'Server Error';
                        this.verdictColor = 'bg-red-500/10 text-red-500';
                        this.consoleOutput = 'Failed to execute network request.';
                    });
                },

                submitCode() {
                    if (!window.editor) return;
                    this.executing = true;
                    this.consoleOpen = true;
                    this.consoleOutput = '';
                    this.compileOutput = '';
                    this.expectedOutput = '';
                    this.verdictStatus = 'Grading';
                    this.verdictColor = 'bg-gray-800 text-gray-400';

                    const codeVal = window.editor.getValue();

                    fetch("{{ route('problems.submit', $problem->slug) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            language: this.language,
                            code: codeVal,
                            contest_id: "{{ $contestId ?? '' }}"
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.executing = false;
                        this.verdictStatus = data.status;
                        this.executionTime = data.execution_time;

                        if (data.status === 'Accepted') {
                            this.verdictColor = 'bg-emerald-55/10 text-emerald-500';
                            this.consoleOutput = 'All test cases passed! Points awarded.';
                        } else {
                            this.verdictColor = 'bg-rose-55/10 text-rose-500';
                            if (data.status === 'Compile Error') {
                                this.compileOutput = data.stderr || 'Compiler error occurred.';
                                this.consoleOutput = 'Code failed to compile during submission.';
                            } else if (data.status === 'Runtime Error') {
                                this.compileOutput = data.stderr || 'Runtime exception thrown.';
                                this.consoleOutput = 'Execution threw a runtime error during submission.';
                            } else {
                                this.consoleOutput = `Verdict details: ${data.status}. Run code to view standard output or check stderr logs.`;
                            }
                        }
                    })
                    .catch(err => {
                        this.executing = false;
                        this.verdictStatus = 'Server Error';
                        this.verdictColor = 'bg-red-55/10 text-red-500';
                        this.consoleOutput = 'Failed to submit code for grading.';
                    });
                },

                upvoteComment(id, element) {
                    fetch(`/comments/${id}/upvote`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Quick view update
                            const span = element.querySelector('span:last-child');
                            if (span) {
                                span.innerText = `${data.count} Upvote(s)`;
                            }
                        }
                    });
                }
            }
        }
    </script>
</x-app-layout>
