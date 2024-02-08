<x-app-layout>
  <x-slot name="breadcrumb">
    <ul class="text-sm">
      <li class="inline after:content-['>'] after:text-gray-500 after:text-xs">
        <x-link href="{{ route('message.index') }}">{{ __('Messages') }}</x-link>
      </li>
      <li class="inline">{{ __('Create a channel') }}</li>
    </ul>
  </x-slot>

  <div class="py-4 sm:py-12">
    <div class="mx-auto max-w-xl px-2">
      <div class="overflow-hidden bg-white dark:bg-gray-800 rounded sm:rounded-lg p-1">
        <form method="POST" action="{{ route('channel.store') }}">
          @csrf

          <div class="relative border-b dark:border-gray-600 py-4">
            <h1 class="text-lg font-bold">{{ __('Create a channel') }}</h1>
          </div>

          <!-- name -->
          <div class="relative pt-4 pb-2">
            <x-input-label for="channel-name"
                          :value="__('What is the name of the channel?')" />

            <x-text-input class="mt-1 block w-full"
                          id="channel-name"
                          name="channel-name"
                          type="text"
                          required
                          autofocus />

            <x-input-error class="mt-2" :messages="$errors->get('channel-name')" />
          </div>

          <!-- description -->
          <div class="relative py-4">
            <x-input-label for="description"
                          :optional="true"
                          :value="__('Description')" />

            <x-textarea class="mt-1 block w-full"
                      id="description"
                      name="description"
                      type="text">{{ old('description') }}</x-textarea>

            <x-input-error class="mt-2" :messages="$errors->get('description')" />
          </div>

          <!-- is public -->
          <p class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Channel visibility') }}</p>
          <div class="grid grid-flow-row sm:grid-flow-col sm:grid-cols-2 gap-4 pt-2 pb-4">
            <div class="flex p-3 ps-4 border border-gray-200 rounded dark:border-gray-700">
              <div class="flex items-center h-5">
                <input id="visibility-public" name="visibility" checked type="radio" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
              </div>
              <div class="ms-2 text-sm">
                <label for="visibility-public" class="font-medium text-gray-900 dark:text-gray-300">{{ __('Public') }}</label>
                <p class="text-xs font-normal text-gray-500 dark:text-gray-300">{{ __('Anyone in the organization can see the content of the channel.') }}</p>
              </div>
            </div>
            <div class="flex p-3 ps-4 border border-gray-200 rounded dark:border-gray-700">
              <div class="flex items-center h-5">
                <input id="visibility-private" name="visibility" type="radio" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
              </div>
              <div class="ms-2 text-sm">
                <label for="visibility-private" class="font-medium text-gray-900 dark:text-gray-300">🔐 {{ __('Private') }}</label>
                <p class="text-xs font-normal text-gray-500 dark:text-gray-300">{{ __('Only channel members can view its content.') }}</p>
              </div>
            </div>
          </div>

          <!-- actions -->
          <div class="flex items-center justify-between border-t dark:border-gray-600 py-4">
            <x-link href="{{ route('message.index') }}">{{ __('Back') }}</x-link>

            <div>
              <x-primary-button class="w-full text-center" dusk="submit-form-button">
                {{ __('Create') }}
              </x-primary-button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
