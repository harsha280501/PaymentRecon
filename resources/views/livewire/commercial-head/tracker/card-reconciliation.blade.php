<div x-data="{
    start: null,
    end: null,
    reset(){
        this.start = null
        this.end = null
    }
}" x-init="() => {
    Livewire.on('recon:updated', () => {
        succesMessageConfiguration('Recon Updated Successfully')
        window.location.reload()
    })


    Livewire.on('file:imported', () => {
        succesMessageConfiguration('Recon Uploaded Successfully')
        window.location.reload()
    })

    Livewire.on('recon:failed', (message) => {
        errorMessageConfiguration('Error, Something went wrong!.., please try again!')
    })


    Livewire.on('unallocated:success', (message) => {
        succesMessageConfiguration('Moved to Unallocated Successfully')
        window.location.reload()
        return true
    })
    
    Livewire.on('unallocated:failed', (message) => {
        errorMessageConfiguration(message.message)
        return false;
    })
}">

    <style>
        #dataset .select2-selection__rendered,
        #dataset .select2-dropdown {
            padding: .28em;
        }

    </style>
    <x-selection.checkboxes :selectionHas="$selectionHas">


        <div class="row mt-2" id="filters" style="z-index: 1 !important; ">
            <div class="col-lg-12">
                <div class="d-flex d-flex-mob " style="gap: .5em; flex-wrap: wrap;">

                    <div style="display:@if ($filtering) unset @else none @endif" class="">
                        <button @click="() => {
                        $wire.back()
                        reset()
                    }" style="background: transparent; outline: none; border: none; padding: .5em 1em; font-size: 1em">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                    </div>

                    <x-filters.brand_location_store />
                    <x-filters.extensions.dropdown_one keys="bank" initialValue="SELECT A BANK" :dataset="$banks" />

                    <div class="">
                        <div wire:ignore>
                            <select id="select2-dropdown" wire:model="matchStatus" style="width: 220px;" class="custom-select select2 form-control searchField w-mob-100 mb-1" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">
                                <option selected value="" class="dropdown-item">SELECT MATCHED STATUS</option>
                                <option value="" class="dropdown-item">ALL</option>
                                <option value="Matched" class="dropdown-item">Matched</option>
                                <option value="Not Matched" class="dropdown-item">Not Matched</option>
                            </select>
                        </div>
                    </div>

                    <x-filters.months :months="$_months" />
                    <x-filters.date-filter />


                    <div style="flex: 1;"></div>
                    <div>
                        <div style="display: flex; gap: 1em; justify-content: space-between; align-items: center; height: fit-content; width:  100%;">
                            <template x-if="!selection.length">
                                <button data-bs-toggle="modal" data-bs-target="#import-modal" class="bg-success btn mb-1 w-mob-100 py-2 mt-1" style="background: lightgreen; color: #fff;">Import</button>
                            </template>

                            <template x-if="!selection.length">
                                <button type="button" class="btn mb-1 py-2 mt-1" style="background: lightcoral; color: #000;" @click.prevent="$wire.importExcelExport()">
                                    Export Excel (import) </button>
                            </template>

                            <template x-if="!selection.length">
                                <button type="button" class="btn mb-1 py-2 mt-1" style="background: #3682cd; color: #fcf8f8;" @click.prevent="$wire.export()">
                                    Export Excel </button>
                            </template>

                            <template x-if="selection.length">
                                <button type="button" class="btn btn-danger mb-1 py-2 mt-1 text-dark" @click.prevent="() => {
                                    confirmAction(() => { 
                                        loading = true
                                        $wire.moveToUnallocated(Array.from(new Set(selection)), checkedAll)
                                        loading = false
                                    }, 'Are you sure you want to move these items to unallocated?');
                                }">
                                    Move to Unallocated</button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-app.commercial-head.tracker.card-recon.import-modal :message="$message" id="import-modal" />

        <div class="d-flex justify-content-center mt-4" style="flex-direction: column;">

            <div class="d-flex justify-content-center flex-column flex-md-row gap-md-4 align-items-center">
                <p class="mainheadtext">Total Record: <span class="blackh">{{ isset($_totals[0]->TotalCount) ?
                        $_totals[0]->TotalCount : 0 }}</span></p>
                <p class="mainheadtext">Matched: <span class="tealh">{{ isset($_totals[0]->MatchedCount) ?
                        $_totals[0]->MatchedCount : 0 }}</span></p>
                <p class="mainheadtext">Not Matched: <span class="lightcoralh">{{ isset($_totals[0]->NotMatchedCount) ?
                        $_totals[0]->NotMatchedCount : 0 }}</span></p>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-center gap-4 align-items-center mb-4">

                <div class="flex-main padding-top10">
                    <p class="mainheadtext ">Tender Sales: </p>
                    <span class="blackh">{{ isset($_totals[0]->sales_total) ?
                        $_totals[0]->sales_total : 0 }}</span>
                </div>

                <div class="flex-main padding-top10">
                    <p class="mainheadtext">Deposit: </p>
                    <span class="tealh">{{ isset($_totals[0]->collection_total) ?
                        $_totals[0]->collection_total : 0 }}</span>
                </div>

                <div class="flex-main padding-top10">
                    <p class="mainheadtext">Store Response Entry: </p>
                    <span class="bluetext">{{ isset($_totals[0]->adjustment_total) ?
                        $_totals[0]->adjustment_total : 0 }}</span>
                </div>

                <div class="flex-main padding-top10">
                    <p class="mainheadtext">Difference[Sales - Deposit - Store Response]: </p>
                    <span class="lightcoralh">{{ isset($_totals[0]->difference_total) ?
                        $_totals[0]->difference_total : 0 }}</span>
                </div>

            </div>
        </div>

        <div class="col-lg-12" id="dataset">

            <x-scrollable.scrollable :dataset="$cashRecons">
                <x-scrollable.scroll-head>
                    <tr>
                        <th>
                            <x-selection.check-all :selectionHas="$selectionHas" />
                        </th>
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Sales Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                            </div>
                        </th>
                        <th class="left">Deposit Date</th>
                        <th class="left">Store ID</th>
                        <th class="left">Retek Code</th>
                        <th class="left">Brand</th>
                        <th class="left">ColBank</th>
                        <th class="left">Status</th>

                        <th class="right">Card Sales</th>
                        <th class="right">Deposit Amount</th>
                        <th class="right">Store Response Entry</th>
                        <th class="right">Difference <br>[Sales - Deposit - Store Response]</th>
                        <th class="right">Submit Recon</th>
                    </tr>
                </x-scrollable.scroll-head>

                <x-scrollable.scroll-body>
                    @foreach ($cashRecons as $data)
                    <tr wire:key="d9e6c70f62967cd2e6202fa540c58cfabb10d4388467c35144e976d6cf3306f3_{{ rand() }}">
                        <td class="left" scope="row" wire:key="fef19a476993669aa0730d30c7e549b204838979f0a4fd9202117d4d9f9e6cef_{{ rand() }}">
                            <input class="form-check-input" type="checkbox" value="{{ $data->cardSalesRecoUID }}" x-model="selection" />
                        </td>
                        <td class="left"> {{ $data->transactionDate }} </td>
                        <td class="left"> {{ $data->depositDt }} </td>
                        <td class="left"> {{ $data->storeID }} </td>
                        <td class="left"> {{ $data->retekCode }} </td>
                        <td class="left"> {{ $data->brand }} </td>
                        <td class="left"> {{ $data->collectionBank }} </td>
                        <td class="left"> @if( $data->status == "Not Matched") <span class="redtext">{{ $data->status
                                }}</span> @else <span class="greentext">{{ $data->status }}</span> @endif </td>


                        <td class="right"> @if( $data->status == "Not Matched") <span class="redtext">{{ $data->cardSale
                                }}</span> @else {{ $data->cardSale
                            }} @endif </td>

                        <td class="right"> @if( $data->status == "Not Matched") <span class="redtext">{{
                                $data->depositAmount }}</span> @else {{
                            $data->depositAmount }} @endif </td>

                        <td class="right">{{ $data->adjAmount }}</td>
                        <td class="right"> @if( $data->status == "Not Matched") <span class="redtext">{{
                                $data->diffSaleDeposit }}</span> @else {{
                            $data->diffSaleDeposit }} @endif </td>


                        @if($data->isUpdated == 0)
                        <td class="text-center" wire:key="0eecf827c42c9bc78e57344d511cb4b7877afae2b3db4d585a2684f341f91f73_{{ $data->cardSalesRecoUID }}">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#sdkcskskdsfkxnskdldkzsdsdlksddlskoijfdskvm_{{ $data->cardSalesRecoUID }}"><i class="fa-solid fa-eye"></i></a>
                        </td>

                        @else
                        <td class="text-center">
                            <a href="#" data-bs-toggle="modal" style="color: gray"><i class="fa-solid fa-eye"></i></a>
                        </td>
                        @endif
                    </tr>

                    <div wire:key="50fd216281008abd0823129b21bf71e1b4560c3540a578ef600413c4e02af58d_{{  $data->cardSalesRecoUID }}">
                        <x-app.commercial-head.tracker.card-recon.update :data="$data" :message="$message" :stores="$storeIDs" />
                    </div>

                    @endforeach
                </x-scrollable.scroll-body>
            </x-scrollable.scrollable>

        </div>

    </x-selection.checkboxes>
    {{-- filter scripts --}}
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
