<section id="topcust" style="margin-bottom: 2vh">
    <div class="row">
        <div class="col-lg-6">
            <h2 class="text-light font-weight-bold" style="color:#000;">Cash Month Wise Sales</h2>
            <table style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);" class="table table-info table-responsive table-hover">
                <thead style="background-color: #3682cd">
                    <tr>
                        <th>Month</th>
                        <th> Sales </th>
                        <th> Collection </th>
                        <th> Difference </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $september->month }} </td>
                        <td> {{ $september->sales ? $september->sales : '0.00' }} </td>
                        <td> {{ $september->collection ? $september->collection : '0.00' }} </td>
                        <td> {{ $september->difference ? $september->difference : '0.00' }} </td>
                        {{-- <td> {{ floatval($september->sales) - floatval($september->collection) }} </td> --}}
                    </tr>
                    <tr>
                        <td>{{ $august->month }} </td>
                        <td> {{ $august->sales ? $august->sales : '0.00' }} </td>
                        <td> {{ $august->collection ? $august->collection : '0.00' }} </td>
                        <td> {{ $august->difference ? $august->difference : '0.00' }} </td>
                        {{-- <td> {{ floatval($august->sales) - floatval($august->collection) }} </td> --}}
                    </tr>
                    <tr>
                        <td>{{ $july->month }} </td>
                        <td> {{ $july->sales ? $july->sales : '0.00' }} </td>
                        <td> {{ $july->collection ? $july->collection : '0.00' }} </td>
                        <td> {{ $july->difference ? $july->difference : '0.00' }} </td>
                        {{-- <td> {{ floatval($july->sales) - floatval($july->collection) }} </td> --}}
                    </tr>
                    <tr>
                        <td>{{ $june->month }} </td>
                        <td> {{ $june->sales ? $june->sales : '0.00' }} </td>
                        <td> {{ $june->collection ? $june->collection : '0.00' }} </td>
                        <td> {{ $june->difference ? $june->difference : '0.00' }} </td>
                        {{-- <td> {{ floatval($june->sales) - floatval($june->collection) }} </td> --}}
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-lg-6">
            <h2 class="text-light font-weight-bold" style="color:#000;">Card Month Wise Sales</h2>
            <table style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);" class="table table-info table-responsive table-hover">
                <thead style="background-color: #3682cd">
                    <tr>
                        <th>Month</th>
                        <th>Sales</th>
                        <th>Collection</th>
                        <th>Difference</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>September</td>
                        <td>{{ $cardSeptember->sales ? $cardSeptember->sales : '0.00' }} </td>
                        <td>{{ $cardSeptember->collection ? $cardSeptember->collection : '0.00' }} </td>
                        <td> {{ $cardSeptember->difference ? $cardSeptember->difference : '0.00' }} </td>
                        {{-- <td>{{ floatval($cardSeptember->sales) - floatval($cardSeptember->collection) }} </td> --}}
                    </tr>
                    <tr>
                        <td>August</td>
                        <td>{{ $cardAugust->sales ? $cardAugust->sales : '0.00' }} </td>
                        <td>{{ $cardAugust->collection ? $cardAugust->collection : '0.00' }} </td>
                        <td> {{ $cardAugust->difference ? $cardAugust->difference : '0.00' }} </td>
                        {{-- <td>{{ floatval($cardAugust->sales) - floatval($cardAugust->collection) }} </td> --}}
                    </tr>
                    <tr>
                        <td>July</td>
                        <td>{{ $cardJuly->sales ? $cardJuly->sales : '0.00' }} </td>
                        <td>{{ $cardJuly->collection ? $cardJuly->collection : '0.00' }} </td>
                        <td> {{ $cardJuly->difference ? $cardJuly->difference : '0.00' }} </td>
                        {{-- <td>{{ floatval($cardJuly->sales) - floatval($cardJuly->collection) }} </td> --}}
                    </tr>
                    <tr>
                        <td>June</td>
                        <td>{{ $cardJune->sales ? $cardJune->sales : '0.00' }} </td>
                        <td>{{ $cardJune->collection ? $cardJune->collection : '0.00' }} </td>
                        <td> {{ $cardJune->difference ? $cardJune->difference : '0.00' }} </td>
                        {{-- <td>{{ floatval($cardJune->sales) - floatval($cardJune->collection) }} </td> --}}
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
