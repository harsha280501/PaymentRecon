<!--Modal popup-->
<div class="modal fade" id="repositoryupload" tabindex="1" role="dialog" aria-labelledby="repo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:500px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Details</h5>
                <div class="right">
                    <!-- <button type="button" class="btn btn-success green">Save</button> -->
                    <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>

                </div>

            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label style="color:#800000;font-weight:600;">Date*</label>
                    <input type="date" class="form-control" name="dateImport" id="dateImport" required>
                </div>

                <div class="form-group">
                    <label style="color:#800000;font-weight:600;">Upload*</label>
                    <input id="repositoryFileUpload" class="form-control" type="file" required>

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
                    <button type="button" class="btn btn-success green" id="uploadRepositoryBtn">Upload</button>
                    <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
