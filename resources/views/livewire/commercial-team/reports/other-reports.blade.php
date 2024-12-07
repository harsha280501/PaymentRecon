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

    <div class="row mb-2">
        <div class="col-lg-12">
            <ul class="nav nav-tabs justify-content-start" role="tablist">
                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('mpos-sap')
                        reset()
                    }" class="nav-link @if($activeTab === 'mpos-sap') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#hdfc" style="font-size: .9em !important" href="#" role="tab">SAP Sales vs MPOS Sales
                    </a>
                </li>

                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('zero-sales')
                        reset()
                    }" class="nav-link @if($activeTab === 'zero-sales') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                        Zero Sale Store
                    </a>
                </li>

                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('chargeback-summary')
                        reset()
                    }" class="nav-link @if($activeTab === 'chargeback-summary') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                        Chargeback Summary
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-lg-3 d-flex align-items-center justify-content-end">
            <div class="btn-group mb-1">
            </div>
        </div>
    </div>


    <div class="row mt-3">
        @if($activeTab == 'overall-summary')
        <x-app.commercial-head.reports.other-reports.overall-filter :filtering="$filtering" :stores="$stores" :months="$_months" />
        @else
        <x-app.commercial-head.reports.other-reports.filters :filtering="$filtering" :stores="$stores" :months="$_months" :tab="$activeTab" />
        @endif
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


    <x-app.commercial-head.reports.other-reports.table-headers :orderBy="$orderBy" :dataset="$datas" :activeTab="$activeTab" :startdate="$startdate" :enddate="$enddate">
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
        @if($activeTab == 'bank-drop-missing')
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr>
                <td class="left" style="background: rgba(0, 0, 0, 0.034)">{{ !$data->Date ? '' : Carbon\Carbon::parse($data->Date)->format('d-m-Y') }}</td>
                <td class="left">{{ $data->storeID }}</td>
                <td class="left">{{ $data->retekCode }}</td>
                <td class="left">{{ $data->storeName }}</td>
                <td class="left">{{ $data->brand }}</td>
                <td class="left">{{ $data->bankDropID }}</td>
                <td class="left">{{ $data->tenderDescription }}</td>
                <td class="right">{{ $data->BANKDROPAMOUNTF }}</td>
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
                <td class="left" style="background: rgba(0, 0, 0, 0.034)">{{
                    (($startdate != null && $enddate != null) && ($startdate == $enddate)) 
                        ? Carbon\Carbon::parse($startdate)->format('d-m-Y')
                        : $data->month 
                }}</td>

                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->OP_CASH }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->OP_CARD }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->OP_UPI }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->OP_WALLET }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->SALES_CASH }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->SALES_CARD }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->SALES_UPI }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->SALES_WALLET }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->COLL_CASH }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->COLL_CARD }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->COLL_UPI }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->COLL_WALLET }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->CL_CASH }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->CL_CARD }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->CL_UPI }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->CL_WALLET }}</td>
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

    </x-app.commercial-head.reports.other-reports.table-headers>
</div>
