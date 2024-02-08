<ul class="border-b pb-2 mb-4">
  <li class="{{ request()->is('channels/'.$data['id'].'/edit') ? 'bg-blue-50 dark:bg-gray-600 border-l-blue-300 border-l-2' :  '' }} flex items-center hover:bg-blue-50 dark:hover:bg-gray-600 hover:border-l-blue-300 hover:border-l-2 border border-l-2 border-transparent px-2 py-1 rounded-sm">
    <x-heroicon-o-cog class="w-4 h-4 text-gray-500 mr-2" />
    <x-link href="{{ route('channel.edit', ['channel' => $data['id']]) }}">{{ __('General') }}</x-link>
  </li>
  <li class="{{ request()->is('channels/'.$data['id'].'/edit/users') ? 'bg-blue-50 dark:bg-gray-600 border-l-blue-300 border-l-2' :  '' }} flex items-center hover:bg-blue-50 dark:hover:bg-gray-600 hover:border-l-blue-300 hover:border-l-2 border border-l-2 border-transparent px-2 py-1 rounded-sm">
    <x-heroicon-o-users class="w-4 h-4 text-gray-500 mr-2" />
    <x-link href="{{ route('channel.user.edit', ['channel' => $data['id']]) }}">{{ __('Members') }}</x-link>
  </li>
</ul>
