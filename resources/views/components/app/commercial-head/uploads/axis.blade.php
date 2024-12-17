<div class="col-lg-2 col-12">
    <div class="entry-box1 p-3">
        <h2>AXIS</h2>
        <div class="row">
            <div class="col-lg-12 col-6">
                <button class="btn btn-axis" data-bs-toggle="modal" data-bs-target="#axisCashmodel"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Cash</button>
            </div>
            <div class="col-lg-4 col-6" style="display: none;">
                <button class="btn btn-axis"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br>Card</button>
            </div>
            <div class="col-lg-4 col-6" style="display: none;">
                <button class="btn btn-axis"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>

    <x-modals.commercial-head.upload name="Axis Cash Upload" id="axisCashmodel" url="/chead/upload/add-axis-cash" exampleFileLink="{{ asset('public/sample/axis-cash-sample.CSV') }}" />

</div>
