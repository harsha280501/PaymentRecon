<x-scrollable.scrollable :dataset="$dataset">
    <x-scrollable.scroll-head>

        <tr>
            <th colspan="1"></th>
            <th colspan="5">Tender Sale</th>
            <th colspan="5" style="background: rgba(0, 0, 0, 0.034)">Tender Collection</th>
            <th colspan="5">Total Difference</th>
        </tr>

        <tr>

            <th>
                <div class="d-flex align-items-center gap-2">
                    <span>{{ config('constants.StoreVariables.SalesDate') }}</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                        class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>

            <th style="text-align: right !important">Cash</th>
            <th style="text-align: right !important">Card</th>
            <th style="text-align: right !important">Upi</th>
            <th style="text-align: right !important">Wallet</th>
            <th style="text-align: right !important">Total Sales</th>
            <th style="background: rgba(0, 0, 0, 0.034); text-align: right !important">Cash</th>
            <th style="background: rgba(0, 0, 0, 0.034); text-align: right !important">Card</th>
            <th style="background: rgba(0, 0, 0, 0.034); text-align: right !important">Upi</th>
            <th style="background: rgba(0, 0, 0, 0.034); text-align: right !important">Wallet</th>
            <th style="text-align: right !important" style="background: rgba(0, 0, 0, 0.034)">Total Receivables</th>
            <th style="text-align: right !important">Cash</th>
            <th style="text-align: right !important">Card</th>
            <th style="text-align: right !important">Upi</th>
            <th style="text-align: right !important">Wallet</th>
            <th style="text-align: right !important">Total Difference</th>
        </tr>

    </x-scrollable.scroll-head>
    {{ $slot }}
</x-scrollable.scrollable>