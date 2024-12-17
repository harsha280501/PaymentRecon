<div class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab" x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    }
    
}">
    <section id="bankmis">
        <div class="row">
            <div class="col-lg-12 mb-2">
            </div>
        </div>


        {{-- Start of tabs --}}
        <div class="row">
            <div class="col-lg-9">
                <ul class="nav nav-tabs justify-content-start" role="tablist">
                    <li class="nav-item">
                        <a @click="() => {
                            $wire.switchTab('hdfc')
                            reset()
                        }" class="nav-link @if($activeTab === 'hdfc') active @endif" data-bs-toggle="tab" data-bs-target="#hdfc" href="#" role="tab">
                            <img src="{{ asset('assets/images/hdfc-logo.png') }}" />HDFC
                            BANK
                        </a>
                    </li>

                    <li class="nav-item">
                        <a @click="() => {
                            $wire.switchTab('axis')
                            reset()
                        }" class="nav-link @if($activeTab === 'axis') active @endif" data-bs-toggle="
                            tab" data-bs-target="#axis" href="#" role="tab">
                            <img src="{{ asset('assets/images/axis-logo.png') }}" />Axis Bank
                        </a>
                    </li>

                    <li class="nav-item">
                        <a @click="() => {
                            $wire.switchTab('icici')
                            reset()
                        }" class="nav-link @if($activeTab === 'icici') active @endif" data-bs-toggle="tab" data-bs-target="#icici" href="#" role="tab">
                            <img src="{{ asset('assets/images/icici-logo.png') }}" />ICICI Bank
                        </a>
                    </li>
                    <li class="nav-item">
                        <a @click="() => {
                            $wire.switchTab('sbi')
                            reset()
                        }" class="nav-link @if($activeTab === 'sbi') active @endif" data-bs-toggle="
                            tab" data-bs-target="#sbi" href="#" role="tab">
                            <img src="{{ asset('assets/images/sbi-logo.png') }}" /> SBI
                            Bank
                        </a>
                    </li>
                    <li class="nav-item">
                        <a @click="() => {
                            $wire.switchTab('idfc')
                            reset()
                        }" class="nav-link @if($activeTab === 'idfc') active @endif" data-bs-toggle="
                            tab" data-bs-target="#idfc" href="#" role="tab">
                            <img src="{{ asset('assets/images/idfc-logo.png') }}" />
                            IDFC Bank
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- start of filters --}}
        <div class="row" style="border-top: 2px solid lightgray; ">
            <div class="my-3 d-flex d-flex-mob gap-2 align-items-center">

                {{-- Back button --}}
                <div style="display:@if ($filtering) unset @else none @endif" class="">
                    <button @click="() => {
                        $wire.back()
                        reset()    
                }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>

                <select class="bg-brown me-2" style="height: 7vh; outline: none; border: none; border-radius: 4px; font-size: .7em; padding: .5em 1em .5em .5em" wire:model="bankType">
                    @foreach ($bankTypes as $type)
                    <option value="{{ $type->accountNo }}">Acct: {{ $type->accountNo }}</option>
                    @endforeach
                </select>




                <div class="mt-2 w-mob-100">
                    <x-filters.months :months="$_months" />
                </div>


                {{-- months filter --}}
                <div class=" w-mob-100">
                    <x-filters.searchFilter placeHolder="Desc | Ref" />
                </div>

                <div class="mt-1 w-mob-100">
                    <x-filters.date-filter />
                </div>

                <x-filters.simple-export />
            </div>
        </div>


        <!--Tab contents--->

        <div class="row">

            <x-scrollable.scrollable :dataset="$mis">
                <x-scrollable.scroll-head>
                    @if ($activeTab == 'hdfc')
                    <tr class="headers">
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Credit Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif">
                                </i>
                            </div>
                        </th>
                        <td data-headerName="acctNo">Deposit Date</td>
                        <td data-headerName="mid">Reference Number</td>
                        <td data-headerName="mid">Transaction Branch</td>
                        <td data-headerName="mid">Description</td>
                        <td style="text-align: right !important" data-headerName="mername">Debit</td>
                        <td style="text-align: right !important" data-headerName="tranType">Credit</td>
                    </tr>

                    @elseif($activeTab == 'axis' || $activeTab == 'idfc'|| $activeTab == 'sbi')
                    <tr class="headers">

                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Credit Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif">
                                </i>
                            </div>
                        </th>
                        <td data-headerName="acctNo">Deposit Date</td>
                        <td data-headerName="mid">Reference Number</td>
                        <td data-headerName="mid">Transaction Branch</td>
                        <td data-headerName="mid">Description</td>
                        <td style="text-align: right !important" data-headerName="mername">Debit</td>
                        <td style="text-align: right !important" data-headerName="tranType">Credit</td>
                        {{-- <td data-headerName="acctNo">Ledger Balance</td> --}}
                    </tr>

                    @elseif ($activeTab == 'icici')
                    <tr class="headers">
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Credit Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif">
                                </i>
                            </div>
                        </th>
                        <td data-headerName="acctNo">Deposit Date</td>
                        <td data-headerName="mid">Reference Number</td>
                        <td data-headerName="mid">Transaction Branch</td>
                        <td data-headerName="mid">Description</td>

                        <td style="text-align: right !important" data-headerName="mername">Debit</td>
                        <td style="text-align: right !important" data-headerName="tranType">Credit</td>
                    </tr>

                    @else
                    <span></span>

                    @endif
                </x-scrollable.scroll-head>
                <x-scrollable.scroll-body>
                    @if ($activeTab == 'hdfc')

                    @foreach ($mis as $main)
                    @php
                    $data = (array) $main
                    @endphp

                    <tr>
                        <td class="bookDt">{{ !$data["crDt"] ? '' : Carbon\Carbon::parse($data["crDt"])->format('d-m-Y') }}</td>
                        <td class="depositDt">{{ !$data["depositDt"] ? '' : Carbon\Carbon::parse($data["depositDt"])->format('d-m-Y') }}</td>
                        <td class="depositAmt">{{ $data["refNo"] }}</td>
                        <td class="tid">{{ $data["transactionBr"] }}</td>
                        <td class="tid">{{ $data["description"] }}</td>
                        <td style="text-align: right !important" class="depositAmt">{{ $data["debit"] }}</td>
                        <td style="text-align: right !important" class="tranType">{{ $data["credit"] }}</td>
                    </tr>
                    @endforeach

                    @elseif($activeTab == 'axis' || $activeTab == 'idfc'|| $activeTab == 'sbi')

                    @foreach ($mis as $main)
                    @php
                    $data = (array) $main
                    @endphp

                    <tr>

                        <td class="bookDt">{{ !$data['crDt'] ? '' : Carbon\Carbon::parse($data["crDt"])->format('d-m-Y') }}</td>
                        <td class="depositDt">{{ !$data['depositDt'] ? '' : Carbon\Carbon::parse($data["depositDt"])->format('d-m-Y') }}</td>
                        <td class="depositAmt">{{ $data["refNo"] }}</td>
                        <td class="tid">{{ $data["transactionBr"] }}</td>
                        <td class="tid">{{ $data["description"] }}</td>
                        <td style="text-align: right !important" class="depositAmt">{{ $data["debit"] }}</td>
                        <td style="text-align: right !important" class="tranType">{{ $data["credit"] }}</td>
                    </tr>

                    @endforeach

                    @elseif($activeTab == 'icici')

                    @foreach ($mis as $main)
                    @php
                    $data = (array) $main
                    @endphp

                    <tr>
                        <td class="bookDt">{{ !$data['crDt'] ? '' : Carbon\Carbon::parse($data["crDt"])->format('d-m-Y') }}</td>
                        <td class="depositDt">{{ !$data['depositDt'] ? '' : Carbon\Carbon::parse($data["depositDt"])->format('d-m-Y') }}</td>
                        <td class="depositAmt">{{ $data["refNo"] }}</td>
                        <td class="tid">{{ $data["transactionBr"] }}</td>
                        <td class="tid">{{ $data["description"] }}</td>
                        <td style="text-align: right !important" class="depositAmt">{{ $data["debit"] }}</td>
                        <td style="text-align: right !important" class="tranType">{{ $data["credit"] }}</td>
                    </tr>
                    @endforeach
                    @endif

                </x-scrollable.scroll-body>
            </x-scrollable.scrollable>

        </div>
    </section>
</div>
