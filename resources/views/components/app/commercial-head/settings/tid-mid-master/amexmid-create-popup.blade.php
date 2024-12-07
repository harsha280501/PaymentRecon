<!-- Modal popup -->
<div class="modal fade" id="amexCreate" tabindex="1" role="dialog" aria-labelledby="repo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 1200px !important; padding: 2em">
        <div class="modal-content">
            <form x-data x-on:submit.prevent="createAmexFormData">
                <!-- Add a form element with an ID for handling form submission -->
                <div class="modal-header">
                    <h5 class="modal-title">AMEX MID</h5>
                    <div class="right">
                        <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label style="color:#000">MID <span style='color: red'>*</span></label>
                            <input type="number" placeholder="Eg: 120012..." class="form-control" id="MID" name="MID" value="" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label style="color:#000">POS <span style='color: red'>*</span></label>
                            <input type="number" placeholder="Eg: 232121..." class="form-control" id="POS" name="POS" value="" required>
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label style="color:#000">Store ID <span style='color: red'>*</span></label>
                            <input type="number" placeholder="Eg: 0000" class="form-control" id="storeID" name="storeID" value="" required>
                        </div>

                        <div class="form-group col-lg-6">
                            <label style="color:#000">Old Retek Code</label>
                            <input placeholder="Eg: 00000" type="number" class="form-control" id="oldRetekCode" name="retekCode" value="">
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label style="color:#000">New Retek Code <span style='color: red'>*</span></label>
                            <input placeholder="Eg: 00000" type="number" class="form-control" id="newRetekCode" name="retekCode" value="" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label style="color:#000">Brand Name <span style='color: red'>*</span></label>
                            <input type="text" class="form-control" id="brandName" name="brandName" value="" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label style="color:#000">Status <span style='color: red'>*</span></label>
                            <input type="text" class="form-control" id="Status" name="Status" value="" required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label style="color:#000">Closure Date <span style='color: red'>*</span></label>
                            <input type="date" class="form-control" id="closureDate" name="closureDate" value="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label style="color:#000">Date of Conversion <span style='color: red'>*</span></label>
                            <input type="date" class="form-control" id="conversionDt" name="relevance" value="" required>
                        </div>

                        <div class="form-group col-lg-6">
                            <label style="color:#000">Revelance <span style='color: red'>*</span></label>
                            <input type="text" class="form-control" id="relevance" name="relevance" value="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label style="color:#000">EDC Service Provider <span style='color: red'>*</span></label>
                            <input type="text" class="form-control" id="EDCServiceProvider" name="EDCServiceProvider" value="" required>
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
                        <button type="submit" class="btn btn-success green">Save</button>
                        <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
