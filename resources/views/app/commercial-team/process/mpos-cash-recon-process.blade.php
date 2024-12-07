@extends('layouts.commertial-team')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />

        <div class="tab-content tab-transparent-content">
            @livewire('commercial-team.process.mpos-cash-recon')
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

            livewire.components.getComponentsByName('commercial-team.process.mpos-cash-recon')[0].call('dateFilter', dates);

        });

        const form1 = document.querySelector('#card-process-search-form');
        const start1 = form1.querySelector('#startDate');
        const end1 = form1.querySelector('#endDate');


        form1.addEventListener('submit', e => {
            e.preventDefault();


            const dates = {
                start: start1.value
                , end: end1.value
            , }

            if (dates.start == "" && dates.end == "") {
                start1.style.border = "1px solid lightcoral";
                end1.style.border = "1px solid lightcoral";
                start1.style.color = "lightcoral";
                end1.style.color = "lightcoral";
                return false;
            } else {
                start1.style.border = "1px solid #000";
                end1.style.border = "1px solid #000";
                start1.style.color = "#000";
                end1.style.color = "#000";
            }

            livewire.components.getComponentsByName('commercial-team.process.mpos-cash-recon')[0].call('dateFilter', dates);
        });



        // listen for reset event
        Livewire.on('resetAll', e => {

            const dateform = document.querySelector('#cash-process-search-form');
            const dateform2 = document.querySelector('#card-process-search-form');
            const start = dateform.querySelector('#startDate');
            const start1 = dateform2.querySelector('#startDate');
            const end = dateform.querySelector('#endDate');
            const end1 = dateform2.querySelector('#endDate');


            const resetItems = ['#select1-dropdown', '#select2-dropdown'];


            resetItems.forEach(item => {
                $j(item).select2('destroy');
                $j(item).val('');
                $j(item).select2();
            });

            start.value = "";
            start1.value = "";
            end1.value = "";
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

        var error = false;
        // checking for error
        const modal = document.querySelector(`#${id}`)
        const inputs = modal.querySelectorAll('.mainFormValidaitionInputs')

        // dont need validation array
        const dontValidateArray = [''];

        inputs.forEach(item => {
            mainInputs = item.querySelectorAll('input')
            files = item.querySelectorAll('input[type="file"]')

            files.forEach(inp => {
                if (inp.files[0] && !fileExtension(inp.files[0])) {
                    error = true
                    inp.classList.add('form-error');
                }
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



    const cashApproval = async (dataset, id, total, tenderAdj, bankAdj) => {


        dataset.map(async (item) => {
            const formData = new FormData();
            formData.append('item', item.item == 'Other' ? item.name : item.item);
            formData.append('CashTenderBkDrpUID', id)
            formData.append('amount', item.amount)
            formData.append('bankName', item.bankName)
            formData.append('creditDate', item.creditDate)
            formData.append('slipnoORReferenceNo', item.slipnoORReferenceNo)
            formData.append('remarks', item.remarks)
            formData.append('supportDocupload', item.supportDocupload ? item.supportDocupload[0] : '')
            formData.append('tenderAdj', tenderAdj)
            formData.append('bankAdj', bankAdj)
            formData.append('adjAmount', total)


            // creating a new record
            const data = await request.http({
                url: '/cuser/process/cash-recon/update/' + id
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

<script defer>
    var $j = jQuery.noConflict();

    // Livewire started
    document.addEventListener('livewire:load', event => {

        // listen for reset event
        Livewire.on('resetAll', e => {
            // clear items
            const resetItems = ['#select01-dropdown', '#select2-dropdown', '#select2-dropdown1', '#select2-dropdown2'];
            resetItems.forEach(item => {
                $j(item).select2('destroy');
                $j(item).val('');
                $j(item).select2();
            })
        });
    });

</script>



@endsection
