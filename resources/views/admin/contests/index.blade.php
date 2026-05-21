<x-admin-layout>
    <div class="space-y-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold font-outfit text-gray-900 dark:text-white">Manage Contests</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Schedule coding competitions, link practice problems, and view leaderboard records.</p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('admin.contests.create') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold transition-all shadow-md shadow-blue-500/10">
                    + Schedule New Contest
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-150 dark:border-gray-850 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-555 dark:text-gray-400">
                    <thead>
                        <tr class="text-xs text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50">
                            <th class="py-3 px-6 font-semibold">Title</th>
                            <th class="py-3 px-6 font-semibold">Schedule</th>
                            <th class="py-3 px-6 font-semibold text-center">Status</th>
                            <th class="py-3 px-6 font-semibold text-center">Problems Linked</th>
                            <th class="py-3 px-6 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-105 dark:divide-gray-800">
                        @forelse($contests as $contest)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-855/40 transition-colors">
                                <td class="py-4 px-6 font-bold text-gray-900 dark:text-white">
                                    <a href="{{ route('contests.show', $contest->slug) }}" class="hover:text-blue-505 transition-colors">
                                        {{ $contest->title }}
                                    </a>
                                </td>
                                <td class="py-4 px-6 text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                                    <strong>Start:</strong> {{ $contest->start_time->format('d M Y, H:i') }} <br>
                                    <strong>End:</strong> &nbsp;{{ $contest->end_time->format('d M Y, H:i') }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($contest->isActive())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400">
                                            Active
                                        </span>
                                    @elseif($contest->isUpcoming())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-900/20 text-blue-650 dark:text-blue-400">
                                            Upcoming
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                                            Finished
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center font-bold text-gray-900 dark:text-white">
                                    {{ $contest->problems->count() }} problems
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.contests.edit', $contest->id) }}" class="text-xs bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold py-1.5 px-3 rounded-lg transition-colors">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.contests.destroy', $contest->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete contest \'{{ $contest->title }}\'?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs bg-rose-50 dark:bg-rose-955/20 hover:bg-rose-100 dark:hover:bg-rose-900/40 text-rose-600 dark:text-rose-400 font-bold py-1.5 px-3 rounded-lg transition-colors">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-gray-400">No contests found. Click "+ Schedule New Contest" to schedule one.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $contests->links() }}
    </div>
</x-admin-layout>
