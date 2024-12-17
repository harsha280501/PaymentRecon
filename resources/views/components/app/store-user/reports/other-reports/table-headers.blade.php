<x-scrollable.scrollable :dataset="$dataset">
    <x-scrollable.scroll-head>


        @if($activeTab == 'overall-summary')

        <tr>
            <th colspan="1"></th>
            <th style="background: rgba(253, 253, 253, 0.493)" colspan="1"></th>
            <th colspan="4">Opening Balance</th>
            <th style="background: rgba(253, 253, 253, 0.493)" colspan="4">Sales</th>
            <th colspan="4">Collection</th>
            <th style="background: rgba(253, 253, 253, 0.493)" colspan="4">Closing Balance</th>
        </tr>

        <tr>
            <th>Retek Code</th>
            <th style="background: rgba(253, 253, 253, 0.493)">
                <div class="d-flex align-items-center gap-2">
                    <span>{{ (($startdate != null && $enddate != null) && ($startdate == $enddate)) ? 'Date' :
                        'Month'}}</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                        class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>
            <th style="text-align: right !important">Cash</th>
            <th style="text-align: right !important">Card</th>
            <th style="text-align: right !important">UPI</th>
            <th style="text-align: right !important">Wallet</th>
            <th style="text-align: right !important; background: rgba(253, 253, 253, 0.493)">Cash</th>
            <th style="text-align: right !important; background: rgba(253, 253, 253, 0.493)">Card</th>
            <th style="text-align: right !important; background: rgba(253, 253, 253, 0.493)">UPI</th>
            <th style="text-align: right !important; background: rgba(253, 253, 253, 0.493)">Wallet</th>
            <th style="text-align: right !important">Cash</th>
            <th style="text-align: right !important">Card</th>
            <th style="text-align: right !important">UPI</th>
            <th style="text-align: right !important">Wallet</th>
            <th style="text-align: right !important; background: rgba(253, 253, 253, 0.493)">Cash</th>
            <th style="text-align: right !important; background: rgba(253, 253, 253, 0.493)">Card</th>
            <th style="text-align: right !important; background: rgba(253, 253, 253, 0.493)">UPI</th>
            <th style="text-align: right !important; background: rgba(253, 253, 253, 0.493)">Wallet</th>
        </tr>
        @endif

    </x-scrollable.scroll-head>
    {{ $slot }}
</x-scrollable.scrollable>