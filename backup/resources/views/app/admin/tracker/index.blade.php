@extends('layouts.admin')

@section('content')


<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
    </div>
    <div class="tab-content tab-transparent-content bg-white">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
            <section id="entry">
                <div class="row mb-3 gap-2">
                    <div class="col-lg-8 col-12">
                        <div class="entry-box2 p-3">
                            <h2>Tracker</h2>
                            <div class="row">
                                {{-- /admin/process/mpos-cash-recon?t=cash --}}
                                <div class="col-lg-4 col-12">
                                    <a class="btn btn-warning" href="{{ url('/') }}/admin/mpos-reconcil?tab=mposbankrecon" style="padding: 1.4375rem 1.25rem;">MPOS Cash Tender To Bank Drop Reconciliation</a>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <a class="btn btn-warning" href="{{ url('/') }}/admin/mpos-reconcil?tab=mposmisrecon" style="padding: 1.4375rem 1.25rem;">MPOS Bank Drop To Cash MIS Reconciliation</a>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <a class="btn btn-warning" href="{{ url('/') }}/admin/mpos-reconcil?tab=mposcardrecon" style="padding: 1.4375rem 1.25rem;">MPOS Card Reconciliation</a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-4 col-12">
                                    <a class="btn btn-warning" href="{{ url('/') }}/admin/mpos-reconcil?tab=mposwalletrecon" style="padding: 1.4375rem 1.25rem;">MPOS Wallet Reconciliation</a>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <a class="btn btn-warning" href="{{ url('/') }}/admin/mpos-reconcil?tab=mpossaprecon" style="padding: 1.4375rem 1.25rem;">MPOS SAP Reconciliation</a>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <a class="btn btn-warning" href="{{ url('/') }}/admin/mpos-reconcil?tab=mpossapcardrecon" style="padding: 1.4375rem 1.25rem;">MPOS SAP Card Reconciliation</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@endsection
