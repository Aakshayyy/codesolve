<x-admin-layout>
    <div class="space-y-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold font-outfit text-gray-900 dark:text-white">Manage Problems</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Add, edit, or remove coding challenges and hidden/public test cases.</p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('admin.problems.create') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold transition-all shadow-md shadow-blue-500/10">
                    + Add New Problem
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-150 dark:border-gray-850 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-555 dark:text-gray-400">
                    <thead>
                        <tr class="text-xs text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50">
                            <th class="py-3 px-6 font-semibold">Title</th>
                            <th class="py-3 px-6 font-semibold">Tags</th>
                            <th class="py-3 px-6 font-semibold text-center">Difficulty</th>
                            <th class="py-3 px-6 font-semibold text-center">Limits</th>
                            <th class="py-3 px-6 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($problems as $problem)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-850/40 transition-colors">
                                <td class="py-4 px-6 font-bold text-gray-900 dark:text-white">
                                    <a href="{{ route('problems.show', $problem->slug) }}" class="hover:text-blue-500 transition-colors">
                                        {{ $problem->title }}
                                    </a>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($problem->tags as $tag)
                                            <span class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-450 text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
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
                                <td class="py-4 px-6 text-center text-xs text-gray-450">
                                    {{ $problem->time_limit }}ms / {{ $problem->memory_limit }}MB
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.problems.edit', $problem->id) }}" class="text-xs bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold py-1.5 px-3 rounded-lg transition-colors">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.problems.destroy', $problem->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete problem \'{{ $problem->title }}\'? All submissions will be deleted.')">
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
                                <td colspan="5" class="text-center py-10 text-gray-400">No problems found. Click "+ Add New Problem" to create one.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $problems->links() }}
    </div>
</x-admin-layout>
