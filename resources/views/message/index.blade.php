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
            <h1 class="text-2xl">Title of the channel</h1>
            <x-primary-button class="text-sm">
              {{ __('New message') }}
            </x-primary-button>
          </div>

          <!-- list of topics -->
          <div class="flex items-center group justify-between hover:bg-blue-50 dark:hover:bg-gray-600 hover:border-l-blue-300 hover:border-l-2 border border-l-2 border-transparent sm:px-3 py-2">
            <div class="flex w-full">
              <img src="https://d10oy3rrrp8hu2.cloudfront.net/09655bd2e4d2137ad3d4ddb2800dd6df_s195.jpg" class="w-6 h-6 sm:w-12 sm:h-12 rounded-full mr-3" />
              <div>
                <div class="flex items-center">
                  <h2 class="font-bold mr-2">This is a title</h2>
                  <span class="font-mono text-xs border border-gray-200 bg-gray-100 dark:bg-gray-500 dark:border-gray-400 rounded-lg px-2 py-0"># channel name</span>
                </div>
                <p class="text-sm">Dolore eiusmod dolor et cupidatat consequat duis minim non sunt proident voluptate eiusmod fugiat.</p>
              </div>
            </div>
            <div class="w-24 text-right text-sm text-gray-500 dark:text-gray-300">
              <p class="group-hover:inline hidden transition delay-150">31/02/12</p>
              <p class="group-hover:hidden">21 days ago</p>
            </div>
          </div>
          <div class="flex items-center group justify-between hover:bg-blue-50 dark:hover:bg-gray-600 hover:border-l-blue-300 hover:border-l-2 border border-l-2 border-transparent px-3 py-2">
            <div class="flex w-full">
              <img src="https://d10oy3rrrp8hu2.cloudfront.net/09655bd2e4d2137ad3d4ddb2800dd6df_s195.jpg" class="w-12 h-12 rounded-full mr-3" />
              <div>
                <h2 class="font-bold">This is a title</h2>
                <p class="text-sm">Dolore eiusmod dolor et cupidatat consequat duis minim non sunt proident voluptate eiusmod fugiat.</p>
              </div>
            </div>
            <div class="w-24 text-right text-sm text-gray-500">
              <p class="group-hover:inline hidden transition delay-150">31/02/12</p>
              <p class="group-hover:hidden">21 days ago</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
