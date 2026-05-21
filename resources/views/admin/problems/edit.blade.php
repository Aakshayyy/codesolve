<x-admin-layout>
    <div class="space-y-8" x-data="problemForm()">
        <div>
            <h2 class="text-2xl font-bold font-outfit text-gray-900 dark:text-white">Edit Problem: {{ $problem->title }}</h2>
            <p class="text-sm text-gray-555 dark:text-gray-405">Update statements, constraints, categories, or grading test cases.</p>
        </div>

        <form action="{{ route('admin.problems.update', $problem->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Card 1: Description and Details -->
            <div class="bg-white dark:bg-gray-900 p-6 sm:p-8 rounded-3xl border border-gray-150 dark:border-gray-855 shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-gray-905 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-3">Basic Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2 space-y-1.5">
                        <label for="title" class="text-xs font-bold text-gray-400 uppercase tracking-wider">Problem Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $problem->title) }}" required placeholder="e.g. Two Sum"
                               class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-200 dark:border-gray-800 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-905 dark:text-white" />
                        @error('title') <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Difficulty -->
                    <div class="space-y-1.5">
                        <label for="difficulty" class="text-xs font-bold text-gray-400 uppercase tracking-wider">Difficulty</label>
                        <select id="difficulty" name="difficulty" required class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-200 dark:border-gray-800 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-905 dark:text-white">
                            <option value="easy" {{ old('difficulty', $problem->difficulty) === 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ old('difficulty', $problem->difficulty) === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="hard" {{ old('difficulty', $problem->difficulty) === 'hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                        @error('difficulty') <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Description Text -->
                <div class="space-y-1.5">
                    <label for="description" class="text-xs font-bold text-gray-400 uppercase tracking-wider">Description (Markdown / Text)</label>
                    <textarea id="description" name="description" rows="8" required placeholder="Write clear problem statement instructions here..."
                              class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-200 dark:border-gray-800 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-905 dark:text-white">{{ old('description', $problem->description) }}</textarea>
                    @error('description') <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Card 2: Input / Output Format and Constraints -->
            <div class="bg-white dark:bg-gray-900 p-6 sm:p-8 rounded-3xl border border-gray-150 dark:border-gray-855 shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-gray-905 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-3">Input/Output Details & Constraints</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Input Format -->
                    <div class="space-y-1.5">
                        <label for="input_format" class="text-xs font-bold text-gray-400 uppercase tracking-wider">Input Format</label>
                        <textarea id="input_format" name="input_format" rows="3" placeholder="Describe the variables and input lines..."
                                  class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-200 dark:border-gray-800 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-905 dark:text-white">{{ old('input_format', $problem->input_format) }}</textarea>
                    </div>

                    <!-- Output Format -->
                    <div class="space-y-1.5">
                        <label for="output_format" class="text-xs font-bold text-gray-400 uppercase tracking-wider">Output Format</label>
                        <textarea id="output_format" name="output_format" rows="3" placeholder="Describe expected output formatting..."
                                  class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-200 dark:border-gray-800 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-905 dark:text-white">{{ old('output_format', $problem->output_format) }}</textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Constraints -->
                    <div class="md:col-span-1 space-y-1.5">
                        <label for="constraints" class="text-xs font-bold text-gray-400 uppercase tracking-wider">Constraints</label>
                        <input type="text" id="constraints" name="constraints" value="{{ old('constraints', $problem->constraints) }}" placeholder="e.g. 1 <= N <= 10^5"
                               class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-200 dark:border-gray-800 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-905 dark:text-white" />
                    </div>

                    <!-- Time Limit -->
                    <div class="space-y-1.5">
                        <label for="time_limit" class="text-xs font-bold text-gray-400 uppercase tracking-wider">Time Limit (ms)</label>
                        <input type="number" id="time_limit" name="time_limit" value="{{ old('time_limit', $problem->time_limit) }}" required min="100" max="10000"
                               class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-200 dark:border-gray-800 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-905 dark:text-white" />
                        @error('time_limit') <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Memory Limit -->
                    <div class="space-y-1.5">
                        <label for="memory_limit" class="text-xs font-bold text-gray-400 uppercase tracking-wider">Memory Limit (MB)</label>
                        <input type="number" id="memory_limit" name="memory_limit" value="{{ old('memory_limit', $problem->memory_limit) }}" required min="16" max="1024"
                               class="w-full bg-gray-50 dark:bg-gray-955 border border-gray-200 dark:border-gray-800 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-905 dark:text-white" />
                        @error('memory_limit') <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Card 3: Tags Checkboxes -->
            <div class="bg-white dark:bg-gray-900 p-6 sm:p-8 rounded-3xl border border-gray-150 dark:border-gray-855 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 dark:border-gray-800 pb-2">Select Tags / Categories</h3>
                <div class="flex flex-wrap gap-4">
                    @php
                        $selectedTags = old('tags', $problem->tags->pluck('id')->toArray());
                    @endphp
                    @foreach($tags as $tag)
                        <label class="inline-flex items-center space-x-2 bg-gray-50 dark:bg-gray-955 px-3 py-2 border border-gray-200 dark:border-gray-800 rounded-xl cursor-pointer select-none">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-blue-600 focus:ring-blue-550" />
                            <span class="text-xs font-bold text-gray-750 dark:text-gray-300">{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Card 4: Grading Test Cases (Dynamic Alpine List) -->
            <div class="bg-white dark:bg-gray-900 p-6 sm:p-8 rounded-3xl border border-gray-150 dark:border-gray-855 shadow-sm space-y-6">
                <div class="flex justify-between items-center border-b border-gray-100 dark:border-gray-800 pb-3">
                    <h3 class="text-lg font-bold text-gray-905 dark:text-white">Grading Test Cases</h3>
                    <button type="button" @click="addTestCase()" class="bg-indigo-50 dark:bg-indigo-950/40 text-indigo-650 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/30 font-bold px-3 py-1.5 rounded-xl text-xs transition-colors hover:bg-indigo-100 dark:hover:bg-indigo-900/60">
                        + Add Case
                    </button>
                </div>

                @error('test_cases')
                    <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                @enderror

                <div class="space-y-4">
                    <template x-for="(tc, index) in testCases" :key="index">
                        <div class="p-4 border border-gray-150 dark:border-gray-800 rounded-2xl bg-gray-50/50 dark:bg-gray-955/20 space-y-4 relative">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide" x-text="`Test Case #${index + 1}`"></span>
                                <button type="button" @click="removeTestCase(index)" x-show="testCases.length > 1" class="text-xs font-bold text-rose-500 hover:underline">
                                    Remove Case
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Input -->
                                <div class="space-y-1.5">
                                    <label :for="`tc_input_${index}`" class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Input Data (Stdin)</label>
                                    <textarea :id="`tc_input_${index}`" :name="`test_cases[${index}][input]`" x-model="tc.input" rows="2" placeholder="e.g. 2\n3 5"
                                              class="w-full bg-white dark:bg-gray-955 border border-gray-200 dark:border-gray-800 rounded-xl text-xs font-mono focus:ring-blue-500 focus:border-blue-500 text-gray-905 dark:text-white"></textarea>
                                </div>

                                <!-- Output -->
                                <div class="space-y-1.5">
                                    <label :for="`tc_output_${index}`" class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Expected Output (Stdout)</label>
                                    <textarea :id="`tc_output_${index}`" :name="`test_cases[${index}][expected_output]`" x-model="tc.expected_output" required rows="2" placeholder="e.g. 8"
                                              class="w-full bg-white dark:bg-gray-955 border border-gray-200 dark:border-gray-800 rounded-xl text-xs font-mono focus:ring-blue-500 focus:border-blue-500 text-gray-905 dark:text-white"></textarea>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 pt-2 border-t border-gray-100 dark:border-gray-800">
                                <input type="checkbox" :id="`tc_hidden_${index}`" :name="`test_cases[${index}][is_hidden]`" value="1" x-model="tc.is_hidden"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-550" />
                                <label :for="`tc_hidden_${index}`" class="text-xs font-semibold text-gray-650 dark:text-gray-400">Is Hidden (Check to hide from users during coding sessions)</label>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Submit buttons -->
            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl text-sm transition-colors shadow-lg shadow-blue-500/10">
                    Update Problem
                </button>
                <a href="{{ route('admin.problems.index') }}" class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold py-3 px-8 rounded-xl text-sm transition-colors flex items-center justify-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Alpine dynamic form controllers -->
    <script>
        function problemForm() {
            return {
                testCases: @json(old('test_cases', $problem->testCases->map(function($tc) {
                    return [
                        'input' => $tc->input,
                        'expected_output' => $tc->expected_output,
                        'is_hidden' => (bool)$tc->is_hidden
                    ];
                })->toArray())),
                
                addTestCase() {
                    this.testCases.push({
                        input: '',
                        expected_output: '',
                        is_hidden: false
                    });
                },
                
                removeTestCase(index) {
                    if (this.testCases.length > 1) {
                        this.testCases.splice(index, 1);
                    }
                }
            }
        }
    </script>
</x-admin-layout>
