<!-- Modal popup -->
<div class="modal fade midupdate"
    wire:key="3a0938b213ccac764b3112c482fb8914ff9540b581358bf5a97cffb7051f775d84c6cae8b7b2c4079cac9865d8f98b38a16c2a2d75dcf801fe41f5985c4161ea{{ rand() }}"
    id="exampleModalCenter_{{ $data->amexMIDUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 1300px; padding: 2em">
        <div class="modal-content" style="height: fit-content">
            <form class="forms-sample">
                <div class="modal-header">
                    <h5 class="modal-title">AMEX TID</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-4 ">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>TID</h5>
                                </label>
                                <input type="text" class="form-control" id="MID" value="{{ $data->MID }}">
                            </div>
                        </div>
                        <div class="col-lg-4 d-none">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>POS</h5>
                                </label>
                                <input type="text" class="form-control" id="POS" value="{{ $data->POS ?? 0 }}">
                            </div>
                        </div> 
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Store ID</h5>
                                </label>
                                <input type="number" class="form-control" id="storeID" value="{{ $data->storeID }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label style="color:#000; font-size: 15px; font-weight: bold; margin-bottom:1.0rem">Bank Name</label>
                                <div style="padding: 8px; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                                    {{ $data->tidType ?? 'AMEX' }}
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Store Opening Date</h5>
                                </label>
                                <input type="date" class="form-control" id="openingDt"
                                    value="{{ $data->openingDt }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Old Retek Code</h5>
                                </label>
                                <input type="number" class="form-control" id="oldRetekCode"
                                    value="{{ $data->oldRetekCode }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>New Retek Code</h5>
                                </label>
                                <input type="number" class="form-control" id="newRetekCode"
                                    value="{{ $data->newRetekCode }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Brand Name</h5>
                                </label>
                                <input type="text" class="form-control" id="brandName"
                                    value="{{ $data->brandName }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1" class="pb-2">
                                    <h5 class="d-inline">Status</h5>
                                    <small class="d-inline ml-1">
                                        (International Business/Closed/Operational/Other Status)
                                    </small>
                                </label>
                                <input type="text" class="form-control" id="Status" value="{{ $data->Status }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Closure Date</h5>
                                </label>
                                <input type="date" class="form-control" id="closureDate"
                                    value="{{ $data->closureDate }}">
                            </div>
                        </div>
                        <div class="col-lg-4 d-none">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Revelance</h5>
                                </label>
                                <input type="text" class="form-control" id="relevance"
                                    value="{{ $data->relevance ?? '' }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">
                                        <h5>Date of Conversion</h5>
                                    </label>
                                    <input type="date" class="form-control" id="conversionDt" value="{{ $data->conversionDt }}">
                                </div>
                            </div>
                           
                            
                           
                            
                            
                        </div>
                        
                        <div class="col-lg-4 d-none">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>EDC Service Provider</h5>
                                </label>
                                <input type="text" class="form-control" id="EDCServiceProvider"
                                    value="{{ $data->EDCServiceProvider ?? 0 }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="flex: 1">
                        <div class="footer-loading-btn"
                            style="display: none; text-align:left; margin: 0 1em; flex: 1; color: #000">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span>Loading ...</span>
                        </div>
                    </div>
                    <div class="d-flex" style="gap: 3;">
                        <button x-data
                            @click="(e) => handleFormData(e, '#exampleModalCenter_{{ $data->amexMIDUID }}')"
                            style="width: fit-content" data-id="{{ $data->amexMIDUID }}" type="button"
                            id="modalSubmitButton" class="btn btn-success green">Update</button>
                        <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
