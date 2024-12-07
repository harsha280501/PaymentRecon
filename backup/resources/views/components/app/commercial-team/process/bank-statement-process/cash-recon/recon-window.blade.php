<section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">

    <div class="row cash-pickup">
        <div class="col-lg-3">
            <h5>Credit Date</h5>
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
            {{ Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}
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
</section>
