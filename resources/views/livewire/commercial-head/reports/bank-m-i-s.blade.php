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

            <div class="col-lg-9" wire:ignore>
                <ul class="nav nav-tabs justify-content-start" role="tablist">

                    <li class="nav-item"
                        wire:key="2cf24dba5fb0a30e26fngfhsccvcve83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824">
                        <a href="{{ url('/') }}/chead/reports/bankmis?t=all-cash-mis"
                            class="nav-link @if ($activeTab === 'all-cash-mis') active @endif">
                            <img style="width: 30px; object-fit: cover" src="{{ asset('assets/images/cash.png') }}" />
                            CASH MIS
                        </a>
                    </li>

                    <li class="nav-item"
                        wire:key="d872c4505c5202scassdsaqw32f7c0e11c369cda54fb7131e3f85462f331da0e68ec36c9b2ff">
                        <a href="{{ url('/') }}/chead/reports/bankmis?t=all-card-mis"
                            class="nav-link @if ($activeTab === 'all-card-mis') active @endif">
                            <img style="width: 30px; object-fit: cover; mix-blend-mode: multiply !important;"
                                src="{{ asset('assets/images/card.png') }}" />
                            CARD MIS
                        </a>
                    </li>

                    <li class="nav-item"
                        wire:key="ecd26292b7f02ssssssssss970ca6909abb23e1aedd0dd57d0ee9ff40bf3f30c325e3e453a">
                        <a href="{{ url('/') }}/chead/reports/bankmis?t=all-upi-mis"
                            class="nav-link @if ($activeTab === 'all-upi-mis') active @endif">
                            <img style="width: 30px; object-fit: cover; mix-blend-mode: multiply !important;"
                                src="{{ asset('assets/images/upi.png') }}" />
                            UPI MIS
                        </a>
                    </li>

                    <li class="nav-item"
                        wire:key="d7914fe546b68468sdassd8bb95f4f888a92dfc680603a75f23eb823658031fff766d9">
                        <a href="{{ url('/') }}/chead/reports/bankmis?t=all-wallet-mis"
                            class="nav-link @if ($activeTab === 'all-wallet-mis') active @endif">
                            <img style="width: 30px; object-fit: cover" src="{{ asset('assets/images/wallet.png') }}" />
                            WALLET MIS
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row" style="border-top: 2px solid lightgray;"
            wire:key="2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824">
            <div class="my-2 d-flex d-flex-mob gap-2 align-items-center">
                <div style="display:@if ($filtering) unset @else none @endif" class="">
                    <button
                        @click="() => {
                        $wire.back()
                        reset()
                        window.location.reload();
                }"
                        style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>

                <div wire:ignore class="mt-1 w-mob-100"
                    wire:key="d7914fe546b684688bb95f4f888a92dfc680603a75f23eb823658031fff766d9">
                    <div wire:key="ecd26292b7f02970ca6909abb23e1aedd0dd57d0ee9ff40bf3f30c325e3e453a" wire:ignore.self>
                        <template x-if="$wire.activeTab == 'all-card-mis'"
                            wire:key="522366a1b1721036b37522f091c2fe5b9aa8011ab39da79ef5edc8a49b96bdce">
                            <div class="select mb-1 w-mob-100" style="width: 200px" wire:ignore.self>
                                <select x-on:change="$wire.bankName = $event.target.value" id="select22-dropdown">
                                    <option selected disabled value="" class="">SELECT BANK NAME</option>
                                    @foreach ($card_banks as $bank)
                                        @php
                                            $bank = (array) $bank;
                                        @endphp
                                        <option value="{{ $bank['colBank'] }}" class="">{{ $bank['colBank'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </template>

                        <template x-if="$wire.activeTab == 'all-wallet-mis'"
                            wire:key="5111292cc76e40a363f8f0622f842c633cdbf473a4b3686222e7fd8b68fc3c04" wire:ignore>
                            <div class="select mb-1 w-mob-100" style="width: 200px" wire:ignore.self>
                                <select x-on:change="$wire.bankName = $event.target.value" id="select22-dropdown">
                                    <option selected disabled value="" class="">SELECT BANK NAME</option>
                                    @foreach ($wallet_banks as $bank)
                                        @php
                                            $bank = (array) $bank;
                                        @endphp
                                        <option value="{{ $bank['colBank'] }}" class="">{{ $bank['colBank'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </template>

                        <template x-if="$wire.activeTab == 'all-cash-mis'"
                            wire:key="991f4756d8bb9de0b2e0c2f0d9463d74cd067f42d2cd8ddefb7474a0112d2406">
                            <div class="mt-2 w-mob-100">
                                <x-filters.bank_slip :bank="$bankName" />
                            </div>
                        </template>
                    </div>
                </div>

                <div class="d-flex gap-2 pt-2 align-items-center">
                    <template x-if="$wire.activeTab == 'all-card-mis' || $wire.activeTab == 'all-upi-mis'"
                        wire:key="tid-filter">
                        <div x-data="{ tid: '' }" style="display: flex; align-items: center; gap: 10px;">
                            <div style="position: relative; width: 200px;" wire:ignore>
                                <select id="tid_filter_dropdown" style="width: 100%; height: 40px;"></select>
                                <button id="clear_tid_btn" type="button" class="clear-btn">×</button>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-2 w-mob-100" wire:ignore.self>
                    <x-filters._filterStore data="stores" arr="store" key="SGVsbG9rbmRrbmNkYw" update="store"
                        initialValue="SELECT A STORE" />
                </div>


                <div class="mt-2 w-mob-100">
                    <x-filters.months :months="$_months" />
                </div>

                <div class="pt-2">
                    <x-filters.date-filter />
                </div>
                <x-filters.simple-export />
            </div>
        </div>

        <x-app.commercial-head.reports.bankmis.totals :dataset="$totals" />
        <div class="row">
            <div class="col-lg-12">
                <x-scrollable.scrollable :dataset="$mis">
                    <x-scrollable.scroll-head>
                        @if ($activeTab == 'all-cash-mis')
                            <tr class="headers">
                                <th class="left">
                                    <div class="d-flex align-items-center gap-2">
                                        <span>Deposit Date</span>
                                        <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                            class="fa-solid @if ($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                                    </div>
                                </th>
                                <th>Credit Date</th>
                                <th>Store ID</th>
                                <th>Retek Code</th>
                                <th>Pick Up Location</th>
                                <th>Deposit Through</th>
                                <th>Collection Bank</th>
                                <th>Slip Number</th>
                                <th style="text-align: right !important">Deposit Amount</th>
                            </tr>
                        @endif

                        @if ($activeTab == 'all-card-mis')
                            <tr class="headers">
                                <th class="left">
                                    <div class="d-flex align-items-center gap-2">
                                        <span>Deposit Date</span>
                                        <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                            class="fa-solid @if ($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                                    </div>
                                </th>
                                <th>Credit Date</th>
                                <th>Store ID</th>
                                <th>Retek Code</th>
                                <th>Collection Bank</th>
                                <th>Merchant Code</th>
                                <th>TID</th>
                                <th style="text-align: right !important">Deposit Amount</th>
                                <th style="text-align: right !important">MSF</th>
                                <th style="text-align: right !important">GST</th>
                                <th style="text-align: right !important">Net Amount</th>
                            </tr>
                        @endif

                        @if ($activeTab == 'all-upi-mis')
                            <tr class="headers">
                                <th class="left">
                                    <div class="d-flex align-items-center gap-2">
                                        <span>Deposit Date</span>
                                        <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                            class="fa-solid @if ($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                                    </div>
                                </th>
                                <th>Credit Date</th>
                                <th>Store ID</th>
                                <th>Retek Code</th>
                                <th>Collection Bank</th>
                                <th>Merchant Code</th>
                                <th>TID</th>
                                <th style="text-align: right !important">Deposit Amount</th>
                                <th style="text-align: right !important">MSF</th>
                                <th style="text-align: right !important">GST</th>
                                <th style="text-align: right !important">Net Amount</th>
                            </tr>
                        @endif

                        @if ($activeTab == 'all-wallet-mis')
                            <tr class="headers">
                                <th class="left">
                                    <div class="d-flex align-items-center gap-2">
                                        <span>Deposit Date</span>
                                        <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                            class="fa-solid @if ($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                                    </div>
                                </th>
                                <th>Credit Date</th>
                                <th>Store ID</th>
                                <th>Retek Code</th>
                                <th>Collection Bank</th>
                                <th>TID</th>
                                <th style="text-align: right !important">Deposit Amount</th>
                                <th style="text-align: right !important">Fee</th>
                                <th style="text-align: right !important">GST</th>
                                <th style="text-align: right !important">Net Amount</th>
                                <th>Bank Ref / UTR No</th>
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
                                    <td>{{ !$data['depositDt'] ? '' : Carbon\Carbon::parse($data['depositDt'])->format('d-m-Y') }}
                                    </td>
                                    <td>{{ !$data['crDt'] ? '' : Carbon\Carbon::parse($data['crDt'])->format('d-m-Y') }}
                                    </td>
                                    <td>{{ $data['storeID'] }}</td>
                                    <td>{{ $data['retekCode'] }}</td>
                                    <td>{{ $data['locationName'] }}</td>
                                    <td>{{ $data['depositThrough'] }}</td>
                                    <td>{{ $data['colBank'] }}</td>
                                    <td>{{ $data['depostSlipNo'] }}</td>
                                    <td style="text-align: right !important">
                                        {{ number_format($data['depositAmount'], 2) }}</td>
                                </tr>
                            @endforeach

                            {{-- Card --}}
                        @elseif($activeTab == 'all-card-mis')
                            @foreach ($mis as $main)
                                @php
                                    $data = (array) $main;
                                @endphp
                                <tr>
                                    <td>{{ !$data['depositDt'] ? '' : Carbon\Carbon::parse($data['depositDt'])->format('d-m-Y') }}
                                    </td>
                                    <td>{{ !$data['creditDt'] ? '' : Carbon\Carbon::parse($data['creditDt'])->format('d-m-Y') }}
                                    </td>
                                    <td>{{ $data['storeID'] }}</td>
                                    <td>{{ $data['retekCode'] }}</td>
                                    <td>{{ $data['colBank'] }}</td>
                                    {{-- <td>{{ $data['accountNo'] }}</td> --}}
                                    <td>{{ $data['merCode'] }}</td>
                                    <td>{{ $data['tid'] }}</td>
                                    <td style="text-align: right !important">
                                        {{ number_format($data['depositAmount'], 2) }}</td>
                                    <td style="text-align: right !important">{{ number_format($data['msfComm'], 2) }}
                                    </td>
                                    <td style="text-align: right !important">{{ number_format($data['gstTotal'], 2) }}
                                    </td>
                                    <td style="text-align: right !important">
                                        {{ number_format($data['netAmount'], 2) }}</td>
                                </tr>
                            @endforeach

                            {{-- UPI --}}
                        @elseif($activeTab == 'all-upi-mis')
                            @foreach ($mis as $main)
                                @php
                                    $data = (array) $main;
                                @endphp
                                <tr>
                                    <td>{{ !$data['depositDt'] ? '' : Carbon\Carbon::parse($data['depositDt'])->format('d-m-Y') }}
                                    </td>
                                    <td>{{ !$data['creditDt'] ? '' : Carbon\Carbon::parse($data['creditDt'])->format('d-m-Y') }}
                                    </td>
                                    <td>{{ $data['storeID'] }}</td>
                                    <td>{{ $data['retekCode'] }}</td>
                                    <td>{{ $data['colBank'] }}</td>
                                    {{-- <td>{{ $data['accountNo'] }}</td> --}}
                                    <td>{{ $data['merCode'] }}</td>
                                    <td>{{ $data['tid'] }}</td>
                                    <td style="text-align: right !important">
                                        {{ number_format($data['depositAmount'], 2) }}</td>
                                    <td style="text-align: right !important">{{ number_format($data['msfComm'], 2) }}
                                    </td>
                                    <td style="text-align: right !important">{{ number_format($data['gstTotal'], 2) }}
                                    </td>
                                    <td style="text-align: right !important">
                                        {{ number_format($data['netAmount'], 2) }}</td>
                                </tr>
                            @endforeach

                            {{-- Wallet --}}
                        @elseif($activeTab == 'all-wallet-mis')
                            @foreach ($mis as $main)
                                @php
                                    $data = (array) $main;
                                @endphp
                                <tr>
                                    <td>{{ !$data['depositDt'] ? '' : Carbon\Carbon::parse($data['depositDt'])->format('d-m-Y') }}
                                    </td>
                                    <td>{{ !$data['creditDt'] ? '' : Carbon\Carbon::parse($data['creditDt'])->format('d-m-Y') }}
                                    </td>
                                    <td>{{ $data['storeID'] }}</td>
                                    <td>{{ $data['retekCode'] }}</td>
                                    <td>{{ $data['colBank'] }}</td>
                                    <td>{{ $data['tid'] }}</td>
                                    <td style="text-align: right !important">
                                        {{ number_format($data['depositAmount'], 2) }}</td>
                                    <td style="text-align: right !important">{{ number_format($data['msfComm'], 2) }}
                                    </td>
                                    <td style="text-align: right !important">{{ number_format($data['gstTotal'], 2) }}
                                    </td>
                                    <td style="text-align: right !important">
                                        {{ number_format($data['netAmount'], 2) }}</td>
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

        function initializeTidFilter() {
            let activeTab = @json($activeTab ?? '');
            const tidFilter = $j('#tid_filter_dropdown').select2({
                placeholder: 'SELECT A TID',
                minimumInputLength: 3,
                ajax: {
                    url: '{{ route('tidSearch') }}',
                    dataType: 'json',
                    delay: 250,
                    data: params => ({
                        search: params.term,
                        activeTab: activeTab,
                    }),
                    processResults: function(data) {
                        return {
                            results: data.results ? data.results : []
                        };
                    },
                },
            });

            $j('#clear_tid_btn').on('click', function() {
                $j('#tid_filter_dropdown').val(null).trigger('change');
                Livewire.emit('updateTid', ''); // Emit empty string when clearing
                $j(this).hide();
            }).hide();

            tidFilter.on('select2:select', function(event) {
                const selectedTid = event.target.value;
                // Emit the selected tid to Livewire component
                Livewire.emit('updateTid', selectedTid);
                $j('#clear_tid_btn').show();
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initializeTidFilter();
        });
    </script>
    <style>
        .clear-btn {
            background: transparent;
            color: rgb(94, 58, 58);
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            font-size: 24px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 33%;
            right: 20px;
            transform: translateY(-50%);
            z-index: 1;
            cursor: pointer;
        }

        .clear-btn:hover {
            color: #ff0000;
        }
    </style>
</div>
