<div wire:ignore wire:key="{{ $data->className }}">


    <x-app.commercial-head.reports.unallocated.edit-modal :data="$data" header="Edit Un Allocated Card">
        @php
        $items = ['depositDate', 'pkupPtCode', 'colBank', 'depositAmount'];

        $alias = [
        'depositDate' => 'Deposit Date',
        'pkupPtCode' => 'Pickup Point Code',
        'colBank' => 'Collection Bank',
        'depositAmount' => 'Deposit Amount'
        ];

        $formatted = ['depositDate' => !$data->depositDate ? '' :
        Carbon\Carbon::parse($data->depositDate)->format('d-m-Y')];

        @endphp
        <div class="row mb-5">
            @foreach($data as $key => $value)
            @if(in_array($key, $items))
            <x-app.commercial-head.reports.unallocated.list-item :name="$key" :value="$value" :alias="$alias"
                :formatted="$formatted" />
            @endif
            @endforeach
        </div>
    </x-app.commercial-head.reports.unallocated.edit-modal>

</div>