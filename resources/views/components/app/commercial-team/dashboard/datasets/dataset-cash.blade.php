<div class="col-lg-12" style="overflow-x: scroll">
    <div style="display: flex; justify-content: start; align-items: center; flex-wrap: wrap" class="gap-0 gap-md-2 flex-column flex-md-row">
        <h2 class="text-light font-weight-bold" style="color:#000;">Cash</h2>
        @if($store)
        <div style="display: flex; justify-content: center;align-items: center; height: inherit; flex-wrap: wrap; flex: 1;" class="gap-0 gap-md-3">
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
                <th colspan="1" class="bg-secondary">Sales (Cr)</th>
                <th colspan="1" class="bg-success">Collection (Cr)</th>
                <th colspan="1">Difference (Cr)</th>
            </tr>
            <tr>
                <th class="bg-secondary">CASH</th>
                <th class="bg-success">CASH</th>
                <th class="">CASH</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($initial as $data)
            <tr>
                <td class="bg-light">{{ in_array($timeline, $showFullStatsFor) ? $timeline : $data->{"MONTH"} }}
                    <x-viewer.dates :from="$from" :to="$to" />
                </td>
                <td data-bs-toggle="tooltip" title="{{ $data->CASH_SALES }}" class="">₹ {{ $data->FC_CASH_SALES }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->CASH_COL }}" class="">₹ {{ $data->FC_CASH_COL }}</td>
                <td data-bs-toggle="tooltip" title="{{ $data->CASH_DIFF }}" class="">₹ {{ $data->FC_CASH_DIFF }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">NO DATA FOUND</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
