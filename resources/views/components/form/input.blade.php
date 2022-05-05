@props(['name'])

<x-form.field>
    <x-form.label name="{{ $name }}"></x-form.label>

    <input class="border border-gray-200 p-2 w-full rounded"
        {{-- default type for input is text --}}
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name) }}"
        required
        {{-- accept all attributes without explicitly defining it in @props --}}
        {{ $attributes }}
    >

    <x-form.error name="{{ $name }}"></x-form.error>
</x-form.label>
