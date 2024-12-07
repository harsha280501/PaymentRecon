<div class="col-lg-12">
    <h2 class="text-light font-weight-bold" style="color:#000;">UPI</h2>
    <div style="max-height: 357px;overflow-y: auto;">

        <table style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);" class="table table-info table-responsive table-hover">
            <thead style="position: sticky; top: 0; background-color: #3682cd">
                <tr>
                    <th class="bg-warning" rowspan="2">Month</th>
                    <th colspan="1" class="bg-secondary">Sales</th>
                    <th colspan="1" class="bg-success">Collection</th>
                    <th colspan="1">Difference</th>
                </tr>
                <tr>
                    <th class="bg-secondary">HDFC</th>
                    <th class="bg-success">HDFC</th>
                    <th class="">HDFC</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($initial as $data)
                <tr>
                    <td class="bg-light">{{ in_array($timeline, $showFullStatsFor) ? $timeline : $data->{"MONTH"} }}
                        <x-viewer.dates :from="$from" :to="$to" />
                    </td>
                    <td class="">{{ $data->UPIH_SALES }}</td>
                    <td class="">{{ $data->UPIH_COL }}</td>
                    <td class="">{{ $data->UPIH_DIFF }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">NO DATA FOUND</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
