@extends('layouts.commertial-head')

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
                    <x-app.commercial-head.uploads.hdfc />
                    {{-- ICICI --}}
                    <x-app.commercial-head.uploads.icici />
                    {{-- sbi --}}
                    <x-app.commercial-head.uploads.axis />

                    <x-app.commercial-head.uploads.idfc />

                    {{-- Axis Upload --}}
                </div>
                <div class="row mb-3">
                    <x-app.commercial-head.uploads.sbi />

                    {{-- AMEX bank --}}
                    <x-app.commercial-head.uploads.amex />

                    {{-- All bank --}}
                    <x-app.commercial-head.uploads.all />


                    <div class="col-lg-2 col-12 mt-3">
                        <div class="entry-box1 p-3">
                            <h2>Franchisee Debit</h2>
                            <div class="row">
                                <div class="col-lg-12 col-6">
                                    <button data-bs-toggle="modal" data-bs-target="#franchiseeUpload" class="btn btn-hdfc"><i class="fa fa-plus mb-1" aria-hidden="true"></i><br></button>
                                </div>
                            </div>
                        </div>
                        <x-modals.commercial-head.upload name="Franchisee Debit" id="franchiseeUpload" url="/chead/upload/franchisee-debit" exampleFileLink="{{ asset('public/sample/franchise-debit-sample.xlsx') }}" />
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/js/custom/bankMIS.js') }}?t={{ time() }}"></script>
@endsection
