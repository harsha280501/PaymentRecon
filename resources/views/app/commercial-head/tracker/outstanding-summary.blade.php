@extends('layouts.commertial-head')
@extends('layouts.commertial-head')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
        <div class="tab-content tab-transparent-content bg-white" style="min-height: 500px;">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                <section id="recent">
                    <div class="row">
                        @livewire('commercial-head.tracker.outstanding-summary')
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

{{-- Script for listeners  --}}
<script defer>
    // var $j = jQuery.noConflict();

    document.addEventListener('livewire:load', event => {
        // listen for reset event
        Livewire.on('resetAll', e => {
            // clear items
            const resetItems = ['#outstanding_storeFilter'];

            resetItems.forEach(item => {
                $j(item).select2('destroy');
                $j(item).val('');
                $j(item).select2();
            });
        });
    });

</script>
