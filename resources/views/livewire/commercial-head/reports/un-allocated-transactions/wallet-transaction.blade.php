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

    Livewire.on('file:imported', () => {
        succesMessageConfiguration('Un Allocated Transactions Updated Successfully.');
        window.location.reload();
    });
}">

    <x-app.commercial-head.reports.unallocated.tabs :filtering="$filtering" :activeTab="$activeTab" />

    <x-selection.checkboxes :selectionHas="$selectionHas">

        <div class="row mt-3">
            <x-app.commercial-head.reports.unallocated.filters :activeTab="$activeTab" :filtering="$filtering" :months="$_months" :tab="$activeTab" />
        </div>
        <x-app.commercial-head.reports.unallocated.partials.totals :dataset="$totals" />

        <x-scrollable.scrollable :dataset="$dataset">
            <x-scrollable.scroll-head>
                <tr>
                    <th scope="col" class="left" wire:key="c50ef199a58f929ecaded5108d2737bf0e6ad680c85e66307d4f8799b8241d5f_{{ rand() }}">
                        <x-selection.check-all :selectionHas="$selectionHas" />
                    </th>
                    <td class="left">Sales Date</td>
                    <th>
                        <div class="d-flex align-items-center gap-2 left">
                            <span>Deposit Date</span>
                            <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="
                            fa-solid @if($orderBy == 'asc') 
                             fa-caret-up 
                            @else fa-caret-down @endif"> </i>
                        </div>
                    </th>
                    <td class="left">Store ID</td>
                    <td class="left">Retek Code</td>
                    <td class="left"> TID </td>
                    <td class="leftleft"> Collection Bank</td>
                    <td class="left"> Store Name </td>
                    <td class="right"> Deposit Amount </td>
                    <td class="">Action</td>

                </tr>
            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>
                @foreach ($dataset as $data)
                <tr wire:key="9a1e0534d0566caa73a4db185a20278eddb5448c82cdefc76ad5ea749df8be99_{{ rand() }}"> 
                    <td class="left" scope="row">
                        <input class="form-check-input" type="checkbox" wire:key="9a1e0534d0566caa73a4db185a20278eddb5448c82cdefc76ad5ea749df8be99dssdsd_{{ rand() }}" value="{{ $data->storeMissingUID }}" x-model="selection" />
                    </td>
                    <td class="left">
                        {{ !$data->salesDate ? '' : Carbon\Carbon::parse($data->salesDate)->format('d-m-Y') }}
                    </td>
                    <td class="left">
                        {{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}
                    </td>
                    <td class="left"> {{ $data->storeID }} </td>
                    <td class="left"> {{ $data->retekCode }} </td>
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
            </x-scrollable.scroll-body>
        </x-scrollable.scrollable>
    </x-selection.checkboxes>

    {{-- <x-app.commercial-head.reports.unallocated.import-modal :message="$message" id="import-modal" /> --}}
    <x-app.commercial-head.reports.unallocated.import-walletmodal :message="$message" id="import-modal" name="Unallocated Wallet Upload" url="/chead/upload/unallocated/wallet" exampleFileLink="{{ asset('public/sample/hdfc-cash-sample.CSV') }}"/>

</div>
