<div class="col-lg-2 col-12">
    <div class="entry-box1 p-3">
        <h2>SBI</h2>
        <div class="row">
            <div class="col-lg-12 col-4">
                <button data-bs-toggle="modal" data-bs-target="#sbiBankStatementUploadModal" class="btn btn-sbi">
                    <i class="fa fa-upload mb-1" aria-hidden="true"></i><br>Upload</button>
            </div>

        </div>
    </div>
    <x-modals.commercial-team.bank-statements-upload.bank-statement-upload text="SBI Bank Statement" name="SBI Bank Statement"
        id="sbiBankStatementUploadModal" url="/admin/upload/bank-statement-upload/sbi"
        exampleFileLink="{{ asset('public/sample/sbi-cash-sample.xlsx') }}" />

</div>
