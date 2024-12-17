<section id="topcust" style="width: 40%">
    <div class="row">
        <div class="col-12">
            <h2 class="text-light font-weight-bold" style="color:#000;">MPOS Sales</h2>
            <table class="table table-info table-responsive table-hover" style="box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
                <thead style="background-color: #3682cd">
                    <tr>
                        <th>Month</th>
                        <th> Cash (Cr)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($collections as $mpossale)
                    @php
                    $mpossale = (array)$mpossale;
                    @endphp
                    <tr>
                        <td class="table-primary" style="font-size: 1rem">{{ $mpossale['month'] }} </td>

                        <td class="amount-main table-warning">
                            <span data-bs-toggle="tooltip" title="{{  $mpossale['cashdata'] ?  $mpossale['cashdata'] : '0.00'  }}"> {{ $mpossale['cash'] ? '₹ '. $mpossale['cash'] : '0.00' }} </span>
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
