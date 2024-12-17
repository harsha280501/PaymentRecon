@extends('layouts.commertial-head')


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
                            @livewire('commercial-head.uploads.repository')
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<x-modals.commercial-head.repository-create />

<script type="text/javascript" difer>
    const errorMessageConfiguration = (message) => {
        return Swal.fire("Error!", message, "error");
    };

    /**
     * Generating success response
     * @param {*} message
     * @returns
     */
    const succesMessageConfiguration = (message) => {
        return Swal.fire("Success!", message, "success");
    };

    // fetch idfc data

    const mainUpload = async (url, data, dateImport) => {


        if (!dateImport || dateImport == undefined) {
            errorMessageConfiguration("Please select date");
            return false;
        }

        if (!data || data == undefined) {
            errorMessageConfiguration("Please import a file");
            return false;
        }

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
            errorMessageConfiguration(error ? .mesage);
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
        const loader = repositoryModal.querySelector('.loader');
        loader.style.display = 'unset';
        // upload file
        const data = await mainUpload('/chead/repository/upload', repositoryFileUpload.files[0], dateImport.value);
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
