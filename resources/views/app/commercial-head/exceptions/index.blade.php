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
                    <div class="col-lg-8 col">
                        <div class="entry-box2 p-3">
                            <h2>Exception</h2>
                            <div class="row">
                                <div class="col-lg-3 col-12">
                                    <a class="btn btn-warning" href="{{ url('/') }}/chead/exception/mail-list" style="padding: 1.4375rem 1.25rem;">Mail List</a>
                                </div>
                                <div class="col-lg-3 col-12">
                                    <a class="btn btn-warning" href="{{ url('/') }}/chead/exception/adj-collection" style="padding: 1.4375rem 1.25rem;">Adjustment Collections</a>
                                </div>
                                <div class="col-lg-3 col-12">
                                    <a class="btn btn-warning" href="{{ url('/') }}/chead/exception/deposit-deposit" style="padding: 1.4375rem 1.25rem;">All Bank - Direct Deposit</a>
                                </div>
                                <div class="col-lg-3 col-12">
                                    <a class="btn btn-warning" href="{{ url('/') }}/chead/exception/activity" style="padding: 1.4375rem 1.25rem;">User Activity</a>
                                </div>
                                <div class="col-lg-3 col-12 mt-3">
                                    <a class="btn btn-warning" href="{{ url('/') }}/chead/exception/store-update-history" style="padding: 1.4375rem 1.25rem;">Store Update History</a>
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
