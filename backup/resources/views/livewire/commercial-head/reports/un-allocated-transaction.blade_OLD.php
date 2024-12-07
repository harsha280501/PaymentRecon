<div x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    }
}" x-init="() => console.log('loaded ...')">

    <div class="row mb-2">
        <div class="col-lg-12">
            <ul class="nav nav-tabs justify-content-start" role="tablist">
                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('cash')
                        reset()
                    }" class="nav-link @if($activeTab === 'cash') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#hdfc" style="font-size: .9em !important" href="#" role="tab">Cash Transactions
                    </a>
                </li>

                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('card')
                        reset()
                    }" class="nav-link @if($activeTab === 'card') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                        Card Transactions
                    </a>
                </li>

                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('upi')
                        reset()
                    }" class="nav-link @if($activeTab === 'upi') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                        Upi Transactions
                    </a>
                </li>

                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('wallet')
                        reset()
                    }" class="nav-link @if($activeTab === 'wallet') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                        Wallet Transactions
                    </a>
                </li>
            </ul>
        </div>

        {{-- <div class="row mt-3">
            @if($activeTab == 'cash')
            <x-app.commercial-head.reports.unallocated.overall-filter :filtering="$filtering" :months="$_months" />
            @else
            <x-app.commercial-head.reports.unallocated.filters :filtering="$filtering" :months="$_months" :tab="$activeTab" :banks="$card_banks" />
            @endif
        </div> --}}

        <div class="row mt-3">
            <x-app.commercial-head.reports.unallocated.filters :filtering="$filtering" :months="$_months" :tab="$activeTab" />
        </div>

        <div class="d-flex justify-content-center mt-3" style="flex-direction: column;">
            <div class="d-flex flex-column flex-md-row justify-content-center gap-4 align-items-center mb-2" style="margin-top: -10px">
                {{-- Total Count --}}
                <div class="flex-main">
                    <p class="text-primary mainheadtext">Total Amount: </p>
                    <span style="color: black; font-weight: 900;">{{ isset($datas[0]->totalAmount) ?
                        $datas[0]->totalAmount : 0 }}</span>
                </div>
                @if($activeTab == 'cash')
                <div class="flex-main">
                    <p class="text-primary mainheadtext">HDFC: </p>
                    <span style="color: black; font-weight: 900;">{{ isset($datas[0]->HDFC) ?
                        $datas[0]->HDFC : 0 }}</span>
                </div>

                <div class="flex-main">
                    <p class="text-primary mainheadtext">AXIS: </p>
                    <span style="color: black; font-weight: 900;">{{ isset($datas[0]->AXIS) ?
                        $datas[0]->AXIS : 0 }}</span>
                </div>

                <div class="flex-main">
                    <p class="text-primary mainheadtext">ICICI: </p>
                    <span style="color: black; font-weight: 900;">{{ isset($datas[0]->ICICI) ?
                        $datas[0]->ICICI : 0 }}</span>
                </div>

                <div class="flex-main">
                    <p class="text-primary mainheadtext">IDFC: </p>
                    <span style="color: black; font-weight: 900;">{{ isset($datas[0]->IDFC) ?
                        $datas[0]->IDFC : 0 }}</span>
                </div>

                <div class="flex-main">
                    <p class="text-primary mainheadtext">SBI: </p>
                    <span style="color: black; font-weight: 900;">{{ isset($datas[0]->SBI) ?
                        $datas[0]->SBI : 0 }}</span>
                </div>

                @elseif($activeTab == 'card')

                <div class="flex-main">
                    <p class="text-primary mainheadtext">HDFC: </p>
                    <span style="color: black; font-weight: 900;">{{ isset($datas[0]->HDFC) ?
                        $datas[0]->HDFC : 0 }}</span>
                </div>

                <div class="flex-main">
                    <p class="text-primary mainheadtext">AMEX: </p>
                    <span style="color: black; font-weight: 900;">{{ isset($datas[0]->AMEX) ?
                        $datas[0]->AMEX : 0 }}</span>
                </div>

                <div class="flex-main">
                    <p class="text-primary mainheadtext">ICICI: </p>
                    <span style="color: black; font-weight: 900;">{{ isset($datas[0]->ICICI) ?
                        $datas[0]->ICICI : 0 }}</span>
                </div>

                <div class="flex-main">
                    <p class="text-primary mainheadtext">SBI: </p>
                    <span style="color: black; font-weight: 900;">{{ isset($datas[0]->SBI) ?
                        $datas[0]->SBI : 0 }}</span>
                </div>


                @elseif($activeTab == 'wallet')

                <div class="flex-main">
                    <p class="text-primary mainheadtext">PhonePe: </p>
                    <span style="color: black; font-weight: 900;">{{ isset($datas[0]->PhonePe) ?
                        $datas[0]->PhonePe : 0 }}</span>
                </div>

                <div class="flex-main">
                    <p class="text-primary mainheadtext">PayTM: </p>
                    <span style="color: black; font-weight: 900;">{{ isset($datas[0]->PayTM) ?
                        $datas[0]->PayTM : 0 }}</span>
                </div>

                @endif

            </div>
        </div>




        <x-app.commercial-head.reports.unallocated.table-headers :orderBy="$orderBy" :dataset="$datas" :activeTab="$activeTab" :startdate="$startDate" :enddate="$endDate">

            <x-scrollable.scroll-body>
                @if($activeTab == 'cash')
                @foreach ($datas as $data)
                <tr data-id="{{ $data->{'storeID'} }}">
                    <td class="left"> {{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }} </td>
                    <td class="left"> {{ $data->{'pkupPtCode'} }} </td>
                    <td class="left"> {{ $data->{'depSlipNo'} }} </td>
                    <td class="left"> {{ $data->{'colBank'} }} </td>
                    <td class="left"> {{ $data->{'locationShort'} }} </td>
                    <td class="right"> {{ $data->{'depositAmount'} }} </td>
                </tr>
                @endforeach
                @endif
                @if($activeTab == 'card')
                @foreach ($datas as $data)
                <tr data-id="{{ $data->{'storeID'} }}">
                    <td class="left"> {{ !$data->depositDate ? '' :  Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }} </td>
                    <td class="left"> {{ $data->{'pkupPtCode'} }} </td>
                    <td class="left"> {{ $data->{'colBank'} }} </td>
                    <td class="right"> {{ $data->{'depositAmount'} }} </td>
                </tr>
                @endforeach
                @endif

                @if($activeTab == 'upi')
                @foreach ($datas as $data)
                <tr data-id="{{ $data->{'storeID'} }}">
                    <td class="left"> {{ !$data->depositDate ? '' :  Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }} </td>
                    <td class="left"> {{ $data->{'pkupPtCode'} }} </td>
                    <td class="left"> {{ $data->{'colBank'} }} </td>
                    <td class="right"> {{ $data->{'depositAmount'} }} </td>
                </tr>
                @endforeach
                @endif

                @if($activeTab == 'wallet')
                @foreach ($datas as $data)
                <tr data-id="{{ $data->{'storeID'} }}">
                    <td class="left"> {{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }} </td>
                    <td class="left"> {{ $data->{'pkupPtCode'} }} </td>
                    <td class="left"> {{ $data->{'colBank'} }} </td>
                    <td class="left"> {{ $data->{'storeName'} }} </td>
                    <td class="right"> {{ $data->{'depositAmount'} }} </td>
                </tr>
                @endforeach
                @endif
            </x-scrollable.scroll-body>
        </x-app.commercial-head.reports.unallocated.table-headers>
    </div>
</div>
