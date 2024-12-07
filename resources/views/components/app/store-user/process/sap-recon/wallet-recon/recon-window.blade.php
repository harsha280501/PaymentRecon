<section class="d-flex" style="display: none ; padding: 0 .8em;" id="process-card-recon-window-mobile">

    <div class="row cash-pickup">
        <div class="col-lg-3">
            <h5>Sale Date</h5>
            {{ Carbon\Carbon::parse($data->transactionDate)->format('d-m-Y') }}
        </div>
        <div class="col-lg-2">
            <h5>Sales Amount</h5>
            ₹ {{ number_format($data->walletSale, 2) }}
        </div>

        <div class="col-lg-2">
            <h5>Deposit Date</h5>
            {{ Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}s
        </div>

        <div class="col-lg-2">
            <h5>Deposit Amount</h5>
            ₹ {{ number_format($data->depositAmount, 2) }}
        </div>
        <div class="col-lg-2">
            <h5>Difference [Sale-Collection]</h5>
            ₹ {{ number_format($data->diffSaleDeposit, 2) }}
        </div>
        <div class="col-lg-2">
            <h5>Pending Difference</h5>
            ₹ {{ $data->calculatedDifference }}
        </div>
    </div>


</section>
<section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="process-card-recon-window-desktop">

    <div class="row cash-pickup">
        <div class="col-lg-2">
            <h5>Sale Date</h5>
        </div>
        <div class="col-lg-2">
            <h5>Sales Amount</h5>
        </div>

        <div class="col-lg-2">
            <h5>Deposit Date</h5>
        </div>

        <div class="col-lg-2">
            <h5>Deposit Amount</h5>
        </div>
        <div class="col-lg-2">
            <h5>Difference [Sale-Collection]</h5>
        </div>
        <div class="col-lg-2">
            <h5>Pending Difference</h5>
        </div>
    </div>

    <div class="row cash-pickup-item">
        <div class="col-lg-2">
            {{ Carbon\Carbon::parse($data->transactionDate)->format('d-m-Y') }}
        </div>
        <div class="col-lg-2">
            ₹ {{ number_format($data->walletSale, 2) }}
        </div>

        <div class="col-lg-2">
            {{ Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}
        </div>
        <div class="col-lg-2">
            ₹ {{ number_format($data->depositAmount, 2) }}
        </div>
        <div id="difference" class="col-lg-2">
            ₹ {{ number_format($data->diffSaleDeposit, 2) }}
        </div>
        <div id="difference" class="col-lg-2">
            ₹ {{ $data->calculatedDifference }}
        </div>
    </div>
</section>
