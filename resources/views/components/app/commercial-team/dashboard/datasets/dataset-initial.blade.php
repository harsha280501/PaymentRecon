<div class="col-lg-12" style="overflow-x: scroll">
    <div style="display: flex; justify-content: start; align-items: center; gap: 1em; flex-wrap: wrap" class="gap-0 gap-md-2">
        <h2 class="text-light font-weight-bold" style="color:#000;">Month wise Summary</h2>
        @if($store)
        <div style="display: flex; justify-content: center;align-items: center; height: inherit; flex-wrap: wrap; flex: 1;" class="gap-0 gap-md-3">
            <h2 class="text-light font-weight-bold" style="color:#000;"><span class="text-primary">STORE ID</span>: {{ $storeData['Store ID'] }}</h2>
            <h2 class="text-light font-weight-bold" style="color:#000;"><span class="text-primary">RETEK CODE</span>: {{ $storeData['RETEK Code'] }}</h2>
            <h2 class="text-light font-weight-bold" style="color:#000;"><span class="text-primary">BRAND</span>: {{ $storeData['Brand Desc']}}</h2>
        </div>
        @endif
    </div>
    <table style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);" class="table table-info table-responsive table-hover">
        <thead style="background-color: #3682cd">
            <tr>
                <th class="bg-warning" rowspan="2">Month (Cr)</th>
                <th colspan="5" class="bg-secondary">Sales (Cr)</th>
                <th colspan="5" class="bg-success">Collection (Cr)</th>
                <th colspan="5">Difference (Cr)</th>
            </tr>
            <tr>
                <th class="bg-secondary">Card</th>
                <th class="bg-secondary">UPI</th>
                <th class="bg-secondary">Wallet</th>
                <th class="bg-secondary">Cash</th>
                <th class="bg-secondary">Total</th>
                <th class="bg-success">Card</th>
                <th class="bg-success">UPI</th>
                <th class="bg-success">Wallet</th>
                <th class="bg-success">Cash</th>
                <th class="bg-success">Total</th>
                <th>Card</th>
                <th>UPI</th>
                <th>Wallet</th>
                <th>Cash</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>

            @forelse ($initial as $data)
            <tr>
                <td class="bg-light">{{
                    in_array($timeline, $showFullStatsFor) ? $timeline : $data->{"MONTH"} }}
                    <x-viewer.dates :from="$from" :to="$to" />
                </td>
                <td data-bs-toggle="tooltip" title="{{ $data->{"SALES_CARD"} }}">₹ {{ $data->{"FC_SALES_CARD"} }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->{"SALES_UPI"} }}">₹ {{ $data->{"FC_SALES_UPI"} }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->{"SALES_WALLET"} }}">₹ {{ $data->{"FC_SALES_WALLET"} }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->{"SALES_CASH"} }}">₹ {{ $data->{"FC_SALES_CASH"} }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->{"SALES_TOTAL"} }}">₹ {{ $data->{"FC_SALES_TOTAL"} }}</td>

                <td data-bs-toggle="tooltip" title="{{ $data->{"CARD"} }}" class="bg-light">₹ {{ $data->{"FC_CARD"} }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->{"UPI"} }}" class="bg-light">₹ {{ $data->{"FC_UPI"} }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->{"WALLET"} }}" class="bg-light">₹ {{ $data->{"FC_WALLET"} }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->{"CASH"} }}" class="bg-light">₹ {{ $data->{"FC_CASH"} }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->{"TOTAL COLLECTION"} }}" class="bg-light">₹ {{ $data->{"FC_TOTAL COLLECTION"} }}</td>

                <td data-bs-toggle="tooltip" title="{{ $data->{"DIFF_CARD"} }}">₹ {{ $data->{"FC_DIFF_CARD"} }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->{"DIFF_UPI"} }}">₹ {{ $data->{"FC_DIFF_UPI"} }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->{"DIFF_WALLET"} }}">₹ {{ $data->{"FC_DIFF_WALLET"} }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->{"DIFF_CASH"} }}">₹ {{ $data->{"FC_DIFF_CASH"} }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->{"DIFF_TOTAL"} }}">₹ {{ $data->{"FC_DIFF_TOTAL"} }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="16" class="text-center">NO DATA FOUND</td>
            </tr>
            @endforelse

        </tbody>
    </table>
</div>
