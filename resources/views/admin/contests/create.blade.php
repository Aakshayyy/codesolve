<x-admin-layout>
    <div class="space-y-8" x-data="contestForm()">
        <div>
            <h2 class="text-2xl font-bold font-outfit text-gray-900 dark:text-white">Schedule New Contest</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Establish a timeline, specify guidelines, select algorithmic tasks, and distribute score values.</p>
        </div>

        <form action="{{ route('admin.contests.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Basic details -->
            <div class="bg-white dark:bg-gray-900 p-6 sm:p-8 rounded-3xl border border-gray-150 dark:border-gray-855 shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-gray-905 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-3 font-outfit">Contest Settings</h3>
                
                <div class="space-y-4">
                    <!-- Title -->
                    <div class="space-y-1.5">
                        <label for="title" class="text-xs font-bold text-gray-400 uppercase tracking-wider">Contest Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. CodeSolve Weekly Contest 1"
                               class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-200 dark:border-gray-800 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-905 dark:text-white" />
                        @error('title') <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Description -->
                    <div class="space-y-1.5">
                        <label for="description" class="text-xs font-bold text-gray-400 uppercase tracking-wider">Description</label>
                        <textarea id="description" name="description" rows="4" placeholder="Rules, instructions, and registration guidelines..."
                                  class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-200 dark:border-gray-800 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-905 dark:text-white">{{ old('description') }}</textarea>
                        @error('description') <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Start Time -->
                        <div class="space-y-1.5">
                            <label for="start_time" class="text-xs font-bold text-gray-400 uppercase tracking-wider">Start Time</label>
                            <input type="datetime-local" id="start_time" name="start_time" value="{{ old('start_time') }}" required
                                   class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-200 dark:border-gray-800 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-905 dark:text-white" />
                            @error('start_time') <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <!-- End Time -->
                        <div class="space-y-1.5">
                            <label for="end_time" class="text-xs font-bold text-gray-400 uppercase tracking-wider">End Time</label>
                            <input type="datetime-local" id="end_time" name="end_time" value="{{ old('end_time') }}" required
                                   class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-200 dark:border-gray-800 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-905 dark:text-white" />
                            @error('end_time') <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Problem association checklist -->
            <div class="bg-white dark:bg-gray-900 p-6 sm:p-8 rounded-3xl border border-gray-150 dark:border-gray-855 shadow-sm space-y-6">
                <div class="border-b border-gray-100 dark:border-gray-800 pb-3">
                    <h3 class="text-lg font-bold text-gray-905 dark:text-white font-outfit">Select Contest Problems</h3>
                    <p class="text-xs text-gray-450 mt-1">Check the problems you want to link to this contest, and specify their max score values.</p>
                </div>

                @error('problems')
                    <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                @enderror

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($problems as $problem)
                        <div class="p-4 border rounded-2xl transition-all duration-150 flex items-center justify-between gap-4"
                             :class="selectedProblems.includes({{ $problem->id }}) ? 'border-blue-200 dark:border-blue-900/40 bg-blue-50/20 dark:bg-blue-950/10' : 'border-gray-150 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-955/20'">
                            <div class="flex items-center space-x-3">
                                <input type="checkbox" name="problems[]" value="{{ $problem->id }}" id="prob_chk_{{ $problem->id }}"
                                       @change="toggleProblem({{ $problem->id }})"
                                       class="rounded border-gray-300 dark:border-gray-700 text-blue-600 focus:ring-blue-550" />
                                <label for="prob_chk_{{ $problem->id }}" class="cursor-pointer select-none">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white leading-tight">{{ $problem->title }}</div>
                                    <span class="text-[10px] uppercase font-bold text-gray-400">
                                        {{ $problem->difficulty }}
                                    </span>
                                </label>
                            </div>

                            <div class="flex items-center space-x-2 shrink-0">
                                <span class="text-xs text-gray-400">Points:</span>
                                <input type="number" name="points[{{ $problem->id }}]" value="100" min="1" required
                                       :disabled="!selectedProblems.includes({{ $problem->id }})"
                                       class="w-20 py-1 bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-xs font-mono text-center focus:ring-blue-500 text-gray-905 dark:text-white disabled:opacity-50" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit actions -->
            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl text-sm transition-colors shadow-lg shadow-blue-500/10">
                    Create Contest
                </button>
                <a href="{{ route('admin.contests.index') }}" class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold py-3 px-8 rounded-xl text-sm transition-colors flex items-center justify-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Alpine checklist managers -->
    <script>
        function contestForm() {
            return {
                selectedProblems: [],
                
                toggleProblem(id) {
                    const idx = this.selectedProblems.indexOf(id);
                    if (idx > -1) {
                        this.selectedProblems.splice(idx, 1);
                    } else {
                        this.selectedProblems.push(id);
                    }
                }
            }
        }
    </script>
</x-admin-layout>
