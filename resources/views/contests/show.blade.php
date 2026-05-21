<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <span class="text-xs font-bold text-red-500 uppercase tracking-widest flex items-center gap-1.5 mb-1">
                    <span class="w-2 h-2 bg-red-500 rounded-full animate-ping"></span> Live Contest
                </span>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight font-outfit">
                    {{ $contest->title }}
                </h2>
            </div>
            
            <div class="shrink-0 flex items-center space-x-3" x-data="countdown('{{ $contest->end_time->toIso8601String() }}')">
                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Time Remaining:</span>
                <span class="font-mono text-gray-900 dark:text-white font-extrabold text-lg bg-gray-100 dark:bg-gray-800 px-3.5 py-1.5 rounded-xl" x-text="timeString">
                    Calculating...
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <!-- Main Problems list -->
                <div class="lg:col-span-3 space-y-6">
                    <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-150 dark:border-gray-850 shadow-sm">
                        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Contest Problem Set</h3>
                            <a href="{{ route('contests.leaderboard', $contest->slug) }}" class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:underline">
                                View Live Scoreboard
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-555 dark:text-gray-400">
                                <thead>
                                    <tr class="text-xs text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800">
                                        <th class="py-3 px-4 font-semibold w-12 text-center">Status</th>
                                        <th class="py-3 px-4 font-semibold w-16 text-center">#</th>
                                        <th class="py-3 px-4 font-semibold">Problem Title</th>
                                        <th class="py-3 px-4 font-semibold w-28">Difficulty</th>
                                        <th class="py-3 px-4 font-semibold w-24 text-right">Max Points</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @forelse($contest->problems as $index => $problem)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                            <td class="py-4 px-4 text-center">
                                                @if(in_array($problem->id, $solvedProblemIds))
                                                    <span class="text-emerald-500 font-bold" title="Solved">✔</span>
                                                @else
                                                    <span class="text-gray-300 dark:text-gray-700">&mdash;</span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-4 text-center font-bold text-gray-400">
                                                {{ chr(65 + $index) }}
                                            </td>
                                            <td class="py-4 px-4 font-bold text-gray-900 dark:text-white">
                                                <a href="{{ route('problems.show', ['problem' => $problem->slug, 'contest_id' => $contest->id]) }}" class="hover:text-blue-600 transition-colors">
                                                    {{ $problem->title }}
                                                </a>
                                            </td>
                                            <td class="py-4 px-4">
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
                                            <td class="py-4 px-4 text-right font-mono font-semibold text-gray-900 dark:text-white">
                                                {{ $problem->pivot->points ?? 100 }} pts
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-10 text-gray-400">
                                                No problems linked to this contest yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Contest Info Pane -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-150 dark:border-gray-850 shadow-sm space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-outfit">Contest Info</h3>
                        
                        <div class="space-y-4 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-450">Problems:</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $contest->problems->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-450">Duration:</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $contest->start_time->diffInHours($contest->end_time) }} hours</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-450">Start:</span>
                                <span class="font-bold text-gray-900 dark:text-white text-xs">{{ $contest->start_time->format('d M, H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-450">End:</span>
                                <span class="font-bold text-gray-900 dark:text-white text-xs">{{ $contest->end_time->format('d M, H:i') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('contests.leaderboard', $contest->slug) }}" class="w-full text-center block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl text-xs transition-colors shadow-md shadow-blue-500/10">
                            Show Standings
                        </a>
                    </div>

                    <!-- Guidelines -->
                    <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-150 dark:border-gray-850 shadow-sm space-y-3">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Rules & Penalties</h4>
                        <ul class="text-xs text-gray-500 dark:text-gray-400 space-y-2 list-disc pl-4 leading-relaxed">
                            <li>Each wrong compilation/run does not carry penalty, but a **Wrong Answer** submission adds **20 minutes** penalty.</li>
                            <li>Ranking is sorted by descending **Total Points**, then ascending **Penalty Time**.</li>
                            <li>Copying code is strictly monitored. Do your own work!</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Countdown Javascript Helper -->
    <script>
        function countdown(endTimeStr) {
            return {
                targetTime: new Date(endTimeStr).getTime(),
                timeString: '',
                timer: null,
                
                init() {
                    this.updateTime();
                    this.timer = setInterval(() => this.updateTime(), 1000);
                },
                
                updateTime() {
                    const now = new Date().getTime();
                    const distance = this.targetTime - now;
                    
                    if (distance < 0) {
                        this.timeString = "Finished";
                        clearInterval(this.timer);
                        return;
                    }
                    
                    const hours = Math.floor(distance / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    this.timeString = `${hours}h ${minutes}m ${seconds}s`;
                }
            }
        }
    </script>
</x-app-layout>
