<x-scrollable.scrollable :dataset="$dataset">
    <x-scrollable.scroll-head>
        <tr>
            <th>
                <div class="d-flex align-items-center gap-2">
                    <span>Deposit Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="
                        fa-solid @if($orderBy == 'asc') 
                         fa-caret-up 
                        @else fa-caret-down @endif"> </i>
                </div>
            </th>
            <td class="right"> Bank</td>
            <td class="right"> Pickupt Code </td>
            <td class="right"> Deposit Amount </td>
            <td class="left"> Deposit Slip No </td>
            <td class="left">Location</td>
        </tr>
    </x-scrollable.scroll-head>
    {{ $slot }}
</x-scrollable.scrollable>
