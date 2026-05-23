<x-app-layout>
    <div class="py-10 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Hero User Banner -->
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-650 rounded-3xl p-6 sm:p-8 text-white shadow-xl">
                <!-- Decorative backgrounds -->
                <div class="absolute right-0 bottom-0 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl pointer-events-none translate-x-12 translate-y-12"></div>
                <div class="absolute left-1/3 top-0 w-64 h-64 bg-indigo-400 opacity-20 rounded-full blur-2xl pointer-events-none -translate-y-12"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center md:justify-between gap-6">
                    <div class="flex flex-col sm:flex-row items-center gap-6 text-center sm:text-left">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Avatar" class="w-24 h-24 rounded-2xl object-cover border-4 border-white/20 shadow-lg">
                        @else
                            <div class="w-24 h-24 rounded-2xl bg-white/10 text-white flex items-center justify-center font-bold text-4xl uppercase border-4 border-white/20 shadow-lg font-outfit">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="space-y-1">
                            <h1 class="text-3xl font-extrabold font-outfit tracking-tight">{{ $user->name }}</h1>
                            <p class="text-white/80 text-sm font-medium">Joined {{ $user->created_at->format('M Y') }} &bull; {{ $user->role === 'admin' ? 'Administrator' : 'Platform Member' }}</p>
                            <div class="flex flex-wrap gap-2 pt-2 justify-center sm:justify-start">
                                <span class="bg-white/15 px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm">🏆 {{ $user->points }} Points</span>
                                <span class="bg-white/15 px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm">🔥 {{ $user->streak }} Day Streak</span>
                            </div>
                        </div>
                    </div>
                    <div class="shrink-0">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center bg-white text-indigo-705 px-5 py-2.5 rounded-xl font-bold hover:bg-gray-100 transition-colors shadow-md text-sm">
                            Edit Profile Settings
                        </a>
                    </div>
                </div>
            </div>

            <!-- Dashboard Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Statistics Card 1: Problem Solving Progress -->
                <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-200 dark:border-gray-800 shadow-sm flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400 font-semibold text-sm uppercase tracking-wider">Solved Problems</span>
                            <div class="p-2 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <div class="flex items-baseline space-x-2">
                            <span class="text-4xl font-extrabold text-gray-900 dark:text-white font-outfit">{{ $solvedCount }}</span>
                            <span class="text-gray-400 dark:text-gray-500 text-sm">/ {{ \App\Models\Problem::count() }} Total</span>
                        </div>
                        <!-- Difficulty Breakdown -->
                        <div class="space-y-2.5 pt-2">
                            <div>
                                <div class="flex justify-between text-xs font-semibold text-gray-550 dark:text-gray-400 mb-1">
                                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>Easy</span>
                                    <span>{{ $solvedEasy }} / {{ $totalEasy }}</span>
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-gray-800 h-2 rounded-full overflow-hidden">
                                    <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $totalEasy > 0 ? ($solvedEasy / $totalEasy) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-semibold text-gray-550 dark:text-gray-400 mb-1">
                                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>Medium</span>
                                    <span>{{ $solvedMedium }} / {{ $totalMedium }}</span>
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-gray-800 h-2 rounded-full overflow-hidden">
                                    <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $totalMedium > 0 ? ($solvedMedium / $totalMedium) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-semibold text-gray-550 dark:text-gray-400 mb-1">
                                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>Hard</span>
                                    <span>{{ $solvedHard }} / {{ $totalHard }}</span>
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-gray-800 h-2 rounded-full overflow-hidden">
                                    <div class="bg-rose-500 h-2 rounded-full" style="width: {{ $totalHard > 0 ? ($solvedHard / $totalHard) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Card 2: Chart.js Difficulty Ring -->
                <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-200 dark:border-gray-800 shadow-sm flex flex-col items-center justify-center">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 self-start mb-4">Solved Ratio</h3>
                    <div class="relative w-40 h-40">
                        <canvas id="difficultyChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-2xl font-extrabold text-gray-900 dark:text-white font-outfit">
                                {{ \App\Models\Problem::count() > 0 ? round(($solvedCount / \App\Models\Problem::count()) * 100) : 0 }}%
                            </span>
                            <span class="text-[10px] uppercase font-bold text-gray-400">Completion</span>
                        </div>
                    </div>
                </div>

                <!-- Statistics Card 3: Streak & Tag Performance -->
                <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-200 dark:border-gray-800 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-gray-500 dark:text-gray-400 font-semibold text-sm uppercase tracking-wider">Coding Streak</span>
                            <span class="text-xs bg-amber-500/10 text-amber-550 dark:text-amber-450 px-2 py-0.5 rounded-full font-bold">ACTIVE</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-4xl font-extrabold text-amber-500 font-outfit">🔥 {{ $user->streak }}</div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">Consecutive Days</p>
                                <p class="text-xs text-gray-500 dark:text-gray-450">Solve daily problems to build your streak and earn point multipliers!</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-100 dark:border-gray-800 pt-4 mt-4">
                        <h4 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2.5">Progress by Topic</h4>
                        <div class="flex flex-wrap gap-2">
                            @forelse($tagProgress as $tp)
                                <span class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs font-medium px-2.5 py-1 rounded-lg">
                                    {{ $tp['name'] }} <span class="font-extrabold text-blue-500 dark:text-blue-400 ms-1">{{ $tp['count'] }}</span>
                                </span>
                            @empty
                                <span class="text-xs text-gray-400 dark:text-gray-500">No topics solved yet. Solve problems to show stats here!</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Submissions History Table (Left 2 cols) -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-200 dark:border-gray-800 shadow-sm space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold font-outfit text-gray-900 dark:text-white">Recent Submissions</h3>
                        <a href="{{ route('problems.index') }}" class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:underline">Solve More Problems</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                            <thead>
                                <tr class="text-xs text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800">
                                    <th class="py-3 font-semibold">Problem</th>
                                    <th class="py-3 font-semibold">Language</th>
                                    <th class="py-3 font-semibold">Status</th>
                                    <th class="py-3 font-semibold">Runtime / Memory</th>
                                    <th class="py-3 font-semibold">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @forelse($submissions as $sub)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                        <td class="py-4 font-semibold text-gray-900 dark:text-white">
                                            <a href="{{ route('problems.show', $sub->problem->slug) }}" class="hover:text-blue-500 transition-colors">
                                                {{ $sub->problem->title }}
                                            </a>
                                        </td>
                                        <td class="py-4 font-mono text-xs uppercase">{{ $sub->language }}</td>
                                        <td class="py-4">
                                            @if($sub->status === 'Accepted')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400">
                                                    Accepted
                                                </span>
                                            @elseif($sub->status === 'Wrong Answer')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400">
                                                    Wrong Answer
                                                </span>
                                            @elseif($sub->status === 'Time Limit Exceeded')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400">
                                                    TLE
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-55/10 text-red-600 dark:text-red-400">
                                                    {{ $sub->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 font-mono text-xs">
                                            {{ $sub->execution_time }} ms &bull; {{ round($sub->memory_used / 1024, 1) }} MB
                                        </td>
                                        <td class="py-4 text-xs text-gray-400">
                                            {{ $sub->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-8 text-gray-400">
                                            No submissions yet. Start coding today!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{ $submissions->links() }}
                </div>

                <!-- Achievements & Badges (Right 1 col) -->
                <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-200 dark:border-gray-800 shadow-sm space-y-6">
                    <h3 class="text-xl font-bold font-outfit text-gray-900 dark:text-white">Unlocked Badges</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($badges as $badge)
                            <div class="relative group p-4 border rounded-2xl flex flex-col items-center justify-center text-center transition-all duration-200 
                                {{ $badge['unlocked'] 
                                    ? 'bg-blue-50/50 dark:bg-blue-900/10 border-blue-100 dark:border-blue-900/30 text-gray-900 dark:text-white' 
                                    : 'bg-gray-50/50 dark:bg-gray-800 border-gray-100 dark:border-gray-800 text-gray-400 opacity-60' }}">
                                
                                <div class="text-4xl mb-2 transition-transform duration-200 group-hover:scale-110 {{ $badge['unlocked'] ? '' : 'filter grayscale' }}">
                                    {{ $badge['icon'] }}
                                </div>
                                <h4 class="text-xs font-bold tracking-tight">{{ $badge['name'] }}</h4>
                                <span class="text-[9px] uppercase font-semibold text-gray-400 mt-1">
                                    {{ $badge['unlocked'] ? 'Unlocked' : 'Locked' }}
                                </span>

                                <!-- Tooltip -->
                                <div class="absolute z-20 bottom-full mb-2 w-48 hidden group-hover:block bg-gray-900 dark:bg-gray-800 text-white text-[11px] p-2.5 rounded-xl shadow-xl border border-gray-800">
                                    <p class="font-bold mb-1">{{ $badge['name'] }}</p>
                                    <p class="text-gray-300 font-normal leading-snug">{{ $badge['description'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Certificates Card -->
                <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-200 dark:border-gray-800 shadow-sm space-y-6">
                    <h3 class="text-xl font-bold font-outfit text-gray-900 dark:text-white">Earned Certificates</h3>
                    @if(count($earnedCertificates) > 0)
                        <div class="space-y-3">
                            @foreach($earnedCertificates as $cert)
                                <div class="p-4 border rounded-2xl flex items-center justify-between bg-slate-50 dark:bg-gray-950 border-slate-100 dark:border-gray-900">
                                    <div class="flex items-center space-x-3.5 font-outfit">
                                        @if($cert['type'] === 'gold')
                                            <div class="w-10 h-10 rounded-full bg-yellow-500/10 border border-yellow-500/30 flex items-center justify-center text-xl text-yellow-500">🏆</div>
                                        @elseif($cert['type'] === 'silver')
                                            <div class="w-10 h-10 rounded-full bg-slate-400/10 border border-slate-400/30 flex items-center justify-center text-xl text-slate-400">🥈</div>
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-amber-600/10 border border-amber-600/30 flex items-center justify-center text-xl text-amber-600">🥉</div>
                                        @endif
                                        <div>
                                            <h4 class="text-xs font-bold text-gray-900 dark:text-white">{{ $cert['name'] }}</h4>
                                            <p class="text-[10px] text-gray-500 mt-0.5 leading-snug">{{ $cert['description'] }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('certificates.view', ['user' => $user->id, 'type' => $cert['type']]) }}" target="_blank"
                                       class="text-[10px] font-bold text-amber-500 hover:text-amber-600 border border-amber-500/20 hover:border-amber-500/40 px-3 py-1.5 rounded-xl transition-all">
                                        View
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6 border border-dashed rounded-2xl border-gray-200 dark:border-gray-800 text-gray-400 font-outfit">
                            <span class="text-3xl">🎓</span>
                            <p class="text-xs mt-2 font-medium">No certificates unlocked yet.</p>
                            <p class="text-[10px] text-gray-500 mt-0.5">Solve at least 1 problem to earn your Bronze certificate!</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- ChartJS Render Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('difficultyChart').getContext('2d');
            const data = {
                labels: ['Easy', 'Medium', 'Hard', 'Remaining'],
                datasets: [{
                    data: [
                        {{ $solvedEasy }}, 
                        {{ $solvedMedium }}, 
                        {{ $solvedHard }}, 
                        {{ max(0, \App\Models\Problem::count() - $solvedCount) }}
                    ],
                    backgroundColor: [
                        '#10b981', // emerald-500
                        '#f59e0b', // amber-500
                        '#f43f5e', // rose-500
                        '#e5e7eb'  // gray-200 (dark mode needs alternative, handled in options)
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            };

            const isDark = document.documentElement.classList.contains('dark');
            data.datasets[0].backgroundColor[3] = isDark ? '#1f2937' : '#e5e7eb'; // dark: gray-800, light: gray-200

            new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: {
                    cutout: '80%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>
</x-app-layout>
