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
                    <div class="col-lg-7 col-12">
                        <div class="entry-box2 p-3">
                            <h2>Settings</h2>
                            <div class="row">
                                <div class="col-lg-4 col-12">
                                    <a class="btn btn-danger" href="{{ url('/') }}/chead/settings/storemaster" style="padding: 1.4375rem 1.25rem;">Store Master</a>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <a class="btn btn-danger" href="{{ url('/') }}/chead/settings/tid-mid-master" style="padding: 1.4375rem 1.25rem;">TID MID Master</a>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <a class="btn btn-danger" href="{{ url('/') }}/chead/changepwd" style="padding: 1.4375rem 1.25rem;">Change Password</a>
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
