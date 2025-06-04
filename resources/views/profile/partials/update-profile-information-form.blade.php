<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
            :value="old('name', $user->name)" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email -->
    <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
            :value="old('email', $user->email)" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Age -->
    <div class="mt-4">
        <x-input-label for="age" :value="__('Age')" />
        <x-text-input id="age" name="age" type="number" class="mt-1 block w-full"
            :value="old('age', $user->customer->age ?? '')" required />
        <x-input-error :messages="$errors->get('age')" class="mt-2" />
    </div>

    <!-- Gender -->
    <div class="mt-4">
        <x-input-label for="gender" :value="__('Gender')" />
        <x-text-input id="gender" name="gender" type="text" class="mt-1 block w-full"
            :value="old('gender', $user->customer->gender ?? '')" required />
        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
    </div>

    <!-- Phone -->
    <div class="mt-4">
        <x-input-label for="phone" :value="__('Phone')" />
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
            :value="old('phone', $user->customer->phone ?? '')" required />
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>

    <!-- Avatar -->
    <div class="mt-4">
        <x-input-label for="avatar" :value="__('Profile Picture')" />
        <input id="avatar" name="avatar" type="file" class="mt-1 block w-full" accept="image/*" />
        <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
    </div>

    <div class="flex items-center gap-4 mt-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>

        @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-green-600 dark:text-green-400"
            >{{ __('Saved.') }}</p>
        @endif
    </div>
</form>
</section>
