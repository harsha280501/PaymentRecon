<div class="col-lg-2 col-12">
    <div class="entry-box1 p-3">
        <h2>Opening Balance </h2>
        <div class="row">
            <div class="col-lg-12 col-12">
                <button data-bs-toggle="modal" data-bs-target="#openingBalanceUploadModal" class="btn btn-idfc"><i class="fa fa-upload mb-1" aria-hidden="true"></i><br>Upload</button>
            </div>
        </div>
    </div>
    <x-modals.commercial-head.bank-statements-upload.bank-statement-upload text="Opening Balance" name="Opening Balance" id="openingBalanceUploadModal" url="/chead/upload/bank-statement-upload/opbalance" exampleFileLink="{{ asset('public/sample/opbalance-sample.xlsx') }}" />
</div>
