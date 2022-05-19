<x-layout>
    {{-- when you pass the property to the child component, the value will be passed as it is
        in case you need to pass the value dynamically, use colon in front of property
        to tell Laravel to parse that correctly --}}
    <x-setting :heading="'Edit Post: ' . $post->title ">
        <form method="POST" action="/admin/posts/{{ $post->id }}" enctype="multipart/form-data">
            @csrf
            {{-- browser doesn't understand PATCH request
            hence we need to send a hint to the server
            so Laravel could know that this is a PATCH request --}}
            @method('PATCH')

            <x-form.input name="title" required :value="old('title', $post->title)"></x-form.input>
                                        {{-- if there is any fail validation when updating the post
                                            then reuse recently value
                                            if none then use the original value --}}
            <x-form.input name="slug" required :value="old('slug', $post->slug)"></x-form.input>

            <div class="flex mt-6">
                <div class="flex-1">
                    <x-form.input name="thumbnail" type="file" :value="old('thumbnail', $post->thumbnail)"></x-form.input>
                </div>

                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Blog Post illustration" class="rounded-xl ml-6" width="100">
            </div>

            <x-form.textarea name="excerpt">{{ old('excerpt', $post->excerpt) }}</x-form.textarea>

            <x-form.textarea name="body">{{ old('body', $post->body) }}</x-form.textarea>

            <x-form.field>
                <x-form.label name="category_id">Category</x-form.label>

                <select name="category_id" id="category_id">
                    @foreach (\App\Models\Category::all() as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}
                        >{{ $category->name }}</option>
                    @endforeach
                </select>

                <x-form.error name="category_id"></x-form.error>
            </x-form.field>

            <div class="flex mx-36 justify-around">
                @if ($post->status === "DRAFT")
                    <x-form.button name="status" value="DRAFT" option="draft">Save as Draft</x-form.button>
                @endif
                <x-form.button name="status" value="PUBLISHED">Update</x-form.button>
            </div>

        </form>
    </x-setting>
</x-layout>
