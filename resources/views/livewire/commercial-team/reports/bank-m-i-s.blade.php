<div x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    }

}" class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
    <section id="bankmis">
        <div class="row">
            <div class="col-lg-12 mb-2">
            </div>
        </div>

        <div class="row mb-2">

            <div class="col-lg-9">
                <ul class="nav nav-tabs justify-content-start" role="tablist">

                    <li class="nav-item">
                        <a @click="() => {
                            $wire.switchTab('all-cash-mis')
                            reset()
                        }" class="nav-link @if($activeTab === 'all-cash-mis') active @endif" data-bs-toggle="
                            tab" data-bs-target="#idfc" href="#" role="tab">
                            <img style="width: 30px; object-fit: cover" src="{{ asset('assets/images/cash.png') }}" />
                            CASH MIS
                        </a>
                    </li>

                    <li class="nav-item">
                        <a @click="() => {
                            $wire.switchTab('all-card-mis')
                            reset()
                        }" class="nav-link @if($activeTab === 'all-card-mis') active @endif" data-bs-toggle="
                            tab" data-bs-target="#idfc" href="#" role="tab">
                            <img style="width: 30px; object-fit: cover; mix-blend-mode: multiply !important;" src="{{ asset('assets/images/card.png') }}" />
                            CARD MIS
                        </a>
                    </li>

                    <li class="nav-item">
                        <a @click="() => {
                            $wire.switchTab('all-upi-mis')
                            reset()
                        }" class="nav-link @if($activeTab === 'all-upi-mis') active @endif" data-bs-toggle="
                            tab" data-bs-target="#idfc" href="#" role="tab">
                            <img style="width: 30px; object-fit: cover; mix-blend-mode: multiply !important;" src="{{ asset('assets/images/upi.png') }}" />
                            UPI MIS
                        </a>
                    </li>

                    <li class="nav-item">
                        <a @click="() => {
                            $wire.switchTab('all-wallet-mis')
                            reset()
                        }" class="nav-link @if($activeTab === 'all-wallet-mis') active @endif" data-bs-toggle="
                            tab" data-bs-target="#idfc" href="#" role="tab">
                            <img style="width: 30px; object-fit: cover" src="{{ asset('assets/images/wallet.png') }}" />
                            WALLET MIS
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row" style="border-top: 2px solid lightgray; ">
            <div class="my-2 d-flex d-flex-mob gap-2 align-items-center">
                <div style="display:@if ($filtering) unset @else none @endif" class="">
                    <button @click="() => {
                        $wire.back()
                        reset()    
                }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>

                <div wire:ignore class="mt-1 w-mob-100">
                    <template x-if=" $wire.activeTab=='all-cash-mis'">
                        <div class="select mb-1 w-mob-100" style="width: 200px">
                            <select x-on:change="$wire.bankName = $event.target.value" id="select22-dropdown">
                                <option selected disabled value="" class="">SELECT BANK NAME</option>
                                @foreach ($cash_banks as $bank)
                                @php
                                $bank = (array) $bank;
                                @endphp
                                <option value="{{ $bank['colBank'] }}" class="">{{ $bank['colBank'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </template>
                    <template x-if="$wire.activeTab == 'all-card-mis'">
                        <div class="select mb-1 w-mob-100" style="width: 200px">
                            <select x-on:change="$wire.bankName = $event.target.value" id="select22-dropdown">
                                <option selected disabled value="" class="">SELECT BANK NAME</option>
                                @foreach ($card_banks as $bank)
                                @php
                                $bank = (array) $bank;
                                @endphp
                                <option value="{{ $bank['colBank'] }}" class="">{{ $bank['colBank'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </template>

                    <template x-if="$wire.activeTab == 'all-wallet-mis'">
                        <div class="select mb-1 w-mob-100" style="width: 200px">
                            <select x-on:change="$wire.bankName = $event.target.value" id="select22-dropdown">
                                <option selected disabled value="" class="">SELECT BANK NAME</option>
                                @foreach ($wallet_banks as $bank)
                                @php
                                $bank = (array) $bank;
                                @endphp
                                <option value="{{ $bank['colBank'] }}" class="">{{ $bank['colBank'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </template>
                </div>

                <div class="mt-2 w-mob-100">
                    <x-filters._filter data="stores" arr="store" key="SGVsbG9rbmRrbmNkYw" update="store" initialValue="SELECT A STORE" />
                </div>

                <div class="mt-2 w-mob-100">
                    <x-filters.months :months="$_months" />
                </div>


                <x-filters.date-filter />

                <x-filters.simple-export />
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <x-scrollable.scrollable :dataset="$mis">
                    <x-scrollable.scroll-head>
                        @if($activeTab == 'all-cash-mis')
                        <tr class="headers">

                            <th class="left">
                                <div class="d-flex align-items-center gap-2">
                                    <span>Credit Date</span>
                                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                                </div>
                            </th>
                            <th>Deposit Date</th>
                            <th>Store ID</th>
                            <th>Retek Code</th>
                            <th>Pick Up Location</th>
                            <th>Collection Bank</th>
                            <th>Slip Number</th>
                            <th style="text-align: right !important">Deposit Amount</th>
                        </tr>
                        @endif

                        @if($activeTab == 'all-card-mis')
                        <tr class="headers">

                            <th class="left">
                                <div class="d-flex align-items-center gap-2">
                                    <span>Credit Date</span>
                                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                                </div>
                            </th>
                            <th>Deposit Date</th>
                            <th>Store ID</th>
                            <th>Retek Code</th>
                            <th>Collection Bank</th>
                            <th>Merchant Code</th>
                            <th>Terminal Number</th>
                            <th style="text-align: right !important">Deposit Amount</th>
                            <th style="text-align: right !important">MSF</th>
                            <th style="text-align: right !important">GST</th>
                            <th style="text-align: right !important">Net Amount</th>
                        </tr>
                        @endif

                        @if($activeTab == 'all-upi-mis')
                        <tr class="headers">

                            <th class="left">
                                <div class="d-flex align-items-center gap-2">
                                    <span>Credit Date</span>
                                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                                </div>
                            </th>
                            <th>Deposit Date</th>
                            <th>Store ID</th>
                            <th>Retek Code</th>
                            <th>Collection Bank</th>
                            <th>Merchant Code</th>
                            <th>Terminal Number</th>
                            <th style="text-align: right !important">Deposit Amount</th>
                            <th style="text-align: right !important">MSF</th>
                            <th style="text-align: right !important">GST</th>
                            <th style="text-align: right !important">Net Amount</th>
                        </tr>
                        @endif

                        @if($activeTab == 'all-wallet-mis')
                        <tr class="headers">
                            <th class="left">
                                <div class="d-flex align-items-center gap-2">
                                    <span>Credit Date</span>
                                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                                </div>
                            </th>
                            <th>Deposit Date</th>
                            <th>Store ID</th>
                            <th>Retek Code</th>
                            <th>Collection Bank</th>
                            <th>Terminal ID</th>
                            <th style="text-align: right !important">Deposit Amount</th>
                            <th style="text-align: right !important">Fee</th>
                            <th style="text-align: right !important">GST</th>
                            <th style="text-align: right !important">Net Amount</th>
                            <th>Bank Ref / UTR No</th>
                        </tr>
                        @endif
                    </x-scrollable.scroll-head>
                    <x-scrollable.scroll-body>
                        @if($activeTab == 'all-cash-mis')
                        @foreach ($mis as $main)
                        @php
                        $data = (array) $main
                        @endphp
                        <tr>
                            <td>{{ !$data['crDt'] ? '' : Carbon\Carbon::parse($data["crDt"])->format('d-m-Y') }}</td>
                            <td>{{ !$data['depositDt'] ? '' : Carbon\Carbon::parse($data["depositDt"])->format('d-m-Y') }}</td>
                            <td>{{ $data["storeID"] }}</td>
                            <td>{{ $data["retekCode"] }}</td>
                            <td>{{ $data["locationName"] }}</td>
                            <td>{{ $data["colBank"] }}</td>
                            <td>{{ $data["depostSlipNo"] }}</td>
                            <td style="text-align: right !important">{{ number_format($data['depositAmount'] ,2) }}</td>
                        </tr>
                        @endforeach

                        {{-- Card --}}
                        @elseif($activeTab == 'all-card-mis')

                        @foreach ($mis as $main)
                        @php
                        $data = (array) $main
                        @endphp
                        <tr>
                            <td>{{ !$data['creditDt'] ? '' : Carbon\Carbon::parse($data["creditDt"])->format('d-m-Y') }}</td>
                            <td>{{ !$data['depositDt'] ? '' : Carbon\Carbon::parse($data["depositDt"])->format('d-m-Y') }}</td>
                            <td>{{ $data['storeID'] }}</td>
                            <td>{{ $data['retekCode'] }}</td>
                            <td>{{ $data['colBank'] }}</td>
                            {{-- <td>{{ $data['accountNo'] }}</td> --}}
                            <td>{{ $data['merCode'] }}</td>
                            <td>{{ $data['tid'] }}</td>
                            <td style="text-align: right !important">{{ number_format($data['depositAmount'] ,2) }}</td>
                            <td style="text-align: right !important">{{ number_format($data['msfComm'] ,2) }}</td>
                            <td style="text-align: right !important">{{ number_format($data['gstTotal'] ,2) }}</td>
                            <td style="text-align: right !important">{{ number_format($data['netAmount'] ,2) }}</td>
                        </tr>
                        @endforeach

                        {{-- UPI --}}
                        @elseif($activeTab == 'all-upi-mis')

                        @foreach ($mis as $main)
                        @php
                        $data = (array) $main
                        @endphp
                        <tr>
                            <td>{{ !$data['creditDt'] ? '' : Carbon\Carbon::parse($data["creditDt"])->format('d-m-Y') }}</td>
                            <td>{{ !$data['depositDt'] ? '' : Carbon\Carbon::parse($data["depositDt"])->format('d-m-Y') }}</td>
                            <td>{{ $data['storeID'] }}</td>
                            <td>{{ $data['retekCode'] }}</td>
                            <td>{{ $data['colBank'] }}</td>
                            {{-- <td>{{ $data['accountNo'] }}</td> --}}
                            <td>{{ $data['merCode'] }}</td>
                            <td>{{ $data['tid'] }}</td>
                            <td style="text-align: right !important">{{ number_format($data['depositAmount'] ,2) }}</td>
                            <td style="text-align: right !important">{{ number_format($data['msfComm'] ,2) }}</td>
                            <td style="text-align: right !important">{{ number_format($data['gstTotal'] ,2) }}</td>
                            <td style="text-align: right !important">{{ number_format($data['netAmount'] ,2) }}</td>
                        </tr>
                        @endforeach

                        {{-- Wallet --}}
                        @elseif($activeTab == 'all-wallet-mis')

                        @foreach ($mis as $main)
                        @php
                        $data = (array) $main
                        @endphp
                        <tr>
                            <td>{{ !$data['creditDt'] ? '' : Carbon\Carbon::parse($data["creditDt"])->format('d-m-Y') }}</td>
                            <td>{{ !$data['depositDt'] ? '' : Carbon\Carbon::parse($data["depositDt"])->format('d-m-Y') }}</td>
                            <td>{{ $data['storeID'] }}</td>
                            <td>{{ $data['retekCode'] }}</td>
                            <td>{{ $data['colBank'] }}</td>
                            <td>{{ $data['tid'] }}</td>
                            <td style="text-align: right !important">{{ number_format($data['depositAmount'] ,2) }}</td>
                            <td style="text-align: right !important">{{ number_format($data['msfComm'] ,2) }}</td>
                            <td style="text-align: right !important">{{ number_format($data['gstTotal'] ,2) }}</td>
                            <td style="text-align: right !important">{{ number_format($data['netAmount'] ,2) }}</td>
                            <td>{{ $data['bankRrefORutrNo'] }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </x-scrollable.scroll-body>
                </x-scrollable.scrollable>
            </div>
        </div>
    </section>

    <script>
        var $j = jQuery.noConflict();

        Livewire.on('resetall', event => {
            $j('#select22-dropdown').val('');
        });

    </script>
</div>
