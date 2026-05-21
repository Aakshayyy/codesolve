<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight font-outfit">
            {{ __('Leaderboard Rankings') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Type Switch Tabs -->
            <div class="flex bg-gray-150 dark:bg-gray-900 p-1 rounded-2xl max-w-md border border-gray-200 dark:border-gray-800">
                <a href="{{ route('leaderboard', ['type' => 'global']) }}" 
                   class="flex-1 text-center py-2.5 rounded-xl text-xs font-bold transition-colors {{ $type === 'global' ? 'bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm' : 'text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }}">
                    Global Standings
                </a>
                <a href="{{ route('leaderboard', ['type' => 'weekly']) }}" 
                   class="flex-1 text-center py-2.5 rounded-xl text-xs font-bold transition-colors {{ $type === 'weekly' ? 'bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm' : 'text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }}">
                    Weekly (Last 7 Days)
                </a>
            </div>

            <!-- Rankings Card -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-150 dark:border-gray-850 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">
                        {{ $type === 'weekly' ? 'Weekly Standings' : 'Global Standings' }}
                    </h3>
                    <span class="text-xs text-gray-400 font-semibold">Ordered by accrued points</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-555 dark:text-gray-400">
                        <thead>
                            <tr class="text-xs text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800">
                                <th class="py-3 px-4 font-semibold w-20 text-center">Rank</th>
                                <th class="py-3 px-4 font-semibold">User</th>
                                <th class="py-3 px-4 font-semibold w-32 text-center">Solved Count</th>
                                <th class="py-3 px-4 font-semibold w-32 text-center">Streak</th>
                                <th class="py-3 px-4 font-semibold w-32 text-right">Points</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @if($type === 'global')
                                @forelse($globalLeaderboard as $index => $rowUser)
                                    @php
                                        // Rank is current index + offset + 1
                                        $rank = ($globalLeaderboard->currentPage() - 1) * $globalLeaderboard->perPage() + $index + 1;
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-850/40 transition-colors">
                                        <td class="py-4 px-4 text-center">
                                            @if($rank === 1)
                                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-100 text-amber-600 font-extrabold text-sm border border-amber-300">🥇</span>
                                            @elseif($rank === 2)
                                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-100 text-slate-600 font-extrabold text-sm border border-slate-350">🥈</span>
                                            @elseif($rank === 3)
                                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-orange-100 text-orange-600 font-extrabold text-sm border border-orange-300">🥉</span>
                                            @else
                                                <span class="font-bold text-gray-400">{{ $rank }}</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 font-bold text-gray-900 dark:text-white">
                                            <div class="flex items-center space-x-2">
                                                @if($rowUser->profile_picture)
                                                    <img src="{{ asset('storage/' . $rowUser->profile_picture) }}" alt="Avatar" class="w-7 h-7 rounded-full object-cover">
                                                @else
                                                    <div class="w-7 h-7 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-[10px] uppercase">
                                                        {{ substr($rowUser->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <span>{{ $rowUser->name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-center font-medium">
                                            {{ $rowUser->submissions()->where('status', 'Accepted')->distinct('problem_id')->count() }} solved
                                        </td>
                                        <td class="py-4 px-4 text-center text-xs text-amber-500 font-bold">
                                            🔥 {{ $rowUser->streak }} d
                                        </td>
                                        <td class="py-4 px-4 text-right font-mono font-extrabold text-blue-600 dark:text-blue-400">
                                            {{ $rowUser->points }} pts
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-10 text-gray-400">No users found.</td>
                                    </tr>
                                @endforelse
                            @else
                                @forelse($weeklyLeaderboard as $index => $row)
                                    @php
                                        $rank = ($paginator['current_page'] - 1) * $paginator['per_page'] + $index + 1;
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-850/40 transition-colors">
                                        <td class="py-4 px-4 text-center">
                                            @if($rank === 1)
                                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-100 text-amber-600 font-extrabold text-sm border border-amber-300">🥇</span>
                                            @elseif($rank === 2)
                                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-100 text-slate-600 font-extrabold text-sm border border-slate-350">🥈</span>
                                            @elseif($rank === 3)
                                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-orange-100 text-orange-600 font-extrabold text-sm border border-orange-300">🥉</span>
                                            @else
                                                <span class="font-bold text-gray-400">{{ $rank }}</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 font-bold text-gray-900 dark:text-white">
                                            <div class="flex items-center space-x-2">
                                                @if($row['user']->profile_picture)
                                                    <img src="{{ asset('storage/' . $row['user']->profile_picture) }}" alt="Avatar" class="w-7 h-7 rounded-full object-cover">
                                                @else
                                                    <div class="w-7 h-7 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-[10px] uppercase">
                                                        {{ substr($row['user']->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <span>{{ $row['user']->name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-center font-medium">
                                            {{ $row['solved_count'] }} solved
                                        </td>
                                        <td class="py-4 px-4 text-center text-xs text-amber-505 font-bold">
                                            🔥 {{ $row['user']->streak }} d
                                        </td>
                                        <td class="py-4 px-4 text-right font-mono font-extrabold text-blue-600 dark:text-blue-400">
                                            {{ $row['points'] }} pts
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-10 text-gray-400">No submissions in the last 7 days.</td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Paginations -->
                @if($type === 'global')
                    {{ $globalLeaderboard->links() }}
                @else
                    @if($paginator['has_pages'])
                        <div class="flex justify-between items-center pt-4">
                            <span class="text-xs text-gray-400">Page {{ $paginator['current_page'] }} of {{ $paginator['last_page'] }}</span>
                            <div class="flex space-x-2">
                                @if($paginator['current_page'] > 1)
                                    <a href="{{ request()->fullUrlWithQuery(['page' => $paginator['current_page'] - 1]) }}" class="px-3.5 py-1.5 bg-gray-100 dark:bg-gray-800 text-xs font-bold rounded-lg hover:bg-gray-200 transition-colors">Prev</a>
                                @endif
                                @if($paginator['current_page'] < $paginator['last_page'])
                                    <a href="{{ request()->fullUrlWithQuery(['page' => $paginator['current_page'] + 1]) }}" class="px-3.5 py-1.5 bg-gray-100 dark:bg-gray-800 text-xs font-bold rounded-lg hover:bg-gray-200 transition-colors">Next</a>
                                @endif
                            </div>
                        </div>
                    @endif
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
