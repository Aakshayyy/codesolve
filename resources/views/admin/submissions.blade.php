<x-admin-layout>
    <div class="space-y-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold font-outfit text-gray-900 dark:text-white">System Submissions</h2>
                <p class="text-sm text-gray-550 dark:text-gray-400">View and inspect all compilation, run, and evaluation records across the platform.</p>
            </div>
        </div>

        <!-- Filter bar -->
        <div class="bg-white dark:bg-gray-900 p-5 rounded-3xl border border-gray-150 dark:border-gray-850 shadow-sm">
            <form action="{{ route('admin.submissions') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="space-y-1.5 w-full sm:w-48">
                    <label for="status" class="text-xs font-bold text-gray-400 uppercase tracking-wider">Status</label>
                    <select id="status" name="status" class="w-full py-2 bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-xs focus:ring-blue-500 text-gray-900 dark:text-white">
                        <option value="">All Statuses</option>
                        <option value="Accepted" {{ request('status') === 'Accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="Wrong Answer" {{ request('status') === 'Wrong Answer' ? 'selected' : '' }}>Wrong Answer</option>
                        <option value="Time Limit Exceeded" {{ request('status') === 'Time Limit Exceeded' ? 'selected' : '' }}>Time Limit Exceeded</option>
                        <option value="Runtime Error" {{ request('status') === 'Runtime Error' ? 'selected' : '' }}>Runtime Error</option>
                        <option value="Compile Error" {{ request('status') === 'Compile Error' ? 'selected' : '' }}>Compile Error</option>
                    </select>
                </div>

                <div class="space-y-1.5 w-full sm:w-48">
                    <label for="language" class="text-xs font-bold text-gray-400 uppercase tracking-wider">Language</label>
                    <select id="language" name="language" class="w-full py-2 bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-xs focus:ring-blue-500 text-gray-900 dark:text-white">
                        <option value="">All Languages</option>
                        <option value="cpp" {{ request('language') === 'cpp' ? 'selected' : '' }}>C++</option>
                        <option value="java" {{ request('language') === 'java' ? 'selected' : '' }}>Java</option>
                        <option value="python" {{ request('language') === 'python' ? 'selected' : '' }}>Python</option>
                        <option value="javascript" {{ request('language') === 'javascript' ? 'selected' : '' }}>JavaScript</option>
                    </select>
                </div>

                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit" class="flex-1 sm:flex-initial bg-blue-605 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded-xl text-xs transition-colors shadow-md">
                        Filter
                    </button>
                    <a href="{{ route('admin.submissions') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-bold flex items-center justify-center transition-colors">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Submissions table -->
        <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-150 dark:border-gray-850 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead>
                        <tr class="text-xs text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50">
                            <th class="py-3 px-6 font-semibold">User</th>
                            <th class="py-3 px-6 font-semibold">Problem</th>
                            <th class="py-3 px-6 font-semibold text-center">Language</th>
                            <th class="py-3 px-6 font-semibold text-center">Verdict</th>
                            <th class="py-3 px-6 font-semibold text-center">Runtime / Memory</th>
                            <th class="py-3 px-6 font-semibold text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-105 dark:divide-gray-800">
                        @forelse($submissions as $sub)
                            <tr class="hover:bg-gray-55 dark:hover:bg-gray-850/40 transition-colors">
                                <td class="py-4 px-6 font-bold text-gray-900 dark:text-white">
                                    {{ $sub->user->name ?? 'Deleted User' }}
                                </td>
                                <td class="py-4 px-6 text-gray-700 dark:text-gray-300 font-semibold">
                                    <a href="{{ route('problems.show', $sub->problem->slug) }}" class="hover:text-blue-500 transition-colors">
                                        {{ $sub->problem->title }}
                                    </a>
                                </td>
                                <td class="py-4 px-6 text-center font-mono text-xs uppercase">
                                    {{ $sub->language }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($sub->status === 'Accepted')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400">
                                            Accepted
                                        </span>
                                    @elseif($sub->status === 'Wrong Answer')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400">
                                            Wrong Answer
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400">
                                            {{ $sub->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center font-mono text-xs">
                                    {{ $sub->execution_time }} ms &bull; {{ round($sub->memory_used / 1024, 1) }} MB
                                </td>
                                <td class="py-4 px-6 text-right text-xs text-gray-400">
                                    {{ $sub->created_at->format('d M Y, H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-400">No submissions found matching filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $submissions->links() }}
    </div>
</x-admin-layout>
