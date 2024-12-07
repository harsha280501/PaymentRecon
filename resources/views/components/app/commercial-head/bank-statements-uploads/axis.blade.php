<div class="col-lg-2 col-12">
    <div class="entry-box1 p-3">
        <h2>AXIS</h2>
        <div class="row">
            <div class="col-lg-12 col-12">
                <button class="btn btn-axis" data-bs-toggle="modal" data-bs-target="#axisBankStatementModel"><i class="fa fa-upload mb-1" aria-hidden="true"></i><br>Upload</button>
            </div>
        </div>
    </div>

    <x-modals.commercial-head.bank-statements-upload.bank-statement-upload text="Axis Bank Statement" name="Axis Bank Statement Upload" id="axisBankStatementModel" url="/chead/upload/bank-statement-upload/axis" exampleFileLink="{{ asset('public/sample/axis-cash-sample.CSV') }}" />
</div>
