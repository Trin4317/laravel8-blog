@php
    $classes = "text-white uppercase font-semibold text-xs py-2 px-10 mt-2 rounded-2xl";

    if (!isset($attributes['option'])) {
        $classes .= " bg-blue-500 hover:bg-blue-600";
    }
    if ($attributes['option'] === 'draft') {
        $classes .= " bg-yellow-500 hover:bg-yellow-600";
    }
    if ($attributes['option'] === 'unfollow') {
        $classes .= " bg-red-500 hover:bg-red-600";
    }
@endphp

<x-form.field>
    <button type="submit"
            {{ $attributes->merge([ 'class' => $classes ]) }}
    >
        {{ $slot }}
    </button>
</x-form.field>
