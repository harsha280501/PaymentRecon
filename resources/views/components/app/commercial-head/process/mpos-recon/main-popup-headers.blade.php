<form class="forms-sample">
    <div class="row" style="margin-bottom: -20px">
        <h5>Reconciliation dashboard</h5>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="exampleInputUsername1">
                    <h5>Store ID : </h5>
                </label>
                <label for="exampleInputUsername1">
                    <h5>{{ $data->storeID }} </h5>
                </label>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="exampleInputUsername1">
                    <h5>Retek Code : </h5>
                </label>
                <label for="exampleInputUsername1">
                    <h5>{{ $data->retekCode }}</h5>
                </label>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="exampleInputUsername1">
                    <h5>Brand : </h5>
                </label>
                <label for="exampleInputUsername1">
                    <h5>{{ $data->brand }}</h5>
                </label>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="exampleInputUsername1">
                    <h5>Location : </h5>
                </label>
                <label for="exampleInputUsername1">
                    <h5>{{ $data->Location }}</h5>
                </label>
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom: -20px">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="exampleInputUsername1">
                    <h5>Reconciliation Date : </h5>
                </label>
                <label for="exampleInputUsername1">
                    <h5>{{ Carbon\Carbon::parse($data->createdDate)->format('d-m-Y')
                    }}</h5>
                </label>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="exampleInputUsername1">
                    <h5>Bank Drop ID:</h5>
                </label>
                <label for="exampleInputUsername1">
                    <h5>{{ $data->bankDropID }}</h5>
                </label>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="form-group">
                <label for="exampleInputUsername1">
                    <h5>Bank Drop Amount :</h5>
                </label>
                <label for="exampleInputUsername1">
                    <h5>{{ $data->bankDropAmount }}</h5>
                </label>
            </div>
        </div>

    </div>
</form>
