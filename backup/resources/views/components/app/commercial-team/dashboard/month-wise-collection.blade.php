<section id="topcust">
    <div class="row">
        <div class="col-12">
            <h2 class="dashboard-heading" style="">Collections</h2>
            <table class="table table-info table-responsive table-hover" style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
                <thead style="background-color: #3682cd">
                    <tr>
                        <th colspan="3">Month</th>
                        <th colspan="6"> Cash (Cr)</th>
                        <th colspan="6"> Card (Cr)</th>
                        <th colspan="6"> UPI (Cr)</th>
                        <th colspan="6"> Wallet (Cr)</th>
                        <th colspan="3"> Total Collection (Cr) </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($collections as $collection)
                    <tr>
                        <td style="font-size: 1rem" colspan="3" class="table-primary">{{ $collection->month }} </td>
                        <td colspan="6" class="table-warning amount-main">
                            <span data-bs-toggle="tooltip" title="{{ $collection->cashdata ? $collection->cashdata : '0.00'  }}">
                                {{ $collection->cash ? '₹ '.$collection->cash : '0.00' }}
                            </span>
                        </td>
                        <td colspan="6" class="table-danger amount-main">
                            <span data-bs-toggle="tooltip" title="{{ $collection->carddata ? $collection->carddata : '0.00'  }}">
                                {{ $collection->card ? '₹ '.$collection->card : '0.00' }}
                            </span>
                        </td>
                        <td colspan="6" class="table-warning amount-main">
                            <span data-bs-toggle="tooltip" title="{{ $collection->upidata ? $collection->upidata : '0.00'  }}">
                                {{ $collection->upi ? '₹ '.$collection->upi : '0.00' }}
                            </span>
                        </td>
                        <td colspan="6" class="table-secondary amount-main">
                            <span data-bs-toggle="tooltip" title="{{ $collection->walletdata ? $collection->walletdata : '0.00'  }}">
                                {{ $collection->wallet ? '₹ '.$collection->wallet : '0.00' }}
                            </span>
                        </td>
                        <td class="amount-main" colspan="3">
                            <span data-bs-toggle="tooltip" title="{{ $collection->totaldata ? $collection->totaldata : '0.00'  }}">
                                {{ $collection->total ? '₹ '.$collection->total : '0.00' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
