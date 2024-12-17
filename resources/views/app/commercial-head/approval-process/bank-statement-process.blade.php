@extends('layouts.commertial-head')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
        <div class="tab-content tab-transparent-content bg-white" style="min-height: 500px;">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                <section id="recent">
                    <div class="row">
                        @livewire('commercial-head.approval-process.bank-statement-process')
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
    var $j = jQuery.noConflict();

    // Livewire started
    document.addEventListener('livewire:load', event => {

        // listen for reset event
        Livewire.on('resetAll', e => {
            // clear items
            const resetItems = [
                '#select01-dropdown'
                , '#select02-dropdown'
                , '#select03-dropdown'
                , '#select04-dropdown'

                , '#select11-dropdown'
                , '#select12-dropdown'
                , '#select13-dropdown'
                , '#select14-dropdown'

                , '#select21-dropdown'
                , '#select22-dropdown'
                , '#select23-dropdown'
                , '#select24-dropdown'
            ];
            resetItems.forEach(item => {
                $j(item).select2('destroy');
                $j(item).val('');
                $j(item).select2();
            })
        });
    });

</script>
@endsection
