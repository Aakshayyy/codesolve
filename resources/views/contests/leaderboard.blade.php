<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <span class="text-xs font-bold text-blue-650 dark:text-blue-450 uppercase tracking-widest mb-1 block">Scoreboard</span>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight font-outfit">
                    {{ $contest->title }} Standings
                </h2>
            </div>
            <div class="shrink-0">
                <a href="{{ route('contests.show', $contest->slug) }}" class="inline-flex items-center justify-center bg-gray-150 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-850 dark:text-gray-200 px-4 py-2 rounded-xl text-xs font-bold transition-colors">
                    Back to Contest Arena
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-150 dark:border-gray-850 shadow-sm space-y-6">
                
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Live Standings</h3>
                    <span class="text-xs text-gray-400 font-semibold">{{ count($leaderboard) }} Contestants</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-555 dark:text-gray-400">
                        <thead>
                            <tr class="text-xs text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50">
                                <th class="py-3 px-4 font-semibold w-16 text-center">Rank</th>
                                <th class="py-3 px-4 font-semibold">Contestant</th>
                                <th class="py-3 px-4 font-semibold w-24 text-center">Solved</th>
                                <th class="py-3 px-4 font-semibold w-32 text-center">Points</th>
                                <th class="py-3 px-4 font-semibold w-32 text-center">Penalty Time</th>
                                @foreach($contest->problems as $index => $problem)
                                    <th class="py-3 px-4 font-semibold text-center" title="{{ $problem->title }}">
                                        {{ chr(65 + $index) }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($leaderboard as $rankIndex => $row)
                                <tr class="hover:bg-gray-55 dark:hover:bg-gray-850/40 transition-colors">
                                    <td class="py-4 px-4 text-center font-bold text-gray-900 dark:text-white">
                                        {{ $rankIndex + 1 }}
                                    </td>
                                    <td class="py-4 px-4 font-semibold text-gray-900 dark:text-white">
                                        <div class="flex items-center space-x-2">
                                            @if($row['user']->profile_picture)
                                                <img src="{{ asset('storage/' . $row['user']->profile_picture) }}" alt="Avatar" class="w-6 h-6 rounded-full object-cover">
                                            @else
                                                <div class="w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-[9px] uppercase">
                                                    {{ substr($row['user']->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <span>{{ $row['user']->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center font-extrabold text-gray-900 dark:text-white">
                                        {{ $row['solved_count'] }}
                                    </td>
                                    <td class="py-4 px-4 text-center font-mono font-bold text-emerald-500">
                                        {{ $row['total_points'] }}
                                    </td>
                                    <td class="py-4 px-4 text-center font-mono text-gray-500 dark:text-gray-400 text-xs">
                                        {{ $row['total_time'] }} mins
                                    </td>
                                    
                                    @foreach($contest->problems as $problem)
                                        @php
                                            $probData = $row['problems'][$problem->id] ?? null;
                                        @endphp
                                        <td class="py-4 px-4 text-center text-xs">
                                            @if($probData)
                                                @if($probData['solved'])
                                                    <div class="bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 p-2 rounded-xl border border-emerald-100 dark:border-emerald-900/30">
                                                        <div class="font-bold">+{{ $probData['points'] }}</div>
                                                        <div class="text-[9px] text-emerald-500 font-medium">at {{ $probData['time_taken'] }}m @if($probData['attempts'] > 0) (+{{ $probData['attempts'] }}) @endif</div>
                                                    </div>
                                                @else
                                                    <div class="bg-rose-50 dark:bg-rose-955/20 text-rose-600 dark:text-rose-400 p-2 rounded-xl border border-rose-100 dark:border-rose-900/30">
                                                        <div class="font-bold">--</div>
                                                        <div class="text-[9px] text-rose-500 font-medium">({{ $probData['attempts'] }} attempts)</div>
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-gray-300 dark:text-gray-700">&mdash;</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ 5 + $contest->problems->count() }}" class="text-center py-10 text-gray-400">
                                        No submissions recorded for this contest yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
