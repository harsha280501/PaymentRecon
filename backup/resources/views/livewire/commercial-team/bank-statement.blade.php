<div class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
    <section id="bankmis">
        <div class="row">
            <div class="col-lg-12 mb-2">
            </div>
        </div>

        <div class="row">

            <div class="col-lg-9">
                <ul class="nav nav-tabs justify-content-start" role="tablist">
                    <li class="nav-item">
                        <a wire:click="switchTab('hdfc')" class="nav-link @if($activeTab === 'hdfc') active @endif"
                            data-bs-toggle="tab" data-bs-target="#hdfc" href="#" role="tab">
                            <img src="{{ asset('assets/images/hdfc-logo.png') }}" />HDFC
                            BANK
                        </a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="switchTab('axis')" class="nav-link @if($activeTab === 'axis') active @endif"
                            data-bs-toggle="
                            tab" data-bs-target="#axis" href="#" role="tab">
                            <img src="{{ asset('assets/images/axis-logo.png') }}" />Axis Bank
                        </a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="switchTab('icici')" class="nav-link @if($activeTab === 'icici') active @endif"
                            data-bs-toggle="tab" data-bs-target="#icici" href="#" role="tab">
                            <img src="{{ asset('assets/images/icici-logo.png') }}" />ICICI Bank
                        </a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="switchTab('sbi')" class="nav-link @if($activeTab === 'sbi') active @endif"
                            data-bs-toggle="
                            tab" data-bs-target="#sbi" href="#" role="tab">
                            <img src="{{ asset('assets/images/sbi-logo.png') }}" /> SBI
                            Bank
                        </a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="switchTab('idfc')" class="nav-link @if($activeTab === 'idfc') active @endif"
                            data-bs-toggle="
                            tab" data-bs-target="#idfc" href="#" role="tab">
                            <img src="{{ asset('assets/images/idfc-logo.png') }}" />
                            IDFC Bank
                        </a>
                    </li>

                </ul>
            </div>
            <div class="col-lg-3 d-flex align-items-center justify-content-end gap-2">

                <select class="bg-brown me-2"
                    style="height: 7vh; outline: none; border: none; border-radius: 4px; font-size: .7em; padding: .5em 1em .5em .5em"
                    wire:model="bankType">
                    @foreach ($bankTypes as $type)
                    <option value="{{ $type->accountNo }}">Acct: {{ $type->accountNo }}</option>
                    @endforeach
                </select>

                <div>

                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 1em; ">

                        <div x-data="{ show: false, timeout: null }" class="d-flex align-items-center gap-2 w-mob-100"
                            style="width: 100px; " x-init="@this.on('no-data', () => {
                        clearTimeout(timeout); show = true; timeout = setTimeout(() => { show = false }, 3000);
                    })" style="position: relative">
                            <p class="alert alert-sm alert-info" x-show="show"
                                style="padding: .5em 1em; margin-top: 11px; position: absolute; z-index: 9999; width: 200px; right:10%">
                                No
                                Data
                                to Export</p>

                            <div class="w-mob-100">
                                <button type="button" class="btn mb-1 w-mob-100 py-2 mt-1"
                                    style="background: #3682cd; color: #fcf8f8;width:110px; font-size: 14px !important;"
                                    wire:click.prevent="export">
                                    Export Excel </button>
                            </div>
                        </div>
                    </div>
                </div>
                {{--
                <x-filters.simple-export /> --}}
            </div>
        </div>
        <!--Tab contents--->
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content text-center">
                    <div class="tab-pane active" id="icici" role="tabpanel">
                        <section id="recent">
                            <div class="row">

                                <x-scrollable.scrollable :dataset="$mis">
                                    <x-scrollable.scroll-head>
                                        @if ($activeTab == 'hdfc')
                                        <tr class="headers">
                                            <th>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span>Credit Date</span>
                                                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                                        class="
                                                            fa-solid @if($orderBy == 'asc') 
                                                             fa-caret-up 
                                                            @else fa-caret-down @endif"> </i>
                                                </div>
                                            </th>
                                            <td data-headerName="acctNo">Deposit Date</td>
                                            <td data-headerName="mid">Reference Number</td>
                                            <td data-headerName="mid">Transaction Branch</td>
                                            <td data-headerName="tranType">Credit</td>
                                            <td data-headerName="mername">Debit</td>
                                        </tr>

                                        @elseif($activeTab == 'axis' || $activeTab == 'idfc'|| $activeTab == 'sbi')
                                        <tr class="headers">

                                            <th>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span>Credit Date</span>
                                                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                                        class="
                                                            fa-solid @if($orderBy == 'asc') 
                                                             fa-caret-up 
                                                            @else fa-caret-down @endif"> </i>
                                                </div>
                                            </th>
                                            <td data-headerName="acctNo">Deposit Date</td>
                                            <td data-headerName="mid">Reference Number</td>
                                            <td data-headerName="mid">Transaction Branch</td>
                                            <td data-headerName="tranType">Credit</td>
                                            <td data-headerName="mername">Debit</td>
                                            {{-- <td data-headerName="acctNo">Ledger Balance</td> --}}

                                        </tr>

                                        @elseif ($activeTab == 'icici')
                                        <tr class="headers">
                                            <th>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span>Credit Date</span>
                                                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                                        class="
                                                            fa-solid @if($orderBy == 'asc') 
                                                             fa-caret-up 
                                                            @else fa-caret-down @endif"> </i>
                                                </div>
                                            </th>
                                            <td data-headerName="acctNo">Deposit Date</td>
                                            <td data-headerName="mid">Reference Number</td>
                                            <td data-headerName="mid">Transaction Branch</td>
                                            <td data-headerName="tranType">Credit</td>
                                            <td data-headerName="mername">Debit</td>
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
                                            <td class="bookDt">{{ Carbon\Carbon::parse($data["crDt"])->format('d-m-Y')
                                                }}</td>
                                            <td class="depositDt">{{
                                                Carbon\Carbon::parse($data["depositDt"])->format('d-m-Y') }}</td>
                                            <td class="depositAmt">{{ $data["refNo"] }}</td>
                                            <td class="tid">{{ $data["transactionBr"] }}</td>
                                            <td class="tranType">{{ $data["credit"] }}</td>
                                            <td class="depositAmt">{{ $data["debit"] }}</td>
                                        </tr>
                                        @endforeach

                                        @elseif($activeTab == 'axis' || $activeTab == 'idfc'|| $activeTab == 'sbi')

                                        @foreach ($mis as $main)
                                        @php
                                        $data = (array) $main
                                        @endphp

                                        <tr>
                                            <td class="bookDt">{{ Carbon\Carbon::parse($data["crDt"])->format('d-m-Y')
                                                }}</td>
                                            <td class="depositDt">{{
                                                Carbon\Carbon::parse($data["depositDt"])->format('d-m-Y') }}</td>
                                            <td class="depositAmt">{{ $data["refNo"] }}</td>
                                            <td class="tid">{{ $data["transactionBr"] }}</td>
                                            <td class="tranType">{{ $data["credit"] }}</td>
                                            <td class="depositAmt">{{ $data["debit"] }}</td>
                                        </tr>

                                        @endforeach

                                        @elseif($activeTab == 'icici')

                                        @foreach ($mis as $main)
                                        @php
                                        $data = (array) $main
                                        @endphp

                                        <tr>
                                            <td class="bookDt">{{ Carbon\Carbon::parse($data["crDt"])->format('d-m-Y')
                                                }}</td>
                                            <td class="depositDt">{{
                                                Carbon\Carbon::parse($data["depositDt"])->format('d-m-Y') }}</td>
                                            <td class="depositAmt">{{ $data["refNo"] }}</td>
                                            <td class="tid">{{ $data["transactionBr"] }}</td>
                                            <td class="tranType">{{ $data["credit"] }}</td>
                                            <td class="depositAmt">{{ $data["debit"] }}</td>
                                        </tr>
                                        @endforeach
                                        @endif

                                    </x-scrollable.scroll-body>
                                </x-scrollable.scrollable>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>