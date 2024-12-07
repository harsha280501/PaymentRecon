<div class="col-lg-12">
    <h2 class="text-light font-weight-bold" style="color:#000;">Wallet</h2>
    <div style="max-height: 357px;overflow-y: auto;">

        <div style="max-height: 357px;overflow-y: auto;">

            <table style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);" class="table table-info table-responsive table-hover">
                <thead style="position: sticky; top: 0; background-color: #3682cd">
                    <tr>
                        <th class="bg-warning" rowspan="2">Month</th>
                        <th colspan="3" class="bg-secondary">Sales</th>
                        <th colspan="3" class="bg-success">Collection</th>
                        <th colspan="3">Difference</th>
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
                        <td class="">{{ $data->PHONEPE_SALES }}</td>
                        <td class="">{{ $data->PAYTM_SALES }}</td>
                        <td class="">{{ $data->SALES_TOTAL }}</td>
                        <td class="">{{ $data->PHONEPE_COL }}</td>
                        <td class="">{{ $data->PAYTM_COL }}</td>
                        <td class="">{{ $data->COL_TOTAL }}</td>
                        <td class="">{{ $data->PHONEPE_DIFF }}</td>
                        <td class="">{{ $data->PAYTM_DIFF }}</td>
                        <td class="">{{ $data->TOTAL_DIFF }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">NO DATA FOUND</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
