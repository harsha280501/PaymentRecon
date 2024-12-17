<section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">
    @if ($data->reconStatus == 'disapprove')
        <div class="row cash-pickup">
            <div class="col-lg-2">
                <h5>Sales Date</h5>
            </div>

            <div class="col-lg-2">
                <h5>Tender Amount</h5>
            </div>

            <div class="col-lg-2">
                <h5>Bank Drop Amount</h5>
            </div>
            <div class="col-lg-3">
                <h5>Difference [Tender-Bank Drop]</h5>
            </div>

            <div class="col-lg-3">
                <h5>Reason for Disapproval</h5>
            </div>

        </div>

        <div class="row cash-pickup-item">
            <div class="col-lg-2">
                {{ Carbon\Carbon::parse($data->mposDate)->format('d-m-Y') }}
            </div>

            <div class="col-lg-2">
                {{ number_format($data->tenderAmount, 2) }}
            </div>
            <div class="col-lg-2">
                {{ number_format($data->bankDropAmount, 2) }}
            </div>
            <div class="col-lg-3">
                {{ number_format($data->differenceAmount, 2) }}
            </div>

            <div class="col-lg-3">
                {{ number_format($data->approvalRemarks, 2) }}
            </div>
        </div>
    @else
        <div class="row cash-pickup">
            <div class="col-lg-3">
                <h5>Sales Date</h5>
            </div>

            <div class="col-lg-3">
                <h5>Tender Amount</h5>
            </div>

            <div class="col-lg-3">
                <h5>Bank Drop Amount</h5>
            </div>
            <div class="col-lg-3">
                <h5>Difference [Tender-Bank Drop]</h5>
            </div>
        </div>

        <div class="row cash-pickup-item">
            <div class="col-lg-3">
                {{ Carbon\Carbon::parse($data->mposDate)->format('d-m-Y') }}
            </div>

            <div class="col-lg-3">
                {{ number_format($data->tenderAmount, 2) }}
            </div>
            <div class="col-lg-3">
                {{ number_format($data->bankDropAmount, 2) }}
            </div>
            <div class="col-lg-3">
                {{ number_format($data->differenceAmount, 2) }}
            </div>
        </div>
    @endif

</section>
