@extends('layouts.commertial-team')

@section('content')
<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
        <div class="tab-content tab-transparent-content bg-white">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                @livewire('commercial-team.process.bank-statement-recon')
            </div>
        </div>
    </div>
</div>
@endsection

{{-- main scripts --}}
@section('scripts')
<script src="{{ asset('assets/js/commercial-team/bank-statement-process.js') }}"></script>

<script defer>
    var $j = jQuery.noConflict();

    // Livewire started
    document.addEventListener('livewire:load', event => {

        // listen for reset event
        Livewire.on('resetAll', e => {
            // clear items
            const resetItems = [
                "#cash-stores"
                , "#card-stores"
                , "#upi-stores"
                , "#wallet-stores"
                , "#cash-codes"
                , "#card-codes"
                , "#wallet-codes"
                , "#upi-codes"
            , ];
            resetItems.forEach(item => {
                $j(item).select2('destroy');
                $j(item).val('');
                $j(item).select2();
            })
        });
    });

</script>

@endsection
