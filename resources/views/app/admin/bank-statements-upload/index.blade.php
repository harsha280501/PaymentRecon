@extends('layouts.admin')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
    </div>

    <div class="col-12 tab-content tab-transparent-content bg-white">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
            <section id="entry">
                <div class="row mb-3">
                    {{-- HDFC --}}
                    <x-app.admin.bank-statements-uploads.hdfc />

                    {{-- ICICI --}}
                    <x-app.admin.bank-statements-uploads.icici />

                    {{-- sbi --}}
                    <x-app.admin.bank-statements-uploads.sbi />

                    {{-- Axis Upload --}}
                    <x-app.admin.bank-statements-uploads.axis />

                    {{-- IDFC --}}
                    <x-app.admin.bank-statements-uploads.idfc />
                </div>
            </section>
        </div>
    </div>
</div>
</div>

@endsection

@section('scripts')

<script src="{{ asset('assets/js/misc.js') }}?t={{ time() }}"></script>

@endsection
