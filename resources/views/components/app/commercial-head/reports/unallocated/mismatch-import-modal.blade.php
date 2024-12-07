<section class="mainModalUploads" wire:key="{{ base64_encode('hello') }}">
    <div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="{{ $id }}">
        <div wire:ignore.self class="modal-dialog modal-dialog-centered" role="document">
            <div wire:ignore.self class="modal-content">
                <div class="modal-header" wire:ignore.self>
                    <h5 class="modal-title">Import Unallocated Collection</h5>
                    <button type="button" class="close" data-bs-dismiss="modal">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body" wire:ignore.self>
                    <div class="row" wire:ignore.self>
                        <div class="col-lg-12">
                            <h3 wire:ignore.self>Please Upload only the exported file</h3>
                            <div class="drag-area" wire:ignore.self>
                                <div class="icon" wire:ignore.self><i class="fa fa-cloud-upload" aria-hidden="true"></i></div>
                                <center wire:ignore.self>
                                    <input wire:model="importFile" type="file" style="margin-left:10px">
                                </center>
                                <header>Drag & Drop files to Upload</header>
                                <p class="text-danger" style="font-size: 1em; text-align: center;">{{ $message }}</p>
                            </div>

                            <div wire:ignore.self class="d-flex" style="justify-content: space-between; align-items: center; padding: 0 2em">
                                <div wire:ignore.self>
                                    <div class="loader" wire:loading.class="d-block" style="display: none">
                                        <div class="spinner-border spinner-border-sm" style="color: #000" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span>Loading ...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
