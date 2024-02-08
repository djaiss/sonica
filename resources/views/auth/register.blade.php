<x-guest-layout>
  <!-- image + title -->
  <div class="border-b px-6 py-4">
    <a href="/">
      <x-application-logo class="mx-auto mb-4 block w-28 text-center" />
    </a>

    <h2 class="mb-2 text-center font-bold">{{ __('Welcome to Sonica') }}</h2>
    <h3 class="text-center text-sm text-gray-700">{{ __('Be part of something unique.') }}</h3>
  </div>

  <form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="px-6 py-4">
      <!-- Email Address -->
      <div class="mb-4">
        <x-input-label class="mb-1" for="email" :value="__('Email')" />
        <x-text-input class="mb-2 block w-full"
                      id="email"
                      name="email"
                      type="email"
                      :value="old('email')"
                      required
                      autocomplete="username" />

        <x-input-help>
          {{ __('We will send you a verification email, and won\'t spam you.') }}
        </x-input-help>

        <x-input-error class="mt-2" :messages="$errors->get('email')" />
      </div>

      <!-- Password -->
      <div class="mb-4">
        <x-input-label class="mb-1" for="password" :value="__('Password')" />

        <x-text-input class="block w-full"
                      id="password"
                      name="password"
                      type="password"
                      required
                      autocomplete="new-password" />

        <x-input-error class="mt-2" :messages="$errors->get('password')" />
      </div>

      <!-- Confirm Password -->
      <div class="mb-2">
        <x-input-label class="mb-1" for="password_confirmation" :value="__('Confirm Password')" />

        <x-text-input class="block w-full"
                      id="password_confirmation"
                      name="password_confirmation"
                      type="password"
                      required
                      autocomplete="new-password" />

        <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
      </div>
    </div>

    <div class="flex items-center justify-between border-t px-6 py-4">
      <x-primary-button>
        {{ __('Register') }}
      </x-primary-button>

      <x-link href="{{ route('login') }}">
        {{ __('Already registered?') }}
      </x-link>
    </div>
  </form>
</x-guest-layout>
