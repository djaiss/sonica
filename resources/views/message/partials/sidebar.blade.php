<!-- menu -->
<ul class="border-b pb-2 mb-4">
  <li class="flex items-center hover:bg-blue-50 dark:hover:bg-gray-600 hover:border-l-blue-300 hover:border-l-2 border border-l-2 border-transparent px-2 py-1 rounded-sm">
    <x-heroicon-o-book-open class="w-4 h-4 text-gray-500 mr-2" />
    <span>{{ __('New') }}</span>
  </li>
  <li class="flex items-center hover:bg-blue-50 dark:hover:bg-gray-600 hover:border-l-blue-300 hover:border-l-2 border border-l-2 border-transparent px-2 py-1 rounded-sm">
    <x-heroicon-o-star class="w-4 h-4 text-gray-500 mr-2" />
    <span>{{ __('Favorited') }}</span>
  </li>
</ul>

<!-- channels -->
<div>
  <!-- header + cta -->
  <div class="flex justify-between items-center">
    <p class="text-xs">{{ __('Channels') }}</p>
    <x-link dusk="add-channel-cta" href="{{ route('channel.new') }}" class="p-1 hover:bg-gray-200 rounded-md">
      <x-heroicon-o-plus-small class="w-4 h-4 text-gray-500 cursor-pointer" />
    </x-link>
  </div>

  <ul>
    @forelse ($data['layout']['channels'] as $channel)
    <li class="{{ request()->is('channels/'.$channel['id']) ? 'bg-blue-50 dark:bg-gray-600 border-l-blue-300 border-l-2' : '' }} flex items-center hover:bg-blue-50 dark:hover:bg-gray-600 hover:border-l-blue-300 hover:border-l-2 border border-l-2 border-transparent px-2 py-1 rounded-sm">
      <x-heroicon-o-hashtag class="w-3 h-3 text-gray-500 mr-1" />
      <x-link href="{{ $channel['url']['show'] }}">{{ $channel['name'] }}</x-link>

      @if (! $channel['is_public'])
      <x-heroicon-o-lock-closed class="w-3 h-3 text-gray-500 ml-1" />
      @endif
    </li>
    @empty
    <div class="flex flex-col items-center justify-center p-6">
      <div class="rounded-full bg-green-50 border border-green-500 dark:bg-gray-800 dark:border-gray-400 p-2 mb-3">
        <x-heroicon-o-briefcase class="w-4 h-4 text-green-500 dark:text-gray-400" />
      </div>
      <p class="">
        {{ __('Create your first channel to get started.') }}
      </p>
    </div>
    @endforelse
  </ul>
</div>
