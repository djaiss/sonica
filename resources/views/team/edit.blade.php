<x-app-layout>
  <x-slot name="breadcrumb">
    <ul class="text-sm">
      <li class="inline after:content-['>'] after:text-gray-500 after:text-xs">
        <x-link href="{{ route('company.index') }}">{{ __('Company') }}</x-link>
      </li>
      <li class="inline after:content-['>'] after:text-gray-500 after:text-xs">
        <x-link href="{{ route('team.index') }}">{{ __('Teams') }}</x-link>
      </li>
      <li class="inline after:content-['>'] after:text-gray-500 after:text-xs">
        <x-link href="{{ route('team.show', ['team' => $data['id']]) }}">{{ $data['name'] }}</x-link>
      </li>
      <li class="inline">{{ __('Edit') }}</li>
    </ul>
  </x-slot>

  <div class="py-4 sm:py-12">
    <div class="mx-auto max-w-xl px-2">
      <div class="overflow-hidden bg-white dark:bg-gray-800 rounded sm:rounded-lg p-1">
        <form method="POST" action="{{ route('team.update', ['team' => $data['id']]) }}">
          @csrf
          @method('PUT')

          <div class="relative border-b dark:border-gray-600 py-4">
            <h1 class="text-lg font-bold">{{ __('Edit a team') }}</h1>
          </div>

          <!-- name -->
          <div class="relative py-4">
            <x-input-label for="group-name"
                          :value="__('What is the name of the team?')" />

            <x-text-input class="mt-1 block w-full"
                          id="group-name"
                          name="group-name"
                          type="text"
                          :value="old('name', $data['name'])"
                          required
                          autofocus />

            <x-input-error class="mt-2" :messages="$errors->get('group-name')" />
          </div>

          <!-- is public -->
          <p class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Team visibility') }}</p>
          <div class="grid grid-flow-row sm:grid-flow-col sm:grid-cols-2 gap-4 pt-2 pb-4">
            <div class="flex p-3 ps-4 border border-gray-200 rounded dark:border-gray-700">
              <div class="flex items-center h-5">
                <input id="visibility-public" name="visibility" {{ $data['is_public'] ? 'checked' : '' }} type="radio" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
              </div>
              <div class="ms-2 text-sm">
                <label for="visibility-public" class="font-medium text-gray-900 dark:text-gray-300">{{ __('Public') }}</label>
                <p class="text-xs font-normal text-gray-500 dark:text-gray-300">{{ __('Anyone in the organization can see the content of the team.') }}</p>
              </div>
            </div>
            <div class="flex p-3 ps-4 border border-gray-200 rounded dark:border-gray-700">
              <div class="flex items-center h-5">
                <input id="visibility-private" name="visibility" {{ ! $data['is_public'] ? 'checked' : '' }} type="radio" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
              </div>
              <div class="ms-2 text-sm">
                <label for="visibility-private" class="font-medium text-gray-900 dark:text-gray-300">🔐 {{ __('Private') }}</label>
                <p class="text-xs font-normal text-gray-500 dark:text-gray-300">{{ __('Only team members can view the team\'s content.') }}</p>
              </div>
            </div>
          </div>

          <!-- description -->
          <div class="py-4">
            <x-input-label for="description"
                          :optional="true"
                          :value="__('Description')" />

            <x-textarea class="mt-1 block w-full"
                      id="description"
                      name="description"
                      type="text">{{ old('description', $data['description']) }}</x-textarea>

            <x-input-error class="mt-2" :messages="$errors->get('description')" />
          </div>

          <!-- actions -->
          <div class="flex items-center justify-between border-t dark:border-gray-600 py-4">
            <x-link href="{{ route('team.show', ['team' => $data['id']]) }}">{{ __('Back') }}</x-link>

            <div>
              <x-primary-button class="w-full text-center" dusk="submit-form-button">
                {{ __('Save') }}
              </x-primary-button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
