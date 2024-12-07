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
                <div class="d-flex d-flex-mob d-flex-tab gap-2" style="@if($activeTab !== 'card') display: none !important @endif">

                    <div style="display:@if ($filtering) unset @else none @endif" class="">
                        <button @click="() => {
                        $wire.back()
                        reset()
                    }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
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
            {{-- Total Count --}}
            <div style="display: flex; flex-wrap: wrap; gap: .5em">
                <p style="font-size: 1.01em; color: #000; margin: 0">Total Sales: </p>
                <span style="color: black; font-weight: 900;"> {{ isset($dataset[0]->SalesSF) ?
                    $dataset[0]->SalesSF : 0 }}</span>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: .5em">
                <p style="font-size: 1.01em; color: #000; margin: 0">Total Collection: </p>
                <span style="color: teal; font-weight: 900;"> {{ isset($dataset[0]->CollectionSF) ?
                    $dataset[0]->CollectionSF : 0 }}</span>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: .5em">
                <p style="font-size: 1.01em; color: #000; margin: 0">Total Difference: </p>
                <span style="color: lightcoral; font-weight: 900;"> {{ isset($dataset[0]->DifferenceSF) ?
                    $dataset[0]->DifferenceSF : 0 }}</span>
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
                    <th colspan="6">Sales</th>
                    <th colspan="6" style="background: rgb(230, 230, 230)">Collection</th>
                    <th colspan="2">Difference</th>
                    <th style="background: rgb(230, 230, 230)"></th>
                </tr>
                <tr>
                    <th style="background: rgb(230, 230, 230)" class="left">
                        <div class="d-flex align-items-center gap-2">
                            <span>{{ config('constants.StoreVariables.SalesDate') }}</span>
                            <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                        </div>
                    </th>

                    <th style="background: rgb(230, 230, 230)">Deposit Date</th>
                    <th style="text-align: right !important">HDFC</th>
                    <th style="text-align: right !important">ICICI</th>
                    <th style="text-align: right !important">SBI</th>
                    <th style="text-align: right !important">AMEX</th>
                    <th style="text-align: right !important">HDFC UPI</th>
                    <th style="text-align: right !important">Total Sales</th>

                    <th style="background: rgb(230, 230, 230); text-align: right !important">HDFC</th>
                    <th style="background: rgb(230, 230, 230); text-align: right !important">ICICI</th>
                    <th style="background: rgb(230, 230, 230); text-align: right !important">SBI</th>
                    <th style="background: rgb(230, 230, 230); text-align: right !important">AMEX</th>
                    <th style="background: rgb(230, 230, 230); text-align: right !important">HDFC UPI</th>
                    <th style="background: rgb(230, 230, 230); text-align: right !important">Total Collection</th>

                    <th>Status</th>
                    <th style="text-align: right !important">Difference</th>
                    <th class="text-center" style="background: rgb(230, 230, 230)">Submit Recon</th>
                </tr>

            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>

                @foreach ($dataset as $data)
                <tr>
                    <td style="background: rgba(230, 230, 230, 0.37)">{{
                        !$data->saleDate ? '' : Carbon\Carbon::parse($data->saleDate)->format('d-m-Y') }}</td>
                    <td style="background: rgba(230, 230, 230, 0.37)">{{
                        !$data->depositDt ? '' :  Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                    <td style="text-align: right !important">{{ $data->SALES_HDFC }}</td>
                    <td style="text-align: right !important">{{ $data->SALES_ICICI }}</td>
                    <td style="text-align: right !important">{{ $data->SALES_SBI }}</td>
                    <td style="text-align: right !important">{{ $data->SALES_AMEX }}</td>
                    <td style="text-align: right !important">{{ $data->SALES_UPIH }}</td>
                    <td style="text-align: right !important">{{ $data->TotalSales }}</td>
                    <td style="background: rgba(230, 230, 230, 0.37); text-align: right !important">{{ $data->COLL_HDFC
                        }}</td>
                    <td style="background: rgba(230, 230, 230, 0.37); text-align: right !important">{{ $data->COLL_ICICI
                        }}</td>
                    <td style="background: rgba(230, 230, 230, 0.37); text-align: right !important">{{ $data->COLL_SBI
                        }}</td>
                    <td style="background: rgba(230, 230, 230, 0.37); text-align: right !important">{{ $data->COLL_AMEX
                        }}</td>
                    <td style="background: rgba(230, 230, 230, 0.37); text-align: right !important">{{ $data->COLL_UPIH
                        }}</td>
                    <td style="background: rgba(230, 230, 230, 0.37); text-align: right !important">{{
                        $data->TotalCollection }}</td>
                    <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>
                    <td style="text-align: right !important">{{ $data->Difference }}</td>
                    <td class="text-center" data-bs-target="#Main_{{ $data->DateID }}" data-bs-toggle="modal"><a href="#"><i class="fa-solid fa-eye"></i></a></td>
                </tr>

                {{-- modal --}}
                <x-app.store-user.process.all-card-recon.modal :data="$data" :remarks="$remarks" />
                @endforeach

            </x-scrollable.scroll-body>
        </x-scrollable.scrollable>
    </div>
</div>
