<div class="col-lg-4 col-12">
    <div class="entry-box1 p-3">

        <h2>HDFC</h2>
        <div class="row">
            <div class="col-lg-6 col-6">
                <button class="btn btn-hdfc" data-bs-toggle="modal" data-bs-target="#hdfcCardmodel"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Card</button>
            </div>
            <div class="col-lg-6 col-6">
                <button class="btn btn-hdfc" data-bs-toggle="modal" data-bs-target="#hdfcCashmodel"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Cash</button>
            </div>
            {{-- <div class="col-lg-4 col-4">
                <button data-bs-toggle="modal" data-bs-target="#hdfcUPIModal" class="btn btn-hdfc">
                    <i class="fa fa-plus mb-1" aria-hidden="true"></i><br>UPI</button>
            </div>  --}}
        </div>
    </div>



    <x-modals.admin.upload exampleFileLink="{{ asset('public/sample/hdfc-cash-sample.CSV') }}" name="HDFC Cash Upload" id="hdfcCashmodel" url="/admin/upload/add-hdfc-cashdata" />

    <x-modals.admin.upload exampleFileLink="{{ asset('public/sample/hdfc-card-sample.xlsx') }}" name="HDFC Card Upload" id="hdfcCardmodel" url="/admin/upload/add-hdfc-carddata" />

    <x-modals.admin.upload exampleFileLink="{{ asset('public/sample/hdfc-upi-sample.xlsx') }}" name="HDFC UPI Upload" id="hdfcUPIModal" url="/admin/upload/add-hdfc-upidata" />
</div>

{{-- hdfcSpinner --}}
