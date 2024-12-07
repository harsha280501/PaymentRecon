<section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">



    @if ($data->reconStatus == 'disapprove')
    <div class="row cash-pickup">
        <div class="col-lg-1">
            <h5>Deposit Date</h5>
        </div>
        <div class="col-lg-2 text-center">
            <h5>Credit Amount</h5>
        </div>
        <div class="col-lg-2">
            <h5>Collection Amount</h5>
        </div>
        <div class="col-lg-2">
            <h5>Difference [Sale-Collection]</h5>
        </div>
        <div class="col-lg-2">
            <h5>Recon Status</h5>
        </div>
        <div class="col-lg-3">
            <h5>Reason for Disapproval</h5>
        </div>
    </div>

    <div class="row cash-pickup-item">
        <div class="col-lg-1">
            {{ Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}
        </div>
        <div class="col-lg-2">
            ₹ {{ number_format($data->creditAmount, 2) }}
        </div>
        <div class="col-lg-2">
            ₹ {{ number_format($data->depositAmount, 2) }}
        </div>
        <div id="difference" class="col-lg-2">
            ₹ {{ number_format($data->diffSaleDeposit, 2) }}
        </div>
        <div id="" class="col-lg-2">
            {{ ucfirst($data->reconStatus) }}
        </div>
        <div id="" class="col-lg-3">
            {{ $data->approvalRemarks }}
        </div>
    </div>
    @else

    <div class="row cash-pickup">
        <div class="col-lg-3">
            <h5>Deposit Date</h5>
        </div>
        <div class="col-lg-3">
            <h5>Credit Amount</h5>
        </div>
        <div class="col-lg-3">
            <h5>Collection Amount</h5>
        </div>
        <div class="col-lg-3">
            <h5>Difference [Sale-Collection]</h5>
        </div>
    </div>

    <div class="row cash-pickup-item">
        <div class="col-lg-3">
            {{ Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}
        </div>
        <div class="col-lg-3">
            ₹ {{ number_format($data->creditAmount, 2) }}
        </div>
        <div class="col-lg-3">
            ₹ {{ number_format($data->depositAmount, 2) }}
        </div>
        <div id="difference" class="col-lg-3">
            ₹ {{ number_format($data->diffSaleDeposit, 2) }}
        </div>
    </div>
    @endif

</section>
