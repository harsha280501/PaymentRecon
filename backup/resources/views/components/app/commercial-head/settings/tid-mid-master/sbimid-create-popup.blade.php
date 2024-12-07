<!-- Modal popup -->
<div class="modal fade" id="sbiCreate"  wire:key="63dde128e69467423123423rgrkhjgfdsa12111uc87bb10e55a3ab4b0f25eb1546da94b5d8288d1990d862ea8b00" tabindex="1" role="dialog" aria-labelledby="repo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style=" max-width: 950px; padding: 2em">
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
                        <div class="form-group col-lg-4">
                            <label style="color:#800000;font-weight:600;">MID *</label>
                            <input type="number" placeholder="Eg: 00000" class="form-control" id="MID" name="MID" value="" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label style="color:#800000;font-weight:600;">POS *</label>
                            <input type="number" placeholder="Eg: 00000" class="form-control" id="POS" name="POS" value="" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label style="color:#800000;font-weight:600;">Store ID *</label>
                            <input type="number" placeholder="Eg: 0000" class="form-control" id="storeID" name="storeID" value="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label style="color:#800000;font-weight:600;">Old Retek Code</label>
                            <input placeholder="Eg: 00000" type="number" class="form-control" id="oldRetekCode" name="retekCode" value="">
                        </div>
                        <div class="form-group col-lg-4">
                            <label style="color:#800000;font-weight:600;">New Retek Code *</label>
                            <input placeholder="Eg: 00000" type="number" class="form-control" id="newRetekCode" name="retekCode" value="" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label style="color:#800000;font-weight:600;">Brand Name *</label>
                            <input type="text" class="form-control" id="brandName" name="brandName" value="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label style="color:#800000;font-weight:600;">Status *</label>
                            <input type="text" class="form-control" id="status" name="status" value="" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label style="color:#800000;font-weight:600;">Closure Date *</label>
                            <input type="date" class="form-control" id="closureDate" name="closureDate" value="" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label style="color:#800000;font-weight:600;">Date of Conversion *</label>
                            <input type="date" class="form-control" id="conversionDt" name="relevance" value="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label style="color:#800000;font-weight:600;">Revelance *</label>
                            <input type="text" class="form-control" id="relevance" name="relevance" value="" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label style="color:#800000;font-weight:600;">EDC Service Provider *</label>
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
                        {{-- <button x-data @click="(e) => createSbiFormData(e, '#sbiCreate')" type="submit" class="btn btn-success green">Save</button> --}}
                        <button type="submit" class="btn btn-success green">Save</button>
                        <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
