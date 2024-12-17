@extends('layouts.admin')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
        <div class="tab-content tab-transparent-content bg-white" style="min-height: 500px;">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                <section id="recent">
                    <div class="row">
                        @livewire('admin.tracker.wallet-reconciliation')
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script defer>
    const form = document.querySelector('#tracker-wallet-recon-search-form');

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

        livewire.components.getComponentsByName('admin.tracker.wallet-reconciliation')[0].call('filterDate', dates);
    });



    const form2 = document.querySelector('#tracker-wallet2bank-recon-search-form');

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

        livewire.components.getComponentsByName('admin.tracker.wallet-reconciliation')[0].call('filterDate', dates);
    });


    const searchform = document.querySelector('#wallet-reconcilation-search-form');
    const searchString = searchform.querySelector('#search');


    searchform.addEventListener('submit', e => {
        e.preventDefault();

        livewire.components.getComponentsByName('admin.tracker.wallet-reconciliation')[0].call('searchFilter', searchString.value);
    });


    const search2form = document.querySelector('#wallet2bank-reconcilation-search-form');
    const search2String = search2form.querySelector('#search');

    search2form.addEventListener('submit', e => {
        e.preventDefault();

        livewire.components.getComponentsByName('admin.tracker.wallet-reconciliation')[0].call('searchFilter', search2String.value);
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
            });

            const dateform = document.querySelector('#tracker-cash-recon-search-form');

            const start = dateform.querySelector('#startDate');
            const end = dateform.querySelector('#endDate');

            start.value = "";
            end.value = "";

        });
    });

</script>



@endsection


{{-- if (searchString.value == "") {
 searchString.style.border = "1px solid lightcoral";
 searchString.style.color = "lightcoral";
 return false;
 } else {
 searchString.style.border = "1px solid #000";
 searchString.style.color = "#000";
 }  --}}
