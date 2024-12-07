<div class="col-lg-3 col-12">
    <div class="entry-box1 p-3">
        <h2>ICICI</h2>
        <div class="row">
            <div class="col-lg-6 col-6">
                <button data-bs-toggle="modal" data-bs-target="#iciciUploadModal" class="btn btn-icici"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Cash</button>
            </div>
            <div class="col-lg-6 col-6">
                <button class="btn btn-icici" data-bs-toggle="modal" data-bs-target="#icicicreditUploadModal"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Card</button>
            </div>
            <div class="col-lg-4 col-4" style="display: none;">
                <button class="btn btn-icici"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    <x-modals.commercial-head.upload name="ICICI Cash Upload" id="iciciUploadModal" url="/cuser/upload/cash/icici" exampleFileLink="{{ asset('public/sample/icici-cash-sample.CSV') }}" />
    <x-modals.commercial-head.upload name="ICICI Card Upload" id="icicicreditUploadModal" url="/cuser/upload/card/icici" exampleFileLink="{{ asset('public/sample/icici-card-sample.xls') }}" />
</div>
