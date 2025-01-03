@extends('layouts.commertial-head')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
        <div class="tab-content tab-transparent-content bg-white" style="min-height: 500px;">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                <section id="recent">
                    <div class="row">
                        @livewire('commercial-head.reports.un-allocated-transactions.cash-direct-deposit-reco')
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@endsection




@section('scripts')
<script>
    // Livewire started
    document.addEventListener('livewire:load', event => {

        // listen for reset event
        Livewire.on('reset:all', e => {

            const resetItems = [
                '#select1-dropdown'
            ];

            resetItems.forEach(item => {
                $j(item).select2('destroy');
                $j(item).val('');
                $j(item).select2();
            });
        });
    });

</script>
@endsection