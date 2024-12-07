<x-scrollable.scrollable :dataset="$dataset">
    <x-scrollable.scroll-head>
        <tr>
            <th class="left">
                <div class="d-flex align-items-center gap-2">
                    <span>Sale Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>
            <td class="right"> Store ID </td>
            <td class="right"> RETEK Code </td>
            <td class="right"> Brand Desc </td>
            <td class="right">City</td>
            <td style="text-align: right !important" class="left"> Cash </td>

        </tr>
    </x-scrollable.scroll-head>
    {{ $slot }}
</x-scrollable.scrollable>
