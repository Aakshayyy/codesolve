<x-admin-layout>
    <div class="space-y-8">
        <div>
            <h2 class="text-2xl font-bold font-outfit text-gray-900 dark:text-white">User Administration</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Change member roles (Admin/User) or delete users from the system.</p>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-150 dark:border-gray-850 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead>
                        <tr class="text-xs text-gray-400 uppercase border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50">
                            <th class="py-3 px-6 font-semibold">User</th>
                            <th class="py-3 px-6 font-semibold">Email</th>
                            <th class="py-3 px-6 font-semibold text-center">Role</th>
                            <th class="py-3 px-6 font-semibold text-center">Score</th>
                            <th class="py-3 px-6 font-semibold text-center">Streak</th>
                            <th class="py-3 px-6 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-850/40 transition-colors">
                                <td class="py-4 px-6 font-bold text-gray-900 dark:text-white">
                                    <div class="flex items-center space-x-3">
                                        @if($user->profile_picture)
                                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Avatar" class="w-7 h-7 rounded-full object-cover">
                                        @else
                                            <div class="w-7 h-7 rounded-full bg-blue-550 text-white flex items-center justify-center font-bold text-[10px] uppercase">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <span>{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-gray-650 dark:text-gray-400">
                                    {{ $user->email }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($user->role === 'admin')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-indigo-50 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400">
                                            Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
                                            User
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center font-mono font-bold text-gray-900 dark:text-white">
                                    {{ $user->points }} pts
                                </td>
                                <td class="py-4 px-6 text-center text-xs text-amber-500 font-bold">
                                    🔥 {{ $user->streak }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- Toggle Role Form -->
                                        @if($user->id !== Auth::id())
                                            <form action="{{ route('admin.users.toggle-role', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-xs bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold py-1.5 px-3 rounded-lg transition-colors">
                                                    Toggle Role
                                                </button>
                                            </form>

                                            <!-- Delete Form -->
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete user \'{{ $user->name }}\'? This action is permanent.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs bg-rose-50 dark:bg-rose-955/20 hover:bg-rose-100 dark:hover:bg-rose-900/40 text-rose-600 dark:text-rose-400 font-bold py-1.5 px-3 rounded-lg transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Self</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-400">No users found in the system.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $users->links() }}
    </div>
</x-admin-layout>
