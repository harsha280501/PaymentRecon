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
                            <div class="mb-2" style="float: right;margin-top:7px;display: none;">
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#storemastermodel" aria-hidden="true">New StoreMaster</button>
                            </div>
                            @livewire('area-manager.settings.store-master')
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<x-modals.area-manager.storemaster-create name="New StoreMaster Upload" id="storemastermodel" url="/amanager/upload/newstoremaster" exampleFileLink="{{ asset('public/sample/newstoremaster-sample.xlsx') }}" />
</div>


<script>
    const createFormData = async (e) => {

        const parent = document.querySelector('#storemasterCreate');

        const data = await request.http({
            url: '/amanager/settings/addstoremaster', // Add a forward slash before the ID
            method: 'POST'
            , data: {
                MGPSAPcode: parent.querySelector('#MGPSAPcode').value, // Use the variables defined above
                StoreID: parent.querySelector('#StoreID').value
                , RETEKCode: parent.querySelector('#RETEKCode').value
                , OLDIONo: parent.querySelector('#OLDIONo').value
                , NewIONo: parent.querySelector('#NewIONo').value
                , BrandDesc: parent.querySelector('#BrandDesc').value
                , SubBrand: parent.querySelector('#SubBrand').value
                , StoreTypeasperBrand: parent.querySelector('#StoreTypeasperBrand').value
                , Channel: parent.querySelector('#Channel').value
                , StoreName: parent.querySelector('#StoreName').value
                , StoreopeningDate: parent.querySelector('#StoreopeningDate').value
                , SStatus: parent.querySelector('#SStatus').value
                , QTR: parent.querySelector('#QTR').value
                , Location: parent.querySelector('#Location').value
                , City: parent.querySelector('#City').value
                , State: parent.querySelector('#State').value
                , Address: parent.querySelector('#Address').value
                , Pincode: parent.querySelector('#Pincode').value
                , Located: parent.querySelector('#Located').value
                , StoreArea: parseFloat(parent.querySelector('#StoreArea').value)
                , Region: parent.querySelector('#Region').value
                , StoreManagerName: parent.querySelector('#StoreManagerName').value
                , Contactno: parent.querySelector('#Contactno').value
                , Basementoccupied: parent.querySelector('#Basementoccupied').value
                , ARMemailid: parent.querySelector('#ARMemailid').value
                , RMemailid: parent.querySelector('#RMemailid').value
                , NROMemailid: parent.querySelector('#NROMemailid').value
                , RCMmail: parent.querySelector('#RCMmail').value
                , Correctstoreemailid: parent.querySelector('#Correctstoreemailid').value
                , HOcontact: parent.querySelector('#HOcontact').value
                , RDemailid: parent.querySelector('#RDemailid').value
                , PickupBank: parent.querySelector('#PickupBank').value
            }
        });

        if (data.isError) {
            errorMessageConfiguration(data.error);
            return false;
        }

        succesMessageConfiguration('Success'); // Corrected typo: 'succesMessage' to 'successMessage'
        window.location.reload();

        return true;
    };

</script>

<script>
    // Get references to the input field and error message div
    var storeIDInput = document.getElementById("StoreID");
    var storeIDError = document.getElementById("storeIDError");

    // Add an event listener to the input field
    storeIDInput.addEventListener("input", function() {
        var inputValue = storeIDInput.value;

        // Check if the input consists of numbers only
        if (/[^0-9]/.test(inputValue)) {
            storeIDError.textContent = "Please enter numbers only.";
            storeIDInput.setCustomValidity("Please enter numbers only.");
        } else {
            storeIDError.textContent = "";
            storeIDInput.setCustomValidity("");
        }
    });

    // Get references to the input field and error message div
    var RETEKCodeInput = document.getElementById("RETEKCode");
    var RETEKCodeError = document.getElementById("RETEKCodeError");

    // Add an event listener to the input field
    RETEKCodeInput.addEventListener("input", function() {
        var inputValue = RETEKCodeInput.value;

        // Check if the input consists of numbers only
        if (/[^0-9]/.test(inputValue)) {
            RETEKCodeError.textContent = "Please enter numbers only.";
            RETEKCodeInput.setCustomValidity("Please enter numbers only.");
        } else {
            RETEKCodeError.textContent = "";
            RETEKCodeInput.setCustomValidity("");
        }
    });

    // Get references to the input field and error message div
    var BrandDescInput = document.getElementById("BrandDesc");
    var BrandDescError = document.getElementById("BrandDescError");

    // Add an event listener to the input field
    BrandDescInput.addEventListener("input", function() {
        var inputValue = BrandDescInput.value;

        // Check if the input consists of numbers only
        if (/[a-z0-9]/.test(inputValue)) {
            BrandDescError.textContent = "Please enter uppercase letters only.";
            BrandDescInput.setCustomValidity("Please enter uppercase letters only.");
        } else {
            BrandDescError.textContent = "";
            BrandDescInput.setCustomValidity("");
        }
    });

</script>

@endsection
