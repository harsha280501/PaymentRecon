<!-- Modal popup -->
<div wire:ignore wire:key="2919863a34ff72602952049255f0e3b2222d9dbb0e7a3b2ded08494cd134e2fd_{{ rand() }}" class="modal fade midupdate" id="exampleModalCenterSecondTab_{{ $data->iciciMIDUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 1300px; padding: 2em">
        <div class="modal-content" style="height: fit-content">
            <form class="forms-sample">
                <div class="modal-header">
                    <h5 class="modal-title">ICICI TID</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>TID</h5>
                                </label>
                                <input type="text" class="form-control" id="MID" value="{{ $data->MID }}">
                            </div>
                        </div>
                     
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Store ID</h5>
                                </label>
                                <input type="text" class="form-control" id="storeID" value="{{ $data->storeID }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" >
                                <label style="color:#000; font-size: 15px; font-weight: bold;margin-bottom:1.5rem ">Bank Name</label>
                                <div style="padding: 5px; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9;">
                                    {{ $data->tidType ?? 'ICICI' }}
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
                                <input type="date" class="form-control" id="openingDt" value="{{ $data->openingDt }}">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Old Retek Code</h5>
                                </label>
                                <input type="number" class="form-control" id="oldRetekCode" value="{{ $data->oldRetekCode }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>New Retek Code</h5>
                                </label>
                                <input type="number" class="form-control" id="newRetekCode" value="{{ $data->newRetekCode }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Brand Code : </h5>
                                </label>
                                <input type="text" class="form-control" id="brandCode" value="{{ $data->brandCode }}">
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
                                <input type="text" class="form-control" id="status" value="{{ $data->status }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Closure Date</h5>
                                </label>
                                <input type="date" class="form-control" id="closureDate" value="{{ $data->closureDate }}">
                            </div>
                        </div>
                        <div class="col-lg-4 d-none">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Revelance</h5>
                                </label>
                                <input type="text" class="form-control" id="relevance" value="{{ $data->relevance ?? ''}}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Date of Conversion</h5>
                                </label>
                                <input type="date" class="form-control" id="conversionDt" value="{{ $data->conversionDt }}">
                            </div>
                        </div>
                        <div class="col-lg-4 d-none">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>EDC Service Provider</h5>
                                </label>
                                <input type="text" class="form-control" id="EDCServiceProvider" value="{{ $data->EDCServiceProvider ?? ''}}">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div style="flex: 1">
                            <div class="footer-loading-btn" style="display: none; text-align:left; margin: 0 1em; flex: 1; color: #000">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span>Loading ...</span>
                            </div>
                        </div>
                        <div class="d-flex" style="gap: 3">
                            <button x-data @click="(e) => handleFormDataicici(e, '#exampleModalCenterSecondTab_{{ $data->iciciMIDUID }}')" style="width: fit-content" data-id="{{ $data->iciciMIDUID }}" type="button" id="modalSubmitButton" class="btn btn-success green">Update</button>
                            <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>