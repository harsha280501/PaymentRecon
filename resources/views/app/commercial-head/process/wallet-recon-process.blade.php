@extends('layouts.commertial-head')

@section('content')
<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
        <div class="tab-content tab-transparent-content bg-white">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                @livewire('commercial-head.process.wallet-process')
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="{{ asset('assets/js/commercial-head/sap-recon.js') }}"></script>
@endsection
