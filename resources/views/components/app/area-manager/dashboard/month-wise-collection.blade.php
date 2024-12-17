<section id="topcust" style="margin-bottom: 2em">
    <div class="row">
        <div class="col-12">
            <h2 class="text-light font-weight-bold" style="color:#000;">Collections</h2>
            <table class="table table-info table-responsive table-hover" style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
                <thead style="background-color: #3682cd">
                    <tr>
                        <th>Month</th>
                        <th> Cash </th>
                        <th> Card </th>
                        <th> UPI </th>
                        <th> Wallet </th>
                        <th> Total Collection </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($collections as $collection)
                    <tr>
                        <td class="table-primary">{{ $collection->month }} </td>
                        <td class="table-warning"> {{ $collection->cash ? $collection->cash : '0.00' }} </td>
                        <td class="table-danger"> {{ $collection->card ? $collection->card : '0.00' }} </td>
                        <td class="table-warning"> {{ $collection->upi ? $collection->upi : '0.00' }} </td>
                        <td class="table-secondary"> {{ $collection->wallet ? $collection->wallet : '0.00' }} </td>
                        <td> {{ $collection->total ? $collection->total : '0.00' }} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
