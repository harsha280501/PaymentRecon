<div class="col-lg-3 col-12">
    <div class="entry-box1 p-3">
        <h2>Wallet</h2>
        <div class="row">
            <div class="col-lg-6 col-4">
                <button data-bs-toggle="modal" data-bs-target="#PhonepayUploadModal" class="btn btn-success"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br>PhonePay</button>
            </div>
            <div class="col-lg-6 col-4">
                <button data-bs-toggle="modal" data-bs-target="#PayTMUploadModal" class="btn btn-success"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br>PayTM</button>
            </div>
            <div class="col-lg-4 col-4" style="display: none;">
                <button class="btn btn-success"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    <x-modals.commercial-head.upload name="PHONEPAY Upload" id="PhonepayUploadModal" url="/cuser/upload/phonepay" exampleFileLink="{{ asset('public/sample/phonepay-sample.csv') }}" />

    <x-modals.commercial-head.upload exampleFileLink="{{ asset('public/sample/idfc-example-csv.xlsx') }}" name="PAYTM Upload" id="PayTMUploadModal" url="/cuser/upload/paytm" />
</div>
