<x-app-layout>
  <x-slot name="breadcrumb">
    <ul class="text-sm">
      <li class="inline after:content-['>'] after:text-gray-500 after:text-xs">
        <x-link href="{{ route('company.index') }}">{{ __('Company') }}</x-link>
      </li>
      <li class="inline after:content-['>'] after:text-gray-500 after:text-xs">
        <x-link href="{{ route('team.index') }}">{{ __('Teams') }}</x-link>
      </li>
      <li class="inline">{{ $data['team']['name'] }}</li>
    </ul>
  </x-slot>

  <div class="py-4 sm:py-12">
    <div class="mx-auto max-w-8xl px-4 sm:px-6 lg:px-8">
      <div class="team-grid grid grid-cols-1 gap-6">

        <!-- left -->
        <div>
          <!-- name -->
          <div class="flex items-center mb-2">
            <h1 class="text-2xl mr-1 font-semibold">{{ $data['team']['name'] }}</h1>

            @if (! $data['team']['is_public'])
            <x-tooltip text="{{ __('The team is private') }}">
              <x-heroicon-o-lock-closed class="w-4 h-4 text-gray-500" />
            </x-tooltip>
            @endif
          </div>

          <!-- description -->
          @if ($data['team']['description'])
          <p class="mb-4">{{ $data['team']['description'] }}</p>
          @else
          <p class="text-gray-500 mb-4 text-sm">{{ __('There are no description for now.') }}</p>
          @endif

          <!-- actions -->
          @if ($data['team']['is_part_of_team'])
          @include('team.partials.actions')
          @endif
        </div>

        <!-- right -->
        <div class="p-0 sm:px-3 sm:py-0">
          <!-- members -->
          <div hx-target="#user-list" hx-swap="innerHTML" hx-get="{{ route('team.member.index', ['team' => $data['team']['id']]) }}" hx-trigger="loadMembers from:body">
            <!-- title -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b dark:border-gray-600 pb-2">
              <h1 class="font-semibold mb-2 sm:mb-0">{{ __('Members') }}</h1>

              @if ($data['team']['is_part_of_team'])
              <x-primary-button
                hx-get="{{ route('team.member.new', ['team' => $data['team']['id']]) }}"
                hx-target="#add-user-list"
                dusk="add-user-cta" class="text-sm">
                {{ __('Add a member') }}
              </x-primary-button>
              @endif
            </div>

            <div id="add-user-list">
            </div>

            <!-- list -->
            <div id="user-list">
              @fragment('user-list')
              @include('team.partials.user-list')
              @endfragment
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
