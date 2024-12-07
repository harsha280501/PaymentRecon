@extends('layouts.area-manager')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
    </div>
    <div class="tab-content tab-transparent-content bg-white">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
            <section id="entry">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="entry-box2 p-3">
                            {{--  <h2>Tracker</h2>  --}}
                            <div class="row">
                                <div class="col-lg-4 col-4">
                                    <a class="btn btn-warning" href="{{ url('/') }}/amanager/cashreconcil" style="padding: 1.4375rem 1.25rem;">Cash Reconciliation</a>
                                </div>
                                <div class="col-lg-4 col-4">
                                    <a class="btn btn-warning" href="{{ url('/') }}/amanager/cardreconcil" style="padding: 1.4375rem 1.25rem;">Card Reconciliation</a>
                                </div>
                                <div class="col-lg-4 col-4">
                                    <a class="btn btn-warning" href="{{ url('/') }}/amanager/walletreconcil" style="padding: 1.4375rem 1.25rem;">Wallet Reconciliation</a>
                                </div>

                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-4 col-4">
                                    <a class="btn btn-warning" href="{{ url('/') }}/amanager/cashreconcil?tab=cash2bank" style="padding: 1.4375rem 1.25rem;">Cash MIS to Bank Statement</a>
                                </div>
                                <div class="col-lg-4 col-4">
                                    <a class="btn btn-warning" href="{{ url('/') }}/amanager/cardreconcil?tab=card2bank" style="padding: 1.4375rem 1.25rem;">Card MIS to Bank Statement</a>
                                </div>
                                <div class="col-lg-4 col-4">
                                    <a class="btn btn-warning" href="{{ url('/') }}/amanager/walletreconcil?tab=wallet2bank" style="padding: 1.4375rem 1.25rem;">Wallet MIS to Bank Statement</a>
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
