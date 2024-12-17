@extends('layouts.commertial-head')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />

        <div class="tab-content tab-transparent-content">
            @livewire('commercial-head.dashboard.dashboard')
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/js/commercial-head/DisplayController.js') }}"></script>

<script>
    // Listening for Livewire Reset Event
    Livewire.on('resetAll', () => {
        const resetsItem = ['#select1-dropdown'];

        resetsItem.forEach(item => {
            $j(item).select2('destroy');
            $j(item).val('');
            $j(item).select2();
        });
    })


    // Trigger tooltips
    document.addEventListener('DOMContentLoaded', () => {
        Livewire.hook('message.processed', (message, component) => {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        });
    })

</script>
@endsection
