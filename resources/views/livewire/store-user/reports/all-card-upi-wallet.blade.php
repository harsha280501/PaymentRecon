<div>
    <div class="row mt-3">
        <x-app.store-user.reports.recon-summary.filters :filtering="$filtering" :months="$_months" />
    </div>



    <div class="d-flex justify-content-center mt-2" style="flex-direction: column;">
        <div class="d-flex justify-content-center gap-4 align-items-center mb-4 flex-column flex-md-row text-center">
            {{-- Total Count --}}
            <div style="flex-main">
                <p style="font-size: 1.01em; color: #000; margin: 0">Total Sales: </p>
                <span style="color: black; font-weight: 900;">{{ isset($datas[0]->TOTAL_SALES_SUM) ? $datas[0]->TOTAL_SALES_SUM : 0 }}</span>
            </div>

            <div style="flex-main">
                <p style="font-size: 1.01em; color: #000; margin: 0">Total Collection: </p>
                <span style=" color: teal; font-weight: 900;">{{ isset($datas[0]->TOTAL_COLL_SUM) ? $datas[0]->TOTAL_COLL_SUM : 0 }}</span>
            </div>

            <div style="flex-main">
                <p style="font-size: 1.01em; color: #000; margin: 0">Total Difference: </p>
                <span style="color: lightcoral; font-weight: 900;">{{ isset($datas[0]->TOTAL_DIFF_SUM) ? $datas[0]->TOTAL_DIFF_SUM : 0 }}</span>
            </div>
        </div>
    </div>


    <x-app.store-user.reports.recon-summary.table-headers :dataset="$datas" :orderBy="$orderBy">
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr>
                <td style="background: rgba(0, 0, 0, 0.034)">{{ Carbon\Carbon::parse($data->CALDAY)->format('d-m-Y') }}</td>
                <td style="text-align: right !important">{{ $data->CASH }}</td>
                <td style="text-align: right !important">{{ $data->CARD }}</td>
                <td style="text-align: right !important">{{ $data->UPI }}</td>
                <td style="text-align: right !important">{{ $data->WALLET }}</td>
                <td style="text-align: right !important">{{ $data->sales_total }}</td>
                <td style="font-weight: 700; color: @if($data->status == 'Matched') green @else red @endif">{{ $data->status }}</td>

                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->CASH_COLL }}</td>
                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->HDFC }}</td>
                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->AMEX }}</td>
                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->SBI }}</td>
                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->ICICI }}</td>
                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->UPIH }}</td>

                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->PhonePe }}</td>
                <td style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->PayTM }}</td>

                <td style="text-align: right !important">{{ $data->total_cash_collection }}</td>
                <td style="text-align: right !important">{{ $data->total_card_collection }}</td>
                <td style="text-align: right !important">{{ $data->total_upi_collection }}</td>
                <td style="text-align: right !important">{{ $data->total_wallet_collection }}</td>
                <td style="text-align: right !important">{{ $data->collection_total }}</td>

                <td>{{ $data->difference }}</td>
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
    </x-app.store-user.reports.recon-summary.table-headers>
</div>
