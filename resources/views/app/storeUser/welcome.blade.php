@extends('layouts.store-user')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />

        <div class="tab-content tab-transparent-content">
            <section id="entry">
                <div class="row mb-3 gap-2">
                    <div class="col-lg-12 col-12">
                        <div class="entry-box2 p-3 text-center " style="height: 20vh; place-items: center">
                            <h2 class="mt-3">Welcome to the Collection Management & Reconciliation Portal</h2>
                            <p>head straight to your <a href="{{ url('/') }}/suser/dashboard">Dashboard</a></p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@endsection
