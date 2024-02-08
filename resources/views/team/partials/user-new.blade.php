<div class="mb-6 rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900 mt-4" x-data="{
  search: '',
  show: true,
  show_item(el) {
    return this.search === '' || el.textContent.toLowerCase().includes(this.search.toLowerCase())
  },
}" x-show="show">
  <!-- search -->
  <div class="border-b border-gray-200 p-2 dark:border-gray-700">
    <x-input-label for="search"
                  :value="__('Filter the list')" />

    <x-text-input class="mt-1 block w-full"
                  id="search"
                  name="search"
                  type="text"
                  @keydown.escape="show = false"
                  required
                  x-model="search"
                  autofocus />
  </div>

  <ul class="tag-list overflow-auto h-40 bg-white dark:bg-gray-900 rounded-b-lg">
    @forelse ($data['team']['users'] as $user)
    <li x-show="show_item($el)"
      hx-post="{{ $user['url']['store'] }}"
      hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
      hx-target="#user-list"
      @click="show = false"
      dusk="user-candidate-{{ $user['id'] }}"
      class="sm:flex cursor-pointer items-center border-b border-gray-200 px-3 py-2 hover:bg-slate-50 dark:border-gray-700 dark:bg-slate-900 hover:dark:bg-slate-800">
      <div class="flex">
        <x-avatar :data="$user['avatar']" class="w-5" />

        <span class="mr-3">{{ $user['name'] }}</span>
      </div>

      <span class="italic text-gray-500">{{ $user['email'] }}</span>
    </li>
    @empty
    <div class="text-gray-500 text-center py-4">
    {{ __('There are no other users.') }}
    </div>
    @endforelse
  </ul>
</div>
