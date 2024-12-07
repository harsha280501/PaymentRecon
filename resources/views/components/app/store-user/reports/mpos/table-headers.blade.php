<x-scrollable.scrollable :dataset="$dataset">
    <x-scrollable.scroll-head>
        <tr>
            <th colspan="4">
                <div class="d-flex align-items-center gap-2">
                    <span>{{ config('constants.StoreVariables.SalesDate') }}</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                        class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>
            <th colspan="1" style="text-align: right !important"> Cash </th>
            <th colspan="6">
            </th>
        </tr>
    </x-scrollable.scroll-head>
    {{ $slot }}
</x-scrollable.scrollable>