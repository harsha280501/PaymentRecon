<div class="col-lg-12" style="overflow-x: scroll">
    <div style="display: flex; justify-content: start; align-items: center; gap: 1em; flex-wrap: wrap" class="gap-0 gap-md-2 flex-column flex-md-row">
        <h2 class="text-light font-weight-bold" style="color:#000;">Card</h2>
        @if($store)
        <div style=" display: flex; justify-content: center;align-items: center; height: inherit; flex-wrap: wrap; flex: 1;" class="gap-0 gap-md-3">
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
                <th colspan="5" class="bg-secondary">Sales (Cr)</th>
                <th colspan="5" class="bg-success">Collection (Cr)</th>
                <th colspan="5">Difference</th>
            </tr>
            <tr>
                <th class="bg-secondary">HDFC</th>
                <th class="bg-secondary">AMEX</th>
                <th class="bg-secondary">SBI</th>
                <th class="bg-secondary">ICICI</th>
                <th class="bg-secondary">Total</th>

                <th class="bg-success">HDFC</th>
                <th class="bg-success">AMEX</th>
                <th class="bg-success">SBI</th>
                <th class="bg-success">ICICI</th>
                <th class="bg-success">Total</th>

                <th class="">HDFC</th>
                <th class="">AMEX</th>
                <th class="">SBI</th>
                <th class="">ICICI</th>
                <th class="">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($initial as $data)
            <tr>
                <td class="bg-light">{{ in_array($timeline, $showFullStatsFor) ? $timeline : $data->{"MONTH"} }}
                    <x-viewer.dates :from="$from" :to="$to" />
                </td>
                <td data-bs-toggle="tooltip" title="{{ $data->HDFC_CASH }}" class="">₹ {{ $data->FC_HDFC_CASH }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->AMEX_CASH }}" class="">₹ {{ $data->FC_AMEX_CASH }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->SBI_CASH }}" class="">₹ {{ $data->FC_SBI_CASH }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->ICICI_CASH }}" class="">₹ {{ $data->FC_ICICI_CASH }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->CASH_TOTAL }}" class="">₹ {{ $data->FC_CASH_TOTAL }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->HDFC_CARD }}" class="">₹ {{ $data->FC_HDFC_CARD }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->AMEX_CARD }}" class="">₹ {{ $data->FC_AMEX_CARD }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->SBI_CARD }}" class="">₹ {{ $data->FC_SBI_CARD }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->ICICI_CARD }}" class="">₹ {{ $data->FC_ICICI_CARD }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->CARD_TOTAL }}" class="">₹ {{ $data->FC_CARD_TOTAL }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->HDFC_DIFF }}" class="">₹ {{ $data->FC_HDFC_DIFF }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->AMEX_DIFF }}" class="">₹ {{ $data->FC_AMEX_DIFF }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->SBI_DIFF }}" class="">₹ {{ $data->FC_SBI_DIFF }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->ICICI_DIFF }}" class="">₹ {{ $data->FC_ICICI_DIFF }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->TOTAL_DIFF }}" class="">₹ {{ $data->FC_TOTAL_DIFF }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="16" class="text-center">NO DATA FOUND</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
