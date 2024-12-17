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
            <x-app.commercial-head.reports.unallocated.filters :activeTab="$activeTab" :filtering="$filtering" :months="$_months"
                :tab="$activeTab" :tids="$tids" />
        </div>




        <x-app.commercial-head.reports.unallocated.partials.totals :dataset="$totals" />

        <x-scrollable.scrollable :dataset="$dataset">
            <x-scrollable.scroll-head>
                <tr
                    wire:key="8dc4d6616fa2a2d68bb2d3f3bfabe9216cc2b722257dfcebd79c80da83ffc53720f1c983be9458f2016df9b98cc2310429414f25b4cead5c2d799f639aecccb3">
                    <th scope="col" class="left" wire:key="47e6abd91dc1dafjsad2550de757959fdf119d5c00e8b4e752bba69">
                        <x-selection.check-all :selectionHas="$selectionHas" />
                    </th>
                    <td class="left">Sales Date</td>
                    <th>
                        <div class="d-flex align-items-center gap-2 left">
                            <span>Deposit Date</span>
                            <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                class="
                                fa-solid @if ($orderBy == 'asc') fa-caret-up
                                @else fa-caret-down @endif">
                            </i>
                        </div>
                    </th>
                    <td class="left">Store ID</td>
                    <td class="left">Retek Code</td>
                    <td class="left"> TID </td>
                    <td class="left"> Collection Bank</td>
                    <td class="right"> Deposit Amount </td>
                    <td class="">Action</td>
                </tr>
            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>
                @foreach ($dataset as $data)
                    <tr
                        wire:key="9683ee228606fe5891156f0dcb871506d3d029b4ab77f8bf869a6fcd9f0cd30305f7833887ddcb7a1d11be7cc430bb26076b20f3f1e5d4614f39c27dca9fd117_{{ rand() }}">
                        <td class="left" scope="row"
                            wire:key="59a5b3012d55f464d72f4342_{{ rand() }}"79f02c515b08ec593e734645e6f2d9d6e085298194a40f0630f49bc0ee35f49cb2ecd6c816112aa273efc6be43f74b53c7ece008_{{ rand() }}">
                            <input class="form-check-input"
                                wire:key="e7f7c8da53d3541b0ee8e4c17cfdeb720a536a6ac1db1ffd32bbbfb8bd33f445928dfb42842b1c80639c0a7f68dfa8e4b4b3f590ba17d8f94c8e0490f9cce2e_{{ rand() }}"
                                type="checkbox" value="{{ $data->storeMissingUID }}" x-model="selection" />
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
                        <td class="left"> {{ $data->{'colBank'} }} </td>
                        <td class="right"> {{ $data->{'depositAmount'} }} </td>
                        <td>
                            <button style="border: none; outline: none; background: transparent;" class="text-primary"
                                data-bs-target="#{{ $data->className }}" data-bs-toggle="modal">
                                <i class="fa fa-eye"></i>
                            </button>
                        </td>

                        <div
                            wire:key="0ea87000a6b9d872accb329089ca7b78e5ec436d1a4e15c01ddb94e7bb7dda326f14c89d91b4982f1cf31c42ec295be4329a8cacf8a51faf89eafde55567f2ae_{{ rand() }}"">
                            <x-app.commercial-head.reports.unallocated.partials.card-modal :data="$data" />
                        </div>
                    </tr>
                @endforeach
            </x-scrollable.scroll-body>
        </x-scrollable.scrollable>
    </x-selection.checkboxes>

    {{-- <x-app.commercial-head.reports.unallocated.import-modal :message="$message" id="import-modal" /> --}}
    <x-app.commercial-head.reports.unallocated.import-cardmodal :message="$message" id="import-modal"
        name="Unallocated Card Upload" url="/chead/upload/unallocated/card"
        exampleFileLink="{{ asset('public/sample/hdfc-cash-sample.CSV') }}" />
</div>
