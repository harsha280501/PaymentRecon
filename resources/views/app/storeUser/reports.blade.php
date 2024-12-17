@extends('layouts.store-user')

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
                            <h2>Tenderwise Sales</h2>
                            <div class="row">
                                <div class="col-lg-4 col-12">
                                    <a class="btn btn-warning" href="{{ url('/') }}/suser/reports/card-tender-sales" style="padding: 1.4375rem 1.25rem;">Daily Card/UPI/Wallet Sales</a>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <a class="btn btn-warning" href="{{ url('/') }}/suser/reports/cash-tender-sales" style="padding: 1.4375rem 1.25rem;">Daily Cash Sales</a>
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
