<x-scrollable.scrollable :dataset="$dataset">
    <x-scrollable.scroll-head>

        <tr style="background: #fff">
            <th style="background: rgba(0, 0, 0, 0.034)"></th>
            <th colspan="5">Sales</th>
            <th colspan="1" style="background: rgba(0, 0, 0, 0.021)"></th>
            <th colspan="8" style="background: rgba(0, 0, 0, 0.034)">Collection</th>
            <th colspan="5">Total</th>
            <th colspan="1"></th>
        </tr>

        <tr style="background: #fff">
            <th colspan="1"><b>Sales</b></th>

            <th colspan="1">{{ isset($dataset[0]->TOTAL_CASH_SALES) ? $dataset[0]->TOTAL_CASH_SALES : "₹ 0.00" }}</th>
            <th colspan="1">{{ isset($dataset[0]->TOTAL_CARD_SALES) ? $dataset[0]->TOTAL_CARD_SALES : "₹ 0.00" }}</th>
            <th colspan="1">{{ isset($dataset[0]->TOTAL_UPI_SALES) ? $dataset[0]->TOTAL_UPI_SALES : "₹ 0.00" }}</th>
            <th colspan="1">{{ isset($dataset[0]->TOTAL_WALLET_SALES) ? $dataset[0]->TOTAL_WALLET_SALES : "₹ 0.00" }}
            </th>
            <th colspan="1">{{ isset($dataset[0]->TOTAL_SALES_SUM) ? $dataset[0]->TOTAL_SALES_SUM : "₹ 0.00" }}</th>
            <th colspan="1"><b>Collection</b></th>
            <th colspan="1">{{ isset($dataset[0]->SUM_CASH_COLLECTION) ? $dataset[0]->SUM_CASH_COLLECTION : "₹ 0.00" }}
            </th>
            <th colspan="1">{{ isset($dataset[0]->HDFC_TOTAL) ? $dataset[0]->HDFC_TOTAL : "₹ 0.00" }}</th>
            <th colspan="1">{{ isset($dataset[0]->AMEX_TOTAL) ? $dataset[0]->AMEX_TOTAL : "₹ 0.00" }}</th>
            <th colspan="1">{{ isset($dataset[0]->SBI_TOTAL) ? $dataset[0]->SBI_TOTAL : "₹ 0.00" }}</th>
            <th colspan="1">{{ isset($dataset[0]->ICICI_TOTAL) ? $dataset[0]->ICICI_TOTAL : "₹ 0.00" }}</th>
            <th colspan="1">{{ isset($dataset[0]->UPIH_TOTAL) ? $dataset[0]->UPIH_TOTAL : "₹ 0.00" }}</th>
            <th colspan="1">{{ isset($dataset[0]->PHONEPE_TOTAL) ? $dataset[0]->PHONEPE_TOTAL : "₹ 0.00" }}</th>
            <th colspan="1">{{ isset($dataset[0]->PAYTM_TOTAL) ? $dataset[0]->PAYTM_TOTAL : "₹ 0.00" }}</th>
            <th colspan="4"></th>
            <th colspan="1"><b>Difference </b></th>
            <th colspan="1">{{ isset($dataset[0]->TOTAL_DIFF_SUM) ? $dataset[0]->TOTAL_DIFF_SUM : "₹ 0.00" }}</th>
        </tr>
        <tr>
            <th class="left">
                <div class="d-flex align-items-center gap-2">
                    <span>{{ config('constants.StoreVariables.SalesDate') }}</span>
                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                        class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                </div>
            </th>
            <th style="text-align: right !important">CASH</th>
            <th style="text-align: right !important">CARD</th>
            <th style="text-align: right !important">UPI</th>
            <th style="text-align: right !important">WALLET</th>
            <th style="text-align: right !important">TOTAL</th>
            <th>Status</th>
            <th style="text-align: right !important">CASH</th>
            <th style="text-align: right !important">HDFC</th>
            <th style="text-align: right !important">AMEXPOS</th>
            <th style="text-align: right !important">SBI</th>
            <th style="text-align: right !important">ICICI</th>
            <th style="text-align: right !important">UPI</th>
            <th style="text-align: right !important">PHONEPE</th>
            <th style="text-align: right !important">PAYTM</th>

            <th style="text-align: right !important">Total Cash Collection</th>
            <th style="text-align: right !important">Total Card Collection</th>
            <th style="text-align: right !important">Total UPI Collection</th>
            <th style="text-align: right !important">Total Wallet Collection</th>
            <th style="text-align: right !important">Total Collection</th>
            <th style="text-align: right !important">Difference</th>
        </tr>
    </x-scrollable.scroll-head>
    {{ $slot }}
</x-scrollable.scrollable>