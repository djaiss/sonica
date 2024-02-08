<x-app-layout>
  <x-slot name="breadcrumb">
    <ul class="text-sm">
      <li class="inline after:content-['>'] after:text-gray-500 after:text-xs">
        <x-link href="{{ route('company.index') }}">{{ __('Company') }}</x-link>
      </li>
      <li class="inline">{{ __('Teams') }}</li>
    </ul>
  </x-slot>

  <div class="py-4 sm:py-12">
    <div class="mx-auto max-w-8xl px-2 sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white dark:bg-gray-800 rounded sm:rounded-lg">

        <!-- header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 border-b dark:border-gray-600 pb-2">
          <h1 class="font-semibold mb-2 sm:mb-0">{{ __('All the teams') }}</h1>

          <x-primary-link href="{{ route('team.new') }}" dusk="add-team-cta" class="text-sm">
            {{ __('Add a team') }}
          </x-primary-link>
        </div>

        <!-- list of teams -->
        @if (count($data['teams']) > 0)
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr>
                <th scope="col" class="px-2 py-1 sm:px-6 sm:py-3" width="60%">
                  {{ __('Team name') }}
                </th>
                <th scope="col" class="px-2 py-1 sm:px-6 sm:py-3">
                  {{ __('Members') }}
                </th>
                <th scope="col" class="px-2 py-1 sm:px-6 sm:py-3">
                  {{ __('Last activity') }}
                </th>
              </tr>
            </thead>
              <tbody>
                @foreach ($data['teams'] as $team)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <th scope="row" class="flex items-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <x-heroicon-o-lock-closed class="w-5 h-5 text-gray-400 mr-1" />
                    <x-link
                      dusk="team-{{ $team['id'] }}"
                      href="{{ route('team.show', $team['id']) }}">{{ $team['name'] }}</x-link>
                  </th>
                  <td class="px-6 py-4">
                    {{ $team['count'] }}
                  </td>
                  <td class="px-6 py-4">
                    {{ $team['last_active_at'] }}
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>

        @else

        <div class="flex flex-col items-center justify-center p-6">
          <div class="rounded-full bg-green-50 border border-green-500 dark:bg-gray-800 dark:border-gray-400 p-2 mb-3">
            <x-heroicon-o-users class="w-4 h-4 text-green-500 dark:text-gray-400" />
          </div>
          <p class="font-bold mb-1">
            {{ __('Create your first team.') }}
          </p>
          <p class="text-center">{{ __('A team brings together people who share a common purpose.') }}</p>
        </div>

        @endif
      </div>
    </div>
  </div>
</x-app-layout>
