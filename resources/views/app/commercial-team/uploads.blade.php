@extends('layouts.commertial-team')

@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
    </div>
    <div class="tab-content tab-transparent-content bg-white">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
            <section id="entry">

                <div class="row mb-3">
                    {{-- HDFC --}}
                    <x-app.commercial-team.uploads.hdfc />

                    {{-- ICICI --}}
                    <x-app.commercial-team.uploads.icici />

                    {{-- sbi --}}
                    <x-app.commercial-team.uploads.sbi />

                    {{-- Axis Upload --}}
                    <x-app.commercial-team.uploads.axis />
                </div>
                <div class="row mb-3">
                    {{-- All bank --}}
                    <x-app.commercial-team.uploads.all />
                    {{-- AMEX bank --}}
                    <x-app.commercial-team.uploads.amex />
                    {{-- IDFC --}}
                    <x-app.commercial-team.uploads.idfc />
                </div>
            </section>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script defer src="{{ asset('assets/js/custom/uploads.js') }}?t={{ time() }}"></script>
@endsection
