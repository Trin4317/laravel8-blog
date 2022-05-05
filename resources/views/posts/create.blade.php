<x-layout>
    <section class="px-6 py-8 max-w-md mx-auto">
        <h1 class="text-lg font-bold mb-4">
            Publish New Post
        </h1>
        <x-panel>
            <form method="POST" action="/admin/posts" enctype="multipart/form-data">
                @csrf

                <x-form.input name="title"></x-form.input>

                <x-form.input name="slug"></x-form.input>

                <x-form.input name="thumbnail" type="file"></x-form.input>

                <x-form.textarea name="excerpt"></x-form.textarea>

                <x-form.textarea name="body"></x-form.textarea>

                <x-form.field>
                    <x-form.label name="category_id">Category</x-form.label>

                    <select name="category_id" id="category_id">
                        @foreach (\App\Models\Category::all() as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}
                            >{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <x-form.error name="category_id"></x-form.error>
                </x-form.field>

                <x-submit-button>Publish</x-submit-button>

            </form>
        </x-panel>
    </section>
</x-layout>
