<section class="d-flex" style="flex-direction: column; padding: 0 .8em; display: none" id="process-card-recon-window-mobile">

    <div class="row cash-pickup">
        <div class="col-lg-3">
            <h5>Tender Date</h5>
            {{ Carbon\Carbon::parse($data->mposDate)->format('d-m-Y') }}
        </div>
        <div class="col-lg-2">
            <h5>Tender Amount</h5>
            {{ $data->tenderAmountF }}
        </div>
        <div class="col-lg-2">
            <h5>Deposit Date</h5>
            {{ Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}

        </div>
        <div class="col-lg-2">
            <h5>Deposit Amount</h5>
            {{ $data->depositAmountF }}

        </div>
        <div class="col-lg-3">
            <h5>Difference [Tender - Deposit]</h5>
            {{ $data->bank_cash_differenceF }}

        </div>
    </div>
</section>

<section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="process-card-recon-window-desktop">

    <div class="row cash-pickup">
        <div class="col-lg-2">
            <h5>Tender Date</h5>
        </div>
        <div class="col-lg-2">
            <h5>Tender Amount</h5>
        </div>
        <div class="col-lg-2">
            <h5>Deposit Date</h5>
        </div>
        <div class="col-lg-2">
            <h5>Deposit Amount</h5>
        </div>
        <div class="col-lg-2">
            <h5>Difference [Tender - Deposit]</h5>
        </div>
        <div class="col-lg-2">
            <h5>Pending Difference </h5>
        </div>
    </div>

    <div class="row cash-pickup-item">
        <div class="col-lg-2">
            {{ Carbon\Carbon::parse($data->mposDate)->format('d-m-Y') }}
        </div>
        <div class="col-lg-2">
            {{ $data->tenderAmountF }}
        </div>
        <div class="col-lg-2">
            {{ Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}
        </div>
        <div class="col-lg-2">
            {{ $data->depositAmountF }}
        </div>
        <div id="difference" class="col-lg-2">
            {{ $data->bank_cash_differenceF }}
        </div>

        <div id="difference" class="col-lg-2">
            ₹ {{ number_format($data->calculatedDifference, 2) }}
        </div>
    </div>
</section>
