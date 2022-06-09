<x-layout>
    <x-profile-setting heading="My Profile">
        <main class="mx-auto">
            <form method="POST" action="/profile/update" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <x-form.input name="name" :value="old('name', $user->name)" required></x-form.input>

                <x-form.input name="username" :value="old('username', $user->username)" required></x-form.input>

                <x-form.input name="email" type="email" :value="old('email', $user->email)" required></x-form.input>

                <div class="flex mt-6">
                    <div class="flex-1">
                        <x-form.input name="avatar" type="file" :value="old('avatar', $user->avatar)"></x-form.input>
                    </div>

                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Your avatar" class="rounded-xl ml-6" width="100">
                </div>

                <div class="flex mx-36 justify-around">
                    <x-form.button>Update</x-form.button>
                </div>

            </form>
        </main>
    </x-profile-setting>
</x-layout>
