<div x-data="{ open: @json($data['team']['show_actions']) }">
  <div x-show="!open" @click="open = ! open" hx-swap="none" hx-put="{{ $data['team']['url']['toggle_actions'] }}" hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}' class="flex items-center mr-2 cursor-pointer">
    <x-heroicon-o-chevron-right class="w-4 h-4 mr-1 text-gray-500" />
    <h2 class="font-semibold">{{ __('Actions') }}</h2>
  </div>

  <div x-show="open" @click="open = ! open" hx-swap="none" hx-put="{{ $data['team']['url']['toggle_actions'] }}" hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}' class="flex items-center mb-2 pb-1 border-b mr-2 cursor-pointer">
    <x-heroicon-o-chevron-down class="w-4 h-4 mr-1 text-gray-500" />
    <h2 class="font-semibold">{{ __('Actions') }}</h2>
  </div>

  <div x-cloak x-show="open" x-transition>
    <ul class="text-sm">
      <li class="mb-1">
        <x-link href="{{ route('team.edit', ['team' => $data['team']['id']]) }}" dusk="edit-team">{{ __('Edit team details') }}</x-link>
      </li>
      <li>
        <x-htmx-link
          dusk="delete-team"
          hx-delete="{{ route('team.destroy', $data['team']['id']) }}"
          hx-confirm="{{ __('Are you sure you want to proceed? This can not be undone.') }}"
          >{{ __('Delete') }}</x-htmx-link>
      </li>
    </ul>
  </div>
</div>
