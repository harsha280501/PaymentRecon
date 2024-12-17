<div>
    <div class="row mt-3">
        <x-app.commercial-team.reports.recon-summary.filters :filtering="$filtering" :stores="$stores"
            :months="$_months" />
    </div>


    <div class="d-flex justify-content-center align-items-center mt-2" style="flex-direction: column;">
        <div class="d-flex justify-content-center flex-md-row flex-column gap-md-4 align-items-center mb-4">
            {{-- Total Count --}}
            <div style="display: flex; flex-wrap: wrap; gap: .5em">
                <p style="font-size: 1.01em; color: #000; margin: 0">Total Sales: </p>
                <span style="color: black; font-weight: 900;">{{ isset($datas[0]) ? $datas[0]->TOTAL_SALES_SUM : 0
                    }}</span>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: .5em">
                <p style="font-size: 1.01em; color: #000; margin: 0">Total Collection: </p>
                <span style="color: teal; font-weight: 900;">{{ isset($datas[0]) ? $datas[0]->TOTAL_COLL_SUM : 0
                    }}</span>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: .5em">
                <p style="font-size: 1.01em; color: #000; margin: 0">Total Difference: </p>
                <span style="color: lightcoral; font-weight: 900;">{{ isset($datas[0]) ? $datas[0]->TOTAL_DIFF_SUM : 0
                    }}</span>
            </div>
        </div>
    </div>


    <x-app.commercial-team.reports.recon-summary.table-headers :orderBy="$orderBy" :dataset="$datas">
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{
                    Carbon\Carbon::parse($data->CALDAY)->format('d-m-Y') }}</td>
                <td class="right">{{ $data->storeID }}</td>
                <td class="right">{{ $data->retekCode }}</td>
                <td class="right" style="text-align: right !important">{{ $data->CASH }}</td>
                <td class="right" style="text-align: right !important">{{ $data->CARD }}</td>
                <td class="right" style="text-align: right !important">{{ $data->UPI }}</td>
                <td class="right" style="text-align: right !important">{{ $data->WALLET }}</td>
                <td class="right" style="text-align: right !important">{{ $data->sales_total }}</td>
                <td style="font-weight: 700; color: @if($data->status == 'Matched') green @else red @endif">{{
                    $data->status }}</td>
                <td class="right" style="text-align: right !important; background: rgba(0, 0, 0, 0.034)">{{
                    $data->CASH_COLL }}</td>
                <td class="right" style="text-align: right !important; background: rgba(0, 0, 0, 0.034)">{{ $data->HDFC
                    }}</td>
                <td class="right" style="text-align: right !important; background: rgba(0, 0, 0, 0.034)">{{ $data->AMEX
                    }}</td>
                <td class="right" style="text-align: right !important; background: rgba(0, 0, 0, 0.034)">{{ $data->SBI
                    }}</td>
                <td class="right" style="text-align: right !important; background: rgba(0, 0, 0, 0.034)">{{ $data->ICICI
                    }}</td>
                <td class="right" style="text-align: right !important; background: rgba(0, 0, 0, 0.034)">{{ $data->UPIH
                    }}</td>

                <td class="right" style="text-align: right !important; background: rgba(0, 0, 0, 0.034)">{{
                    $data->PhonePe }}</td>
                <td class="right" style="text-align: right !important; background: rgba(0, 0, 0, 0.034)">{{ $data->PayTM
                    }}</td>

                <td class="right" style="text-align: right !important">{{ $data->total_cash_collection }}</td>
                <td class="right" style="text-align: right !important">{{ $data->total_card_collection }}</td>
                <td class="right" style="text-align: right !important">{{ $data->total_upi_collection }}</td>
                <td class="right" style="text-align: right !important">{{ $data->total_wallet_collection }}</td>
                <td class="right" style="text-align: right !important">{{ $data->collection_total }}</td>
                <td style="text-align: right !important">{{ $data->difference }}</td>

            </tr>
            @endforeach
        </x-scrollable.scroll-body>
    </x-app.commercial-team.reports.recon-summary.table-headers>


    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {
            $j('#select1-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });
        });

    </script>
</div>