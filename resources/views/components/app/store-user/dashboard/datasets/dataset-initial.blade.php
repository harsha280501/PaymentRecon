<div class="col-lg-12">
    <h2 class="text-light font-weight-bold" style="color:#000;">Month wise Summary</h2>
    <div style="max-height: 357px;overflow-y: auto;">
        <table style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);" class="table table-info table-responsive table-hover">
            <thead style="position: sticky; top: 0; background-color: #3682cd">
                <tr>
                    <th class="bg-warning" rowspan="2">Month</th>
                    <th colspan="5" class="bg-secondary">Sales</th>
                    <th colspan="5" class="bg-success">Collection</th>
                    <th colspan="5">Difference</th>
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
                    <td class="bg-light">{{ in_array($timeline, $showFullStatsFor) ? $timeline : $data->{"MONTH"} }}
                        <x-viewer.dates :from="$from" :to="$to" />
                    </td>
                    <td>{{ $data->{"SALES_CARD"} }}</td>
                    <td>{{ $data->{"SALES_UPI"} }}</td>
                    <td>{{ $data->{"SALES_WALLET"} }}</td>
                    <td>{{ $data->{"SALES_CASH"} }}</td>
                    <td>{{ $data->{"SALES_TOTAL"} }}</td>
                    <td class="bg-light">{{ $data->{"CARD"} }}</td>
                    <td class="bg-light">{{ $data->{"UPI"} }}</td>
                    <td class="bg-light">{{ $data->{"WALLET"} }}</td>
                    <td class="bg-light">{{ $data->{"CASH"} }}</td>
                    <td class="bg-light">{{ $data->{"TOTAL COLLECTION"} }}</td>
                    <td>{{ $data->{"DIFF_CARD"} }}</td>
                    <td>{{ $data->{"DIFF_UPI"} }}</td>
                    <td>{{ $data->{"DIFF_WALLET"} }}</td>
                    <td>{{ $data->{"DIFF_CASH"} }}</td>
                    <td>{{ $data->{"DIFF_TOTAL"} }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="16" class="text-center">NO DATA FOUND</td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
