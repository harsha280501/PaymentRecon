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

                            <div class="mb-2" style="float: right;margin-top:7px;display: none;">
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#storemastermodel" aria-hidden="true">New StoreMaster</button>
                            </div>
                            @livewire('commercial-team.settings.store-master')
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
</div>
<x-modals.commercial-head.storemaster-create name="New StoreMaster Upload" id="storemastermodel" url="/chead/upload/newstoremaster" exampleFileLink="{{ asset('public/sample/newstoremaster-sample.xlsx') }}" />
</div>



<script>
    // submitting the banks
    /**
     * Generating error response
     * @param {*} message
     * @returns
     */
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
    const mainUpload = async (url, data) => {
        if (!data || data == undefined) {
            errorMessageConfiguration("Please import a file");
            return false;
        }

        // form data
        const formData = new FormData();
        formData.append("file", data);

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

    // 3. AXIS CASH MODEL
    const storemastermodel = document.querySelector("#storemastermodel");
    const storemastermodelSubmitButton = storemastermodel.querySelector("#uploadBtn");
    const storemastermodelFileUploadBtn = storemastermodel.querySelector("#storemastermodelFileUploadBtn");
    const storemastermodelLoader = storemastermodel.querySelector(".loader");

    /**
     * Main Submit Event
     */
    storemastermodelSubmitButton.addEventListener("click", async (e) => {
        storemastermodelLoader.style.display = "unset";
        storemastermodelSubmitButton.setAttribute("disabled", true);
        // upload file
        const data = await mainUpload(
            storemastermodel.dataset.url
            , storemastermodelFileUploadBtn.files[0]
        );
        // if not data, dont want to contineu
        if (!data) {
            storemastermodelSubmitButton.removeAttribute("disabled");
            storemastermodelLoader.style.display = "none";
            return false;
        }
        // show success message
        succesMessageConfiguration("Successfully uploaded");
        storemastermodelLoader.style.display = "none";
        storemastermodelSubmitButton.removeAttribute("disabled");

        setTimeout(() => {
            window.location.reload();
        }, 2000);
    });

</script>
@endsection
