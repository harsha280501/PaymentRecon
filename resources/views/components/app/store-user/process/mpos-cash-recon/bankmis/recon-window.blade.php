<section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">

    <div class="row cash-pickup">
        <div class="col-lg-3">
            <h5>MPOS Date</h5>
        </div>
        <div class="col-lg-3">
            <h5>Bank Drop Amount</h5>
        </div>
        <div class="col-lg-3">
            <h5>Deposit Amount</h5>
        </div>
        <div class="col-lg-3">
            <h5>Difference [Bank Drop - Deposit]</h5>
        </div>
    </div>

    <div class="row cash-pickup-item">
        <div class="col-lg-3">
            {{ Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}
        </div>
        <div class="col-lg-3">
            ₹ {{ number_format($data->bankDropAmount, 2) }}
        </div>
        <div class="col-lg-3">
            ₹ {{ number_format($data->depositAmount, 2) }}
        </div>
        <div id="difference" class="col-lg-3">
            ₹ {{ number_format($data->DiffAmount, 2) }}

        </div>
    </div>
</section>
