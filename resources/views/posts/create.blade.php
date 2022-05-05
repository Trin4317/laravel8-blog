<x-layout>
    <section class="px-6 py-8 max-w-md mx-auto">
        <h1 class="text-lg font-bold mb-4">
            Publish New Post
        </h1>
        <x-panel>
            <form method="POST" action="/admin/posts" class="mt-1" enctype="multipart/form-data">
                @csrf

                <x-form.input name="title"></x-form.input>

                <x-form.input name="slug"></x-form.input>

                <x-form.input name="thumbnail" type="file"></x-form.input>

                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        for="excerpt">
                        Excerpt
                    </label>

                    <textarea class="border border-gray-400 p-2 w-full"
                        name="excerpt"
                        id="excerpt"
                        required
                    >{{ old('excerpt') }}</textarea>

                    @error('excerpt')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        for="body">
                        Body
                    </label>

                    <textarea class="border border-gray-400 p-2 w-full"
                        name="body"
                        id="body"
                        required
                    >{{ old('body') }}</textarea>

                    @error('body')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        for="category_id">
                        Category
                    </label>

                    <select name="category_id" id="category_id">
                        @foreach (\App\Models\Category::all() as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}
                            >{{ $category->name }}</option>
                        @endforeach
                    </select>

                    @error('category')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <x-submit-button>Publish</x-submit-button>

            </form>
        </x-panel>
    </section>
</x-layout>
