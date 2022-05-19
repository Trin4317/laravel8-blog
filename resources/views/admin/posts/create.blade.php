<x-layout>
    <x-setting heading="Publish New Post">
        <form method="POST" action="/admin/posts" enctype="multipart/form-data">
            @csrf

            <x-form.input name="title" required></x-form.input>

            <x-form.input name="slug" required></x-form.input>

            <x-form.input name="thumbnail" type="file" required></x-form.input>

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

            <div class="flex mx-36 justify-between">
                <x-form.button name="status" value="DRAFT" option="draft">Save as Draft</x-form.button>
                <x-form.button name="status" value="PUBLISHED" >Publish</x-form.button>
            </div>

        </form>
    </x-setting>
</x-layout>
