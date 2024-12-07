@extends('layouts.commertial-team')

@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
    </div>
    <div class="tab-content tab-transparent-content bg-white">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
            <section id="entry">
                <div class="row mb-3 gap-2">
                    <div class="col-lg-7 col-12">
                        <div class="entry-box2 p-3">
                            <h2>Tracker</h2>

                            <div style="display: flex; gap: 3em; flex-wrap: wrap">
                                <div>
                                    <div class="row">
                                        <div class="col-lg-3 col-12">
                                            <a class="btn btn-primary" href="{{ url('/') }}/cuser/tracker/cash-recon" style="padding: 1.4375rem 1.25rem;">Cash Reconciliation</a>
                                        </div>
                                        <div class="col-lg-3 col-12">
                                            <a class="btn btn-primary" href="{{ url('/') }}/cuser/tracker/card-recon" style="padding: 1.4375rem 1.25rem;">Card Reconciliation</a>
                                        </div>
                                        <div class="col-lg-3 col-12">
                                            <a class="btn btn-primary" href="{{ url('/') }}/cuser/tracker/upi-recon" style="padding: 1.4375rem 1.25rem;">UPI Reconciliation</a>
                                        </div>

                                        <div class="col-lg-3 col-12 ">
                                            <a class="btn btn-primary" href="{{ url('/') }}/cuser/tracker/wallet-recon" style="padding: 1.4375rem 1.25rem;">Wallet Reconciliation</a>
                                        </div>

                                        <div class="col-lg-3 col-12 mt-2">
                                            <a class="btn btn-primary" href="{{ url('/') }}/cuser/tracker/all-card-recon" style="padding: 1.4375rem 1.25rem;">All Tender Reconciliation</a>
                                        </div>
                                    </div>
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
