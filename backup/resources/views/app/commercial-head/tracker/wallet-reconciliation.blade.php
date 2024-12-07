@extends('layouts.commertial-head')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
        <div class="tab-content tab-transparent-content bg-white" style="min-height: 500px;">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                <section id="recent">
                    <div class="row">
                        @livewire('commercial-head.tracker.wallet-reconciliation')
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

{{-- Scripts for values  --}}
<script defer>
    const form = document.querySelector('#card-reconcilation-search-form');

    const searchString = form.querySelector('#search');

    form.addEventListener('submit', e => {
        e.preventDefault();

        livewire.components.getComponentsByName('commercial-head.card-reconciliation')[0].call('searchFilter', searchString.value);
    });


    // {{--  Second Tab  --}}
    const form2 = document.querySelector('#cash2bank-reconcilation-search-form');

    const searchString2 = form2.querySelector('#search');

    form2.addEventListener('submit', e => {
        e.preventDefault();

        livewire.components.getComponentsByName('commercial-head.card-reconciliation')[0].call('searchFilter', searchString2.value);
    });




    const dateform = document.querySelector('#tracker-card-recon-search-form');

    const start = dateform.querySelector('#startDate');
    const end = dateform.querySelector('#endDate');

    dateform.addEventListener('submit', e => {
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

        livewire.components.getComponentsByName('commercial-head.card-reconciliation')[0].call('filterDate', dates);
    });


    // {{--  Second form  --}}
    const dateform2 = document.querySelector('#tracker-cash2bank-recon-search-form');

    const start2 = dateform2.querySelector('#startDate');
    const end2 = dateform2.querySelector('#endDate');

    dateform2.addEventListener('submit', e => {
        e.preventDefault();

        const dates = {
            start: start2.value
            , end: end2.value
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

        livewire.components.getComponentsByName('commercial-head.card-reconciliation')[0].call('filterDate', dates);
    });



    const processform = document.querySelector('#tracker-card-process-recon-search-form');

    const processstart = processform.querySelector('#startDate');

    const processend = processform.querySelector('#endDate');



    processform.addEventListener('submit', e => {

        e.preventDefault();

        const dates = {
            start: processstart.value
            , end: processend.value
        , }

        if (dates.start == "" && dates.end == "") {
            processstart.style.border = "1px solid lightcoral";
            processend.style.border = "1px solid lightcoral";
            processstart.style.color = "lightcoral";
            processend.style.color = "lightcoral";
            return false;
        } else {
            processstart.style.border = "1px solid #000";
            processend.style.border = "1px solid #000";
            processstart.style.color = "#000";
            processend.style.color = "#000";
        }

        livewire.components.getComponentsByName('commercial-head.card-reconciliation')[0].call('filterDate', dates);
    });

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
                '#select1-dropdown'
                , '#select2-dropdown'
                , '#select3-dropdown'
                , '#select4-dropdown'
            , ];
            resetItems.forEach(item => {
                $j(item).select2('destroy');
                $j(item).val('');
                $j(item).select2();
            })

            const dateform = document.querySelector('#tracker-card-recon-search-form');

            const start = dateform.querySelector('#startDate');
            const end = dateform.querySelector('#endDate');

            start.value = "";
            end.value = "";

        });
    });

</script>
@endsection
