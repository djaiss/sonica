<x-app-layout>
  <x-slot name="breadcrumb">
    <ul class="text-sm">
      <li class="inline after:content-['>'] after:text-gray-500 after:text-xs">
        <x-link href="{{ route('settings.index') }}">{{ __('Settings') }}</x-link>
      </li>
      <li class="inline">
        {{ __('Profile') }}
      </li>
    </ul>
  </x-slot>

  <div class="py-4 sm:py-12">
    <div class="mx-auto max-w-2xl px-2">
      <div class="overflow-hidden bg-white dark:bg-gray-800 rounded sm:rounded-lg p-1">
        <form method="POST" action="{{ route('settings.profile.update') }}">
          @csrf
          @method('PUT')

          <div class="relative border-b dark:border-gray-600 py-4">
            <h1 class="text-lg font-bold">{{ __('Update your profile') }}</h1>
          </div>

          <!-- name -->
          <div class="mb-1 grid grid-flow-row sm:grid-flow-col sm:grid-cols-2 gap-4 py-4">
            <div class="mr-0">
              <x-input-label for="first_name" :value="__('First name')" />
              <x-text-input class="mt-1 block w-full"
                            id="first_name"
                            name="first_name"
                            type="text"
                            :value="old('first_name', $data['first_name'])"
                            required
                            autofocus
                            autocomplete="first_name" />
              <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>

            <div>
              <x-input-label for="last_name" :value="__('Last name')" />
              <x-text-input class="mt-1 block w-full"
                            id="last_name"
                            name="last_name"
                            type="text"
                            :value="old('last_name', $data['last_name'])"
                            required
                            autocomplete="last_name" />
              <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>
          </div>

          <!-- email -->
          <div class="relative pb-4">
            <x-input-label for="email"
                          :value="__('Email address')" />

            <x-text-input class="mt-1 block w-full"
                          id="email"
                          name="email"
                          type="text"
                          :value="old('email', $data['email'])"
                          required
                          autofocus />

            <x-input-help>
              {{ __('We will send you a verification email, and won\'t spam you.') }}
            </x-input-help>

            <x-input-error class="mt-2" :messages="$errors->get('email')" />
          </div>

          <!-- locale -->
          <div class="relative pb-4">
            <label for="locale" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Language') }}</label>
            <div class="mt-2">
              <select id="locale" name="locale" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                <option value="en" @selected($data['locale'] == 'en')>{{ __('English') }}</option>
                <option value="fr" @selected($data['locale'] == 'fr')>{{ __('French') }}</option>
              </select>
            </div>
          </div>

          <!-- actions -->
          <div class="flex items-center justify-between border-t dark:border-gray-600 py-4">
            <x-link href="{{ route('settings.index') }}">{{ __('Back') }}</x-link>

            <div>
              <x-primary-button class="w-full text-center">
                {{ __('Save') }}
              </x-primary-button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
