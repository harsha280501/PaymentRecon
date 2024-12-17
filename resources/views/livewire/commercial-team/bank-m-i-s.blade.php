<div x-data class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
    <section id="bankmis">
        <div class="row">
            <div class="col-lg-12 mb-2">
            </div>
        </div>

        <div class="row mb-2">

            <div class="col-lg-9">
                <ul class="nav nav-tabs justify-content-start" role="tablist">

                    <li class="nav-item">
                        <a wire:click="switchTab('all-cash-mis')"
                            class="nav-link @if($activeTab === 'all-cash-mis') active @endif" data-bs-toggle="
                            tab" data-bs-target="#idfc" href="#" role="tab">
                            <img style="width: 30px; object-fit: cover" src="{{ asset('assets/images/cash.png') }}" />
                            CASH MIS
                        </a>
                    </li>

                    <li class="nav-item">
                        <a wire:click="switchTab('all-card-mis')"
                            class="nav-link @if($activeTab === 'all-card-mis') active @endif" data-bs-toggle="
                            tab" data-bs-target="#idfc" href="#" role="tab">
                            <img style="width: 30px; object-fit: cover; mix-blend-mode: multiply !important;"
                                src="{{ asset('assets/images/card.png') }}" />
                            CARD MIS
                        </a>
                    </li>


                    <li class="nav-item">
                        <a wire:click="switchTab('all-wallet-mis')"
                            class="nav-link @if($activeTab === 'all-wallet-mis') active @endif" data-bs-toggle="
                            tab" data-bs-target="#idfc" href="#" role="tab">
                            <img style="width: 30px; object-fit: cover" src="{{ asset('assets/images/wallet.png') }}" />
                            WALLET MIS
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row" style="border-top: 2px solid lightgray; ">
            <div x-data='{
                    from: $wire.from,
                    to: $wire.to,
                    clear() {
                        this.from = "";
                        this.to = "";
                    }
                }' class="my-2 d-flex d-flex-mob gap-2 align-items-center">
                <div class="@if(!$filtering) d-none @endif">
                    <button @click="clear()" wire:click="back"
                        style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
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
                    @if ($activeTab == 'all-cash-mis')
                    <x-filters.stores :stores="$cash_stores" />

                    @elseif($activeTab == 'all-card-mis')
                    <x-filters.stores :stores="$card_stores" />

                    @elseif($activeTab == 'all-wallet-mis')
                    <x-filters.stores :stores="$wallet_stores" />
                    @endif
                </div>

                <div class="mt-2 w-mob-100">
                    <x-filters.months :months="$_months" />
                </div>

                <form id="main-form-submit" wire:ignore id="" class="d-flex d-flex-mob gap-2 w-mob-100"
                    style="flex: 1;">
                    <div>
                        <input x-model="from" class="w-mob-100" id="startDate"
                            style="border: 1px solid #00000015 ; border-radius: 0px; outline: none; font-size: .9em; color: #000; padding: .4em; font-family: inherit"
                            type="date">
                    </div>
                    <div>
                        <input x-model="to" class="w-mob-100" id="endDate"
                            style="border: 1px solid #00000015 ; border-radius: 0px; outline: none; font-size: .9em; color: #000 ; padding: .4em; font-family: inherit"
                            type="date">
                    </div>
                    <button @click.prevent="$wire.filterDates({start: from, end: to})" class="btn-mob w-mob-100"
                        style="border: none; outline: none; background: #dbdbdbe7; padding: .3em .5em; border-radius: 2px;"
                        type="submit"><i class="fa fa-search"></i></button>
                </form>

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
                                    <span>Sales Date</span>
                                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                        class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                                </div>
                            </th>
                            <th>Deposit Date</th>
                            <th>Store ID</th>
                            <th>Retek Code</th>
                            <th>Pick Up Location</th>
                            <th>Collection Bank</th>
                            <th>Slip Number</th>
                            <th>Deposit Amount</th>
                        </tr>
                        @endif

                        @if($activeTab == 'all-card-mis')
                        <tr class="headers">

                            <th class="left">
                                <div class="d-flex align-items-center gap-2">
                                    <span>Sales Date</span>
                                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                        class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                                </div>
                            </th>
                            <th>Deposit Date</th>
                            <th>Store ID</th>
                            <th>Retek Code</th>
                            <th>Collection Bank</th>
                            <th>Merchant Code</th>
                            <th>Terminal Number</th>
                            <th>Deposit Amount</th>

                        </tr>
                        @endif

                        @if($activeTab == 'all-wallet-mis')
                        <tr class="headers">
                            <th class="left">
                                <div class="d-flex align-items-center gap-2">
                                    <span>Sales Date</span>
                                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                        class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                                </div>
                            </th>
                            <th>Deposit Date</th>
                            <th>Store ID</th>
                            <th>Retek Code</th>
                            <th>Collection Bank</th>
                            <th>Terminal ID</th>
                            <th>Merchant ID</th>
                            <th>Deposit Amount</th>

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
                            <td>{{ Carbon\Carbon::parse($data["crDt"])->format('d-m-Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($data["depositDt"])->format('d-m-Y') }}</td>
                            <td>{{ $data["storeID"] }}</td>
                            <td>{{ $data["retekCode"] }}</td>
                            <td>{{ $data["locationName"] }}</td>
                            <td>{{ $data["colBank"] }}</td>
                            <td>{{ $data["depostSlipNo"] }}</td>
                            <td>{{ number_format($data['depositAmount'] ,2) }}</td>
                        </tr>
                        @endforeach
                        @elseif($activeTab == 'all-card-mis')

                        @foreach ($mis as $main)
                        @php
                        $data = (array) $main
                        @endphp
                        <tr>
                            <td>{{ Carbon\Carbon::parse($data["creditDt"])->format('d-m-Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($data["depositDt"])->format('d-m-Y') }}</td>
                            <td>{{ $data['storeID'] }}</td>
                            <td>{{ $data['retekCode'] }}</td>
                            <td>{{ $data['colBank'] }}</td>
                            {{-- <td>{{ $data['accountNo'] }}</td> --}}
                            <td>{{ $data['merCode'] }}</td>
                            <td>{{ $data['tid'] }}</td>
                            <td>{{ number_format($data['depositAmount'] ,2) }}</td>

                        </tr>
                        @endforeach

                        @elseif($activeTab == 'all-wallet-mis')

                        @foreach ($mis as $main)
                        @php
                        $data = (array) $main
                        @endphp
                        <tr>
                            <td>{{ Carbon\Carbon::parse($data["creditDt"])->format('d-m-Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($data["depositDt"])->format('d-m-Y') }}</td>
                            <td>{{ $data['storeID'] }}</td>
                            <td>{{ $data['retekCode'] }}</td>
                            <td>{{ $data['colBank'] }}</td>
                            <td>{{ $data['tid'] }}</td>
                            <td>{{ $data['mid'] }}</td>
                            <td>{{ number_format($data['depositAmount'] ,2) }}</td>

                        </tr>
                        @endforeach
                        @else

                        {{-- If does not match the scenerio --}}
                        <span class="text-center small">This bank does not have the requested
                            payment type</span>

                        {{-- End --}}
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