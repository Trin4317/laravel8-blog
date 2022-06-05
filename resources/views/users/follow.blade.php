<x-layout>
    <x-profile-setting heading="My Profile">
        <main class="mx-auto">
            <x-tabs active="Following">
                <x-tab name="Following">
                    <ul>
                        @foreach ($followings as $following)
                            <li class="flex justify-between px-24 mb-3">
                                    {{ $following->name }}
                                    <form method="POST" action="/profile/unfollow/{{ $following->id }}">
                                        @csrf
                                        <button type="submit" class="w-6 h-6 rounded-full bg-red-500 text-white">✕</button>
                                    </form>
                            </li>
                        @endforeach
                    </ul>
                </x-tab>
                <x-tab name="Follower">
                    <ul>
                        @foreach ($followers as $follower)
                            <li class="flex justify-between px-24 mb-3">{{ $follower->name }}</li>
                        @endforeach
                    </ul>
                </x-tab>
            </x-tabs>
        </main>
    </x-profile-setting>
</x-layout>
