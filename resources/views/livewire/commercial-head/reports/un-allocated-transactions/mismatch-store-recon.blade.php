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

    Livewire.on('unallocated:failed', (message) => {
        errorMessageConfiguration('Something went wrong!, Please try again.' + message);
        return false;
    });
}">

    <style>
        .modal .select2-selection__rendered {
            padding: .28em !important;
        }

    </style>

    <x-app.commercial-head.reports.unallocated.tabs :filtering="$filtering" :activeTab="$activeTab" />


    <div class="row mt-3">
        <x-app.commercial-head.reports.unallocated.mismatch-store-recon-filters :activeTab="$activeTab" :filtering="$filtering" :months="$_months" :tab="$activeTab" />
    </div>

    <x-scrollable.scrollable :dataset="$dataset">
        <x-scrollable.scroll-head>
            <tr wire:key="8dc4d6616fa2a2d68bb2d3f3bfabe9216cc2b722257dfcebd79c80da83ffc53720f1c983be9458f2016df9b98cc2310429414f25b4cead5c2d799f639aecccb3">
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
                <td class="left">Collection Bank</td>
                <td class="left">Store Updated Remarks</td>
                <td class="right">Deposit Amount</td>
                <td class="right">Store Response Entry</td>
                <td class="text-center">Submit Recon</td>
            </tr>
        </x-scrollable.scroll-head>
        <x-scrollable.scroll-body>
            @foreach ($dataset as $data)
            <tr wire:key="8d8ef52a0fd3f76bf79ec7314aedb20f63e118713e9aba10444bb5151a0fe7658b5f9007aafad075a50b966bd6751846e10b1b7140ebdb602ef5849c73cdc1a0_{{ rand() }}">
                <td class="left">
                    {{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}
                </td>
                <td class="left"> {{ $data->storeID }} </td>
                <td class="left"> {{ $data->retekCode }} </td>
                <td class="left"> {{ $data->colBank }} </td>
                <td class="left" data-bs-toggle="tooltip" title="{{ $data->storeUpdateRemarks }}">
                    {{ substr($data->storeUpdateRemarks, 0, 30) }}...
                </td>
                <td class="right"> {{ $data->depositAmount }} </td>
                <td class="right"> {{ $data->adjAmount }} </td>
                <td class="text-center"><a href="#"><i class="fa fa-eye" data-bs-toggle="modal" data-bs-target="#upload_modal_{{ $data->storeMissingUID }}"></i></a></td>
            </tr>
            <x-app.commercial-head.reports.unallocated.mismatch-store-reco-modal :stores="$stores" :data="$data" />
            @endforeach
        </x-scrollable.scroll-body>
    </x-scrollable.scrollable>

    <div wire:key="521e65fabae605f525a90f0ebad3e87103e9277f400586c1083513efb8f40ed5">
        <x-app.commercial-head.reports.unallocated.mismatch-import-modal :message="$message" id="import-modal" />
    </div>

    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();
        $j('.searchField1').select2();

        document.addEventListener('livewire:load', function() {

            $j('#select2-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('status', e.target.value);
            });
        });

    </script>

</div>
