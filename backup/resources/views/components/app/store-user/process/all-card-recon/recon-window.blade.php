<section class="d-flex justify-content-center forms-sample">
    <div class="d-flex flex-column w-100 align-items-between justify-content-center" style="border: 1px solid #000">
        <div class=" w-100">
            <div class="d-flex justify-content-between align-items-center gap-1 px-2" style="border-bottom: 1px solid #000; width: 100%">
                <h5 class="text-black">Sales Date: </h5>
                <p class="text-black mt-1">{{ $data->saleDate }}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-1 px-2" style="border-bottom: 1px solid #000; width: 100%">
                <h5 class="text-black">HDFC: </h5>
                <p class="text-black mt-1">{{ $data->SALES_HDFC }}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-1 px-2" style="border-bottom: 1px solid #000; width: 100%">
                <h5 class="text-black">ICICI: </h5>
                <p class="text-black mt-1">{{ $data->SALES_ICICI }}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-1 px-2" style="border-bottom: 1px solid #000; width: 100%">
                <h5 class="text-black">SBI: </h5>
                <p class="text-black mt-1">{{ $data->SALES_SBI }}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-1 px-2" style="border-bottom: 1px solid #000; width: 100%">
                <h5 class="text-black">AMEX: </h5>
                <p class="text-black mt-1">{{ $data->SALES_AMEX }}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-1 px-2" style=" width: 100%">
                <h5 class="text-black">HDFC UPI: </h5>
                <p class="text-black mt-1">{{ $data->SALES_UPIH }}</p>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column w-100 align-items-between justify-content-center" style="border: 1px solid #000">
        <div class=" w-100">
            <div class="d-flex justify-content-between align-items-center gap-1 px-2" style="border-bottom: 1px solid #000; width: 100%">
                <h5 class="text-black">Deposit Date: </h5>
                <p class="text-black mt-1">{{ $data->depositDt }}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-1 px-2" style="border-bottom: 1px solid #000; width: 100%">
                <h5 class="text-black">HDFC: </h5>
                <p class="text-black mt-1">{{ $data->COLL_HDFC }}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-1 px-2" style="border-bottom: 1px solid #000; width: 100%">
                <h5 class="text-black">ICICI: </h5>
                <p class="text-black mt-1">{{ $data->COLL_ICICI }}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-1 px-2" style="border-bottom: 1px solid #000; width: 100%">
                <h5 class="text-black">SBI: </h5>
                <p class="text-black mt-1">{{ $data->COLL_SBI }}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-1 px-2" style="border-bottom: 1px solid #000; width: 100%">
                <h5 class="text-black">AMEX: </h5>
                <p class="text-black mt-1">{{ $data->COLL_AMEX }}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-1 px-2" style="width: 100%">
                <h5 class="text-black">HDFC UPI: </h5>
                <p class="text-black mt-1">{{ $data->COLL_UPIH }}</p>
            </div>
        </div>
    </div>
</section>

<section class="d-flex mt-3" style="flex-direction: column; padding: 0 .8em;" id="process-card-recon-window-desktop">

    <div class="row cash-pickup">

        <div class="col-lg-4 text-center">
            <h5>Total Sales</h5>
        </div>
        <div class="col-lg-4 text-center">
            <h5>Total Collection</h5>
        </div>

        <div class="col-lg-4 text-center">
            <h5>Total Difference</h5>
        </div>

    </div>

    <div class="row cash-pickup-item">

        <div class="col-lg-4 text-center">
            {{ $data->TotalSales }}
        </div>

        <div class="col-lg-4 text-center">
            {{ $data->TotalCollection }}
        </div>
        <div class="col-lg-4 text-center">
            {{ $data->Difference }}
        </div>
    </div>
</section>
