<x-app-layout>
  <div class="py-4 sm:py-12">
    <div class="mx-auto max-w-8xl px-4 sm:px-6 lg:px-8">
      <div class="message-grid grid grid-cols-1 gap-6">

        <!-- left -->
        <div>
          @include('message.partials.sidebar')
        </div>

        <!-- right -->
        <div class="p-0 sm:px-3 sm:py-0">
          <!-- channel title -->
          <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl flex items-center">
              {{ $data['channel']['name'] }}

              @if (! $data['channel']['is_public'])
              <x-heroicon-o-lock-closed class="w-4 h-4 text-gray-500 ml-2" />
              @endif
            </h1>

            <!-- actions -->
            <div class="flex">
              <x-primary-link dusk="add-topic-cta" href="{{ $data['channel']['url']['new'] }}" class="text-sm mr-2">
                {{ __('New topic') }}
              </x-primary-link>

              <div x-data="{ dropdownOpen: false }" class="relative">

                <div @click="dropdownOpen=true" dusk="channel-menu-options" class="px-2 py-1 inline-flex items-center justify-center whitespace-nowrap rounded-md font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 border border-gray-300 bg-transparent shadow-sm hover:bg-accent hover:text-accent-foreground ease-in-out duration-150 hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:hover:text-gray-800 cursor-pointer">
                  <x-heroicon-o-ellipsis-horizontal class="w-5 h-5 text-gray-500" />
                </div>

                <div x-show="dropdownOpen"
                  @click.away="dropdownOpen=false"
                  x-transition:enter="ease-out duration-200"
                  x-transition:enter-start="-translate-y-2"
                  x-transition:enter-end="translate-y-0"
                  class="absolute top-0 z-50 w-56 mt-8 -translate-x-1/2 -right-28"
                  x-cloak>
                  <div class="p-1 mt-1 bg-white border rounded-md shadow-md border-neutral-200/70 text-neutral-700">
                    <div class="relative flex cursor-default select-none hover:bg-neutral-100 items-center rounded px-2 py-1.5 text-sm outline-none transition-colors data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                      <x-heroicon-o-pencil-square class="w-4 h-4 mr-2" />
                      <a href="{{ $data['channel']['url']['edit'] }}" dusk="edit-channel-link">{{ __('Edit channel') }}</a>
                      <span class="ml-auto text-xs tracking-widest opacity-60">⌘E</span>
                    </div>
                    <div class="relative flex cursor-default select-none hover:bg-neutral-100 items-center rounded px-2 py-1.5 text-sm outline-none transition-colors data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                      <x-heroicon-o-arrow-left-on-rectangle class="w-4 h-4 mr-2" />
                      <span>{{ __('Leave channel') }}</span>
                      <span class="ml-auto text-xs tracking-widest opacity-60">⌘E</span>
                    </div>
                    <div class="h-px my-1 -mx-1 bg-neutral-200"></div>
                    <div class="text-red-700 relative flex cursor-default select-none hover:bg-neutral-100 items-center rounded px-2 py-1.5 text-sm outline-none transition-colors data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                      <x-heroicon-o-trash class="w-4 h-4 mr-2" />
                      <a href="{{ $data['channel']['url']['edit'] }}" dusk="delete-channel-link">{{ __('Delete channel') }}</a>
                      <span class="ml-auto text-xs tracking-widest opacity-60">⌘E</span>
                    </div>
                  </div>
                </div>
            </div>
            </div>
          </div>

          <!-- channel members & channel description -->
          <div class="mb-6 flex">

            <div class="flex -space-x-4 rtl:space-x-reverse">
              @foreach ($data['channel']['users'] as $user)
              <x-avatar :data="$user['avatar']" class="w-8 h-8 border-2 border-white rounded-full dark:border-gray-800" />
              @endforeach
            </div>

            @if ($data['channel']['description'])
            <p class="text-gray-500 dark:text-gray-400">{{ $data['channel']['description'] }}</p>
            @endif
          </div>

          <!-- list of topics -->
          @forelse ($data['channel']['topics'] as $topic)
          <div class="flex items-center group justify-between hover:bg-blue-50 dark:hover:bg-gray-600 hover:border-l-blue-300 hover:border-l-2 border border-l-2 border-transparent sm:px-3 py-2">
            <div class="flex w-full">
              <x-avatar :data="$topic['user']['avatar']" class="w-6 h-6 sm:w-12 sm:h-12 rounded-full mr-3" />
              <div>
                <div>
                  <x-link href="{{ $topic['url']['show'] }}" class="mr-2">{{ $topic['title'] }}</x-link>
                  <p class="block sm:hidden text-sm my-1">{{ $topic['created_at'] }}</p>
                </div>
                <p class="text-sm">{{ $topic['content'] }}</p>
              </div>
            </div>
            <div class="w-24 text-right text-sm text-gray-500 dark:text-gray-300 hidden sm:inline">
              <p class="group-hover:inline hidden transition delay-150">{{ $topic['created_at'] }}</p>
              <p class="group-hover:hidden">{{ $topic['created_at_human_format'] }}</p>
            </div>
          </div>
          @empty
          <div class="flex flex-col items-center justify-center p-6">
            <div class="rounded-full bg-green-50 border border-green-500 dark:bg-gray-800 dark:border-gray-400 p-2 mb-3">
              <x-heroicon-o-inbox class="w-4 h-4 text-green-500 dark:text-gray-400" />
            </div>
            <p class="font-bold mb-1">
              {{ __('Create your first topic.') }}
            </p>
            <p class="text-center">{{ __('Topics help focus the conversation with team members.') }}</p>
          </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
