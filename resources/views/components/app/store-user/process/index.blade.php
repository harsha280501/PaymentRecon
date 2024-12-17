@extends('layouts.store-user')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
    </div>
    <div class="tab-content tab-transparent-content bg-white">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
            <section id="entry">
                <div class="row mb-3 gap-2">
                    <div class="col-lg-6 col-12">
                        <div class="entry-box2 p-3">
                            <h2>Process</h2>

                            <div class="row">
                                <div class="col-lg-6 col-12 mb-2">
                                    <a class="btn bg-primary" href="{{ url('/') }}/suser/process/cash-recon?t=main" style="padding: 1.4375rem 1.25rem;">Cash Reconciliation</a>
                                </div>
                                <div class="col-lg-6 col-12 mb-2">
                                    <a class="btn bg-primary" href="{{ url('/') }}/suser/process/card-recon?t=card" style="padding: 1.4375rem 1.25rem;"> Card Reconciliation</a>
                                </div>
                                <div class="col-lg-6 col-12 mb-2">
                                    <a class="btn bg-primary" href="{{ url('/') }}/suser/process/wallet-recon?t=wallet" style="padding: 1.4375rem 1.25rem;"> Wallet Reconciliation</a>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <a class="btn bg-primary" href="{{ url('/') }}/suser/process/upi-recon?t=upi" style="padding: 1.4375rem 1.25rem;"> UPI Reconciliation</a>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <a class="btn bg-primary" href="{{ url('/') }}/suser/process/all-card-recon" style="padding: 1.4375rem 1.25rem;"> All Card Reconciliation</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    @endsection
