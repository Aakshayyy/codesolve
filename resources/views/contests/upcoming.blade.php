<x-app-layout>
    <div class="min-h-screen bg-gray-55/30 dark:bg-gray-950 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8" x-data="countdown('{{ $contest->start_time->toIso8601String() }}')">
        <div class="max-w-2xl w-full mx-auto bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-850 rounded-3xl p-8 text-center shadow-xl space-y-8">
            
            <div class="space-y-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-900/20 text-blue-650 dark:text-blue-450 border border-blue-100 dark:border-blue-900/30 uppercase tracking-widest">
                    Contest Register
                </span>
                <h1 class="text-3xl font-extrabold font-outfit text-gray-900 dark:text-white leading-tight">
                    {{ $contest->title }}
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Starts on {{ $contest->start_time->format('l, F d, Y \a\t H:i') }} (Server Time)
                </p>
            </div>

            <!-- Giant Countdown Clock -->
            <div class="grid grid-cols-4 gap-4 max-w-lg mx-auto">
                <div class="bg-gray-50 dark:bg-gray-950 border border-gray-150 dark:border-gray-850 p-4 rounded-2xl">
                    <span class="block text-3xl sm:text-4xl font-extrabold font-mono text-gray-900 dark:text-white" x-text="days">00</span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Days</span>
                </div>
                <div class="bg-gray-50 dark:bg-gray-950 border border-gray-150 dark:border-gray-850 p-4 rounded-2xl">
                    <span class="block text-3xl sm:text-4xl font-extrabold font-mono text-gray-900 dark:text-white" x-text="hours">00</span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Hours</span>
                </div>
                <div class="bg-gray-50 dark:bg-gray-950 border border-gray-150 dark:border-gray-850 p-4 rounded-2xl">
                    <span class="block text-3xl sm:text-4xl font-extrabold font-mono text-gray-900 dark:text-white" x-text="minutes">00</span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Minutes</span>
                </div>
                <div class="bg-gray-50 dark:bg-gray-950 border border-gray-150 dark:border-gray-850 p-4 rounded-2xl">
                    <span class="block text-3xl sm:text-4xl font-extrabold font-mono text-gray-900 dark:text-white" x-text="seconds">00</span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Seconds</span>
                </div>
            </div>

            <div class="border-t border-gray-100 dark:border-gray-800 pt-6 text-left space-y-4">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Contest Description</h3>
                <p class="text-sm text-gray-700 dark:text-gray-350 leading-relaxed whitespace-pre-line">
                    {{ $contest->description ?? 'Ready your compilers! This coding contest contains problems designed to test your algorithmic thinking, speed, and optimization. Register to join the competition.' }}
                </p>
            </div>

            <div class="pt-4 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contests.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl text-sm transition-colors">
                    Back to Contest Hub
                </a>
                <button disabled class="px-6 py-3 bg-blue-600/35 text-white/70 font-bold rounded-xl text-sm cursor-not-allowed">
                    Compilers Ready
                </button>
            </div>

        </div>
    </div>

    <!-- Countdown Engine script -->
    <script>
        function countdown(startTimeStr) {
            return {
                targetTime: new Date(startTimeStr).getTime(),
                days: '00',
                hours: '00',
                minutes: '00',
                seconds: '00',
                timer: null,

                init() {
                    this.updateTime();
                    this.timer = setInterval(() => this.updateTime(), 1000);
                },

                updateTime() {
                    const now = new Date().getTime();
                    const distance = this.targetTime - now;

                    if (distance < 0) {
                        clearInterval(this.timer);
                        window.location.reload(); // Reload page when contest starts to enter it
                        return;
                    }

                    const d = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const s = Math.floor((distance % (1000 * 60)) / 1000);

                    this.days = d < 10 ? '0' + d : d;
                    this.hours = h < 10 ? '0' + h : h;
                    this.minutes = m < 10 ? '0' + m : m;
                    this.seconds = s < 10 ? '0' + s : s;
                }
            }
        }
    </script>
</x-app-layout>
