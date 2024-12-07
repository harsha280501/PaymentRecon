<div class="col-lg-12">
    <h2 class="text-light font-weight-bold" style="color:#000;">Card</h2>

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
                    <th class="bg-secondary">HDFC</th>
                    <th class="bg-secondary">AMEX</th>
                    <th class="bg-secondary">SBI</th>
                    <th class="bg-secondary">ICIC</th>
                    <th class="bg-secondary">Total</th>

                    <th class="bg-success">HDFC</th>
                    <th class="bg-success">AMEX</th>
                    <th class="bg-success">SBI</th>
                    <th class="bg-success">ICIC</th>
                    <th class="bg-success">Total</th>

                    <th class="">HDFC</th>
                    <th class="">AMEX</th>
                    <th class="">SBI</th>
                    <th class="">ICIC</th>
                    <th class="">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($initial as $data)
                <tr>
                    <td class="bg-light">{{ in_array($timeline, $showFullStatsFor) ? $timeline : $data->{"MONTH"} }}
                        <x-viewer.dates :from="$from" :to="$to" />
                    </td>
                    <td class="">{{ $data->HDFC_CASH }}</td>
                    <td class="">{{ $data->AMEX_CASH }}</td>
                    <td class="">{{ $data->SBI_CASH }}</td>
                    <td class="">{{ $data->ICICI_CASH }}</td>
                    <td class="">{{ $data->CASH_TOTAL }}</td>
                    <td class="">{{ $data->HDFC_CARD }}</td>
                    <td class="">{{ $data->AMEX_CARD }}</td>
                    <td class="">{{ $data->SBI_CARD }}</td>
                    <td class="">{{ $data->ICICI_CARD }}</td>
                    <td class="">{{ $data->CARD_TOTAL }}</td>
                    <td class="">{{ $data->HDFC_DIFF }}</td>
                    <td class="">{{ $data->AMEX_DIFF }}</td>
                    <td class="">{{ $data->SBI_DIFF }}</td>
                    <td class="">{{ $data->ICICI_DIFF }}</td>
                    <td class="">{{ $data->TOTAL_DIFF }}</td>
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
