@extends('layouts.commertial-team')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />

        <div class="tab-content tab-transparent-content">
            <section id="entry">
                <div class="row mb-3 gap-2">
                    <div class="col-lg-12 col-12">
                        <div class="entry-box2 p-3 text-center" style="height: fit-content; place-items: center">
                            <img src="{{ url('/') }}/assets/images/logo.jpg" style="object-fit: cover; height: 10em; width: 10em; pointer-events: none; mix-blend-mode: multiply" alt="main">
                            <h2 class="mt-3">Welcome {{ auth()->user()->name }}</h2>
                            <p>head straight to your <a href="{{ url('/') }}/cuser/dashboard">Dashboard</a></p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@endsection
