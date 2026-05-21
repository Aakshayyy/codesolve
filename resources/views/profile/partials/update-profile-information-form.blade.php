<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-150">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information, avatar, and email address.") }}
        </p>
    </header>



    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data" x-data="{ photoName: null, photoPreview: null }">
        @csrf
        @method('patch')

        <!-- Profile Picture Upload with AlpineJS Preview -->
        <div class="space-y-2">
            <x-input-label for="profile_picture" :value="__('Profile Picture')" class="dark:text-gray-300" />
            
            <div class="flex items-center gap-5">
                <!-- Image Holder -->
                <div class="relative w-20 h-20 rounded-2xl overflow-hidden bg-gray-155 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 flex items-center justify-center">
                    <!-- Preview Image -->
                    <template x-if="photoPreview">
                        <img :src="photoPreview" class="w-full h-full object-cover">
                    </template>
                    <!-- Current Image or Default Icon -->
                    <template x-if="!photoPreview">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-gray-400 dark:text-gray-600 font-extrabold text-2xl uppercase">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </template>
                </div>

                <div class="space-y-1.5">
                    <!-- File input -->
                    <input type="file" id="profile_picture" name="profile_picture" class="hidden" 
                           accept="image/*"
                           x-ref="photo"
                           @change="
                                    const file = $refs.photo.files[0];
                                    if (file) {
                                        photoName = file.name;
                                        const reader = new FileReader();
                                        reader.onload = (e) => {
                                            photoPreview = e.target.result;
                                        };
                                        reader.readAsDataURL(file);
                                    }
                           " />
                    
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                            @click.prevent="$refs.photo.click()">
                        Choose Photo
                    </button>
                    <p class="text-xs text-gray-400">JPEG, PNG, JPG, GIF up to 2MB</p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="dark:text-gray-300" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-800 dark:text-gray-100" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="dark:text-gray-300" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-800 dark:text-gray-100" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />


        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-650 dark:text-gray-450"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
