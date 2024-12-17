@extends('layouts.commertial-head')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
        <div class="tab-content tab-transparent-content bg-white" style="min-height: 500px;">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                <section id="recent">
                    <div class="row">
                        @livewire('commercial-head.uploads.bank-mis-repository')
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')

<script defer>
    const form = document.querySelector('#bank-mis-search-form');

    const searchString = form.querySelector('#search');

    form.addEventListener('submit', e => {
        e.preventDefault();

        if (searchString.value == "") {
            searchString.style.border = "1px solid lightcoral";
            searchString.style.color = "lightcoral";
            return false;
        } else {
            searchString.style.border = "1px solid #000";
            searchString.style.color = "#000";

        }

        livewire.components.getComponentsByName('commercial-head.bank-mis-repository')[0].call('searchFilter', searchString.value);

    });

</script>
@endsection
