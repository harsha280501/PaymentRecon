<div x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    },
    resetOne() {
        this.start = null
    }
}">

    <style>
        #table-collection tbody td {
            text-align: end;
            padding: 8px;
        }

        #table-collection tbody tr th {
            padding: 8px;
            /* Adjust the padding value as needed */
        }

        #table-collection tr.empty-row th,
        tr.empty-row td {
            border: none;
            height: 20px;
            /* Adjust the height value as needed */
        }

    </style>
    <div class="row mb-2">
        <div class="col-lg-12">
            <ul class="nav nav-tabs justify-content-start" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if($activeTab === 'mpos-sap') active tab-active @endif" style="font-size: .9em !important" href="{{ url('/') }}/chead/reports/others?t=mpos-sap" role="tab">SAP Sales vs MPOS Sales
                    </a>
                </li>

                <li class="nav-item" style="display: none;">
                    <a class="nav-link @if($activeTab === 'bank-drop-missing') active tab-active @endif" style="font-size: .9em !important" href="{{ url('/') }}/chead/reports/others?t=bank-drop-missing">
                        Bankdrop Missing
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link @if($activeTab === 'zero-sales') active tab-active @endif" style="font-size: .9em !important" href="{{ url('/') }}/chead/reports/others?t=zero-sales">
                        Zero Sale Store
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a class="nav-link @if($activeTab === 'overall-summary') active tab-active @endif" style="font-size: .9em !important" href="{{ url('/') }}/chead/reports/others?t=overall-summary">
                        Outstanding Summary
                    </a>
                </li> --}}

                {{-- <li class="nav-item">
                    <a class="nav-link @if($activeTab === 'chargeback-summary') active tab-active @endif" style="font-size: .9em !important" href="{{ url('/') }}/chead/reports/others?t=chargeback-summary">
                        Chargeback Summary
                    </a>
                </li> --}}


                {{-- <li class="nav-item">
                    <a class="nav-link @if($activeTab === 'date-wise-collection') active tab-active @endif" style="font-size: .9em !important" href="{{ url('/') }}/chead/reports/others?t=date-wise-collection">
                        Datewise Collection
                    </a>
                </li> --}}

                {{-- <!-- <li class="nav-item">
                    <a class="nav-link @if($activeTab === 'collection-difference') active tab-active @endif" style="font-size: .9em !important" href="{{ url('/') }}/chead/reports/others?t=collection-difference">
                        Collection Difference
                    </a>
                </li> --> --}}

                {{-- <li class="nav-item">
                    <a class="nav-link @if($activeTab === 'uploaded-report') active tab-active @endif" style="font-size: .9em !important" href="{{ url('/') }}/chead/reports/others?t=uploaded-report">
                        Uploaded Report
                    </a>
                </li> --}}
            </ul>
        </div>
        <div class="col-lg-3 d-flex align-items-center justify-content-end">
            <div class="btn-group mb-1">
            </div>
        </div>
    </div>


    <div class="row mt-3">
        <x-app.commercial-head.reports.other-reports.overall-filter :filtering="$filtering" :stores="$stores" :months="$_months" :tab="$activeTab" />
        <x-app.commercial-head.reports.other-reports.filters :uploadBanks="$uploadBanks" :filtering="$filtering" :stores="$stores" :months="$_months" :tab="$activeTab" />
    </div>


    @if($activeTab == 'mpos-sap')

    <div class="d-flex justify-content-center align-items-center mt-2" style="flex-direction: column;">
        <div class="d-flex justify-content-center flex-md-row flex-column gap-md-4 align-items-center mb-4">
            <div style="display: flex; flex-wrap: wrap; gap: .5em">
                <p class="mainheadtext">MPOS Sales: </p>
                <span class="blackh">{{ isset($datas[0]) ? $datas[0]->MPOSCashFT : 0 }}</span>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: .5em">
                <p class="mainheadtext">SAP Sales: </p>
                <span class="tealh">{{ isset($datas[0]) ? $datas[0]->SAPCashFT : 0 }}</span>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: .5em">
                <p class="mainheadtext">Total Difference: </p>
                <span class="lightcoralh">{{ isset($datas[0]) ? $datas[0]->differenceFT : 0 }}</span>
            </div>
        </div>
    </div>

    @elseif ($activeTab == 'bank-drop-missing')
    <div class="d-flex justify-content-center align-items-center mt-2" style="flex-direction: column;">
        <div class="d-flex justify-content-center flex-md-row flex-column gap-md-4 align-items-center mb-4">

            <div style="display: flex; flex-wrap: wrap; gap: .5em">
                <p class="mainheadtext">Total Transaction: </p>
                <span style="color: black; font-weight: 900;">{{ isset($datas[0]) ? $datas[0]->TotalTransactions : 0 }}</span>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: .5em">
                <p class="mainheadtext">Total BankDrop: </p>
                <span style="color: teal; font-weight: 900;">{{ isset($datas[0]) ? $datas[0]->TotalBankDrop : 0 }}</span>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: .5em">
                <p style="font-size: 1.01em; color: #000; margin: 0">Total Missing BankDrop: </p>
                <span class="lightcoralh">{{ isset($datas[0]) ? $datas[0]->BankDropMissing : 0 }}</span>
            </div>
        </div>
    </div>

    @endif



    @if($activeTab == 'overall-summary')
    <div style="display: block;text-align: center;">
        <p style="font-size: 1.2em; color: #000; font-weight: 700;">Balance as on
            <span style="color: green;">
                {{ !$startdate ? now()->format('d-m-Y') : Carbon\Carbon::parse($startdate)->format('d-m-Y') }}
            </span>
        </p>
    </div>
    @endif


    @if($activeTab == 'collection-difference')

    <h4 style="color: #000; margin-bottom: 2em">Collection from {{ (!$startdate) ? '01-04-2024' :  Carbon\Carbon::parse($startdate)->format('d-m-Y') }} to {{ (!$enddate) ? \App\Models\Config::reconciliedDate() :  Carbon\Carbon::parse($enddate)->format('d-m-Y') }} </h4>

    <div class="row">
        {{-- @foreach ($datas as $data) --}}
        <x-app.commercial-head.reports.other-reports.collection-difference :data="$datas"/>
        {{-- @endforeach --}}
    </div>

    <x-spinner />
    @else



    <x-app.commercial-head.reports.other-reports.table-headers :orderBy="$orderBy" :dataset="$datas" :activeTab="$activeTab" :startdate="$startdate" :enddate="$enddate" :tender="$tender">
        @if($activeTab == 'mpos-sap')
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr>
                <td class="left" style="background: rgba(0, 0, 0, 0.034)">{{ !$data->Date ? '' : Carbon\Carbon::parse($data->Date)->format('d-m-Y') }}</td>
                <td class="left">{{ $data->storeID }}</td>
                <td class="left">{{ $data->retekCode }}</td>
                <td class="left">{{ $data->{'Brand Desc'} }}</td>
                <td style="font-weight: 700; color: @if($data->status == 'Matched') green @else red @endif">{{ $data->status }}</td>
                <td class="right">{{ $data->SAPCashF }}</td>
                <td class="right">{{ $data->MPOSCashF }}</td>
                <td class="right">{{ $data->differenceF }}</td>
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
        @endif

        @if($activeTab == 'zero-sales')
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr>
                <td class="left" style="background: rgba(0, 0, 0, 0.034)">{{ !$data->Date ? '' : Carbon\Carbon::parse($data->Date)->format('d-m-Y') }}</td>
                <td class="left">{{ $data->storeID }}</td>
                <td class="left">{{ $data->retekCode }}</td>
                <td class="left">{{ $data->brand }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->Store }}</td>
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
        @endif


        @if($activeTab == 'overall-summary')
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr>
                <td class="left">{{ $data->storeID }}</td>
                <td class="left">{{ $data->retekCode }}</td>
                <td class="left">{{ $data->brand }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->OP_TOTAL }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->SALES_TOTAL }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->COLL_TOTAL }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->adjustmentTotal }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->CL_TOTAL }}</td>
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
        @endif


        @if($activeTab == 'chargeback-summary')
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr>
                <td class="left">{{ !$data->depositDate ? '' :  Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}</td>
                <td class="left">{{ !$data->creditDate ? '' :  Carbon\Carbon::parse($data->creditDate)->format('d-m-Y') }}</td>
                <td class="left">{{ $data->storeID }}</td>
                <td class="left">{{ $data->newRetekCode }}</td>
                <td class="left">{{ $data->brandName }}</td>
                <td class="left">{{ $data->decoded_description }}</td>
                <td class="left">{{ $data->accountNo }}</td>
                <td class="left">{{ $data->description }}</td>
                <td class="left">{{ $data->transactionBr }}</td>
                <td class="right">{{ $data->credit }}</td>
                <td class="right">{{ $data->debit }}</td>
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
        @endif


        @if($activeTab == 'date-wise-collection')
        <x-scrollable.scroll-body>

            @if($tender == 'all')

            @foreach ($datas as $data)
            <tr>
                <td class="left">{{ !$data->depositDt ? '' :  Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                <td class="right">{{ $data->cash_hdfc }}</td>
                <td class="right">{{ $data->cash_icici }}</td>
                <td class="right">{{ $data->cash_sbi }}</td>
                <td class="right">{{ $data->cash_axis }}</td>
                <td class="right">{{ $data->cash_idfc }}</td>
                <td class="right">{{ $data->card_hdfc }}</td>
                <td class="right">{{ $data->card_icici }}</td>
                <td class="right">{{ $data->card_sbi }}</td>
                <td class="right">{{ $data->card_amex }}</td>
                <td class="right">{{ $data->upi_hdfc }}</td>
                <td class="right">{{ $data->wallet_paytm }}</td>
                <td class="right">{{ $data->wallet_phonepay }}</td>
                <td class="right">{{ $data->total }}</td>
            </tr>
            @endforeach
            @elseif($tender == 'cash')

            @foreach ($datas as $data)
            <tr>
                <td class="left">{{ !$data->depositDt ? '' :  Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                <td class="right">{{ $data->cash_hdfc }}</td>
                <td class="right">{{ $data->cash_icici }}</td>
                <td class="right">{{ $data->cash_sbi }}</td>
                <td class="right">{{ $data->cash_axis }}</td>
                <td class="right">{{ $data->cash_idfc }}</td>
                <td class="right">{{ $data->total_cash }}</td>
            </tr>
            @endforeach
            @elseif($tender == 'card')

            @foreach ($datas as $data)
            <tr>
                <td class="left">{{ !$data->depositDt ? '' :  Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                <td class="right">{{ $data->card_hdfc }}</td>
                <td class="right">{{ $data->card_icici }}</td>
                <td class="right">{{ $data->card_sbi }}</td>
                <td class="right">{{ $data->card_amex }}</td>
                <td class="right">{{ $data->total_card }}</td>
            </tr>
            @endforeach
            @elseif($tender == 'upi')

            @foreach ($datas as $data)
            <tr>
                <td class="left">{{ !$data->depositDt ? '' :  Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                <td class="right">{{ $data->upi_hdfc }}</td>
                <td class="right">{{ $data->total_upi }}</td>
            </tr>
            @endforeach
            {{-- else then it should be wallet --}}
            @elseif($tender == 'wallet')

            @foreach ($datas as $data)
            <tr>
                <td class="left">{{ !$data->depositDt ? '' :  Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                <td class="right">{{ $data->wallet_phonepay }}</td>
                <td class="right">{{ $data->wallet_paytm }}</td>
                <td class="right">{{ $data->total_wallet }}</td>
            </tr>
            @endforeach
            @endif

        </x-scrollable.scroll-body>
        @endif

        @if($activeTab == 'uploaded-report')
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr>
                <td class="left">{{ !$data->uploadedDate ? '' :  Carbon\Carbon::parse($data->uploadedDate)->format('d-m-Y') }}</td>
                <td class="left">{{ $data->colBank }}</td>
                <td class="left">{{ $data->filename }}</td>
                <td class="right">{{ $data->fileCount }}</td>
                <td class="right">{{ $data->validCount }}</td>
                <td class="right">{{ $data->inValidCount }}</td>
                <td class="right">{{ $data->totalDeposit }}</td>
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
        @endif


    </x-app.commercial-head.reports.other-reports.table-headers>
    @endif


    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {
            $j('#matchFilterMPOS').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('status', e.target.value);
            });

            $j('#tenderSelectFilter').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('tender', e.target.value);
            });

            $j('#outstanding_storeFilter').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });
        });

    </script>
</div>
