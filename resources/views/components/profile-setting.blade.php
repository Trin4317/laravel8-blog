@props(['heading'])

<section class="px-6 py-8 max-w-4xl mx-auto">
    <h1 class="text-lg font-bold mb-8 pb-2 border-b">
        {{ $heading }}
    </h1>

    <div class="flex">
        <aside class="w-48 flex-shrink-0">
            <h4 class="font-semibold mb-2">Links</h4>

            <ul>
                <li>
                    <a href="/profile/follow" class="{{ request()->is('profile/follow') ? 'text-blue-500' : '' }}">Followship</a>
                </li>

                <li>
                    <a href="/profile/bookmark" class="{{ request()->is('profile/bookmark') ? 'text-blue-500' : '' }}">Bookmarks</a>
                </li>
            </ul>
        </aside>

        <main class="flex-1">
            <x-panel>
                {{ $slot }}
            </x-panel>
        </main>
    </div>

</section>
