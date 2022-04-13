<x-layout>
    <article>
        <h1>{{ $post->title }}</h1>

        <p>
            By <a href="#">{{ $post->author->name }}</a> in <a href="/category/{{ $post->category->slug }}">{{ $post->category->name }}</a>
        </p>

        <div>
            {!! $post->body !!}
        </div>
    </article>
    <a href="/">Go back</a>
</x-layout>
