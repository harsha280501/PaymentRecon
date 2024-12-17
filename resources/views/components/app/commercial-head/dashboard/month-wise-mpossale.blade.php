<section id="topcust" style="width: 40%">
    <div class="row">
        <div class="col-12">
            <h2 class="dashboard-heading" style="">MPOS Sales</h2>
            <table class="table table-info table-responsive table-hover" style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
                <thead style="background-color: #3682cd">
                    <tr>
                        <th>Month </th>
                        <th> Cash (Cr)</th>
                        {{-- <th> Card (Cr)</th> --}}
                        {{-- <th> UPI (Cr)</th> --}}
                        {{-- <th> Wallet (Cr)</th> --}}
                        {{-- <th> Total Sales (Cr)</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mpossales as $mpossale)
                    <tr>
                        <td style="font-size: 1rem" class="table-primary">{{ $mpossale->month }} </td>
                        <td class="amount-main table-warning">
                            <span data-bs-toggle="tooltip" title="{{ $mpossale->cashdata ? $mpossale->cashdata : '0.00'  }}">
                                {{ $mpossale->cash ? '₹ '.$mpossale->cash : '0.00' }}
                            </span>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
