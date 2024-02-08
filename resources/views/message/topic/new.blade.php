<x-app-layout>
  <x-slot name="breadcrumb">
    <ul class="text-sm">
      <li class="inline after:content-['>'] after:text-gray-500 after:text-xs">
        <x-link href="{{ route('message.index') }}">{{ __('Messages') }}</x-link>
      </li>
      <li class="inline after:content-['>'] after:text-gray-500 after:text-xs">
        <x-link href="{{ $data['channel']['url']['show'] }}">{{ $data['channel']['name'] }}</x-link>
      </li>
      <li class="inline">{{ __('Create a topic') }}</li>
    </ul>
  </x-slot>

  <div class="py-4 sm:py-12">
    <div class="mx-auto max-w-xl px-2">
      <div class="overflow-hidden bg-white dark:bg-gray-800 rounded sm:rounded-lg p-1">
        <form method="POST" action="{{ $data['channel']['url']['store'] }}">
          @csrf

          <div class="relative border-b dark:border-gray-600 py-4">
            <h1 class="text-lg font-bold">{{ __('Create a topic') }}</h1>
          </div>

          <div>
            <div class="flex">
              <div class="mr-2 top-5 relative">
                <x-avatar :data="$data['user']['avatar']" class="w-8" />
              </div>

              <div class="w-full">
                <!-- name -->
                <div class="relative py-4">
                  <x-input-label for="title"
                                :value="__('What is the name of the topic?')" />

                  <x-text-input class="mt-1 block w-full"
                                id="title"
                                name="title"
                                type="text"
                                required
                                autofocus />

                  <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <!-- content -->
                <div class="relative pt-2 pb-4">
                  <x-input-label for="content"
                                :value="__('Description')" />

                  <x-textarea id="content"
                            name="content"
                            required
                            :height="'min-h-[300px]'"
                            class="mt-2 block w-full"
                            type="text">{{ old('content') }}</x-textarea>

                  <x-input-error class="mt-2" :messages="$errors->get('content')" />
                </div>
              </div>
            </div>

            <!-- who to notify -->
            <div class="w-full border-t dark:border-gray-600 py-4">
              <h2 class="flex items-center font-bold"><x-heroicon-o-bell-alert class="h-4 w-4 mr-2" /> Notifications</h2>
              <p class="text-sm">Regardless of the option you chose, channel members will still see the Unread indicator on the list of topics.</p>
<div id="editorjs"  />
            </div>
          </div>

          <!-- actions -->
          <div class="flex items-center justify-between border-t dark:border-gray-600 py-4">
            <x-link href="{{ $data['channel']['url']['show'] }}">{{ __('Back') }}</x-link>

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
