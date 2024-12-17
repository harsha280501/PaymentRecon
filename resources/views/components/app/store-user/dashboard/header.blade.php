<div style="margin-bottom: -10px !important">
    <div class="row g-6">
        <div class="col-lg-2">
            <div class="form-group">
                <label for="exampleInputUsername1">
                    <h5>Store ID : </h5>
                </label>
                <label for="exampleInputUsername1">
                    <h5 class="text-black">{{auth()->user()->store()['Store ID']}} </h5>
                </label>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label for="exampleInputUsername1">
                    <h5>Retek Code : </h5>
                </label>
                <label for="exampleInputUsername1">
                    <h5 class="text-black">{{auth()->user()->store()['SAP']}} </h5>
                </label>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="exampleInputUsername1">
                    <h5>Brand : </h5>
                </label>
                <label for="exampleInputUsername1">
                    <h5 class="text-black">{{auth()->user()->store()['Brand Name']}}</h5>
                </label>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="exampleInputUsername1">
                    <h5>Location : </h5>
                </label>
                <label for="exampleInputUsername1">
                    <h5 class="text-black">{{auth()->user()->store()['Location']}} , {{auth()->user()->store()['CITY']}} , {{auth()->user()->store()['State']}} , {{intval(auth()->user()->store()['PIN Code'])}}</h5>
                </label>
            </div>
        </div>
    </div>
</div>
