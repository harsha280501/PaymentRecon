<div class="col-lg-12">
    <div style="display: flex; justify-content: start; align-items: center; flex-wrap: wrap" class="gap-0 gap-md-2 flex-column flex-md-row">
        <h2 class="text-light font-weight-bold" style="color:#000;">Wallet</h2>
        @if($store)
        <div style="display: flex; justify-content: center; align-items: center; height: inherit; flex-wrap: wrap; flex: 1;" class="gap-0 gap-md-3">
            <h2 class="text-light font-weight-bold" style="color:#000;"><span class="text-primary">STORE ID</span>: {{ $storeData['Store ID'] }}</h2>
            <h2 class="text-light font-weight-bold" style="color:#000;"><span class="text-primary">RETEK CODE</span>: {{ $storeData['RETEK Code'] }}</h2>
            <h2 class="text-light font-weight-bold" style="color:#000;"><span class="text-primary">BRAND</span>: {{ $storeData['Brand Desc'] }}</h2>
        </div>
        @endif
    </div>
    <table style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);" class="table table-info table-responsive table-hover">
        <thead style="background-color: #3682cd">
            <tr>
                <th class="bg-warning" rowspan="2">Month (Cr)</th>
                <th colspan="3" class="bg-secondary">Sales (Cr)</th>
                <th colspan="3" class="bg-success">Collection (Cr)</th>
                <th colspan="3">Difference (Cr)</th>
            </tr>
            <tr>
                <th class="bg-secondary">PhonePe</th>
                <th class="bg-secondary">PayTM</th>
                <th class="bg-secondary">Total</th>
                <th class="bg-success">PhonePe</th>
                <th class="bg-success">PayTM</th>
                <th class="bg-success">Total</th>
                <th class="">PhonePe</th>
                <th class="">PayTM</th>
                <th class="">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($initial as $data)
            <tr>
                <td class="bg-light">{{ in_array($timeline, $showFullStatsFor) ? $timeline : $data->{"MONTH"} }}
                    <x-viewer.dates :from="$from" :to="$to" />
                </td>
                <td data-bs-toggle="tooltip" title="{{ $data->PAYTM_SALES }}">₹ {{ $data->FC_PAYTM_SALES }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->PHONEPE_SALES }}">₹ {{ $data->FC_PHONEPE_SALES }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->SALES_TOTAL }}">₹ {{ $data->FC_SALES_TOTAL }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->PAYTM_COL }}">₹ {{ $data->FC_PAYTM_COL }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->PHONEPE_COL }}">₹ {{ $data->FC_PHONEPE_COL }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->COL_TOTAL }}">₹ {{ $data->FC_COL_TOTAL }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->PAYTM_DIFF }}">₹ {{ $data->FC_PAYTM_DIFF }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->PHONEPE_DIFF }}">₹ {{ $data->FC_PHONEPE_DIFF }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->TOTAL_DIFF }}">₹ {{ $data->FC_TOTAL_DIFF }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">NO DATA FOUND</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
