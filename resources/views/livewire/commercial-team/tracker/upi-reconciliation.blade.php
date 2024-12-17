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
            {{-- filter for the first tab --}}
            <div class="d-flex d-flex-mob" style="gap: .5em; flex-wrap: wrap; ">

                <div style="display:@if ($filtering) unset @else none @endif" class="">
                    <button @click="() => {
                        $wire.back()
                        reset()
                    }" style="background: transparent; outline: none; border: none; padding: .5em 1em; font-size: 1em">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                </div>

                <x-filters.brand_location_store />

                <div class="">
                    <div wire:ignore>
                        <select id="select2-dropdown" wire:model="matchStatus" style="width: 220px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">
                            <option selected value="" class="dropdown-item">SELECT MATCHED STATUS</option>
                            <option value="  " class="dropdown-item">ALL</option>
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
                <p class="mainheadtext">Difference[Tender - Deposit - Store Response]: </p>
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
                    <th class="left" style="text-align: right !important">UPI Sales</th>
                    <th class="left" style="text-align: right !important">Deposit Amount</th>
                    <th class="left" style="text-align: right !important">Store Response Entry</th>
                    <th class="left" style="text-align: right !important">Difference [Sale - Deposit]</th>
                    <th class="right">Pending Difference</th>
                    <th class="right">Reconcilied Difference</th>
                </tr>
            </x-scrollable.scroll-head>

            <x-scrollable.scroll-body>
                @foreach ($cashRecons as $data)
                <tr>
                    <td class="left"> {{ $data->transactionDate }} </td>
                    <td class="left"> {{ $data->depositDt }} </td>
                    <td class="left"> {{ $data->storeID }} </td>
                    <td class="left"> {{ $data->retekCode }} </td>
                    <td class="left"> {{ $data->brand }} </td>
                    <td class="left"> {{ $data->collectionBank }} </td>
                    <td class="left"> @if( $data->status == "Not Matched") <span class="redtext">{{ $data->status }}</span> @else <span class="greentext">{{ $data->status }}</span> @endif </td>

                    <td class="right"> @if( $data->status == "Not Matched") <span class="redtext">{{ $data->cardSale }}</span> @else {{ $data->cardSale
                        }} @endif </td>

                    <td class="right"> @if( $data->status == "Not Matched") <span class="redtext">{{ $data->depositAmount }}</span> @else {{
                        $data->depositAmount }} @endif </td>

                    <td class="right">{{ $data->adjAmount }}</td>
                    <td class="right"> @if( $data->status == "Not Matched") <span class="redtext">{{ $data->diffSaleDeposit }}</span> @else {{
                        $data->diffSaleDeposit }} @endif </td>

                    <td class="right">{{ $data->calculatedDifference }}</td>
                    <td class="right">{{ $data->summed_adjustment }}</td>

                </tr>
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
