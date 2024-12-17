<section id="topcust">
    <div class="row">
        <div class="col-12">
            <h2 class="text-light font-weight-bold" style="color:#000;">Collections</h2>
            <table class="table table-info table-responsive table-hover" style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
                <thead style="background-color: #3682cd">
                    <tr>
                        <th>Month</th>
                        <th> Cash (Cr)</th>
                        <th> Card (Cr)</th>
                        <th> UPI (Cr)</th>
                        <th> Wallet (Cr)</th>
                        <th> Total Collection (Cr)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($collections as $collection)
                    @php
                    $collection = (array)$collection;
                    @endphp
                    <tr>
                        <td class="table-primary" style="font-size: 1rem">{{ $collection['month'] }} </td>

                        <td class="amount-main table-warning">
                            <span data-bs-toggle="tooltip" title="{{  $collection['cashdata'] ?  $collection['cashdata'] : '0.00'  }}">
                                {{ $collection['cash'] ? '₹ '. $collection['cash'] : '0.00' }}
                            </span>
                        </td>

                        <td class="amount-main table-danger">
                            <span data-bs-toggle="tooltip" title="{{  $collection['carddata'] ?  $collection['carddata'] : '0.00'  }}"> {{ $collection['card'] ? '₹ '. $collection['card'] : '0.00' }} </span>
                        </td>

                        <td class="amount-main table-warning">
                            <span data-bs-toggle="tooltip" title="{{  $collection['upidata'] ?  $collection['upidata']: '0.00'  }}"> {{ $collection['upi'] ? '₹ '. $collection['upi'] : '0.00' }} </span>
                        </td>

                        <td class="amount-main table-secondary">
                            <span data-bs-toggle="tooltip" title="{{  $collection['walletdata'] ?  $collection['walletdata'] : '0.00'  }}"> {{ $collection['wallet'] ? '₹ '. $collection['wallet'] : '0.00' }} </span>
                        </td>

                        <td class="amount-main">
                            <span data-bs-toggle="tooltip" title="{{  $collection['totaldata'] ?  $collection['totaldata'] : '0.00'  }}"> {{ $collection['total'] ? '₹ '. $collection['total'] : '0.00' }} </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No Data available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
