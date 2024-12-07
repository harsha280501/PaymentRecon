<section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">
    @if ($data->reconStatus == 'disapprove')

    <div class="row cash-pickup">
        <div class="col-lg-2">
            <h5>Tender Date</h5>
        </div>

        <div class="col-lg-2">
            <h5>Tender Amount</h5>
        </div>

        <div class="col-lg-2">
            <h5>Deposit Amount</h5>
        </div>
        <div class="col-lg-3">
            <h5>Difference [tender-deposit]</h5>
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
            {{ $data->tenderAmountF }}
        </div>
        <div class="col-lg-2">
            {{ $data->depositAmountF }}
        </div>
        <div class="col-lg-3">
            {{ $data->bank_cash_differenceF }}
        </div>
        <div class="col-lg-3">
            {{ $data->approvalRemarks }}
        </div>
    </div>
    @else
    <div class="row cash-pickup">
        <div class="col-lg-2">
            <h5>Tender Date</h5>
        </div>

        <div class="col-lg-2">
            <h5>Tender Amount</h5>
        </div>

        <div class="col-lg-2">
            <h5>Deposit Amount</h5>
        </div>
        <div class="col-lg-3">
            <h5>Difference [tender-deposit]</h5>
        </div>

        <div class="col-lg-3">
            <h5>Pending Difference</h5>
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
            {{ $data->depositAmountF }}
        </div>
        <div class="col-lg-3">
            {{ $data->bank_cash_differenceF }}
        </div>
        <div class="col-lg-3">
            {{ $data->calculatedDifference }}
        </div>
    </div>

    @endif
</section>
