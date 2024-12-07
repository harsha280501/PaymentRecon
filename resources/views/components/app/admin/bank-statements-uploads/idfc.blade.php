<div class="col-lg-2 col-12">
    <div class="entry-box1 p-3">
        <h2>IDFC</h2>
        <div class="row">
            <div class="col-lg-12 col-4">
                <button data-bs-toggle="modal" data-bs-target="#idfcBankStatementUploadModal" class="btn btn-idfc"><i
                        class="fa fa-upload mb-1" aria-hidden="true"></i><br>Upload</button>
            </div>
        </div>
    </div>
    <x-modals.commercial-team.bank-statements-upload.bank-statement-upload text="IDFC Bank Statement" name="IDFC Bank Statement"
        id="idfcBankStatementUploadModal" url="/admin/upload/bank-statement-upload/idfc"
        exampleFileLink="{{ asset('public/sample/idfc-card-sample.xls') }}" />
</div>
