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
}" wire:key="291bb4437bfb3ef467aea3e9998081a41393de50da453dcdf177f7e39603db65">

    <x-app.commercial-head.reports.unallocated.tabs :filtering="$filtering" :activeTab="$activeTab" />

    <x-selection.checkboxes :selectionHas="$selectionHas">

        <div class="row mt-3" wire:key="12998c017066eb0d2a70b94e6ed3192985855ce390f321bbdb832022888bd251">
            <x-app.commercial-head.reports.unallocated.filters :activeTab="$activeTab" :filtering="$filtering" :months="$_months" :tab="$activeTab" />
        </div>

        <x-app.commercial-head.reports.unallocated.partials.totals :dataset="$totals" />
        <x-scrollable.scrollable :dataset="$dataset">
            <x-scrollable.scroll-head>
                <tr wire:key="9a1e0534d0566caa73a4db185a20278eddb5448c82cdefc76ad5ea749df8be99_{{ rand() }}">
                    <th>
                        <x-selection.check-all :selectionHas="$selectionHas" />
                    </th>
                    <td class="left">Sales Date</td>

                    <th wire:key="883edc1639a129358de468a9990708774cf49774ae35cbbca6c89690a872b07c">
                        <div class="d-flex align-items-center gap-2">
                            <span>Deposit Date</span>
                            <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="
                                fa @if($orderBy == 'asc') 
                                 fa-caret-up 
                                @else fa-caret-down @endif"> </i>
                        </div>
                    </th>

                    <td class="left">Store ID</td>
                    <td class="left">Retek Code</td>
                    
                    <td class="left">Pickupt Code </td>
                    <td class="left">Deposit Slip No </td>

                    <td class="left">Collection Bank</td>
                    <td class="left">Location</td>

                    <td class="right">Deposit Amount</td>
                    <td class="">Action</td>
                </tr>
            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>
                @foreach ($dataset as $data)
                <tr wire:key="8d8ef52a0fd3f76bf79ec7314aedb20f63e118713e9aba10444bb5151a0fe7658b5f9007aafad075a50b966bd6751846e10b1b7140ebdb602ef5849c73cdc1a0_{{ rand() }}">
                    <td class="left" scope="row" wire:key="fef19a476993669aa0730d30c7e549b204838979f0a4fd9202117d4d9f9e6cef">
                        <input class="form-check-input" type="checkbox" value="{{ $data->storeMissingUID }}" x-model="selection" />
                    </td>
                    <td class="left">
                        {{ !$data->salesDate ? '' : Carbon\Carbon::parse($data->salesDate)->format('d-m-Y') }}
                    </td>
                    <td class="left">
                        {{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}
                    </td>
                    <td class="left"> {{ $data->storeID }} </td>
                    <td class="left"> {{ $data->retekCode }} </td>
                    <td class="left"> {{ $data->{'pkupPtCode'} }} </td>
                    <td class="left"> {{ $data->{'depSlipNo'} }} </td>
                    <td class="left"> {{ $data->{'colBank'} }} </td>
                    <td class="left"> {{ $data->{'locationShort'} }} </td>
                    <td class="right"> {{ $data->{'depositAmount'} }} </td>
                    <td wire:key="204f83aaa4059d6afe5b81f39e5d43323672b6e2f9321631d9ee78d77ae18c72">
                        <button style="border: none; outline: none; background: transparent;" class="text-primary" data-bs-target="#{{ $data->className }}" data-bs-toggle="modal">
                            <i class="fa fa-eye"></i>
                        </button>
                    </td>
                    <div wire:key="5a88bf2b5361909452638374d32d971b5c5afdc770b7186c26a16ebb5bfaa04f">
                        <x-app.commercial-head.reports.unallocated.partials.cash-modal :data="$data" />
                    </div>
                </tr>
                @endforeach
            </x-scrollable.scroll-body>
        </x-scrollable.scrollable>
    </x-selection.checkboxes>

    <div wire:key="521e65fabae605f525a90f0ebad3e87103e9277f400586c1083513efb8f40ed5">
        {{-- <x-app.commercial-head.reports.unallocated.import-modal :message="$message" id="import-modal" /> --}}
        <x-app.commercial-head.reports.unallocated.import-cashmodal :message="$message" id="import-modal" name="Unallocated Cash Upload" url="/chead/upload/unallocated/cash" exampleFileLink="{{ asset('public/sample/hdfc-cash-sample.CSV') }}"/>

    </div>
</div>
