<x-app-layout>
  <div class="py-4 sm:py-12">
    <div class="mx-auto max-w-2xl px-2 sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 rounded sm:rounded-lg p-6">
        <ul>
          @foreach ($data['users'] as $user)
          <li class="">
            <x-link
              dusk="user-{{ $user['id'] }}"
              href="{{ route('user.show', $user['id']) }}">{{ $user['name'] }}</x-link>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</x-app-layout>
