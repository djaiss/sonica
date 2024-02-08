<x-app-layout>
  <x-slot name="breadcrumb">
    <ul class="text-sm">
      <li class="inline after:content-['>'] after:text-gray-500 after:text-xs">
        <x-link href="{{ route('message.index') }}">{{ __('Messages') }}</x-link>
      </li>
      <li class="inline after:content-['>'] after:text-gray-500 after:text-xs">
        <x-link href="{{ $data['channel']['url']['show'] }}">{{ $data['channel']['name'] }}</x-link>
      </li>
      <li class="inline">{{ $data['topic']['title'] }}</li>
    </ul>
  </x-slot>

  <div class="py-4 sm:py-12">
    <div class="mx-auto max-w-8xl px-4 sm:px-6 lg:px-8">
      <div class="message-grid grid grid-cols-1 gap-6">

        <!-- left -->
        <div>
          sldfjal
        </div>

        <!-- right -->
        <div class="p-0 sm:px-3 sm:py-0">
          <!-- topic title -->
          <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl">{{ $data['topic']['title'] }}</h1>
          </div>

          <!-- list of topics -->
          {{ $data['topic']['content'] }}
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
