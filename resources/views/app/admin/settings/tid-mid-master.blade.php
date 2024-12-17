@extends('layouts.admin')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
        <div class="tab-content tab-transparent-content bg-white" style="min-height: 500px;">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                <section id="recent">
                    <div class="row">
                        @livewire('admin.settings.tid-mid-master')
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')

<script defer>
    const handleFormData = async (e, id) => {


        const parent = document.querySelector(id);

        const data = await request.http({
            url: '/admin/settings/amexmid/' + e.target.dataset.id, // Add a forward slash before the ID
            method: 'POST'
            , data: {
                MID: parent.querySelector('#MID').value, // Use the variables defined above
                POS: parent.querySelector('#POS').value
                , sapCode: parent.querySelector('#sapCode').value
                , retekCode: parent.querySelector('#retekCode').value
                , brandName: parent.querySelector('#brandName').value
            , }
        , });

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

        const data = await request.http({
            url: '/admin/settings/icicimid/' + e.target.dataset.id, // Add a forward slash before the ID
            method: 'POST'
            , data: {
                MID: parent.querySelector('#MID').value, // Use the variables defined above
                POS: parent.querySelector('#POS').value
                , sapCode: parent.querySelector('#sapCode').value
                , retekCode: parent.querySelector('#retekCode').value
                , brandCode: parent.querySelector('#brandCode').value
            , }
        , });

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

        const data = await request.http({
            url: '/admin/settings/sbimid/' + e.target.dataset.id, // Add a forward slash before the ID
            method: 'POST'
            , data: {
                MID: parent.querySelector('#MID').value, // Use the variables defined above
                POS: parent.querySelector('#POS').value
                , sapCode: parent.querySelector('#sapCode').value
                , retekCode: parent.querySelector('#retekCode').value
                , brandName: parent.querySelector('#brandName').value
            , }
        , });

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

        const data = await request.http({
            url: '/admin/settings/hdfctid/' + e.target.dataset.id, // Add a forward slash before the ID
            method: 'POST'
            , data: {
                TID: parent.querySelector('#TID').value, // Use the variables defined above
                POS: parent.querySelector('#POS').value
                , sapCode: parent.querySelector('#sapCode').value
                , retekCode: parent.querySelector('#retekCode').value
                , brandName: parent.querySelector('#brandName').value
            , }
        , });

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
            url: '/admin/settings/addamex', // Add a forward slash before the ID
            method: 'POST'
            , data: {
                MID: parent.querySelector('#MID').value, // Use the variables defined above
                POS: parent.querySelector('#POS').value
                , sapCode: parent.querySelector('#sapCode').value
                , retekCode: parent.querySelector('#retekCode').value
                , brandName: parent.querySelector('#brandName').value
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
            url: '/admin/settings/addicici', // Add a forward slash before the ID
            method: 'POST'
            , data: {
                MID: parent.querySelector('#MID').value, // Use the variables defined above
                POS: parent.querySelector('#POS').value
                , sapCode: parent.querySelector('#sapCode').value
                , retekCode: parent.querySelector('#retekCode').value
                , brandCode: parent.querySelector('#brandCode').value
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
            url: '/admin/settings/addsbi', // Add a forward slash before the ID
            method: 'POST'
            , data: {
                MID: parent.querySelector('#MID').value, // Use the variables defined above
                POS: parent.querySelector('#POS').value
                , sapCode: parent.querySelector('#sapCode').value
                , retekCode: parent.querySelector('#retekCode').value
                , brandName: parent.querySelector('#brandName').value
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
            url: '/admin/settings/addhdfc', // Add a forward slash before the ID
            method: 'POST'
            , data: {
                TID: parent.querySelector('#TID').value, // Use the variables defined above
                POS: parent.querySelector('#POS').value
                , sapCode: parent.querySelector('#sapCode').value
                , retekCode: parent.querySelector('#retekCode').value
                , brandName: parent.querySelector('#brandName').value
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

@endsection
