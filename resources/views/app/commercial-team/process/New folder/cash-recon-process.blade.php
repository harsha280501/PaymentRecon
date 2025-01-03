@extends('layouts.commertial-team')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />

        <div class="tab-content tab-transparent-content">
            @livewire('commercial-team.process.mpos.cash-recon')
        </div>
    </div>
</div>

@endsection


@section('scripts')
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

            livewire.components.getComponentsByName('commercial-team.process.process')[0].call('dateFilter', dates);

        });


        // listen for reset event
        Livewire.on('resetAll', e => {


            const resetItems = ['#select3-dropdown', '#select5-dropdown', '#select4-dropdown'];

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


    const fileExtension = (fileName) => {
        const allowedExtensions = ['pdf', 'jpg', 'png'];
        const ext = fileName.name.split('.')[1];

        if (!ext) {
            return false;
        }

        if (!allowedExtensions.includes(ext)) {
            return false;
        }
        return true;
    }



    function MainFormvalidate(id) {
        // removing all the form errors
        document.querySelectorAll('.form-error').forEach(item => item.classList.remove('form-error'))


        const dontValidateArray = ['supportDocupload'];

        var error = false;
        // checking for error
        const modal = document.querySelector(`#${id}`)
        const inputs = modal.querySelectorAll('.mainFormValidaitionInputs')

        inputs.forEach(item => {
            mainInputs = item.querySelectorAll('input')
            files = item.querySelectorAll('input[type="file"]')

            files.forEach(inp => {
                // if (!dontValidateArray.includes(inp.id)) {
                if (inp.files[0] && !fileExtension(inp.files[0])) {
                    error = true
                    inp.classList.add('form-error');
                }
                // }
            });

            mainInputs.forEach(inp => {
                if (!dontValidateArray.includes(inp.id)) {
                    if (inp.value == '') {
                        error = true
                        inp.classList.add('form-error')
                    }
                }
            })
        })

        if (error == true) {
            return false
        }

        return true;

    }

    const handleAlpineSubmit = async (dataset, id, total) => {
        // looping through the dataset
        dataset.map(async (item) => {
            const formData = new FormData();
            formData.append('item', item.item == 'Other' ? item.name : item.item);
            formData.append('cashMisBkStRecoUID', id)
            formData.append('amount', item.amount)
            formData.append('bankName', item.bankName)
            formData.append('creditDate', item.creditDate)
            formData.append('slipnoORReferenceNo', item.slipnoORReferenceNo)
            formData.append('remarks', item.remarks)
            formData.append('supportDocupload', item.supportDocupload ? item.supportDocupload[0] : '')
            formData.append('adjAmount', total)

            // creatign a new record
            const data = await request.http({
                url: '/cuser/process/cash-recon/bank-statement/create/' + id
                , method: 'POST'
                , data: formData
                , processData: false
                , contentType: false
            , });
        });


        succesMessageConfiguration('Success')
        window.location.reload();

        return true;
    }

</script>



@endsection
