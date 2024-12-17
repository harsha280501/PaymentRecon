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
                        <a wire:click="switchTab('hdfc')" class="nav-link @if($activeTab === 'hdfc') active @endif" data-bs-toggle="tab" data-bs-target="#hdfc" href="#" role="tab">
                            <img src="{{ asset('assets/images/hdfc-logo.png') }}" />HDFC
                            BANK
                        </a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="switchTab('axis')" class="nav-link @if($activeTab === 'axis') active @endif" data-bs-toggle="
                            tab" data-bs-target="#axis" href="#" role="tab">
                            <img src="{{ asset('assets/images/axis-logo.png') }}" />Axis Bank
                        </a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="switchTab('icici')" class="nav-link @if($activeTab === 'icici') active @endif" data-bs-toggle="tab" data-bs-target="#icici" href="#" role="tab">
                            <img src="{{ asset('assets/images/icici-logo.png') }}" />ICICI Bank
                        </a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="switchTab('sbi')" class="nav-link @if($activeTab === 'sbi') active @endif" data-bs-toggle="
                            tab" data-bs-target="#sbi" href="#" role="tab">
                            <img src="{{ asset('assets/images/sbi-logo.png') }}" /> SBI
                            Bank
                        </a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="switchTab('idfc')" class="nav-link @if($activeTab === 'idfc') active @endif" data-bs-toggle="
                            tab" data-bs-target="#idfc" href="#" role="tab">
                            <img src="{{ asset('assets/images/idfc-logo.png') }}" />
                            IDFC Bank
                        </a>
                    </li>

                </ul>
            </div>
            <div class="col-lg-3 d-flex align-items-center justify-content-end">

                <select class="bg-brown me-2" style="height: 7vh; outline: none; border: none; border-radius: 4px; font-size: .7em; padding: .5em 1em .5em .5em" wire:model="bankType">
                    @foreach ($bankTypes as $type)
                    <option value="{{ $type->accountNo }}">Acct: {{ $type->accountNo }}</option>
                    @endforeach
                </select>

                <div class="btn-group mb-1" style="margin-right: 5px; width: fit-content;display: none;">
                    <button type="button" class="dropdown-toggle d-flex btn btn-secondary" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                    <div class="dropdown-menu" style="width: 150px !important" aria-labelledby="dropdownMenuButton1">
                        <a style="color: #000; text-decoration: none; font-size: .9em; padding: .7em 1em .7em .3em; width: 100% !important" wire:click="exportExcel" href="#">Export XLS</a>
                    </div>
                </div>

                <!--btn2-->
                <div class="btn-group mb-1">
                </div>
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
                                            <td data-headerName="acctNo">Deposit Date</td>
                                            <td data-headerName="depositDt">Book Date</td>
                                            <td data-headerName="tranType">Credit</td>
                                            <td data-headerName="mername">Debit</td>
                                            <td data-headerName="mid">Reference Number</td>
                                            <td data-headerName="mid">Transaction Branch</td>
                                        </tr>

                                        @elseif($activeTab == 'axis' || $activeTab == 'idfc'|| $activeTab == 'sbi')
                                        <tr class="headers">

                                            <td data-headerName="depositDt">Book Date</td>
                                            <td data-headerName="tranType">Credit</td>
                                            <td data-headerName="mername">Debit</td>
                                            <td data-headerName="acctNo">Ledger Balance</td>
                                            <td data-headerName="mid">Description</td>

                                        </tr>

                                        @elseif ($activeTab == 'icici')
                                        <tr class="headers">
                                            <td data-headerName="depositDt">Book Date</td>
                                            <td data-headerName="tranType">Credit</td>
                                            <td data-headerName="mername">Debit</td>
                                            <td data-headerName="acctNo">Ledger Balance</td>
                                            <td data-headerName="mid">Reference Number</td>
                                            <td data-headerName="mid">Transaction Branch</td>
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

                                            <td class="depositDt">{{ $data["depositDt"] }}</td>
                                            <td class="bookDt">{{ $data["bookDt"] }}</td>
                                            <td class="tranType">{{ $data["credit"] }}</td>
                                            <td class="depositAmt">{{ $data["debit"] }}</td>
                                            <td class="depositAmt">{{ $data["refNo"] }}</td>
                                            <td class="tid">{{ $data["transactionBr"] }}</td>
                                        </tr>
                                        @endforeach

                                        @elseif($activeTab == 'axis' || $activeTab == 'idfc'|| $activeTab == 'sbi')

                                        @foreach ($mis as $main)
                                        @php
                                        $data = (array) $main
                                        @endphp

                                        <tr>
                                            <td class="bookDt">{{ $data["bookDt"] }}</td>
                                            <td class="tranType">{{ $data["credit"] }}</td>
                                            <td class="depositAmt">{{ $data["debit"] }}</td>
                                            <td class="depositDt">{{ $data["ledger_bal"] }}</td>
                                            <td class="depositDt">{{ $data["description"] }}</td>

                                        </tr>

                                        @endforeach

                                        @elseif($activeTab == 'icici')

                                        @foreach ($mis as $main)
                                        @php
                                        $data = (array) $main
                                        @endphp

                                        <tr>

                                            <td class="bookDt">{{ $data["bookDt"] }}</td>
                                            <td class="tranType">{{ $data["credit"] }}</td>
                                            <td class="depositAmt">{{ $data["debit"] }}</td>
                                            <td class="depositDt">{{ $data["ledger_bal"] }}</td>
                                            <td class="depositAmt">{{ $data["refNo"] }}</td>
                                            <td class="tid">{{ $data["transactionBr"] }}</td>
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
