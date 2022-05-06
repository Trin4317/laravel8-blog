@props(['name'])

<x-form.field>
    <x-form.label name="{{ $name }}"></x-form.label>

    <input class="border border-gray-200 p-2 w-full rounded"
        {{-- default type for input is text --}}
        name="{{ $name }}"
        id="{{ $name }}"
        required
        {{-- instead of hard coding value property to use old value
            now we add it to attributes for manipulating when needed --}}
        {{ $attributes(['value' => old($name)]) }}
    >

    <x-form.error name="{{ $name }}"></x-form.error>
</x-form.label>
