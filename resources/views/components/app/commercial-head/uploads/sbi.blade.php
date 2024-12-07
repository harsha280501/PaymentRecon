<div class="col-lg-10 col-12">
    <div class="entry-box1 p-3" style="height: fit-content">
        <h2>SBI</h2>
        <div class="row">
            <div class="col-lg col-6">
                <button data-bs-toggle="modal" data-bs-target="#sbiUploadModal" class="btn btn-sbi">
                    <i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Cash 94429</button>
            </div>
            <div class="col-lg col-6">
                <button data-bs-toggle="modal" data-bs-target="#sbi2UploadModal" class="btn btn-sbi">
                    <i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Cash MIS 2</button>
            </div>

            <div class="col-lg col-6">
                <button data-bs-toggle="modal" data-bs-target="#sbiCardUploadModal" class="btn btn-sbi">
                    <i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Card</button>
            </div>
            {{-- <div class="col-lg col-6">
                <button data-bs-toggle="modal" class="btn btn-sbi" data-bs-target="#sbiBoxUploadModal"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Agency</button>
            </div>
            <div class="col-lg col-6">
                <button data-bs-toggle="modal" class="btn btn-sbi" data-bs-target="#sbiBoxMumbaiUploadModal"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Mumbai</button>
            </div> --}}
            <div class="col-lg col-6">
                <button data-bs-toggle="modal" class="btn btn-sbi" data-bs-target="#sbiHCM"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br>HCM</button>
            </div>
            <div class="col-lg col-6">
                <button data-bs-toggle="modal" class="btn btn-sbi" data-bs-target="#sbiHCM2"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br>HCM 2</button>
            </div>
        </div>
    </div>

    <x-modals.commercial-head.upload name="SBI Cash Upload" id="sbiUploadModal" url="/chead/upload/add-sbi-cash" exampleFileLink="{{ asset('public/sample/sbi-cash-sample.xlsx') }}" />
    
    <x-modals.commercial-head.upload name="SBI Card Upload" id="sbiCardUploadModal" url="/chead/upload/add-sbi-card" exampleFileLink="{{ asset('public/sample/sbi-card-sample.csv') }}" />
    
    <x-modals.commercial-head.upload name="SBI Agency Upload" id="sbiBoxUploadModal" url="/chead/upload/add-sbi-box" exampleFileLink="{{ asset('public/sample/sbi-card-sample.csv') }}" />

    <x-modals.commercial-head.upload name="SBI MIS2 Upload" id="sbi2UploadModal" url="/chead/upload/add-sbi-cashmis" exampleFileLink="{{ asset('public/sample/sbi_two_example.csv') }}" />

    <x-modals.commercial-head.upload name="SBI Mumbai MIS Upload" id="sbiBoxMumbaiUploadModal" url="/chead/upload/add-sbi-cash-mumbai" exampleFileLink="{{ asset('public/sample/sbi_mumbai_example.csv') }}" />

    <x-modals.commercial-head.upload name="SBI HCM" id="sbiHCM" url="/chead/upload/add-sbi-hcm" exampleFileLink="{{ asset('public/sample/sbi-hcm-example.csv') }}" />

    <x-modals.commercial-head.upload name="SBI HCM 2" id="sbiHCM2" url="/chead/upload/add-sbi-hcm2" exampleFileLink="{{ asset('public/sample/sbi-hcm2-example.csv') }}" />
</div>
