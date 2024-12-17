@extends('layouts.admin')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
        <div class="tab-content tab-transparent-content bg-white" style="min-height: 500px;">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                <section id="recent">
                    <div class="row">
                        @livewire('area-manager.tracker.mpos-reconciliation')
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script defer>
    const form = document.querySelector('#tracker-mpos1-recon-search-form');

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

        livewire.components.getComponentsByName('area-manager.tracker.mpos-reconciliation')[0].call('filterDate', dates);
    });



    const form2 = document.querySelector('#tracker-mpos2-recon-search-form');

    const start2 = form2.querySelector('#startDate');
    const end2 = form2.querySelector('#endDate');


    form2.addEventListener('submit', e => {
        e.preventDefault();

        const dates = {
            start: start2.value
            , end: end2.value
        , }

        if (dates.start == "" && dates.end == "") {
            start2.style.border = "1px solid lightcoral";
            end2.style.border = "1px solid lightcoral";
            start2.style.color = "lightcoral";
            end2.style.color = "lightcoral";
            return false;
        } else {
            start2.style.border = "1px solid #000";
            end2.style.border = "1px solid #000";
            start2.style.color = "#000";
            end2.style.color = "#000";
        }

        livewire.components.getComponentsByName('area-manager.tracker.mpos-reconciliation')[0].call('filterDate', dates);
    });


    const form3 = document.querySelector('#tracker-mpos3-recon-search-form');

    const start3 = form3.querySelector('#startDate');
    const end3 = form3.querySelector('#endDate');


    form2.addEventListener('submit', e => {
        e.preventDefault();

        const dates = {
            start: start3.value
            , end: end3.value
        , }

        if (dates.start == "" && dates.end == "") {
            start3.style.border = "1px solid lightcoral";
            end3.style.border = "1px solid lightcoral";
            start3.style.color = "lightcoral";
            end3.style.color = "lightcoral";
            return false;
        } else {
            start3.style.border = "1px solid #000";
            end3.style.border = "1px solid #000";
            start3.style.color = "#000";
            end3.style.color = "#000";
        }

        livewire.components.getComponentsByName('area-manager.tracker.mpos-reconciliation')[0].call('filterDate', dates);
    });


    const searchform = document.querySelector('#wallet-reconcilation-search-form');
    const searchString = searchform.querySelector('#search');


    searchform.addEventListener('submit', e => {
        e.preventDefault();

        livewire.components.getComponentsByName('area-manager.tracker.mpos-reconciliation')[0].call('searchFilter', searchString.value);
    });


    const search2form = document.querySelector('#wallet2bank-reconcilation-search-form');
    const search2String = search2form.querySelector('#search');

    search2form.addEventListener('submit', e => {
        e.preventDefault();

        livewire.components.getComponentsByName('area-manager.tracker.mpos-reconciliation')[0].call('searchFilter', search2String.value);
    });

</script>

{{-- Script for listeners  --}}
<script defer>
    // var $j = jQuery.noConflict();

    document.addEventListener('livewire:load', event => {

        // listen for reset event
        Livewire.on('resetAll', e => {
            // clear items
            const resetItems = [
                '#select01-dropdown'
                , '#select02-dropdown'
                , '#select03-dropdown'
                , '#select04-dropdown'
                , '#select05-dropdown'
                , '#select06-dropdown'
                , '#select11-dropdown'
                , '#select12-dropdown'
                , '#select13-dropdown'
                , '#select14-dropdown'
                , '#select15-dropdown'
                , '#select16-dropdown'
                , '#select21-dropdown'
                , '#select22-dropdown'
                , '#select23-dropdown'
                , '#select24-dropdown'
                , '#select25-dropdown'
                , '#select26-dropdown'
                , '#select31-dropdown'
                , '#select32-dropdown'
                , '#select33-dropdown'
            , ];

            resetItems.forEach(item => {
                $j(item).select2('destroy');
                $j(item).val('');
                $j(item).select2();
            });



        });
    });

</script>
