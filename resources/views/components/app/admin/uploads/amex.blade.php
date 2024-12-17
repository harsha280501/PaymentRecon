<div class="col-lg-2 col-12">
    <div class="entry-box1 p-3">
        <h2>AmexPos</h2>
        <div class="row">
            <div class="col-lg-12 col-4">
                <button data-bs-toggle="modal" data-bs-target="#AmexUploadModal" class="btn btn-success"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Card</button>
            </div>
            <div class="col-lg-4 col-4" style="display: none;">
                <button class="btn btn-success"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Credit</button>
            </div>
            {{-- <div class="col-lg-4 col-4" style="display: none;">
                <button class="btn btn-success"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div> --}}
        </div>
    </div>
    <x-modals.commercial-head.upload name="AMEX Card Bank Upload" id="AmexUploadModal" url="/admin/upload/amexdata" exampleFileLink="{{ asset('public/sample/amexpos-card-sample.csv') }}" />

    {{--
    <x-modals.commercial-head.upload exampleFileLink="{{ asset('public/sample/amexpos-card-sample.csv') }}"
    name="Paytm Upload" id="walletModal" url="/upload/cash/all" /> --}}
</div>
