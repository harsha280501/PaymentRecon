<section id="topcust" style="margin-bottom: 2em">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="dashboard-heading" style="color:#000;">Month wise Summary</h2>
            <table style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);" class="table table-info table-responsive table-hover">
                <thead style="background-color: #3682cd">
                    <tr>
                        <th colspan="4">Month</th>
                        <th colspan="4"> Sales (Cr) </th>
                        <th colspan="4"> Collection (Cr)</th>
                        <th colspan="4"> Difference (Cr) </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthSales as $sale)
                    <tr>
                        <td style="font-size: 1rem" colspan="4">{{ $sale->month }} </td>
                        <td colspan="4" class="amount-main">
                            <span data-bs-toggle="tooltip" title="{{ $sale->salesdata ? $sale->salesdata : '0.00' }}">
                                {{ $sale->sales ? '₹ '.$sale->sales : '0.00' }}
                            </span>
                        </td>
                        <td colspan="4" class="amount-main">
                            <span data-bs-toggle="tooltip" title="{{ $sale->collectiondata ? $sale->collectiondata : '0.00' }}">
                                {{ $sale->collection ? '₹ '.$sale->collection : '0.00' }}
                            </span>
                        </td>
                        <td colspan="4" class="amount-main">
                            <span data-bs-toggle="tooltip" title="{{ $sale->differencedata ? $sale->differencedata : '0.00' }}">
                                {{ $sale->difference ? '₹ '.$sale->difference : '0.00' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
