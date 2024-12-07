@extends('layouts.area-manager')


@section('content')

<style type="text/css">
    #repositoryupload .modal-body {
        height: 250px;
        overflow-y: auto;
    }

    #repoview .modal-body {
        height: 200px;
        overflow-y: auto;
    }

</style>

<div class="tab-content tab-transparent-content bg-white">
    <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
        <section id="recent">
            <div class="row">
                <div class="col-md-12">
                    <x-tabs.index :tabs="$tabs" />
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-2" style="float: right;">
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#repositoryupload">New Upload</button>


                            </div>
                            @livewire('area-manager.respository')
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<section id="mainRepoUpload">
    <div class="modal fade" id="repositoryupload" tabindex="1" role="dialog" aria-labelledby="repo" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Details</h5>
                    <div class="right">
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
                        <button id="uploadRepositoryBtn" class="btn btn-success green">Upload</button>
                        <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('scripts')
<script defer>
    console.log(123);
    const errorMessageConfiguration = (message) => {
        return Swal.fire("Error!", message, "error");
    };

    const succesMessageConfiguration = (message) => {
        return Swal.fire("Success!", message, "success");
    };

    const mainUpload = async (url, data, dateImport) => {

        // form data
        const formData = new FormData();
        formData.append("repositoryFileUpload", data);
        formData.append("dateImport", dateImport);

        // Fetch main data
        const {
            data: main
            , isError
            , error
        , } = await request.http({
            url
            , method: "POST"
            , data: formData
            , processData: false
            , contentType: false
        , });
        // Error
        if (isError) {
            errorMessageConfiguration(error.mesage);
            return false;
        }
        // main
        return main;
    };



    // Commerical Head Repository Upload
    const repositoryModal = document.querySelector("#repositoryupload");
    const repositoryModalSubmitButton = repositoryModal.querySelector("#uploadRepositoryBtn");
    const repositoryFileUpload = repositoryModal.querySelector("#repositoryFileUpload");
    const dateImport = document.querySelector("#dateImport");



    /**
     * Main Submit Event
     */
    repositoryModalSubmitButton.addEventListener("click", async (e) => {

        if (!dateImport.value) {
            errorMessageConfiguration('Please select a date');
            return false;
        }

        if (repositoryFileUpload.files[0] == null || repositoryFileUpload.files[0] == undefined) {
            errorMessageConfiguration('Please select a file to upload');
            return false;
        }
        // assing a loader
        const loader = repositoryModal.querySelector('.loader');
        loader.style.display = 'unset';
        // upload file
        const data = await mainUpload('/amanager/repository/upload', repositoryFileUpload.files[0], dateImport.value);
        // if not data, dont want to contineu
        if (!data) {
            loader.style.display = 'none';
            return false;
        }
        // show success message
        succesMessageConfiguration("Successfully uploaded");
        loader.style.display = 'none';
        window.location.reload();
    });

</script>

@endsection
