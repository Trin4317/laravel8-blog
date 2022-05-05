@props(['name'])

<label class="block mb-2 uppercase font-bold text-xs text-gray-700"
        for="{{ $name }}">
        @if (strlen($slot) > 0)
            {{ $slot }}
        @else
            {{ ucwords($name) }}
        @endif
</label>
