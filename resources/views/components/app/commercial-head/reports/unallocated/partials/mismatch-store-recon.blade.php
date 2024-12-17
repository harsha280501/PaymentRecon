<div wire:ignore.self wire:key="{{ rand() }}">

    <x-app.commercial-head.reports.unallocated.mismatch-store-reco-modal :data="$data" header="Edit Un Allocated Cash">
        @php
        $items = ['depositDate', 'pkupPtCode', 'depSlipNo', 'colBank', 'locationShort', 'depositAmount'];

        $alias = [
        'depositDate' => 'Deposit Date',
        'colBank' => 'Collection Bank',
        'storeUpdateRemarks' => 'Store Update Remarks',
        'depositAmount' => 'Deposit Amount',
        'adjAmount' => 'Store Response Entry'
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