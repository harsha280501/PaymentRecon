<div x-data="{
    tidSelected: '',
    fileSelected: false,
    checkButtonStatus() {
        return this.tidSelected !== '' && this.fileSelected;
    },
    resetFields() {
        this.tidSelected = '';
        this.fileSelected = false;
    }
}" class="modal fade setting" wire:ignore.self id="{{ $id }}"
    wire:key="2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824">

    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('uploadSuccess', message => {
                Swal.fire({
                    title: 'Success!',
                    text: message,
                    icon: 'success',
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                        window.location.reload();
                    }
                });
            });
        });

        const clearErrorMessage = () => {
            const errorMessageElement = document.getElementById('error-message');
            if (errorMessageElement) {
                errorMessageElement.innerHTML = '';
            }
        }

        const handleFileChange = () => {
            // Set fileSelected to true when a file is selected
            this.fileSelected = true;
        }
    </script>

    <div class="modal-dialog modal-dialog-centered" wire:ignore.self
        style="height:250px !important; max-width: 1000px !important; padding: 2em">
        <div class="modal-content" wire:ignore.self>
            <div class="modal-header" wire:ignore.self>
                <h5 class="modal-title">Upload Details</h5>
                <div class="right">
                    <button type="button" class="btn grey" data-bs-dismiss="modal">
                        <i class="fa-solid fa-close"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body" wire:ignore.self>
                <!-- TID Selection Dropdown -->
                <div class="form-group mb-3">
                    <label style="color: #000; font-weight: 600;">Select TID <span style="color: red">*</span></label>
                    <select class="form-control" style="color: #000;" placeholder="Select an Option" required
                        x-model="tidSelected">
                        <option value="" selected disabled>Select a TID</option>
                        <option value="amexmid">AMEX TID</option>
                        <option value="icicimid">ICICI TID</option>
                        <option value="sbimis">SBI TID</option>
                        <option value="hdfctid">HDFC TID</option>
                    </select>
                </div>

                <h3 style="font-size: 1em; font-weight: 500; color: #000" class="mb-3">
                    Please upload only the exported file
                </h3>

                <div class="form-group">
                    <label>Upload <span style="color: red">*</span></label>
                    <input wire:model="importFile" class="form-control" type="file" required
                        onclick="clearErrorMessage()" @change="fileSelected = !!$event.target.files.length">
                    <span id="error-message" style="color:red">{{ $message }}</span>
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
                <div class="d-flex" style="gap: 10px;">
                    <button type="submit" class="btn btn-success green" wire:click="handleSubmit"
                        :disabled="!checkButtonStatus()">Upload</button>
                    <button type="button" class="btn grey" data-bs-dismiss="modal"
                        @click="resetFields()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
