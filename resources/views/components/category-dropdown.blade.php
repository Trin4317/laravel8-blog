<x-dropdown>
    {{-- this section will go into $trigger --}}
    <x-slot name="trigger">
        <button class="py-2 pl-3 pr-9 text-sm font-semibold w-full lg:w-32 text-left flex lg:inline-flex">
            {{ isset($currentCategory) ? $currentCategory->name : 'Categories' }}

            <x-icon name="down-arrow" class="absolute pointer-events-none" style="right: 12px;"></x-icon>
        </button>
    </x-slot>
    {{-- below section will go into default $slot of dropdown component --}}
    @if (isset($currentCategory))
        <x-dropdown-item href="/">All</x-dropdown-item>
    @endif

    @foreach ( $categories as $category)
        <x-dropdown-item
            {{-- if the current URL has query string other than "category"
                then include it to the link for each category
                to filter multiple values --}}
            href="?category={{ $category->slug }}&{{ http_build_query(request()->except('category')) }}"
            :active="$category->is($currentCategory)"
        >{{ $category->name }}
        </x-dropdown-item>
    @endforeach
</x-dropdown>
