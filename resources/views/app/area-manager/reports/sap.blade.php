@extends('layouts.area-manager')

@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
        <div class="tab-content tab-transparent-content bg-white" style="min-height: 550px;">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                <section id="recent">
                    <div class="row">
                        @livewire('area-manager.reports.reports-s-a-p')
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script defer>
    const form = document.querySelector('#sap-team-search-form');

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

        livewire.components.getComponentsByName('area-manager.reports.reports-s-a-p')[0].call('filterDate', dates);
    });

</script>
@endsection
