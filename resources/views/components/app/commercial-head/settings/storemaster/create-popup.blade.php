<div class="modal fade" id="storemasterCreate" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document" style="max-width:90%;">
        <div class="modal-content">
            <form x-data x-on:submit.prevent="createFormData">
                <div class="modal-header">
                    <h5 class="modal-title">Store Master</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>MGP SAP code : </h5>
                                </label>
                                <input type="number" class="form-control" id="MGPSAPcode" name="MGPSAPcode" value="" placeholder="100021" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Store ID : </h5>
                                </label>
                                <input type="number" class="form-control" id="StoreID" name="StoreID" value="" required placeholder="0000">
                                <div id="storeIDError" style="color: red;"></div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>RETEK Code : </h5>
                                </label>
                                <input type="number" class="form-control" id="RETEKCode" name="RETEKCode" value="" placeholder="00000" required>
                                <div id="RETEKCodeError" style="color: red;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Brand Desc : </h5>
                                </label>
                                <input type="text" class="form-control" id="BrandDesc" name="BrandDesc" value="" placeholder="(UPPERCASE/CAPITAL).. PETER ENGLAND" required>
                                <div id="BrandDescError" style="color: red;"></div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Sub Brand : </h5>
                                </label>
                                <input type="text" class="form-control" id="SubBrand" name="SubBrand" placeholder="PETER ENGLAND/BERLIN" value="" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>StoreTypeasperBrand : </h5>
                                </label>
                                <input type="text" class="form-control" id="StoreTypeasperBrand" name="StoreTypeasperBrand" placeholder="PO" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Channel : </h5>
                                </label>
                                <input type="text" class="form-control" id="Channel" name="Channel" value="" required>
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Store Name : </h5>
                                </label>
                                <input type="text" class="form-control" id="StoreName" name="StoreName" value="" placeholder="i.e,. new store" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Store opening Date : </h5>
                                </label>
                                <input type="date" class="form-control" id="StoreopeningDate" name="StoreopeningDate" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Status : </h5>
                                </label>
                                <input type="text" class="form-control" id="SStatus" name="SStatus" placeholder="i.e,. Active" value="">
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Location : </h5>
                                </label>
                                <input type="text" class="form-control" id="Location" name="Location" value="" placeholder="i.e,. BANGALORE" required>
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>City : </h5>
                                </label>
                                <input type="text" class="form-control" id="City" name="City" value="" placeholder="i.e,. Miami" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>State : </h5>
                                </label>
                                <input type="text" class="form-control" id="State" name="State" value="" placeholder="i.e, Florida" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Address : </h5>
                                </label>
                                <input type="text" class="form-control" id="Address" name="Address" value="" required>
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Pin code : </h5>
                                </label>
                                <input type="number" class="form-control" id="Pincode" name="Pincode" value="" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Store Area : </h5>
                                </label>
                                <input type="text" class="form-control" id="StoreArea" name="StoreArea" value="" required>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Region : </h5>
                                </label>
                                <input type="text" class="form-control" id="Region" name="Region" placeholder="i.e,. INDIA" value="" required>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Store Manager Name : </h5>
                                </label>
                                <input type="text" class="form-control" id="StoreManagerName" name="StoreManagerName" placeholder="i.e,. Bernard Hackwell" value="" required>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Contact no : </h5>
                                </label>
                                <input type="number" class="form-control" id="Contactno" name="Contactno" value="+91" required>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Basement occupied (Y/No) : </h5>
                                </label>
                                <input type="text" class="form-control" id="Basementoccupied" name="Basementoccupie" value="" required>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>ARM email id : </h5>
                                </label>
                                <input type="email" class="form-control" id="ARMemailid" name="ARMemailid" value="" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>RM email id : </h5>
                                </label>
                                <input type="email" class="form-control" id="RMemailid" name="RMemailid" value="" required>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>NROM email id : </h5>
                                </label>
                                <input type="email" class="form-control" id="NROMemailid" name="NROMemailid" value="" required>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>RCM mail : </h5>
                                </label>
                                <input type="email" class="form-control" id="RCMmail" name="RCMmail" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Correct store email id : </h5>
                                </label>
                                <input type="email" class="form-control" id="Correctstoreemailid" name="Correctstoreemailid" value="" required>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>HO contact : </h5>
                                </label>
                                <input type="number" class="form-control" id="HOcontact" name="HOcontact" value="" required>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>RD email id : </h5>
                                </label>
                                <input type="email" class="form-control" id="RDemailid" name="RDemailid" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Pickup Bank : </h5>
                                </label>
                                <input type="text" class="form-control" id="PickupBank" name="PickupBank" value="" placeholder="i.e,. HDFC" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>OLD IO No : </h5>
                                </label>
                                <input type="text" class="form-control" id="OLDIONo" name="OLDIONo" value="" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>New IO No : </h5>
                                </label>
                                <input type="text" class="form-control" id="NewIONo" name="NewIONo" value="" required>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Located : </h5>
                                </label>
                                <input type="text" class="form-control" id="Located" name="Located" value="" required>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>QTR : </h5>
                                </label>
                                <input type="text" class="form-control" id="QTR" name="QTR" value="">
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="modal-footer">

                        <div class="footer-loading-btn" style="display: none; text-align:left; margin: 0 1em; flex: 1; color: #000">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span>Loading ...</span>
                        </div>

                        {{-- <button x-data data-bs-target="#exampleModalCenter_{{ $data->{'Store ID'} }} data-id="{{ $data->{'Store ID'} }}" data-bs-toggle="modal" type="button" class="btn btn-success green">Edit</button> --}}
                        <button type="submit" class="btn btn-success green">Save</button>
                        <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
