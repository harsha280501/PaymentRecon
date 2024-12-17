<x-scrollable.scrollable :dataset="$dataset">
    <x-scrollable.scroll-head>
        <thead style="position: sticky; top: 0; background: lightgray">
            <tr>

                <th>
                    <div class="d-flex align-items-center gap-2">
                        <span>{{ config('constants.StoreVariables.SalesDate') }}</span>
                        <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                    </div>
                </th>
                <th style="text-align: right !important">AMEX</th>
                <th style="text-align: right !important">HDFC</th>
                <th style="text-align: right !important">ICICI</th>
                <th style="text-align: right !important">SBI</th>
                {{-- <th style="text-align: right !important">UPI OTHERS</th>
                <th style="text-align: right !important">UPI-HDFC</th> --}}
                <th style="text-align: right !important">UPI-HDFC</th>
                <th style="text-align: right !important">CASH</th>
                <th style="text-align: right !important">PAYTM</th>
                <th style="text-align: right !important">PHONE PE</th>
                <th style="text-align: right !important">Total</th>
                <th style="text-align: right !important">Vouchgram</th>
                <th style="text-align: right !important">Gift Vr Redeemed</th>
                <th style="text-align: right !important">Grand Total</th>
            </tr>
    </x-scrollable.scroll-head>
    {{ $slot }}
</x-scrollable.scrollable>
