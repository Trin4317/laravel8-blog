@props(['active'])

<div x-data="{
        activeTab: '{{ $active }}',
        tabs: [],
        tabHeadings: [],
        getName(tab) {
            return eval(`(${tab.getAttribute('x-data')})`)['name'];
        }

    }"
    x-init="() => {
        tabs = [...$refs.tabs.children];
        tabHeadings = tabs.map(tab => getName(tab));
    }"
>
    <div class="flex mb-3 mt-3">
        <template x-for="(tab, index) in tabHeadings" :key="index">
            <button x-text="tab"
                @click="activeTab = tab;"
                class="py-1 w-1/2 text-sm rounded hover:bg-blue-500 hover:text-white"
                :class="tab === activeTab ? 'bg-blue-500 text-white' : 'text-gray'"
                role="tab"
                :aria-selected="tab === activeTab"
            ></button>
        </template>
    </div>

    <div x-ref="tabs">
        {{ $slot }}
    </div>
</div>
