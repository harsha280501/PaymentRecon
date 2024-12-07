<div x-data="{

start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    }

}">
    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
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

            <div class="row @if (!in_array($activeTab, $implementedFilters)) d-none @endif" style="border-top: 2px solid lightgray; ">

                <div x-data='{
                    from: $wire.from,
                    to: $wire.to,
                    clear() {
                        this.from = "";
                        this.to = "";
                    }
                }' class="my-2 d-flex d-flex-mob gap-2 align-items-center">
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
                            <div class=" select mb-1 w-mob-100" style="width: 200px">
                                <select x-on:change="$wire.bankName = $event.target.value" id="select22-dropdown" class="">
                                    <option selected disabled value="" class="">SELECT BANK NAME</option>
                                    @foreach ($cash_banks as $bank)
                                    <option value="{{ $bank->colBank }}" class="">{{ $bank->colBank }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </template>
                        <template x-if="$wire.activeTab == 'all-card-mis'">
                            <div class="select mb-1 w-mob-100" style="width: 200px">
                                <select x-on:change="$wire.bankName = $event.target.value" id="select22-dropdown" class="">
                                    <option selected disabled value="" class="">SELECT BANK NAME</option>
                                    @foreach ($card_banks as $bank)
                                    <option value="{{ $bank->colBank }}" class="">{{ $bank->colBank }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </template>
                        <template x-if="$wire.activeTab == 'all-wallet-mis'">
                            <div class="select mb-1 w-mob-100" style="width: 200px">
                                <select x-on:change="$wire.bankName = $event.target.value" id="select22-dropdown" class="">
                                    <option selected disabled value="" class="">SELECT BANK NAME</option>
                                    @foreach ($wallet_banks as $bank)
                                    <option value="{{ $bank->colBank }}" class="">{{ $bank->colBank }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </template>
                    </div>

                    <x-filters.months :months="$_months" />
                    <x-filters.date-filter />
                    <x-filters.simple-export />

                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <x-scrollable.scrollable :dataset="$mis">
                        <x-scrollable.scroll-head>

                            @if ($activeTab == 'all-cash-mis')
                            <tr class="headers">
                                <th>
                                    <div class="d-flex align-items-center gap-2">
                                        <span>Sales Date</span>
                                        <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                                    </div>
                                </th>
                                <th>Deposit Date</th>
                                <th>Collection Bank</th>
                                <th>Pick Up Location</th>
                                <th>Slip Number</th>
                                <th style="text-align: right !important">Deposit Amount</th>
                            </tr>
                            @endif

                            @if ($activeTab == 'all-card-mis')
                            <tr class="headers">
                                <th>
                                    <div class="d-flex align-items-center gap-2">
                                        <span>Credit Date</span>
                                        <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                                    </div>
                                </th>

                                <th>Deposit Date</th>
                                <th>Collection Bank</th>
                                {{-- <th>Account Number</th> --}}
                                <th>Merchant Code</th>
                                <th>Terminal Number</th>
                                <th style="text-align: right !important">Deposit Amount</th>
                            </tr>
                            @endif

                            @if ($activeTab == 'all-upi-mis')
                            <tr class="headers">
                                <th>
                                    <div class="d-flex align-items-center gap-2">
                                        <span>Sales Date</span>
                                        <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                                    </div>
                                </th>
                                <th>Deposit Date</th>
                                <th>Collection Bank</th>
                                {{-- <th>Account Number</th> --}}
                                <th>Merchant Code</th>
                                <th>Terminal Number</th>
                                <th style="text-align: right !important">Deposit Amount</th>
                            </tr>
                            @endif

                            @if ($activeTab == 'all-wallet-mis')
                            <tr class="headers">
                                <th>
                                    <div class="d-flex align-items-center gap-2">
                                        <span>Sales Date</span>
                                        <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                                    </div>
                                </th>
                                <th>Deposit Date</th>
                                <th>Collection Bank</th>
                                <th>Terminal ID</th>
                                <th>MID</th>
                                <th style="text-align: right !important">Deposit Amount</th>
                            </tr>
                            @endif

                        </x-scrollable.scroll-head>
                        <x-scrollable.scroll-body>


                            @if ($activeTab == 'all-cash-mis')
                            @foreach ($mis as $main)
                            @php
                            $data = (array) $main;
                            @endphp
                            <tr>
                                <td>{{ $data['crDt'] }}</td>
                                <td>{{ $data['depositDt'] }}</td>

                                <td>{{ $data['colBank'] }}</td>
                                <td>{{ $data['locationName'] }}</td>
                                <td>{{ $data['depostSlipNo'] }}</td>
                                <td style="text-align: right !important">{{ $data['depositAmount'] }}</td>
                            </tr>
                            @endforeach
                            @elseif($activeTab == 'all-card-mis')
                            @foreach ($mis as $main)
                            @php
                            $data = (array) $main;
                            @endphp
                            <tr>
                                <td>{{ $data['creditDt'] }}</td>
                                <td>{{ $data['depositDt'] }}</td>

                                <td>{{ $data['colBank'] }}</td>
                                {{-- <td>{{ $data['accountNo'] }}</td> --}}
                                <td>{{ $data['merCode'] }}</td>
                                <td>{{ $data['tid'] }}</td>
                                <td style="text-align: right !important">{{ $data['depositAmount'] }}</td>
                            </tr>
                            @endforeach
                            @elseif($activeTab == 'all-upi-mis')
                            @foreach ($mis as $main)
                            @php
                            $data = (array) $main;
                            @endphp
                            <tr>
                                <td>{{ $data['creditDt'] }}</td>
                                <td>{{ $data['depositDt'] }}</td>

                                <td>{{ $data['colBank'] }}</td>
                                {{-- <td>{{ $data['accountNo'] }}</td> --}}
                                <td>{{ $data['merCode'] }}</td>
                                <td>{{ $data['tid'] }}</td>
                                <td style="text-align: right !important">{{ $data['depositAmount'] }}</td>
                            </tr>
                            @endforeach
                            @elseif($activeTab == 'all-wallet-mis')
                            @foreach ($mis as $main)
                            @php
                            $data = (array) $main;
                            @endphp
                            <tr>
                                <td>{{ $data['creditDt'] }}</td>
                                <td>{{ $data['depositDt'] }}</td>

                                <td>{{ $data['colBank'] }}</td>
                                <td>{{ $data['tid'] }}</td>
                                <td>{{ $data['mid'] }}</td>
                                <td style="text-align: right !important">{{ $data['depositAmount'] }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </x-scrollable.scroll-body>
                    </x-scrollable.scrollable>
                </div>
        </section>

        <script>
            var $j = jQuery.noConflict();

            Livewire.on('resetall', event => {
                $j('#select22-dropdown').val('');
            });

        </script>
    </div>
