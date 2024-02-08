<x-app-layout>
  <x-slot name="breadcrumb">
    <ul class="text-sm">
      <li class="inline after:content-['>'] after:text-gray-500 after:text-xs">
        <x-link href="{{ route('message.index') }}">{{ __('Messages') }}</x-link>
      </li>
      <li class="inline after:content-['>'] after:text-gray-500 after:text-xs">
        <x-link href="{{ $data['url']['show'] }}">{{ $data['name'] }}</x-link>
      </li>
      <li class="inline">{{ __('Edit channel') }}</li>
    </ul>
  </x-slot>

  <div class="py-4 sm:py-12">
    <div class="mx-auto max-w-8xl px-4 sm:px-6 lg:px-8">
      <div class="message-grid grid grid-cols-1 gap-6">

        <!-- left -->
        <div>
          @include('message.channel.partials.sidebar')
        </div>

        <!-- right -->
        <div class="p-0 sm:px-3 sm:py-0">
          <!-- channel general settings -->
          <form method="POST" action="{{ $data['url']['update'] }}" class="max-w-xl mb-6">
            @csrf
            @method('PUT')

            <div class="relative border-b dark:border-gray-600 pb-4">
              <h1 class="text-lg font-bold">{{ __('Channel settings') }}</h1>
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
                            :value="old('channel-name', $data['name'])"
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
                        type="text">{{ $data['description'] }}</x-textarea>

              <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>

            <!-- is public -->
            <p class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Channel visibility') }}</p>
            <div class="grid grid-flow-row sm:grid-flow-col sm:grid-cols-2 gap-4 pt-2 pb-4">
              <div class="flex p-3 ps-4 border border-gray-200 rounded dark:border-gray-700">
                <div class="flex items-center h-5">
                  <input id="visibility-public" name="visibility" {{ $data['is_public'] ? 'checked' : '' }} type="radio" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div class="ms-2 text-sm">
                  <label for="visibility-public" class="font-medium text-gray-900 dark:text-gray-300">{{ __('Public') }}</label>
                  <p class="text-xs font-normal text-gray-500 dark:text-gray-300">{{ __('Anyone in the organization can see the content of the channel.') }}</p>
                </div>
              </div>
              <div class="flex p-3 ps-4 border border-gray-200 rounded dark:border-gray-700">
                <div class="flex items-center h-5">
                  <input id="visibility-private" name="visibility" {{ ! $data['is_public'] ? 'checked' : '' }} type="radio" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div class="ms-2 text-sm">
                  <label for="visibility-private" class="font-medium text-gray-900 dark:text-gray-300">🔐 {{ __('Private') }}</label>
                  <p class="text-xs font-normal text-gray-500 dark:text-gray-300">{{ __('Only channel members can view its content.') }}</p>
                </div>
              </div>
            </div>

            <!-- actions -->
            <div class="border-t dark:border-gray-600 py-4">
              <x-primary-button class="" dusk="edit-form-button">
                {{ __('Save') }}
              </x-primary-button>
            </div>
          </form>

          <!-- delete channel -->
          <div>
            <div class="relative border-b dark:border-gray-600 pb-4">
              <h1 class="text-lg font-bold">{{ __('Delete channel') }}</h1>
            </div>

            <div class="py-4">
              <p class="">{{ __('Deleting a channel is permanent. All messages and topics will be deleted. This is not recoverable.') }}</p>
            </div>

            <div>
              <x-danger-button
                dusk="destroy-form-button"
                hx-delete="{{ $data['url']['destroy'] }}"
                hx-confirm="{{ __('Are you sure you want to proceed? This can not be undone.') }}">
                {{ __('Delete channel') }}
              </x-danger-button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
