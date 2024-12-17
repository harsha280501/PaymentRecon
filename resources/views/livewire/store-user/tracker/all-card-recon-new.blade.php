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
                <div class="d-flex d-flex-mob d-flex-tab gap-2 flex-wrap" style="@if($activeTab !== 'card') display: none !important @endif">

                    <div style="display:@if ($filtering) unset @else none @endif" class="">
                        <button @click="() => {
                        $wire.back()
                        reset()
                    }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                    </div>


                    <div class="">
                        <div wire:ignore>
                            <select id="select100-dropdown" style="width: 220px;" class="custom-select select2 form-control searchField w-mob-100 mb-1" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">
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
    </div>

    <div class="d-flex justify-content-center mt-3" style="flex-direction: column;">

        <div class="d-flex justify-content-center gap-2 gap-md-4 align-items-center mb-4 flex-column flex-md-row">
            <div style="display: flex; flex-wrap: wrap; gap: .5em">
                <p style="font-size: 1.01em; color: #000; margin: 0">Tender Sales: </p>
                <span style="color: black; font-weight: 900;"> {{ isset($_totals[0]->sales_total) ?
                    $_totals[0]->sales_total : 0 }}</span>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: .5em">
                <p style="font-size: 1.01em; color: #000; margin: 0">Deposit: </p>
                <span style="color: teal; font-weight: 900;"> {{ isset($_totals[0]->collection_total) ?
                    $_totals[0]->collection_total : 0 }}</span>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: .5em">
                <p style="font-size: 1.01em; color: #000; margin: 0">Store Response Entry: </p>
                <span class="bluetext"> {{ isset($_totals[0]->adjustment_total) ?
                    $_totals[0]->adjustment_total : 0 }}</span>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: .5em">
                <p style="font-size: 1.01em; color: #000; margin: 0">Difference [Sales - Deposit - Store Response]: </p>
                <span style="color: lightcoral; font-weight: 900;"> {{ isset($_totals[0]->difference_total) ?
                    $_totals[0]->difference_total : 0 }}</span>
            </div>
        </div>
    </div>



    <div class="col-lg-12">
        {{-- Main sales table --}}
        <x-scrollable.scrollable :dataset="$dataset">
            <x-scrollable.scroll-head>
                <tr>
                    <th style="background: rgb(230, 230, 230)"></th>
                    <th style="background: rgb(230, 230, 230)"></th>
                    <th colspan="5">Sales</th>
                    <th colspan="5" style="background: rgb(230, 230, 230)">Collection</th>
                    <th colspan="5">Store Response Entry</th>
                    <th colspan="6" style="background: rgb(230, 230, 230)">Difference</th>
                </tr>
                <tr>
                    <th style="background: rgb(230, 230, 230)" class="left">
                        <div class="d-flex align-items-center gap-2">
                            <span>{{ config('constants.StoreVariables.SalesDate') }}</span>
                            <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                        </div>
                    </th>

                    <th style="background: rgb(230, 230, 230)">Deposit Date</th>
                    <th style="text-align: right !important">Card Sales</th>
                    <th style="text-align: right !important">UPI Sales</th>
                    <th style="text-align: right !important">Wallet Sales</th>
                    <th style="text-align: right !important">Cash Sales</th>
                    <th style="text-align: right !important">Total Sales</th>

                    <th style="background: rgb(230, 230, 230); text-align: right !important">Card Collection</th>
                    <th style="background: rgb(230, 230, 230); text-align: right !important">UPI Collection</th>
                    <th style="background: rgb(230, 230, 230); text-align: right !important">Wallet Collection</th>
                    <th style="background: rgb(230, 230, 230); text-align: right !important">Cash Collection</th>
                    <th style="background: rgb(230, 230, 230); text-align: right !important">Total Collection</th>

                    <th>Card Store Response</th>
                    <th>UPI Store Response</th>
                    <th>Wallet Store Response</th>
                    <th>Cash Store Response</th>
                    <th>Total Store Response</th>

                    <th style="background: rgb(230, 230, 230); text-align: right !important">Card Difference</th>
                    <th style="background: rgb(230, 230, 230); text-align: right !important">UPI Difference</th>
                    <th style="background: rgb(230, 230, 230); text-align: right !important">Wallet Difference</th>
                    <th style="background: rgb(230, 230, 230); text-align: right !important">Cash Difference</th>
                    <th style="background: rgb(230, 230, 230); text-align: right !important">Total Difference</th>
                    <th style="background: rgb(230, 230, 230)">Status</th>
                </tr>

            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>

                @foreach ($dataset as $data)
                <tr>
                    <td style="background: rgba(230, 230, 230, 0.37)">{{
                        Carbon\Carbon::parse($data->saleDate)->format('d-m-Y') }}</td>
                    <td style="background: rgba(230, 230, 230, 0.37)"><?php if($data->depositDt!=''){?>{{
                        Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }} <?php }?></td>
                    <td style="text-align: right !important">{{ $data->TotalCardSales }}</td>
                    <td style="text-align: right !important">{{ $data->TotalUPISales }}</td>
                    <td style="text-align: right !important">{{ $data->TotalWalletSales }}</td>
                    <td style="text-align: right !important">{{ $data->TotalCashSales }}</td>
                    <td style="text-align: right !important">{{ $data->TotalSales }}</td>

                    <td style="background: rgba(230, 230, 230, 0.37); text-align: right !important">{{
                        $data->TotalCardCollection }}</td>
                    <td style="background: rgba(230, 230, 230, 0.37); text-align: right !important">{{
                        $data->TotalUPICollection }}</td>
                    <td style="background: rgba(230, 230, 230, 0.37); text-align: right !important">{{
                        $data->TotalWalletCollection }}</td>
                    <td style="background: rgba(230, 230, 230, 0.37); text-align: right !important">{{
                        $data->TotalCashCollection }}</td>
                    <td style="background: rgba(230, 230, 230, 0.37); text-align: right !important">{{
                        $data->TotalCollection }}</td>


                    <td style="text-align: right !important">{{ $data->CardAdjustment }}</td>
                    <td style="text-align: right !important">{{ $data->UPIAdjustment }}</td>
                    <td style="text-align: right !important">{{ $data->WalletAdjustment }}</td>
                    <td style="text-align: right !important">{{ $data->CashAdjustment }}</td>
                    <td style="text-align: right !important">{{ $data->TotalAdjustment }}</td>

                    <td style="background: rgba(230, 230, 230, 0.37); text-align: right !important">{{ $data->CardDifference }}</td>
                    <td style="background: rgba(230, 230, 230, 0.37); text-align: right !important">{{ $data->UPIDifference }}</td>
                    <td style="background: rgba(230, 230, 230, 0.37); text-align: right !important">{{ $data->WalletDifference }}</td>
                    <td style="background: rgba(230, 230, 230, 0.37); text-align: right !important">{{ $data->CashDifference }}</td>
                    <td style="background: rgba(230, 230, 230, 0.37); text-align: right !important">{{ $data->Difference }}</td>
                    <td class="right" style="background: rgba(230, 230, 230, 0.37);"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>
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

            $j('#select100-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('status', e.target.value);
            });
        });

    </script>


</div>
