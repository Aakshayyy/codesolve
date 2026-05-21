<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight font-outfit">
            {{ __('Account Settings') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Info Card -->
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-850 shadow-sm rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Card -->
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-850 shadow-sm rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User Card -->
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-850 shadow-sm rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
