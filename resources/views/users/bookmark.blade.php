<x-layout>
    <x-profile-setting heading="My Profile">
        <main class="mx-auto">
            <ul>
                @foreach ($bookmarks as $bookmark)
                    <li class="flex justify-between px-24 mb-3">
                            <a href="/post/{{ $bookmark->slug }}" class="hover:text-blue-500">{{ $bookmark->title }}</a>
                            <form method="POST" action="/profile/unbookmark/{{ $bookmark->id }}">
                                @csrf
                                <button type="submit" class="w-6 h-6 rounded-full bg-red-500 text-white">✕</button>
                            </form>
                    </li>
                @endforeach
            </ul>
        </main>
    </x-profile-setting>
</x-layout>
