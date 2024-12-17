<section id="recent">
    <div class="row">
        <div class="col-lg-12">

            <div style="overflow-x: scroll !important">
                <table class="table table-responsive table-info">
                    <thead>
                        <tr>
                            <th>Correction Tracking ID</th>
                            <th>Record ID</th>
                            <th>Exp Dep Date</th>
                            <th>Retek Code</th>
                            <th>Brand</th>
                            <th>Col Bank</th>
                            <th>Sales Amount</th>
                            <th>Collection Amount</th>
                            <th>Difference[sale-coll]</th>
                            <th>Status</th>
                            <th>Select Entry</th>
                            <th>Match With</th>

                        </tr>
                    </thead>

                    <tbody wire:loading.class='none'>
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
                            <td>{{ $data->diffSaleDeposit }}</td>
                            <td>{{ $data->status }}</td>
                            <td><input type="checkbox"></td>
                            <td>
                                <div class="dropdown ms-0 ml-md-4 mt-2 mt-lg-0">
                                    <a class="dropdown-toggle d-flex " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cash Pickup</a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Cash Pickup</a>
                                        <a class="dropdown-item" href="#">Bank Deposit</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if (count($dataset) < 1) <p class="mt-3">
                    No data available
                    </p>
                    @endif

                    <div style="display: none; text-align:center; margin: 1em 0" wire:loading.class="mainLoading">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span>Loading ...</span>
                    </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $dataset->links() }}
        </div>
    </div>

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
                                    <label for="exampleInputConfirmPassword1">Approval</label>
                                    <input type="password" class="form-control" id="exampleInputConfirmPassword1" placeholder="Disapproved">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Matching Criteria / Mismatch Reason</label><br>
                                    <textarea rows="4" cols="85" name="comment"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1">Reason for disapproval</label><br>
                                    <textarea rows="4" cols="69" name="comment"></textarea>
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
                                    <td>5000</td>

                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>

                                </tr>
                                <tr>
                                    <td>Cash MIS Match</td>
                                    <td>5000</td>

                                </tr>
                                <tr>
                                    <td>Direct Deposit Match</td>
                                    <td>0</td>

                                </tr>
                                <tr>
                                    <td>Adjustment Entry</td>
                                    <td>0</td>

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


</section>
