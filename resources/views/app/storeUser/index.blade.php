@extends('layouts.store-user')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />

        <div class="tab-content tab-transparent-content">
            @livewire('store-user.dashboard.dashboard')
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script src="{{ asset('assets/js/store-user/dashboard.js') }}"></script>
<script src="{{ asset('assets/js/store-user/DisplayController.js') }}"></script>
@endsection
