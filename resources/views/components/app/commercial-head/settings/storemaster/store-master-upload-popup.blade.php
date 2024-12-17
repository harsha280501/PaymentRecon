<!--Modal popup-->
<div x-data="{
    file: @entangle('file'),
    error: ''
}" class="modal fade" wire:ignore.self id="storemasterUpload">
    <div class="modal-dialog modal-dialog-centered" style="height:250px !important; max-width: 950px !important; padding: 2em">
        <div class="modal-content">
            <div wire:ignore.self class="modal-header">
                <h5 class="modal-title">Import Store Master</h5>
                <div class="right">
                    <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>

            <div wire:ignore.self class="modal-body">
                <div class="form-group">
                    <label style="color:#800000;font-weight:600;">Upload *</label>
                    <input wire:model="importFile" id="" class="form-control" type="file" required>
                    @error('importFile') <span class="error" style="color: red; ">{{ $message }}</span> @enderror
                </div>

                <span style="color: red; font-weight: 600" x-text="error"></span>
            </div>

            <div wire:ignore.self class="modal-footer">
                <div style="flex: 1">
                    <div class="loader repoLoader" wire:loading.class="d-block" style="display: none">
                        <div class="spinner-border spinner-border-sm" style="color: #000" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span>Loading ...</span>
                    </div>
                </div>

                <div class="d-flex" style="gap: 3">
                    <button wire:click="importUploadFile" wire:loading.class="d-none" type="button" class="btn btn-success green" id="uploadAmexBtn" style="width: fit-content">Upload</button>
                    <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
