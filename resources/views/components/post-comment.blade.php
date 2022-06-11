@props(['comment'])

<x-panel class="bg-gray-50">
    <article class="flex space-x-4">
        <div class="flex-shrink-0">
            <img src="{{ isset($comment->author->avatar) ? asset('storage/' . $comment->author->avatar) : asset('images/lary-avatar.svg') }}" alt="Your avatar" class="rounded-xl w-14 h-14">
        </div>

        <div>
            <header class="mb-4">
                <h3 class="font-bold">{{ $comment->author->name }}</h3>

                <p class="text-xs">
                    Posted on
                    <time>{{ $comment->created_at->format('F j, Y, g:i a') }}</time>
                </p>
            </header>
            <p>
                {{ $comment->body }}
            </p>
        </div>
    </article>
</x-panel>
