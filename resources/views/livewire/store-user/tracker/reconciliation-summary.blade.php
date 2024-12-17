<div>
    <div class="row mt-3">
        <x-app.store-user.reports.recon-summary.reconciliation-filters :filtering="$filtering" :months="$_months" />
    </div>


    <div class="d-flex justify-content-center mt-2" style="flex-direction: column;">
        <div class="d-flex justify-content-center gap-md-4 gap-2 align-items-center flex-column flex-md-row mb-4">
            {{-- Total Count --}}
            <div class="flex-main">
                <p style="font-size: 1.01em; color: #000; margin: 0">Total Sales: </p>
                <span style="color: black; font-weight: 900;">{{ isset($datas[0]->TOTAL_SALES_SUM) ? $datas[0]->TOTAL_SALES_SUM : 0 }}</span>
            </div>

            <div class="flex-main">
                <p style="font-size: 1.01em; color: #000; margin: 0">Total Collection: </p>
                <span style="color: teal; font-weight: 900;">{{ isset($datas[0]->TOTAL_COLL_SUM) ? $datas[0]->TOTAL_COLL_SUM : 0 }}</span>
            </div>

            <div class="flex-main">
                <p style="font-size: 1.01em; color: #000; margin: 0">Total Difference: </p>
                <span style="color: lightcoral; font-weight: 900;">{{ isset($datas[0]->TOTAL_DIFF_SUM) ? $datas[0]->TOTAL_DIFF_SUM : 0 }}</span>
            </div>
        </div>
    </div>

    <x-livewire.storeuser.reconsummary-table-headers :dataset="$datas" :orderBy="$orderBy">
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr>
                <td class="right">{{  !$data->CALDAY ? '' : Carbon\Carbon::parse($data->CALDAY)->format('d-m-Y') }}</td>
                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->CASH }}</td>
                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->CARD }}</td>
                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->UPI }}</td>
                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->WALLET }}</td>
                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->sales_total }}</td>
                <td style="text-align: right !important">{{ $data->total_cash_collection }}</td>
                <td style="text-align: right !important">{{ $data->total_card_collection }}</td>
                <td style="text-align: right !important">{{ $data->total_upi_collection }}</td>
                <td style="text-align: right !important">{{ $data->total_wallet_collection }}</td>
                <td style="text-align: right !important">{{ $data->collection_total }}</td>
                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->total_cash_difference }}</td>
                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->total_card_difference }}</td>
                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->total_upi_difference }}</td>
                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->total_wallet_difference }}</td>
                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->difference }}</td>
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
    </x-livewire.storeuser.reconsummary-table-headers>

    {{-- <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {
            $j('#select1-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });
        });

    </script> --}}
</div>
