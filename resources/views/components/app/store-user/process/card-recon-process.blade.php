@extends('layouts.store-user')

@section('content')
<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />

        <div class="tab-content tab-transparent-content">
            @livewire('store-user.process.card-recon')
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="{{ asset('assets/js/store-user/sap/sap-recon.js') }}"></script>

<script defer>
    var $j = jQuery.noConflict();

    // Livewire started
    document.addEventListener('livewire:load', event => {

        // listen for reset event
        Livewire.on('resetAll', e => {
            // clear items
            const resetItems = ['#select1-dropdown', '#select2-dropdown'];

            resetItems.forEach(item => {
                $j(item).select2('destroy');
                $j(item).val('');
                $j(item).select2();
            })
        });
    });

</script>
@endsection
