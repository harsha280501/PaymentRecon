<div class="col-lg-2 col-12">
    <div class="entry-box1 p-3">
        <h2>ICICI</h2>
        <div class="row">
            <div class="col-lg-12 col-6">
                <button data-bs-toggle="modal" data-bs-target="#iciciBankStatementUploadModal" class="btn btn-icici"><i
                        class="fa fa-upload mb-1" aria-hidden="true"></i><br>Upload</button>
            </div>
        </div>
    </div>
    <x-modals.commercial-team.bank-statements-upload.bank-statement-upload text="ICICI Bank Statement" name="ICICI Bank Statement"
        id="iciciBankStatementUploadModal" url="/admin/upload/bank-statement-upload/icici"
        exampleFileLink="{{ asset('public/sample/icici-cash-sample.CSV') }}" />
</div>
