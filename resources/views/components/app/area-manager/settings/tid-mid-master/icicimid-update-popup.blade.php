<div class="modal fade" id="exampleModalCenterSecondTab_{{ $data->iciciMIDUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document" style="max-width:90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ICICI MID</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>MID : </h5>
                                </label>
                                <input type="text" class="form-control" id="MID" value="{{ $data->MID }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>POS : </h5>
                                </label>
                                <input type="text" class="form-control" id="POS" value="{{ $data->POS }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>SAPCODE : </h5>
                                </label>
                                <input type="text" class="form-control" id="sapCode" value="{{ $data->sapCode }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>RETEKCODE : </h5>
                                </label>
                                <input type="text" class="form-control" id="retekCode" value="{{ $data->retekCode }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>BRANDCODE : </h5>
                                </label>
                                <input type="text" class="form-control" id="brandCode" value="{{ $data->brandCode }}">
                            </div>
                        </div>



                </form>

                <br>

                <div class="modal-footer">

                    <div class="footer-loading-btn" style="display: none; text-align:left; margin: 0 1em; flex: 1; color: #000">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span>Loading ...</span>
                    </div>
                    <button x-data @click="(e) => handleFormDataicici(e, '#exampleModalCenterSecondTab_{{ $data->iciciMIDUID }}')" style="" data-id="{{ $data->iciciMIDUID }}" type="button" id="modalSubmitButton" class="btn btn-success green">Update</button>



                    {{-- <a href="#"  data-bs-toggle="modal1" data-bs-target="#exampleModalCenterSecondTab_{{ $data->iciciMIDUID }}"  type="button" class="btn btn-success green">Edit</a> --}}

                    <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                </div>
        </div>
    </div>
</div>
</div>
