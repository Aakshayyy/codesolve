<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight font-outfit">
            {{ __('Contests') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            <!-- Active / Ongoing Contests -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-ping"></span>
                    <h3 class="text-xl font-bold font-outfit text-gray-900 dark:text-white">Active Contests</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($activeContests as $contest)
                        <div class="relative overflow-hidden bg-gradient-to-br from-indigo-900 to-slate-900 rounded-3xl p-6 text-white shadow-lg border border-indigo-500/20">
                            <!-- Glowing highlight -->
                            <div class="absolute -right-20 -top-20 w-48 h-48 rounded-full bg-blue-500 blur-3xl opacity-30"></div>
                            
                            <div class="relative z-10 space-y-4 flex flex-col justify-between h-full">
                                <div>
                                    <div class="flex justify-between items-start">
                                        <span class="bg-red-500 text-white text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">LIVE</span>
                                        <span class="text-xs text-indigo-300 font-semibold">{{ $contest->start_time->format('M d, H:i') }} - {{ $contest->end_time->format('H:i') }}</span>
                                    </div>
                                    <h4 class="text-xl font-bold font-outfit mt-2">{{ $contest->title }}</h4>
                                    <p class="text-xs text-indigo-200 mt-2 line-clamp-2">{{ $contest->description ?? 'No description provided.' }}</p>
                                </div>
                                <div class="flex items-center justify-between pt-4 border-t border-indigo-800/40">
                                    <span class="text-xs text-indigo-300 font-semibold">{{ $contest->problems->count() }} Problems</span>
                                    <a href="{{ route('contests.show', $contest->slug) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-xl text-xs transition-colors shadow-md shadow-blue-500/20">
                                        Enter Contest
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 p-8 bg-white dark:bg-gray-900 rounded-3xl border border-gray-150 dark:border-gray-850 shadow-sm text-center text-gray-500 dark:text-gray-405">
                            No contests are active right now. Check upcoming contests below!
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Upcoming Contests -->
            <div class="space-y-4">
                <h3 class="text-xl font-bold font-outfit text-gray-900 dark:text-white">Upcoming Contests</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($upcomingContests as $contest)
                        <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-150 dark:border-gray-850 shadow-sm flex flex-col justify-between space-y-4" x-data="countdown('{{ $contest->start_time->toIso8601String() }}')">
                            <div>
                                <div class="flex justify-between items-start">
                                    <span class="bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 text-[10px] font-bold px-2 py-0.5 rounded-md uppercase">Scheduled</span>
                                </div>
                                <h4 class="text-lg font-bold font-outfit text-gray-900 dark:text-white mt-2">{{ $contest->title }}</h4>
                                <p class="text-xs text-gray-550 dark:text-gray-400 mt-2 line-clamp-2">{{ $contest->description ?? 'No description provided.' }}</p>
                            </div>

                            <div class="pt-4 border-t border-gray-105 dark:border-gray-850">
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Starts In</div>
                                <div class="flex items-center space-x-2 font-mono text-gray-800 dark:text-gray-250 text-sm font-bold">
                                    <span x-text="timeString">Calculating...</span>
                                </div>
                            </div>

                            <a href="{{ route('contests.show', $contest->slug) }}" class="w-full text-center bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold py-2 rounded-xl text-xs transition-colors">
                                View Details
                            </a>
                        </div>
                    @empty
                        <div class="col-span-3 p-8 bg-white dark:bg-gray-900 rounded-3xl border border-gray-150 dark:border-gray-850 shadow-sm text-center text-gray-500 dark:text-gray-405">
                            No upcoming contests scheduled at this time.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Past Contests -->
            <div class="space-y-4">
                <h3 class="text-xl font-bold font-outfit text-gray-900 dark:text-white">Past Contests</h3>
                
                <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-150 dark:border-gray-850 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                            <thead>
                                <tr class="text-xs text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50">
                                    <th class="py-3 px-6 font-semibold">Contest Name</th>
                                    <th class="py-3 px-6 font-semibold">Date</th>
                                    <th class="py-3 px-6 font-semibold">Duration</th>
                                    <th class="py-3 px-6 font-semibold">Problems</th>
                                    <th class="py-3 px-6 font-semibold text-right">Standings</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @forelse($pastContests as $contest)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                        <td class="py-4 px-6 font-bold text-gray-900 dark:text-white">
                                            <a href="{{ route('contests.show', $contest->slug) }}" class="hover:text-blue-500 transition-colors">
                                                {{ $contest->title }}
                                            </a>
                                        </td>
                                        <td class="py-4 px-6 text-xs text-gray-450">
                                            {{ $contest->start_time->format('d M Y, H:i') }}
                                        </td>
                                        <td class="py-4 px-6 text-xs text-gray-650 dark:text-gray-400">
                                            {{ $contest->start_time->diffInHours($contest->end_time) }} hour(s)
                                        </td>
                                        <td class="py-4 px-6 text-xs text-gray-650 dark:text-gray-400">
                                            {{ $contest->problems->count() }} problems
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <a href="{{ route('contests.leaderboard', $contest->slug) }}" class="inline-flex items-center text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">
                                                Final Scoreboard
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-8 text-gray-400">
                                            No past contests.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                {{ $pastContests->links() }}
            </div>

        </div>
    </div>

    <!-- Countdown Javascript Helper -->
    <script>
        function countdown(startTimeStr) {
            return {
                targetTime: new Date(startTimeStr).getTime(),
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
                        this.timeString = "Started";
                        clearInterval(this.timer);
                        return;
                    }
                    
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    let parts = [];
                    if (days > 0) parts.push(`${days}d`);
                    if (hours > 0 || days > 0) parts.push(`${hours}h`);
                    parts.push(`${minutes}m`);
                    parts.push(`${seconds}s`);
                    
                    this.timeString = parts.join(' ');
                }
            }
        }
    </script>
</x-app-layout>
