<x-admin-layout>
    <div class="space-y-8">
        <div>
            <h2 class="text-2xl font-bold font-outfit text-gray-900 dark:text-white">Admin Dashboard Overview</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">System health, problems breakdown, and real-time user statistics.</p>
        </div>

        <!-- Metrics cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-900 p-6 rounded-3xl border border-gray-150 dark:border-gray-850 shadow-sm">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Total Members</span>
                <span class="text-3xl font-extrabold font-outfit text-gray-900 dark:text-white mt-1 block">{{ $totalUsers }}</span>
            </div>
            <div class="bg-white dark:bg-gray-900 p-6 rounded-3xl border border-gray-150 dark:border-gray-850 shadow-sm">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Coding Problems</span>
                <span class="text-3xl font-extrabold font-outfit text-gray-900 dark:text-white mt-1 block">{{ $totalProblems }}</span>
            </div>
            <div class="bg-white dark:bg-gray-900 p-6 rounded-3xl border border-gray-150 dark:border-gray-850 shadow-sm">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Submissions</span>
                <span class="text-3xl font-extrabold font-outfit text-gray-900 dark:text-white mt-1 block">{{ $totalSubmissions }}</span>
            </div>
            <div class="bg-white dark:bg-gray-900 p-6 rounded-3xl border border-gray-150 dark:border-gray-850 shadow-sm">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Acceptance Rate</span>
                <span class="text-3xl font-extrabold font-outfit text-emerald-500 mt-1 block">{{ $successRate }}%</span>
            </div>
        </div>

        <!-- Problem Difficulty breakdown -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-3xl border border-gray-150 dark:border-gray-850 shadow-sm space-y-4">
            <h3 class="text-base font-bold text-gray-900 dark:text-white font-outfit">Problem Difficulty Breakdown</h3>
            <div class="grid grid-cols-3 gap-6 text-center">
                <div class="bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-900/30 p-4 rounded-2xl">
                    <span class="block text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $easyCount }}</span>
                    <span class="text-[10px] font-bold text-emerald-500 uppercase tracking-wider">Easy</span>
                </div>
                <div class="bg-amber-50 dark:bg-amber-950/20 border border-amber-100 dark:border-amber-900/30 p-4 rounded-2xl">
                    <span class="block text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $mediumCount }}</span>
                    <span class="text-[10px] font-bold text-amber-500 uppercase tracking-wider">Medium</span>
                </div>
                <div class="bg-rose-50 dark:bg-rose-955/20 border border-rose-100 dark:border-rose-900/30 p-4 rounded-2xl">
                    <span class="block text-2xl font-bold text-rose-600 dark:text-rose-400">{{ $hardCount }}</span>
                    <span class="text-[10px] font-bold text-rose-500 uppercase tracking-wider">Hard</span>
                </div>
            </div>
        </div>

        <!-- Recent Submissions system overview -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-3xl border border-gray-150 dark:border-gray-850 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-gray-900 dark:text-white font-outfit">Recent System Submissions</h3>
                <a href="{{ route('admin.submissions') }}" class="text-xs text-blue-650 hover:underline">View All Submissions</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-405">
                    <thead>
                        <tr class="text-xs text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800">
                            <th class="py-3 font-semibold">User</th>
                            <th class="py-3 font-semibold">Problem</th>
                            <th class="py-3 font-semibold">Language</th>
                            <th class="py-3 font-semibold">Verdict</th>
                            <th class="py-3 font-semibold">Submitted At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-105 dark:divide-gray-800">
                        @forelse($recentSubmissions as $sub)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-850/40 transition-colors">
                                <td class="py-3 font-semibold text-gray-950 dark:text-white">{{ $sub->user->name ?? 'Deleted User' }}</td>
                                <td class="py-3 text-gray-700 dark:text-gray-300">
                                    <a href="{{ route('problems.show', $sub->problem->slug) }}" class="hover:underline">{{ $sub->problem->title }}</a>
                                </td>
                                <td class="py-3 font-mono text-xs uppercase">{{ $sub->language }}</td>
                                <td class="py-3">
                                    @if($sub->status === 'Accepted')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400">Accepted</span>
                                    @elseif($sub->status === 'Wrong Answer')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400">Wrong Answer</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400">{{ $sub->status }}</span>
                                    @endif
                                </td>
                                <td class="py-3 text-xs text-gray-400">{{ $sub->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-400">No submissions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
