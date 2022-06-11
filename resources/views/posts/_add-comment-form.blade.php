@auth
    <x-panel>
        <form method="POST" action="/post/{{ $post->slug }}/comment">
            @csrf

            <header class="flex items-center">
                <img src="{{ isset(auth()->user()->avatar) ? asset('storage/' . auth()->user()->avatar) : asset('images/lary-avatar.svg') }}" alt="Your avatar" class="rounded-xl w-14 h-14">

                <h2 class="ml-4">Want to participate?</h2>
            </header>

            <div class="mt-4">
                <textarea
                    name="body"
                    class="w-full text-sm focus:outline-none focus:ring border border-gray-200"
                    placeholder="Say something!"
                    cols="30"
                    rows="10"
                    required
                ></textarea>

                @error('body')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end mt-4 pt-4 border-t border-gray-200">
                <x-form.button>Post Comment</x-form.button>
            </div>
        </form>
    </x-panel>
@else
    <p class="font-semibold">
        <a href="/register" class="hover:underline">Register</a> or <a href="/login" class="hover:underline">Log in</a> to leave a comment.
    </p>
@endauth
