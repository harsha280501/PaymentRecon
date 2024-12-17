<section id="topcust" style="width: 60%">
    <div class="row">
        <div class="col-12">
            <h2 class="text-light font-weight-bold" style="color:#000;">SAP Sales</h2>
            <table class="table table-info table-responsive table-hover" style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
                <thead style="background-color: #3682cd">
                    <tr>
                        <th>Month</th>
                        {{-- <th> Cash (Cr)</th> --}}
                        <th> Card (Cr)</th>
                        <th> UPI (Cr)</th>
                        <th> Wallet (Cr)</th>
                        <th> Total Sales (Cr)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($collections as $sapsale)
                    @php
                    $sapsale = (array)$sapsale;
                    @endphp
                    <tr>
                        <td class="table-primary" style="font-size: 1rem">{{ $sapsale['month'] }} </td>

                        <td class="amount-main table-danger">
                            <span data-bs-toggle="tooltip" title="{{  $sapsale['carddata'] ?  $sapsale['carddata'] : '0.00'  }}"> {{ $sapsale['card'] ? '₹ '. $sapsale['card'] : '0.00' }} </span>
                        </td>

                        <td class="amount-main table-warning">
                            <span data-bs-toggle="tooltip" title="{{  $sapsale['upidata'] ?  $sapsale['upidata'] : '0.00'  }}"> {{ $sapsale['upi'] ? '₹ '. $sapsale['upi'] : '0.00' }} </span>
                        </td>

                        <td class="amount-main table-secondary">
                            <span data-bs-toggle="tooltip" title="{{  $sapsale['walletdata'] ?  $sapsale['walletdata'] : '0.00'  }}"> {{ $sapsale['wallet'] ? '₹ '. $sapsale['wallet'] : '0.00' }} </span>
                        </td>


                        <td class="amount-main">
                            <span data-bs-toggle="tooltip" title="{{  $sapsale['totaldata'] ?  $sapsale['totaldata'] : '0.00'  }}"> {{ $sapsale['total'] ? '₹ '. $sapsale['total'] : '0.00' }} </span>
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
