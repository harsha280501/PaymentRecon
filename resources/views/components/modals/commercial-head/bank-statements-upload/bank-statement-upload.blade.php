@props(['id', 'url', 'name', 'exampleFileLink', 'text'])

<section x-data class="mainModalUploads">
    <div data-url="{{ $url }}" data-bs-backdrop="static" class="modal fade" id="{{ $id }}" id="import" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $name }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" @click="() => {
                        $refs.input.value = null    
                    }" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Please download the sample file for {{ $text }}
                                <a href="{{ $exampleFileLink }}" download="">Download a sample
                                    File</a>
                            </h3>
                            <div class="drag-area">
                                <div class="icon"><i class="fa fa-cloud-upload" aria-hidden="true"></i></div>
                                <center>
                                    {{-- <button>Choose Files</button> --}}
                                    <input x-ref="input" id="{{ $id }}FileUploadBtn" type="file">
                                </center>
                                <header>Drag & Drop files to Upload</header>
                            </div>

                            <div class="d-flex" style="justify-content: space-between; align-items: center; padding: 0 2em">

                                <div>
                                    <div class="loader" style="display: none">
                                        <div class="spinner-border spinner-border-sm" style="color: #000" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span>Loading ...</span>
                                    </div>
                                </div>

                                <button type="submit" id="uploadBtn" class=" green importxls2">Import
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
