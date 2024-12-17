<section x-data class="mainModalUploads" x-data="{
    file: null;

    submit(){
        
        if(!this.file) {
            errorMessageConfiguration('Please Select a file')
            return false;
        }
    }
}">
    <div class="modal fade" data-bs-backdrop="static" id="upload-direct-deposit" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document" wire:ignore.self>
            <div class="modal-content" wire:ignore.self>
                <div class="modal-header" wire:ignore.self>
                    <h5 class="modal-title" wire:ignore.self>Import Direct Deposit</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" wire:ignore.self>
                        <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                    </button>
                </div>
                <div class="modal-body" wire:ignore.self>
                    <div class="row" wire:ignore.self>
                        <div class="col-lg-12">
                            <h3>Please download the sample file for Direct Deposit Import
                                <a href="" download="">Download a sample
                                    File</a>
                            </h3>
                            <div class="drag-area">
                                <div class="icon"><i class="fa fa-cloud-upload" aria-hidden="true"></i></div>
                                <center>
                                    <input wire:model="uploadFile" id="FileUploadBtn" type="file" style="margin-left:10px">
                                </center>
                                <header>Drag & Drop files to Upload</header>
                                @error('uploadFile')
                                <p style="color: red; font-size: .9em; font-weight: 500; text-align: center;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="d-flex" style="justify-content: space-between; align-items: center; padding: 0 2em">
                                <div style="flex: 1">
                                    <div class="footer-loading-btn" wire:loading.class="d-block" style="display: none; text-align:left; margin: 0 1em; flex: 1; color: #000">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span>Loading ...</span>
                                    </div>
                                </div>
                                <button type="button" wire:click="save" class="green importxls2">Import</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
