<div class="modal fade" id="exampleModalCenter" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document" style="max-width:90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cash Pickup</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputUsername1">Reconciled By </label>
                                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Email/Login ID">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Approved By</label>
                                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Email/Login ID">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Adj.Amount (Exp, Adj,Debit entry etc.)</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Matching Criteria / Mismatch Reason</label><br>
                                <textarea rows="4" cols="75" name="comment"></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-lg-6">
                            <label for="exampleInputConfirmPassword1">Upload Proof(If any)</label>
                            <input type="file" class="form-control" id="exampleInputConfirmPassword1" placeholder="Password">
                        </div>
                    </div>



                </form>




                <div class="modal-header-data">
                    <h5 class="modal-title-data">Data Matching</h5>
                </div>


                <!-- TABLE -->
                <section id="recent">
                    <table class="table table-responsive table-info">
                        <thead>
                            <tr>
                                <th>Particulars</th>
                                <th>Amount</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Sales Under Reconcilliation</td>
                                <td><input type="text" class="form-control" id="exampleInputUsername1"    placeholder="5000"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Cash MIS Match</td>
                                <td><input type="text" class="form-control" id="exampleInputUsername1"    placeholder="0"></td>

                            </tr>
                            <tr>
                                <td>Direct Deposit Match</td>
                                <td><input type="text" class="form-control" id="exampleInputUsername1"    placeholder="0"></td>

                            </tr>
                            <tr>
                                <td>Adjustment Entry</td>
                                <td><input type="text" class="form-control" id="exampleInputUsername1"    placeholder="0"></td>

                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>5000</td>

                            </tr>
                        </tbody>
                    </table>
                </section>
                <!-- TABLE END-->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success green">Save</button>
                <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
</div>

{{-- <div class="mt-4">
    {{ $dataset->links() }}
</div>

@foreach ($dataset as $data)
<tr>
    <td>1</td>
    <td>3</td>
    <td>{{ Carbon\Carbon::parse($data->expDepDate)->format('d-m-Y') }}</td>
    <td>{{ $data->retekCode }}</td>
    <td>{{ $data->brand }}</td>
    <td>{{ $data->pickupBank }}</td>
    <td>{{ strval($data->cashSale) }}</td>
    <td>{{ $data->depositAmount }}</td>
    <td>{{ $data->diffSaleDeposit }}</td> --}}
<script type="text/javascript" difer>
    const errorMessageConfiguration = (message) => {
     return Swal.fire("Error!", message, "error");
 };

/**
 * Generating success response
 * @param {*} message
 * @returns
 */
 const succesMessageConfiguration = (message) => {
     return Swal.fire("Success!", message, "success");
 };

// fetch idfc data

const mainUpload = async (url, data,dateImport) => {


    if (!dateImport || dateImport == undefined) {
        errorMessageConfiguration("Please select date");
        return false;
    }

    if (!data || data == undefined) {
        errorMessageConfiguration("Please import a file");
        return false;
    }

    // form data
    const formData = new FormData();
    formData.append("repositoryFileUpload", data);
    formData.append("exampleInputUsername1", dateImport);
    formData.append("exampleInputPassword1", dateImport);
    formData.append("exampleInputConfirmPassword1", dateImport);
    formData.append("exampleInputUsername1", dateImport);

    // Fetch main data
    const {
        data: main,
        isError,
        error,
    } = await request.http({
        url,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
    });
    // Error
    if (isError) {
        errorMessageConfiguration(error?.mesage);
        return false;
    }
    // main
    return main;
};

    // Commerical Head Repository Upload

const repositoryModal = document.querySelector("#repositoryupload");
const repositoryModalSubmitButton = repositoryModal.querySelector("#uploadRepositoryBtn");
const repositoryFileUpload = repositoryModal.querySelector("#repositoryFileUpload");
const dateImport = document.querySelector("#dateImport");

/**
 * Main Submit Event
 */
repositoryModalSubmitButton.addEventListener("click", async (e) => {
    const loader = repositoryModal.querySelector('.loader');
    loader.style.display = 'unset';
    // upload file
    const data = await mainUpload('/chead/repository/upload', repositoryFileUpload.files[0],dateImport.value);
    // if not data, dont want to contineu
    if (!data) {
        loader.style.display = 'none';
        return false;
    }
    // show success message
    succesMessageConfiguration("Successfully uploaded");
    loader.style.display = 'none';
    window.location.reload();
});

</script>
