@extends('layouts.store-user')


@section('content')
<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
        <div class="tab-content tab-transparent-content bg-white" style="min-height: 350px;">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                <section id="recent">
                    <div class="row">
                        @livewire('store-user.reports.all-card-upi-wallet')
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@endsection
