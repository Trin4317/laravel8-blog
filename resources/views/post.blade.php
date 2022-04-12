<x-layout>
    <article>
        <h1>{{ $post->title }}</h1>

        <p>
            <a href="/category/{{ $post->category->slug }}">{{ $post->category->name }}</a>
        </p>

        <div>
            {!! $post->body !!}
        </div>
    </article>
    <a href="/">Go back</a>
</x-layout>
