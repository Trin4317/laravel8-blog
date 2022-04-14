@props(['posts'])

<x-post-featured-card :post="$posts[0]"/>

@if ($posts->count() > 1)
    {{-- make a gird of 6 columns --}}
    <div class="lg:grid lg:grid-cols-6">
        @foreach ($posts->skip(1) as $post)
            {{-- for the first 2 posts, span 3 columns --}}
            {{-- span 2 columns for the rest --}}
            <x-post-card
                :post="$post"
                class="{{ $loop->iteration < 3 ? 'col-span-3' : 'col-span-2' }}"
            />
        @endforeach
    </div>
@endif
