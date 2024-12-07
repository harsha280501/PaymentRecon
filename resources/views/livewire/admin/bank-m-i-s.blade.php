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
                        <a wire:click="switchTab('all-cash-mis')" class="nav-link @if($activeTab === 'all-cash-mis') active @endif" data-bs-toggle="
                            tab" data-bs-target="#idfc" href="#" role="tab">
                            <img style="width: 30px; object-fit: cover" src="{{ asset('assets/images/cash.png') }}" />
                            CASH MIS
                        </a>
                    </li>

                    <li class="nav-item">
                        <a wire:click="switchTab('all-card-mis')" class="nav-link @if($activeTab === 'all-card-mis') active @endif" data-bs-toggle="
                            tab" data-bs-target="#idfc" href="#" role="tab">
                            <img style="width: 30px; object-fit: cover; mix-blend-mode: multiply !important;" src="{{ asset('assets/images/card.png') }}" />
                            CARD MIS
                        </a>
                    </li>


                    <li class="nav-item">
                        <a wire:click="switchTab('all-wallet-mis')" class="nav-link @if($activeTab === 'all-wallet-mis') active @endif" data-bs-toggle="
                            tab" data-bs-target="#idfc" href="#" role="tab">
                            <img style="width: 30px; object-fit: cover" src="{{ asset('assets/images/wallet.png') }}" />
                            WALLET MIS
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row @if(!in_array($activeTab, $implementedFilters)) d-none @endif" style="border-top: 2px solid lightgray; ">

            <div x-data='{
                    from: $wire.from,
                    to: $wire.to,
                    clear() {
                        this.from = "";
                        this.to = "";
                    }
                }' class="my-2 d-flex d-flex-mob gap-2 align-items-center">
                <div class="@if(!$filtering) d-none @endif">
                    <button @click="clear()" wire:click="back" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>


                <div wire:ignore class="mt-1" x-data="{
                        cash: ['HDFC', 'AXIS Cash', 'ICICI Cash', 'SBI Cash', 'IDFC'],
                        card: ['HDFC Card', 'HDFC UPI', 'ICICI Card', 'SBI Card','Amex Card'],
                        wallet: ['WALLET PAYTM', 'WALLET PHONEPAY'],
                }">
                    <template x-if="$wire.activeTab == 'all-cash-mis'">
                        <div class="select mb-1" style="width: 200px">
                            <select x-on:change="$wire.bankName = $event.target.value" id="select22-dropdown" class="">
                                <option selected disabled value="" class="">SELECT BANK NAME</option>
                                <template x-for="cashItem in cash">
                                    <option :value="cashItem" x-text="cashItem" class=""></option>
                                </template>
                            </select>
                        </div>
                    </template>
                    <template x-if="$wire.activeTab == 'all-card-mis'">
                        <div class="select mb-1" style="width: 200px">
                            <select x-on:change="$wire.bankName = $event.target.value" id="select22-dropdown">
                                <option selected disabled value="">SELECT BANK NAME</option>
                                <template x-for="cashItem in card">
                                    <option :value="cashItem" x-text="cashItem"></option>
                                </template>
                            </select>
                        </div>
                    </template>
                    <template x-if="$wire.activeTab == 'all-wallet-mis'">
                        <div class="select mb-1" style="width: 200px">
                            <select x-on:change="$wire.bankName = $event.target.value" wire:model="bankName" id="select22-dropdown">
                                <option selected disabled value="">SELECT BANK NAME</option>
                                <template x-for="cashItem in wallet">
                                    <option :value="cashItem" x-text="cashItem"></option>
                                </template>
                            </select>
                        </div>
                    </template>
                </div>



                <form id="main-form-submit" wire:ignore id="" class="d-flex d-flex-mob gap-2" style="flex: 1;">
                    <div>
                        <input x-model="from" id="startDate" style="border: 1px solid #00000015 ; border-radius: 0px; outline: none; font-size: .9em; color: #000; padding: .4em; font-family: inherit" type="date">
                    </div>
                    <div>
                        <input x-model="to" id="endDate" style="border: 1px solid #00000015 ; border-radius: 0px; outline: none; font-size: .9em; color: #000 ; padding: .4em; font-family: inherit" type="date">
                    </div>
                    <button @click.prevent="$wire.filterDates({start: from, end: to})" class="btn-mob" style="border: none; outline: none; background: #dbdbdbe7; padding: .3em .5em; border-radius: 2px;" type="submit"><i class="fa fa-search"></i></button>
                </form>


                {{-- <div class="">
                    <div class="btn-group export1">
                        <button type="button" class="dropdown-toggle d-flex btn mb-1" style="background: #e7e7e7; color: #000;" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Export
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <a href="#" class="dropdown-item p-1" style="font-size: 1em" wire:click.prevent="export">Export as XLSX</a>
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <x-scrollable.scrollable :dataset="$mis">
                    <x-scrollable.scroll-head>
                        @if($activeTab == 'all-cash-mis')
                        <tr class="headers">
                            <th>Deposit Date</th>
                            <th>Credit Date</th>
                            <th>Store ID</th>
                            <th>Reteck Code</th>
                            <th>Collection Bank</th>
                            <th>Pick Up Location</th>
                            <th>Slip Number</th>
                            <th>Deposit Amount</th>
                        </tr>
                        @endif

                        @if($activeTab == 'all-card-mis')
                        <tr class="headers">
                            <th>Deposit Date</th>
                            <th>Credit Date</th>
                            <th>Store ID</th>
                            <th>Reteck Code</th>
                            <th>Collection Bank</th>
                            {{-- <th>Account Number</th> --}}
                            <th>Merchant Code</th>
                            <th>Terminal Number</th>
                            <th>Deposit Amount</th>
                            <th>MSF</th>
                            <th>GST</th>
                            <th>Net Amount</th>
                        </tr>
                        @endif

                        @if($activeTab == 'all-wallet-mis')
                        <tr class="headers">
                            <th>Deposit Date</th>
                            <th>Credit Date</th>
                            <th>Store ID</th>
                            <th>Reteck Code</th>
                            <th>Collection Bank</th>
                            <th>Terminal ID</th>
                            <th>MIS</th>
                            <th>Deposit Amount</th>
                            <th>Fee</th>
                            <th>GST</th>
                            <th>Net Amount</th>
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
                            <td>{{ Carbon\Carbon::parse($data["depositDt"])->format('d-m-Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($data["crDt"])->format('d-m-Y') }}</td>
                            <td>{{ $data["storeID"] }}</td>
                            <td>{{ $data["retekCode"] }}</td>
                            <td>{{ $data["colBank"] }}</td>
                            <td>{{ $data["locationName"] }}</td>
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
                            <td>{{ Carbon\Carbon::parse($data["depositDt"])->format('d-m-Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($data["creditDt"])->format('d-m-Y') }}</td>
                            <td>{{ $data['storeID'] }}</td>
                            <td>{{ $data['retekCode'] }}</td>
                            <td>{{ $data['colBank'] }}</td>
                            {{-- <td>{{ $data['accountNo'] }}</td> --}}
                            <td>{{ $data['merCode'] }}</td>
                            <td>{{ $data['tid'] }}</td>
                            <td>{{ number_format($data['depositAmount'] ,2) }}</td>
                            <td>{{ number_format($data['msfComm'] ,2) }}</td>
                            <td>{{ number_format($data['gstTotal'] ,2) }}</td>
                            <td>{{ number_format($data['netAmount'] ,2) }}</td>
                        </tr>
                        @endforeach

                        @elseif($activeTab == 'all-wallet-mis')

                        @foreach ($mis as $main)
                        @php
                        $data = (array) $main
                        @endphp
                        <tr>
                            <td>{{ Carbon\Carbon::parse($data["depositDt"])->format('d-m-Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($data["creditDt"])->format('d-m-Y') }}</td>
                            <td>{{ $data['storeID'] }}</td>
                            <td>{{ $data['retekCode'] }}</td>
                            <td>{{ $data['colBank'] }}</td>
                            <td>{{ $data['tid'] }}</td>
                            <td>{{ $data['mid'] }}</td>
                            <td>{{ number_format($data['depositAmount'] ,2) }}</td>
                            <td>{{ number_format($data['msfComm'] ,2) }}</td>
                            <td>{{ number_format($data['gstTotal'] ,2) }}</td>
                            <td>{{ number_format($data['netAmount'] ,2) }}</td>
                            <td>{{ $data['bankRrefORutrNo'] }}</td>
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
