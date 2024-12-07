@extends('layouts.commertial-head')

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
                            <h2>Approval Status</h2>

                            <div style="display: flex; gap: 3em; flex-wrap: wrap">
                                <div>
                                    <div class="row">
                                        <div class="col-lg-4 col-12 mb-2">
                                            <a class="btn bg-primary" href="{{ url('/') }}/chead/approval-process/cash-recon-process?tab=main" style="padding: 1.4375rem 1.25rem;">Cash Reconciliation</a>
                                        </div>
                                        <div class="col-lg-4 col-12 mb-2">
                                            <a class="btn bg-primary" href="{{ url('/') }}/chead/approval-process/card-recon-process?tab=card" style="padding: 1.4375rem 1.25rem;">Card Reconciliation</a>
                                        </div>
                                        <div class="col-lg-4 col-12 mb-2">
                                            <a class="btn bg-primary" href="{{ url('/') }}/chead/approval-process/upi-recon-process?tab=upi" style="padding: 1.4375rem 1.25rem;">UPI Reconciliation</a>
                                        </div>

                                        <div class="col-lg-4 col-12 mt-2">
                                            <a class="btn bg-primary" href="{{ url('/') }}/chead/approval-process/wallet-recon-process?tab=wallet" style="padding: 1.4375rem 1.25rem;">Wallet Reconciliation</a>
                                        </div>
                                        <div class="col-lg-4 col-12 mt-2">
                                            <a class="btn bg-primary" href="{{ url('/') }}/chead/approval-process/bank-statement-process" style="padding: 1.4375rem 1.25rem;">Bank Statement Process</a>
                                        </div>
                                        <div class="col-lg-4 col-12 mt-2">
                                            <a class="btn bg-primary" href="{{ url('/') }}/chead/approval-process/direct-deposit" style="padding: 1.4375rem 1.25rem;">Direct Deposit</a>
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
