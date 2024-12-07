<div x-data="{
    start: null,
    end: null,
    reset(){
        this.start = null
        this.end = null
    }
}">
    <div class="row mt-2">
        <div class="col-lg-12">
            <div>
                <div class="d-flex d-flex-mob gap-2 flex-wrap">
                    {{-- Back button --}}
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
                    <x-filters.simple-export />
                </div>
            </div>
        </div>
    </div>


    <div class="d-flex justify-content-center mt-4" style="flex-direction: column;">

        <div class="d-flex justify-content-center flex-column flex-md-row gap-md-4 align-items-center">
            <p class="mainheadtext">Total Record: <span class="blackh">{{
                    isset($_totals[0]->TotalCount) ? $_totals[0]->TotalCount : 0 }}</span></p>
            <p class="mainheadtext">Matched: <span class="tealh">{{
                    isset($_totals[0]->MatchedCount) ?
                    $_totals[0]->MatchedCount : 0 }}</span></p>
            <p class="mainheadtext">Not Matched: <span class="lightcoralh">{{
                    isset($_totals[0]->NotMatchedCount) ?
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
                <p class="mainheadtext">Difference [Tender - Deposit- Store Response]: </p>
                <span class="lightcoralh">{{ isset($_totals[0]->difference_total) ?
                    $_totals[0]->difference_total : 0 }}</span>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        {{-- Main sales table --}}
        <x-scrollable.scrollable :dataset="$cashRecons">
            <x-scrollable.scroll-head>
                <tr>
                    <th>
                        <div class="d-flex align-items-center gap-2">
                            <span>{{ config('constants.StoreVariables.SalesDate') }}</span>
                            <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                        </div>
                    </th>

                    <th class="left">Deposit Date</th>
                    <th class="left">Store ID</th>
                    <th class="left">Retek Code</th>
                    <th class="left">Brand</th>
                    <th class="left">ColBank</th>

                    <th class="left">Status</th>

                    <th class="right">Wallet Sale</th>
                    <th class="right">Deposit Amount</th>
                    <th class="right">Store Response Entry</th>
                    <th class="right">Difference <br>[Sale - Deposit - Store Response]</th>
                    <th class="right">Submit Recon <br></th>
                 
                </tr>

            </x-scrollable.scroll-head>

            <x-scrollable.scroll-body>
                @foreach ($cashRecons as $data)

                <tr>
                    <td class="left">{{ $data->transactionDate }}</td>
                    <td class="left">{{ $data->depositDt }}</td>
                    <td class="left">{{ $data->storeID }}</td>
                    <td class="left">{{ $data->retekCode }}</td>
                    <td class="left">{{ $data->brand }}</td>
                    <td class="left">{{ $data->collectionBank }}</td>

                    <td class="left"> @if( $data->status == "Not Matched") <span class="redtext">{{ $data->status
                            }}</span> @else <span class="greentext">{{ $data->status }}</span>
                        @endif </td>

                    <td class="right"> @if( $data->status == "Not Matched") <span class="redtext">{{ $data->walletSale }}</span> @else {{
                        $data->walletSale }} @endif </td>

                    <td class="right"> @if( $data->status == "Not Matched") <span class="redtext">{{ $data->depositAmount }}</span> @else {{
                        $data->depositAmount }} @endif </td>

                    <td class="right">{{ $data->adjAmount }}</td>
                    <td class="right"> @if( $data->status == "Not Matched") <span class="redtext">{{ $data->diffSaleDeposit }}</span> @else {{
                        $data->diffSaleDeposit }} @endif </td>

                <td class="text-center"
                wire:key="0eecf827c42c9bc78e57344d511cb4b7877afae2b3db4d585a2684f341f91f73_{{ $data->walletSalesRecoUID }}">
                <a href="#" data-bs-toggle="modal"
                    data-bs-target="#sdkcskskdsfkxnskdldkzsdsdlksddlskoijfdskvm_{{ $data->walletSalesRecoUID }}"><i
                        class="fa-solid fa-eye"></i></a>
                </td>
                </tr>
                <div
                wire:key="50fd216281008abd0823129b21bf71e1b4560c3540a578ef600413c4e02af58d_{{  $data->walletSalesRecoUID }}">
                <x-app.commercial-head.tracker.wallet-recon.update :data="$data" :message="$message" />
            </div>
                @endforeach
            </x-scrollable.scroll-body>
        </x-scrollable.scrollable>

    </div>

    {{-- filter scripts --}}
    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {

            $j('#select2-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('status', e.target.value);
            });
        });

    </script>

</div>
