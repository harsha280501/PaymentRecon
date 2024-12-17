<section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">

    <div class="row cash-pickup">
        <div class="col-lg-3">
            <h5>Sales Date</h5>
        </div>

        <div class="col-lg-3">
            <h5>Tender Amount</h5>
        </div>

        <div class="col-lg-3">
            <h5>Deposit Amount</h5>
        </div>
        <div class="col-lg-3">
            <h5>Difference [Tender-Deposit]</h5>
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
            {{ number_format($data->depositAmount, 2) }}
        </div>
        <div class="col-lg-3">
            {{ number_format($data->differenceAmount, 2) }}
        </div>
    </div>
</section>
