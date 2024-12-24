<div class="col-lg-2 col-12">
    <div class="entry-box1 p-3">
        <h2>IDFC</h2>
        <div class="row">
            <div class="col-lg-12 col-6">
                <button data-bs-toggle="modal" data-bs-target="#idfcUploadModal" class="btn btn-idfc"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Cash</button>
            </div>
            <div class="col-lg-4 col-6" style="display: none;">
                <button class="btn btn-idfc"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Credit</button>
            </div>
            <div class="col-lg-4 col-6" style="display: none;">
                <button class="btn btn-idfc"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    <x-modals.commercial-head.upload name="IDFC Bank Upload" id="idfcUploadModal" url="/chead/upload/cash/idfc" exampleFileLink="{{ asset('public/sample/idfc-card-sample.xls') }}" />
</div>
