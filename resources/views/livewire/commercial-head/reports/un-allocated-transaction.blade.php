<div x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    }
}" x-init="() => {
    Livewire.on('unallocated:success', () => {
        succesMessageConfiguration('Un Allocated Transaction Updated Successfully.');
        window.location.reload();
    });

    Livewire.on('unallocated:failed', () => {
        errorMessageConfiguration('Something went wrong!, Please try again.');
        return false;
    });
}">

    <div class="row mb-2">
        <x-app.commercial-head.reports.unallocated.tabs :filtering="$filtering" :activeTab="$activeTab" />


        <div class="row mt-3">
            <x-app.commercial-head.reports.unallocated.filters :filtering="$filtering" :months="$_months" :tab="$activeTab" />
        </div>

        {{-- Totals --}}
        <x-app.commercial-head.reports.unallocated.totals :filtering="$filtering" :datas="$datas" :activeTab="$activeTab" />


        {{-- Table --}}
        <x-app.commercial-head.reports.unallocated.table-headers :orderBy="$orderBy" :dataset="$datas" :activeTab="$activeTab" :startdate="$startDate" :enddate="$endDate">

            <x-scrollable.scroll-body>
                @if ($activeTab == 'cash')
                @foreach ($datas as $data)
                <tr >
                    <td class="left">
                        {{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}
                    </td>
                    <td class="left"> {{ $data->{'pkupPtCode'} }} </td>
                    <td class="left"> {{ $data->{'depSlipNo'} }} </td>
                    <td class="left"> {{ $data->{'colBank'} }} </td>
                    <td class="left"> {{ $data->{'locationShort'} }} </td>
                    <td class="right"> {{ $data->{'depositAmount'} }} </td>
                    <td>
                        <button style="border: none; outline: none; background: transparent;" class="text-primary" data-bs-target="#{{ $data->className }}" data-bs-toggle="modal">
                            <i class="fa fa-eye"></i>
                        </button>
                    </td>
                    <x-app.commercial-head.reports.unallocated.partials.cash-modal :data="$data" />
                </tr>
                @endforeach
                @endif
                @if ($activeTab == 'card')
                @foreach ($datas as $data)
                <tr >
                    <td class="left">
                        {{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}
                    </td>
                    <td class="left"> {{ $data->{'pkupPtCode'} }} </td>
                    <td class="left"> {{ $data->{'colBank'} }} </td>
                    <td class="right"> {{ $data->{'depositAmount'} }} </td>
                    <td>
                        <button style="border: none; outline: none; background: transparent;" class="text-primary" data-bs-target="#{{ $data->className }}" data-bs-toggle="modal">
                            <i class="fa fa-eye"></i>
                        </button>
                    </td>
                    <x-app.commercial-head.reports.unallocated.partials.card-modal :data="$data" />
                </tr>
                @endforeach
                @endif

                @if ($activeTab == 'upi')
                @foreach ($datas as $data)
                <tr >
                    <td class="left">
                        {{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}
                    </td>
                    <td class="left"> {{ $data->{'pkupPtCode'} }} </td>
                    <td class="left"> {{ $data->{'colBank'} }} </td>
                    <td class="right"> {{ $data->{'depositAmount'} }} </td>
                    <td><button style="border: none; outline: none; background: transparent;" class="text-primary" data-bs-target="#{{ $data->className }}" data-bs-toggle="modal">
                            <i class="fa fa-eye"></i>
                        </button>
                    </td>
                    <x-app.commercial-head.reports.unallocated.partials.upi-modal :data="$data" />
                </tr>
                @endforeach
                @endif

                @if ($activeTab == 'wallet')
                @foreach ($datas as $data)
                <tr >
                    <td class="left">
                        {{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}
                    </td>
                    <td class="left"> {{ $data->{'tid'} }} </td>
                    <td class="left"> {{ $data->{'colBank'} }} </td>
                    <td class="left"> {{ $data->{'storeName'} }} </td>
                    <td class="right"> {{ $data->{'depositAmount'} }} </td>
                    <td>
                        <button style="border: none; outline: none; background: transparent;" class="text-primary" data-bs-target="#{{ $data->className }}" data-bs-toggle="modal">
                            <i class="fa fa-eye"></i>
                        </button>
                    </td>
                    <x-app.commercial-head.reports.unallocated.partials.wallet-modal :data="$data" />
                </tr>
                @endforeach
                @endif
            </x-scrollable.scroll-body>
        </x-app.commercial-head.reports.unallocated.table-headers>
    </div>
</div>
