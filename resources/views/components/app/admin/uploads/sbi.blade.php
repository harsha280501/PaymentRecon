<div class="col-lg-3 col-12">
    <div class="entry-box1 p-3">
        <h2>SBI</h2>
        <div class="row">
            <div class="col-lg-6 col-4">
                <button data-bs-toggle="modal" data-bs-target="#sbiUploadModal" class="btn btn-sbi">
                    <i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Cash</button>
            </div>
            <div class="col-lg-6 col-4">
                <button data-bs-toggle="modal" data-bs-target="#sbiCardUploadModal" class="btn btn-sbi">
                    <i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Card</button>
            </div>
            <div class="col-lg-4 col-4" style="display: none;">
                <button class="btn btn-sbi"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    <x-modals.commercial-head.upload name="SBI Cash Upload" id="sbiUploadModal" url="/admin/upload/add-sbi-cash" exampleFileLink="{{ asset('public/sample/sbi-cash-sample.xlsx') }}" />
    <x-modals.commercial-head.upload name="SBI Card Upload" id="sbiCardUploadModal" url="/admin/upload/add-sbi-card" exampleFileLink="{{ asset('public/sample/sbi-card-sample.csv') }}" />
</div>
