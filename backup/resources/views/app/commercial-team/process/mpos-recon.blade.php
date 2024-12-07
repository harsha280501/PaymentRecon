@extends('layouts.commertial-team')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />

        <div class="tab-content tab-transparent-content">
            @livewire('commercial-team.process.mpos-recon')
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script src="{{ asset('assets/js/commercial-team/mpos/mpos-recon.js') }}"></script>
@endsection
