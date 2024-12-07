<!-- Modal popup -->
<div class="modal fade" id="sbiCreate" tabindex="1" role="dialog" aria-labelledby="repo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px;">
        <div class="modal-content">
            <form x-data x-on:submit.prevent="createSbiFormData">
                <!-- Add a form element with an ID for handling form submission -->
                <div class="modal-header">
                    <h5 class="modal-title">SBI MID</h5>
                    <div class="right">
                        <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <div class="modal-body" style="height: 300px !important">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label style="color:#800000;font-weight:600;">MID</label>
                            <input type="text" class="form-control" id="MID" name="MID" value="" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label style="color:#800000;font-weight:600;">POS</label>
                            <input type="text" class="form-control" id="POS" name="POS" value="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label style="color:#800000;font-weight:600;">SAPCODE</label>
                            <input type="text" class="form-control" id="sapCode" name="sapCode" value="" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label style="color:#800000;font-weight:600;">RETEKCODE</label>
                            <input type="text" class="form-control" id="retekCode" name="retekCode" value="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label style="color:#800000;font-weight:600;">BRANDNAME</label>
                            <input type="text" class="form-control" id="brandName" name="brandName" value="" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="flex: 1">
                        <div class="loader repoLoader" style="display: none">
                            <div class="spinner-border spinner-border-sm" style="color: #000" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span>Loading ...</span>
                        </div>
                    </div>
                    <div class="d-flex" style="gap: 3">
                        <!-- Use the submit button to trigger form submission -->
                        {{-- <button x-data @click="(e) => createSbiFormData(e, '#sbiCreate')" type="submit" class="btn btn-success green">Save</button> --}}
                        <button type="submit" class="btn btn-success green">Save</button>
                        <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
