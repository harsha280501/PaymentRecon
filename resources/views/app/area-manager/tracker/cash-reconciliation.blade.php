@extends('layouts.area-manager')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
        <div class="tab-content tab-transparent-content bg-white" style="min-height: 500px;">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                <section id="recent">
                    <div class="row">
                        @livewire('area-manager.tracker.cash-reconciliation')
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script defer>
    const form = document.querySelector('#tracker-cash-recon-search-form');

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

        livewire.components.getComponentsByName('area-manager.tracker.cash-reconciliation')[0].call('filterDate', dates);
    });


    const cash2form = document.querySelector('#tracker-cash2bank-recon-search-form');

    const cash2start = cash2form.querySelector('#startDate');
    const cash2end = cash2form.querySelector('#endDate');


    cash2form.addEventListener('submit', e => {
        e.preventDefault();

        const dates = {
            start: cash2start.value
            , end: cash2end.value
        , }

        if (dates.start == "" && dates.end == "") {
            cash2start.style.border = "1px solid lightcoral";
            cash2end.style.border = "1px solid lightcoral";
            cash2start.style.color = "lightcoral";
            cash2end.style.color = "lightcoral";
            return false;
        } else {
            cash2start.style.border = "1px solid #000";
            cash2end.style.border = "1px solid #000";
            cash2start.style.color = "#000";
            cash2end.style.color = "#000";
        }

        livewire.components.getComponentsByName('area-manager.tracker.cash-reconciliation')[0].call('filterDate', dates);
    });

    const searchform = document.querySelector('#cash-reconcilation-search-form');
    const searchString = searchform.querySelector('#search');


    searchform.addEventListener('submit', e => {
        e.preventDefault();

        livewire.components.getComponentsByName('area-manager.tracker.cash-reconciliation')[0].call('searchFilter', searchString.value);
    });


    const search2form = document.querySelector('#cash2bank-reconcilation-search-form');
    const search2String = search2form.querySelector('#search');


    search2form.addEventListener('submit', e => {
        e.preventDefault();

        livewire.components.getComponentsByName('area-manager.tracker.cash-reconciliation')[0].call('searchFilter', search2String.value);

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
            const resetItems = ['#select2-dropdown', '#select22-dropdown', '#select222-dropdown', '#matchStatus', '#matchStatus2', '#select3-dropdown', '#select2222-dropdown'];


            resetItems.forEach(item => {
                $j(item).select2('destroy');
                $j(item).val('');
                $j(item).select2();
            })

            const dateform = document.querySelector('#tracker-cash-recon-search-form');

            const start = dateform.querySelector('#startDate');
            const end = dateform.querySelector('#endDate');

            start.value = "";
            end.value = "";

        });
    });

</script>

@endsection
