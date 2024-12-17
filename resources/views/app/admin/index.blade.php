@extends('layouts.admin')


@section('content')

<div class="row">
    <div class="col-md-12">
        <x-tabs.index :tabs="$tabs" />

        <div class="tab-content tab-transparent-content">
            @livewire('admin.dashboard.dashboard')
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Listening for Livewire Reset Event
    Livewire.on('resetAll', () => {
        const resetsItem = ['#select1-dropdown'];

        resetsItem.forEach(item => {
            $j(item).select2('destroy');
            $j(item).val('');
            $j(item).select2();
        });
    })

</script>
@endsection
