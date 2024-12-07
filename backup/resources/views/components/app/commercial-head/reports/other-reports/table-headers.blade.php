<x-scrollable.scrollable :dataset="$dataset">
    <x-scrollable.scroll-head>
        @if($activeTab == 'mpos-sap')
        <tr>
            <th class="left">
                <div class="d-flex align-items-center gap-2">
                    <span>Sales Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>

            <th class="left">Store ID</th>
            <th class="left">Retek Code</th>
            <th class="left">Brand</th>
            <th class="left">Status</th>
            <th class="left" style="text-align: right !important">SAP Cash</th>
            <th class="left" style="text-align: right !important">MPOS Cash</th>
            <th class="left" style="text-align: right !important">Difference</th>
        </tr>
        @endif
        @if($activeTab == 'bank-drop-missing')
        <tr>
            <th class="left">
                <div class="d-flex align-items-center gap-2">
                    <span>Sales Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>
            <th class="left">Store ID</th>
            <th class="left">Retek Code</th>
            <th class="left">Store Name</th>
            <th class="left">Brand</th>
            <th class="left">Bank Drop ID</th>
            <th class="left">Tender Description</th>
            <th class="left" style="text-align: right !important">Bank Drop Amount</th>
        </tr>
        @endif

        @if($activeTab == 'zero-sales')
        <tr>
            <th class="left">
                <div class="d-flex align-items-center gap-2">
                    <span>Sales Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>
            <th class="left">Store ID</th>
            <th class="left">Retek Code</th>
            <th class="left">Brand</th>
            <th class="left" style="text-align: right !important">Total Sales</th>
        </tr>
        @endif

        @if($activeTab == 'overall-summary')

        <tr>
            <th>Store ID</th>
            <th>Retek Code</th>
            <th>Brand</th>
            <th style="text-align: right !important">Opening Balance</th>
            <th style=" text-align: right !important">Sales</th>
            <th style="text-align: right !important">Collection</th>
            <th style="text-align: right !important">Store Response</th>
            <th style="text-align: right !important">Closing Balance</th>
        </tr>
        @endif

        @if($activeTab == 'chargeback-summary')
        <tr>
            <th class="left">
                <div class="d-flex align-items-center gap-2">
                    <span>Sales Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>
            <th class="left">Credit Date</th>
            <th class="left">Store ID</th>
            <th class="left">Retek Code</th>
            <th class="left">Brand</th>
            <th class="left">TID</th>
            <th class="left">Account No</th>
            <th class="left">Description</th>
            <th class="left">Transaction Branch</th>
            <th class="left" style="text-align: right !important">Credit</th>
            <th class="left" style="text-align: right !important">Debit</th>
        </tr>
        @endif

        @if($activeTab == 'date-wise-collection')


        @if($tender == 'all')

        <tr>
            <th class="left" rowspan="2">
                <div class="d-flex align-items-center gap-2">
                    <span>Deposit Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>
            <th class="left" style="background-color: rgba(128, 128, 128, 0.096);" colspan="5">Cash</th>
            <th class="left" colspan="4">Card</th>
            <th class="left" style="background-color: rgba(128, 128, 128, 0.096);" colspan="1">UPI</th>
            <th class="left" colspan="2">Wallet</th>
            <th class="right" style="background-color: rgba(128, 128, 128, 0.096);" rowspan="2">Total Collection</th>
        </tr>
        <tr>
            <th style="background-color: rgba(128, 128, 128, 0.096);" class="right">HDFC</th>
            <th style="background-color: rgba(128, 128, 128, 0.096);" class="right">ICICI</th>
            <th style="background-color: rgba(128, 128, 128, 0.096);" class="right">SBI</th>
            <th style="background-color: rgba(128, 128, 128, 0.096);" class="right">AXIS</th>
            <th style="background-color: rgba(128, 128, 128, 0.096);" class="right">IDFC</th>

            <th class="right">HDFC</th>
            <th class="right">ICICI</th>
            <th class="right">SBI</th>
            <th class="right">AMEX</th>

            <th style="background-color: rgba(128, 128, 128, 0.096);" class="right">HDFC</th>

            <th class="right">PhonePe</th>
            <th class="right">PayTM</th>
        </tr>

        @elseif($tender == 'cash')
        <tr>
            <th class="left" rowspan="2">
                <div class="d-flex align-items-center gap-2">
                    <span>Deposit Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>
            <th class="left" style="background-color: rgba(128, 128, 128, 0.096);" colspan="5">Cash</th>
            <th class="right" style="background-color: rgba(128, 128, 128, 0.096);" rowspan="2">Total Collection</th>
        </tr>
        <tr>
            <th style="background-color: rgba(128, 128, 128, 0.096);" class="right">HDFC</th>
            <th style="background-color: rgba(128, 128, 128, 0.096);" class="right">ICICI</th>
            <th style="background-color: rgba(128, 128, 128, 0.096);" class="right">SBI</th>
            <th style="background-color: rgba(128, 128, 128, 0.096);" class="right">AXIS</th>
            <th style="background-color: rgba(128, 128, 128, 0.096);" class="right">IDFC</th>
        </tr>

        @elseif($tender == 'card')
        <tr>
            <th class="left" rowspan="2">
                <div class="d-flex align-items-center gap-2">
                    <span>Deposit Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>
            <th class="left" colspan="4">Card</th>
            <th class="right" style="background-color: rgba(128, 128, 128, 0.096);" rowspan="2">Total Collection</th>
        </tr>
        <tr>
            <th class="right">HDFC</th>
            <th class="right">ICICI</th>
            <th class="right">SBI</th>
            <th class="right">AMEX</th>
        </tr>

        @elseif($tender == 'upi')
        <tr>
            <th class="left" rowspan="2">
                <div class="d-flex align-items-center gap-2">
                    <span>Deposit Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>
            <th class="left" style="background-color: rgba(128, 128, 128, 0.096);" colspan="1">UPI</th>
            <th class="right" style="background-color: rgba(128, 128, 128, 0.096);" rowspan="2">Total Collection</th>
        </tr>
        <tr>
            <th style="background-color: rgba(128, 128, 128, 0.096);" class="right">HDFC</th>
        </tr>
        {{-- else then it should be wallet --}}
        @elseif($tender == 'wallet')

        <tr>
            <th class="left" rowspan="2">
                <div class="d-flex align-items-center gap-2">
                    <span>Deposit Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>
            <th class="left" colspan="2">Wallet</th>
            <th class="right" style="background-color: rgba(128, 128, 128, 0.096);" rowspan="2">Total Collection</th>
        </tr>
        <tr>
            <th class="right">PhonePe</th>
            <th class="right">PayTM</th>
        </tr>
        @endif
        @endif


        @if($activeTab == 'uploaded-report')
        <tr>
            <th class="left">
                <div class="d-flex align-items-center gap-2">
                    <span>Uploaded Date</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>
            <th class="left">Collection Bank</th>
            <th class="left">File Name</th>
            <th class="left" style="text-align: right !important">File Count</th>
            <th class="left" style="text-align: right !important">Valid Count</th>
            <th class="left" style="text-align: right !important">In Valid Count</th>
            <th class="left" style="text-align: right !important">Total Deposit</th>
        </tr>
        @endif

    </x-scrollable.scroll-head>
    {{ $slot }}
</x-scrollable.scrollable>
