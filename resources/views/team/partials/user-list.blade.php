@foreach ($data['team']['users'] as $user)
<div class="flex justify-between text-sm px-2 py-1 first:border-t-0 border-b hover:bg-blue-50 dark:hover:bg-gray-600">
  <x-link :boost="false" href="{{ $user['url']['show'] }}">{{ $user['name'] }}</x-link>

  @if ($data['team']['is_part_of_team'] && $user['can_destroy'])
  <x-htmx-link
    dusk="remove-member-{{ $user['id'] }}"
    hx-delete="{{ $user['url']['destroy'] }}"
    hx-confirm="{{ __('Are you sure you want to proceed? This can not be undone.') }}"
    >{{ __('Remove') }}</x-htmx-link>
  @endif
</div>
@endforeach
