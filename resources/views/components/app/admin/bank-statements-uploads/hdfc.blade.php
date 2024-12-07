<div class="col-lg-2 col-12">

    <div class="entry-box1 p-3">

        <h2>HDFC</h2>

        <div class="row">

            <div class="col-lg-12 col-4">

                <button class="btn btn-hdfc" data-bs-toggle="modal" data-bs-target="#hdfcBankStatementUploadModal"><i

                        class="fa fa-upload mb-1" aria-hidden="true"></i><br>Upload</button>

            </div>

        </div>

    </div>




    <x-modals.commercial-team.bank-statements-upload.bank-statement-upload text="HDFC Bank Statement"

        exampleFileLink="{{ asset('public/sample/hdfc-card-sample.xlsx') }}" name="HDFC Statement Upload"

        id="hdfcBankStatementUploadModal" url="/admin/upload/bank-statement-upload/hdfc" />

</div>
