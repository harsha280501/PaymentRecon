<x-scrollable.scrollable :dataset="$dataset">
    <x-scrollable.scroll-head>

        <tr>
            <th colspan="9" style="background: #dbd9d9fd !important">Store Information</th>
            {{-- <th colspan="5">Store Information</th> --}}
            <th colspan="5">Tender Sale</th>
            <th colspan="5" style="background: rgba(0, 0, 0, 0.034)">Tender Collection</th>
            <th colspan="5">Difference</th>
        </tr>

        <tr>
            <th style="background: #dbd9d9fd !important">Store ID</th>
            <th style="background: #dbd9d9fd !important">Retek Code</th>
            <th style="background: #dbd9d9fd !important">Store Type</th>
            <th style="background: #dbd9d9fd !important">Brand</th>
            <th style="background: #dbd9d9fd !important">Region</th>
            <th style="background: #dbd9d9fd !important">Location</th>
            <th style="background: #dbd9d9fd !important">City</th>
            <th style="background: #dbd9d9fd !important">State</th>
            <th style="background: #dbd9d9fd !important" class="left">
                <div class="d-flex align-items-center gap-2">
                    <span>Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>
            <th class="right">Cash</th>
            <th class="right">Card</th>
            <th class="right">Upi</th>
            <th class="right">Wallet</th>
            <th class="right">Total Sales</th>
            <th class="right" style="background: rgba(0, 0, 0, 0.034)">Cash</th>
            <th class="right" style="background: rgba(0, 0, 0, 0.034)">Card</th>
            <th class="right" style="background: rgba(0, 0, 0, 0.034)">Upi</th>
            <th class="right" style="background: rgba(0, 0, 0, 0.034)">Wallet</th>
            <th class="right" style="background: rgba(0, 0, 0, 0.034)">Total Receivables</th>
            <th class="right">Cash</th>
            <th class="right">Card</th>
            <th class="right">Upi</th>
            <th class="right">Wallet</th>
            <th class="right">Total Difference</th>
        </tr>

    </x-scrollable.scroll-head>
    {{ $slot }}
</x-scrollable.scrollable>
