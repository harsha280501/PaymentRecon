@extends('layouts.commertial-head')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-tabs.index :tabs="$tabs" />
            <div class="tab-content tab-transparent-content bg-white" style="min-height: 500px;">
                <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                    <section id="recent">
                        <div class="row">
                            @livewire('commercial-head.settings.tid-mid-master')
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script defer src="{{ asset('assets/js/custom/Settings-Upload.js') }}"></script>

    <script defer>
        const handleFormData = async (e, id) => {

            const parent = document.querySelector(id);
            // Retrieve only the required field values
            const TID = parent.querySelector('#TID').value.trim();
            const storeID = parent.querySelector('#storeID').value.trim();
            const newRetekCode = parent.querySelector('#newRetekCode').value.trim();
            const brandName = parent.querySelector('#brandName').value.trim();

            parent.querySelectorAll('.error-msg').forEach((msg) => msg.remove());
            if (!validation(parent, TID, storeID, newRetekCode, brandName, 'amexmid')) {
                return false;
            }

            const data = await request.http({
                url: '/chead/settings/amexmid/' + e.target.dataset.id, // Add a forward slash before the ID
                method: 'POST',
                data: {
                    MID: parent.querySelector('#MID').value, // Use the variables defined above
                    // POS: parent.querySelector('#POS').value,
                    storeID: parent.querySelector('#storeID').value,
                    oldRetekCode: parent.querySelector('#oldRetekCode').value,
                    newRetekCode: parent.querySelector('#newRetekCode').value,
                    openingDt: parent.querySelector('#openingDt').value,
                    brandName: parent.querySelector('#brandName').value,
                    Status: parent.querySelector('#Status').value,
                    closureDate: parent.querySelector('#closureDate').value,
                    conversionDt: parent.querySelector('#conversionDt').value,
                    // relevance: parent.querySelector('#relevance').value,
                    // EDCServiceProvider: parent.querySelector('#EDCServiceProvider').value,
                },
            });

            if (data.isError) {
                errorMessageConfiguration(data.error);
                return false;
            }

            succesMessageConfiguration('Success'); // Corrected typo: 'succesMessage' to 'successMessage'
            window.location.reload();

            return true;
        };
        const handleFormDataicici = async (e, id) => {

            const parent = document.querySelector(id);
            // Retrieve only the required field values
            const TID = parent.querySelector('#TID').value.trim();
            const storeID = parent.querySelector('#storeID').value.trim();
            const newRetekCode = parent.querySelector('#newRetekCode').value.trim();
            const brandName = parent.querySelector('#brandCode').value.trim();

            parent.querySelectorAll('.error-msg').forEach((msg) => msg.remove());
            if (!validation(parent, TID, storeID, newRetekCode, brandName, 'icici')) {
                return false;
            }


            const data = await request.http({
                url: '/chead/settings/icicimid/' + e.target.dataset.id, // Add a forward slash before the ID
                method: 'POST',
                data: {
                    MID: parent.querySelector('#MID').value, // Use the variables defined above
                    // POS: parent.querySelector('#POS').value,
                    storeID: parent.querySelector('#storeID').value,
                    oldRetekCode: parent.querySelector('#oldRetekCode').value,
                    newRetekCode: parent.querySelector('#newRetekCode').value,
                    openingDt: parent.querySelector('#openingDt').value,
                    brandCode: parent.querySelector('#brandCode').value,
                    status: parent.querySelector('#status').value,
                    closureDate: parent.querySelector('#closureDate').value,
                    conversionDt: parent.querySelector('#conversionDt').value,
                    // relevance: parent.querySelector('#relevance').value,
                    // EDCServiceProvider: parent.querySelector('#EDCServiceProvider').value,
                },
            });

            if (data.isError) {
                errorMessageConfiguration(data.error);
                return false;
            }

            succesMessageConfiguration('Success'); // Corrected typo: 'succesMessage' to 'successMessage'
            window.location.reload();

            return true;
        };
        const handleFormDatasbi = async (e, id) => {

            const parent = document.querySelector(id);

            // Retrieve only the required field values
            const TID = parent.querySelector('#MID').value.trim();
            const storeID = parent.querySelector('#storeID').value.trim();
            const newRetekCode = parent.querySelector('#newRetekCode').value.trim();
            const brandName = parent.querySelector('#brandName').value.trim();

            parent.querySelectorAll('.error-msg').forEach((msg) => msg.remove());
            if (!validation(parent, TID, storeID, newRetekCode, brandName, 'sbi')) {
                return false;
            }
            const data = await request.http({
                url: '/chead/settings/sbimid/' + e.target.dataset.id, // Add a forward slash before the ID
                method: 'POST',
                data: {
                    MID: parent.querySelector('#MID').value, // Use the variables defined above
                    // POS: parent.querySelector('#POS').value,
                    storeID: parent.querySelector('#storeID').value,
                    oldRetekCode: parent.querySelector('#oldRetekCode').value,
                    newRetekCode: parent.querySelector('#newRetekCode').value,
                    openingDt: parent.querySelector('#openingDt').value,
                    brandName: parent.querySelector('#brandName').value,
                    status: parent.querySelector('#status').value,
                    closureDate: parent.querySelector('#closureDate').value,
                    // relevance: parent.querySelector('#relevance').value,
                    // EDCServiceProvider: parent.querySelector('#EDCServiceProvider').value,
                },
            });

            if (data.isError) {
                errorMessageConfiguration(data.error);
                return false;
            }

            succesMessageConfiguration('Success'); // Corrected typo: 'succesMessage' to 'successMessage'
            window.location.reload();

            return true;
        };

        const handleFormDatahdfc = async (e, id) => {

            const parent = document.querySelector(id);
            // Retrieve only the required field values
            const TID = parent.querySelector('#TID').value.trim();
            const storeID = parent.querySelector('#storeID').value.trim();
            const newRetekCode = parent.querySelector('#newRetekCode').value.trim();
            const brandName = parent.querySelector('#brandName').value.trim();

            parent.querySelectorAll('.error-msg').forEach((msg) => msg.remove());
            if (!validation(parent, TID, storeID, newRetekCode, brandName, 'hdfc')) {
                return false;
            }

            const data = await request.http({
                url: '/chead/settings/hdfctid/' + e.target.dataset.id, // Add a forward slash before the ID
                method: 'POST',
                data: {
                    TID: TID,
                    // POS: parent.querySelector('#POS').value,
                    storeID: storeID,
                    oldRetekCode: parent.querySelector('#oldRetekCode').value,
                    newRetekCode: newRetekCode,
                    openingDt: parent.querySelector('#openingDt').value,
                    brandName: brandName,
                    status: parent.querySelector('#status').value,
                    closureDate: parent.querySelector('#closureDate').value,
                    conversionDt: parent.querySelector('#conversionDt').value,
                    // relevance: parent.querySelector('#relevance').value,
                    // EDCServiceProvider: parent.querySelector('#EDCServiceProvider').value,
                },
            });

            console.log(data);

            if (data.isError) {
                errorMessageConfiguration(data.error);
                return false;
            }

            succesMessageConfiguration('Success'); // Corrected typo: 'succesMessage' to 'successMessage'
            window.location.reload();

            return true;
        };

        const createAmexFormData = async (e, id) => {
            e.preventDefault();
            const parent = document.querySelector('#amexCreate');

            const data = await request.http({
                url: '/chead/settings/addamex', // Add a forward slash before the ID
                method: 'POST',
                data: {
                    MID: parent.querySelector('#MID').value, // Use the variables defined above
                    // POS: parent.querySelector('#POS').value,
                    storeID: parent.querySelector('#storeID').value,
                    openingDt: parent.querySelector('#openingDt').value,
                    oldRetekCode: parent.querySelector('#oldRetekCode').value,
                    newRetekCode: parent.querySelector('#newRetekCode').value,
                    brandName: parent.querySelector('#brandName').value,
                    Status: parent.querySelector('#Status').value,
                    closureDate: parent.querySelector('#closureDate').value,
                    conversionDt: parent.querySelector('#conversionDt').value,
                    // relevance: parent.querySelector('#relevance').value,
                    // EDCServiceProvider: parent.querySelector('#EDCServiceProvider').value,
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

        const createIciciFormData = async (e, id) => {
            e.preventDefault();
            const parent = document.querySelector('#iciciCreate');

            const data = await request.http({
                url: '/chead/settings/addicici', // Add a forward slash before the ID
                method: 'POST',
                data: {
                    MID: parent.querySelector('#MID').value, // Use the variables defined above
                    // POS: parent.querySelector('#POS').value,
                    storeID: parent.querySelector('#storeID').value,
                    oldRetekCode: parent.querySelector('#oldRetekCode').value,
                    newRetekCode: parent.querySelector('#newRetekCode').value,
                    openingDt: parent.querySelector('#openingDt').value,
                    brandCode: parent.querySelector('#brandCode').value,
                    status: parent.querySelector('#status').value,
                    closureDate: parent.querySelector('#closureDate').value,
                    conversionDt: parent.querySelector('#conversionDt').value,
                    // relevance: parent.querySelector('#relevance').value,
                    // EDCServiceProvider: parent.querySelector('#EDCServiceProvider').value,
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

        const createSbiFormData = async (e, id) => {
            e.preventDefault();
            const parent = document.querySelector('#sbiCreate');

            const data = await request.http({
                url: '/chead/settings/addsbi', // Add a forward slash before the ID
                method: 'POST',
                data: {
                    MID: parent.querySelector('#MID').value, // Use the variables defined above
                    // POS: parent.querySelector('#POS').value,
                    storeID: parent.querySelector('#storeID').value,
                    oldRetekCode: parent.querySelector('#oldRetekCode').value,
                    newRetekCode: parent.querySelector('#newRetekCode').value,
                    openingDt: parent.querySelector('#openingDt').value,
                    brandName: parent.querySelector('#brandName').value,
                    status: parent.querySelector('#status').value,
                    closureDate: parent.querySelector('#closureDate').value,
                    conversionDt: parent.querySelector('#conversionDt').value,
                    // relevance: parent.querySelector('#relevance').value,
                    // EDCServiceProvider: parent.querySelector('#EDCServiceProvider').value,
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

        const createHdfcFormData = async (e, id) => {
            e.preventDefault();
            const parent = document.querySelector('#hdfcCreate');

            const data = await request.http({
                url: '/chead/settings/addhdfc', // Add a forward slash before the ID
                method: 'POST',
                data: {
                    TID: parent.querySelector('#TID').value, // Use the variables defined above
                    // POS: parent.querySelector('#POS').value,
                    storeID: parent.querySelector('#storeID').value,
                    oldRetekCode: parent.querySelector('#oldRetekCode').value,
                    newRetekCode: parent.querySelector('#newRetekCode').value,
                    openingDt: parent.querySelector('#openingDt').value,
                    brandName: parent.querySelector('#brandName').value,
                    status: parent.querySelector('#status').value,
                    closureDate: parent.querySelector('#closureDate').value,
                    conversionDt: parent.querySelector('#conversionDt').value,
                    // relevance: parent.querySelector('#relevance').value,
                    // EDCServiceProvider: parent.querySelector('#EDCServiceProvider').value,
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

        // Validations
        const validation = (parent, TID, storeID, newRetekCode, brandName, bank = null) => {
            if (bank == 'hdfc') {
                if (!TID) {
                    showError(parent.querySelector('#TID'), 'TID cannot be empty');
                    return false;
                }
            } else {
                if (!TID) {
                    showError(parent.querySelector('#MID'), 'TID cannot be empty');
                    return false;
                }
            }
            if (!storeID) {
                showError(parent.querySelector('#storeID'), 'Store ID cannot be empty');
                return false;
            } else if (!/^\d{4}$/.test(storeID)) {
                showError(parent.querySelector('#storeID'), 'Store ID must be 4 digits');
                return false;
            }
            if (!newRetekCode) {
                showError(parent.querySelector('#newRetekCode'), 'New Retek Code cannot be empty');
                return false;
            } else if (!/^\d{5}$/.test(newRetekCode)) {
                showError(parent.querySelector('#newRetekCode'), 'New Retek Code must be 5 digits');
                return false;
            }
            if (bank == 'icici') {
                if (!brandName) {
                    showError(parent.querySelector('#brandCode'), 'Brand Name cannot be empty');
                    return false;
                }
            } else {
                if (!brandName) {
                    showError(parent.querySelector('#brandName'), 'Brand Name cannot be empty');
                    return false;
                }
            }
            return true
        }

        const showError = (field, message) => {
            const errorMsg = document.createElement('div');
            errorMsg.className = 'error-msg';
            errorMsg.style.color = 'red';
            errorMsg.style.fontSize = '0.875rem';
            errorMsg.textContent = message;
            field.parentNode.appendChild(errorMsg);
            isValid = false;
        };
    </script>


    {{-- Script for listeners  --}}
    <script defer>
        var $j = jQuery.noConflict();

        // Livewire started
        document.addEventListener('livewire:load', event => {

            // listen for reset event
            Livewire.on('resetAll', e => {
                // clear items
                const resetItems = [
                    '#bankFIlter'
                ];
                resetItems.forEach(item => {
                    $j(item).select2('destroy');
                    $j(item).val('');
                    $j(item).select2();
                })
            });
        });
    </script>
@endsection
