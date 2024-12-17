@extends('layouts.commertial-head')

@section('content')
<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
        <div class="tab-content tab-transparent-content bg-white">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                @livewire('commercial-head.process.mpos-process')
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')

<script>
    const handleFormData = async (e, id) => {
        const processPage = document.querySelector('.process-page');
        const modal = processPage.querySelector(`#${id}`);

        // get modal body
        const modalBody = modal.querySelector('.modal-body');

        const spinner = modal.querySelector('.footer-loading-btn')
        spinner.style.display = 'block';
        const approvalStatus = modal.querySelector('#approvalStatus');


        if (approvalStatus.value == '') {
            spinner.style.display = 'none';
            errorMessageConfiguration('Please select a valid approval status');
            return false;
        }


        // remarks
        const remarks = modal.querySelector('#remarks');
        const amount = modal.querySelector('#recon-amount');
        const depAmount = modal.querySelector('#recon-deposit-amount');

        const data = await request.http({
            url: '/chead/process/mpos-recon/update-tender-approval-status/' + e.target.dataset.id
            , method: 'POST'
            , data: {
                approvalStatus: approvalStatus.value
                , saleReconDifferenceAmount: amount.value
                , depositAmount: depAmount.value
                , remarks: remarks.value
            }
        , });

        if (data.isError) {
            errorMessageConfiguration(data.error);
            return false;
        }

        spinner.style.display = 'none';
        succesMessageConfiguration('Success');
        window.location.reload();

        return true;
    }

    const handleBankFormData = async (e, id) => {
        const processPage = document.querySelector('.process-page');
        const modal = processPage.querySelector(`#${id}`);

        // get modal body
        const modalBody = modal.querySelector('.modal-body');

        const spinner = modal.querySelector('.footer-loading-btn')
        spinner.style.display = 'block';
        const approvalStatus = modal.querySelector('#approvalStatus');

        if (approvalStatus.value == '') {
            spinner.style.display = 'none';
            errorMessageConfiguration('Please select a valid approval status');
            return false;
        }

        // remarks
        const remarks = modal.querySelector('#remarks');
        const amount = modal.querySelector('#recon-amount');
        const depAmount = modal.querySelector('#recon-deposit-amount');

        const data = await request.http({
            url: '/chead/process/mpos-recon/update-bank-approval-status/' + e.target.dataset.id
            , method: 'POST'
            , data: {
                approvalStatus: approvalStatus.value
                , saleReconDifferenceAmount: amount.value
                , depositAmount: depAmount.value
                , remarks: remarks.value
            }
        , });

        if (data.isError) {
            errorMessageConfiguration(data.error);
            return false;
        }

        spinner.style.display = 'none';
        succesMessageConfiguration('Success');
        window.location.reload();

        return true;
    }


    const mainSubmit = async (e, id) => {

        const processPage = document.querySelector('.process-page');
        const modal = processPage.querySelector(`#${id}`);

        // get modal body
        const modalBody = modal.querySelector('.modal-body');

        const spinner = modal.querySelector('.footer-loading-btn')
        spinner.style.display = 'block';
        const approvalStatus = modal.querySelector('#approvalStatus');

        if (approvalStatus.value == '') {
            spinner.style.display = 'none';
            errorMessageConfiguration('Please select a valid approval status');
            return false;
        }

        // remarks
        const remarks = modal.querySelector('#remarks');
        const amount = modal.querySelector('#recon-amount');
        const depAmount = modal.querySelector('#recon-deposit-amount');

        const data = await request.http({
            url: '/chead/process/cash-recon/update-main-approval-status/' + e.target.dataset.id
            , method: 'POST'
            , data: {
                approvalStatus: approvalStatus.value
                , saleReconDifferenceAmount: amount.value
                , depositAmount: depAmount.value
                , remarks: remarks.value
            }
        , });

        if (data.isError) {
            errorMessageConfiguration(data.error);
            return false;
        }

        spinner.style.display = 'none';
        succesMessageConfiguration('Success');
        window.location.reload();

        return true;
    }

</script>



{{-- Livewire Filter  --}}
<script>
    document.addEventListener('livewire:load', event => {

        const form = document.querySelector('#cash-process-search-form');

        const start = form.querySelector('#startDate');
        const end = form.querySelector('#endDate');


        form.addEventListener('submit', e => {
            e.preventDefault();

            const dates = {
                start: start.value
                , end: end.value
            , }

            if (dates.start == "" && dates.end == "") {
                start.style.border = "1px solid lightcoral";
                end.style.border = "1px solid lightcoral";
                start.style.color = "lightcoral";
                end.style.color = "lightcoral";
                return false;
            } else {
                start.style.border = "1px solid #000";
                end.style.border = "1px solid #000";
                start.style.color = "#000";
                end.style.color = "#000";
            }

            livewire.components.getComponentsByName('commercial-head.process.mpos-process')[0].call('dateFilter', dates);

        });
    });

</script>


<script>
    // Livewire started
    document.addEventListener('livewire:load', event => {

        // listen for reset event
        Livewire.on('resetAll', e => {

            const resetItems = [
                '#select1-dropdown'
                , '#select2-dropdown'
                , '#select3-dropdown'
                , '#select4-dropdown'
                , '#select5-dropdown'
                , '#select6-dropdown'
                , '#select7-dropdown'
                , '#select8-dropdown'
                , '#select9-dropdown'
                , '#select10-dropdown'
                , '#select100-dropdown'
                , '#select101-dropdown'
            , ];

            resetItems.forEach(item => {
                $j(item).select2('destroy');
                $j(item).val('');
                $j(item).select2();
            });

            const dateform = document.querySelector('#cash-process-search-form');
            const start = dateform.querySelector('#startDate');
            const end = dateform.querySelector('#endDate');

            start.value = "";
            end.value = "";
        });
    });

</script>

@endsection
