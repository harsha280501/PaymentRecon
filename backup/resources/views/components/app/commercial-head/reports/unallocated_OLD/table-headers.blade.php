<x-scrollable.scrollable :dataset="$dataset">
    <x-scrollable.scroll-head>
        @if($activeTab == 'cash')
        <tr>
            <th>
                <div class="d-flex align-items-center gap-2">
                    <span>Deposit Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="
                                fa @if($orderBy == 'asc') 
                                 fa-caret-up 
                                @else fa-caret-down @endif"> </i>
                </div>
            </th>
            <td class="left"> Pickupt Code </td>
            <td class="left"> Deposit Slip No </td>
            <td class="left"> Collection Bank</td>
            <td class="left">Location</td>
            <td class="right"> Deposit Amount </td>
        </tr>
        @endif
        @if($activeTab == 'card')
        <tr>
            <th>
                <div class="d-flex align-items-center gap-2 left">
                    <span>Deposit Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="
                                fa-solid @if($orderBy == 'asc') 
                                 fa-caret-up 
                                @else fa-caret-down @endif"> </i>
                </div>
            </th>
            <td class="left"> TID/MID </td>
            <td class="left"> Collection Bank</td>
            <td class="right"> Deposit Amount </td>

        </tr>
        @endif

        @if($activeTab == 'upi')
        <tr>
            <th>
                <div class="d-flex align-items-center gap-2 left">
                    <span>Deposit Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="
                                fa-solid @if($orderBy == 'asc') 
                                 fa-caret-up 
                                @else fa-caret-down @endif"> </i>
                </div>
            </th>
            <td class="left"> TID </td>
            <td class="left"> Collection Bank</td>
            <td class="right"> Deposit Amount </td>

        </tr>
        @endif

        @if($activeTab == 'wallet')

        <tr>
            <th>
                <div class="d-flex align-items-center gap-2 left">
                    <span>Deposit Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="
                            fa-solid @if($orderBy == 'asc') 
                             fa-caret-up 
                            @else fa-caret-down @endif"> </i>
                </div>
            </th>
            <td class="left"> MID/TID </td>
            <td class="leftleft"> Collection Bank</td>
            <td class="left"> Store Name </td>
            <td class="right"> Deposit Amount </td>

        </tr>
        @endif



    </x-scrollable.scroll-head>
    {{ $slot }}
</x-scrollable.scrollable>
