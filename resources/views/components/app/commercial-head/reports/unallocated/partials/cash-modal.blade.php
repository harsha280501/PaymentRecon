<div wire:ignore.self wire:key="{{ $data->className }}">

    <x-app.commercial-head.reports.unallocated.edit-modal :data="$data" header="Edit Un Allocated Cash">
        @php
        $items = ['depositDate', 'pkupPtCode', 'depSlipNo', 'colBank', 'locationShort', 'depositAmount'];

        $alias = [
        'depositDate' => 'Deposit Date',
        'pkupPtCode' => 'Pickup Point Code',
        'depSlipNo' => 'Deposit Slip Number',
        'colBank' => 'Collection Bank',
        'locationShort' => 'Location',
        'depositAmount' => 'Deposit Amount'
        ];

        $formatted = ['depositDate' => !$data->depositDate ? '' :
        Carbon\Carbon::parse($data->depositDate)->format('d-m-Y')];

        @endphp
        <div class="row mb-5" wire:ignore.self>
            @foreach($data as $key => $value)
            @if(in_array($key, $items))
            <x-app.commercial-head.reports.unallocated.list-item :name="$key" :value="$value" :alias="$alias"
                :formatted="$formatted" />
            @endif
            @endforeach
        </div>
    </x-app.commercial-head.reports.unallocated.edit-modal>
</div>