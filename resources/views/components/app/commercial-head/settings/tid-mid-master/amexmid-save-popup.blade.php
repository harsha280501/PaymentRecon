@props(['id', 'url', 'name', 'exampleFileLink'])
<!--Modal popup-->
<div x-data="{
    file: null,
    loader: $el.querySelector('.loader'),
}" class="modal fade setting" id="amexsave" tabindex="1" role="dialog" aria-labelledby="repo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="height:250px !important; max-width: 950px !important; padding: 2em">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Save Excel</h5>
                <div class="right">
                    <!-- <button type="button" class="btn btn-success green">Save</button> -->
                    <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label style="color:#800000;font-weight:600;">Upload*</label>
                    <input x-on:change="file = $event.target.files[0]" id="amexFileUpload" class="form-control" type="file" required>
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
                    <button @click="() => amexSaveImport(file, loader)" type="button" class="btn btn-success green" id="uploadAmexBtn" style="width: fit-content">Upload</button>
                    <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
