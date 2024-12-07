<!--Modal popup-->
<div x-data="{
    file: null,
    loader: $el.querySelector('.loader')
}" x-init="() => {
    Livewire.on('file:imported', () => {
        succesMessageConfiguration('MID/TID Updated Successfully')
        window.location.reload()
    })
}" class="modal fade setting" wire:ignore.self id="{{ $id }}" wire:key="2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824">
    <div class="modal-dialog modal-dialog-centered" wire:ignore.self style="height:250px !important; max-width: 1000px !important; padding: 2em">
        <div class="modal-content" wire:ignore.self>
            <div class="modal-header" wire:ignore.self>
                <h5 class="modal-title">Upload Details</h5>
                <div class="right">
                    <button type="button" class="btn grey" data-bs-dismiss="modal"><i class="fa-solid fa-close"></i></button>
                </div>
            </div>
            <div class="modal-body" wire:ignore.self>
                <h3 style="font-size: 1em; font-weight: 500; color: #000" class="mb-3">Please upload only the exported file
                </h3>

                <div class="form-group" wire:ignore.self>
                    <label>Upload <span style="color: red">*</span></label>
                    <input wire:model="importFile" class="form-control" type="file">
                    <span style="color: red">{{ $message }}</span>
                </div>
            </div>

            <div class="modal-footer" wire:ignore.self>
                <div style="flex: 1">
                    <div class="loader repoLoader" wire:loading.class="d-block" style="display: none">
                        <div class="spinner-border spinner-border-sm" style="color: #000" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span>Loading ...</span>
                    </div>
                </div>
                <div class="d-flex" style="gap: 3">
                    {{-- <button @click="() => mainUploadFunc(file, loader)" type="button" class="btn btn-success green" id="uploadAmexBtn" style="width: fit-content">Upload</button> --}}
                    <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
