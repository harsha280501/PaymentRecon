@extends('layouts.area-manager')

@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />
    </div>
    <div class="tab-content tab-transparent-content bg-white">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
            <section id="entry">
                <div class="row mb-3">
                    <div class="col-lg-8 col-12">
                        <div class="entry-box2 p-3">
                            <h2>Reports</h2>
                            <div class="row">
                                <div class="col-lg-3 col-3">
                                    <a class="btn btn-warning" href="{{ url('/') }}/amanager/sap" style="padding: 1.4375rem 1.25rem;">SAP - Tender-wise Sales</a>
                                </div>
                                <div class="col-lg-3 col-3">
                                    <a class="btn btn-warning" href="{{ url('/') }}/amanager/mpos" style="padding: 1.4375rem 1.25rem;">MPOS - Tender Wise Sales</a>
                                </div>
                                <div class="col-lg-3 col-3">
                                    <a class="btn btn-warning" href="{{ url('/') }}/amanager/bank-mis" style="padding: 1.4375rem 1.25rem;">BANK MIS</a>
                                </div>
                                <div class="col-lg-3 col-3">
                                    <a class="btn btn-warning" href="{{ url('/') }}/amanager/bank-statement" style="padding: 1.4375rem 1.25rem;">Bank Statement</a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </section>

        </div>
    </div>

</div>

</div>

@endsection
