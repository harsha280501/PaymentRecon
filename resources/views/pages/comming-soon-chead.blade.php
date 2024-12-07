@extends('layouts.commertial-head')

@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />


        <div class="tab-content tab-transparent-content">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
                <div class="comesoon">
                    <h2 style="text-align: center;padding: 241px;">Coming Soon</h2>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
