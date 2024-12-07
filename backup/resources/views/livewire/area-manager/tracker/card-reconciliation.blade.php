<div>
    {{-- Filters  --}}
    <div class="row">
        <div class="col-lg-12">
            {{-- Tabs  --}}
            <div class="row mb-4">
                <div class="col-lg-9">
                    <ul class="nav nav-tabs justify-content-start" role="tablist">
                        <li class="nav-item">
                            <a wire:click="switchTab('store2card')" class="nav-link @if($activeTab === 'store2card') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#hdfc" href="#" role="tab" style="font-size: .8em !important">STORE TO CARD MIS
                            </a>
                        </li>
                        <li class="nav-item">
                            <a wire:click="switchTab('card2bank')" class="nav-link @if($activeTab === 'card2bank') active tab-active @endif" data-bs-toggle="
                            tab" data-bs-target="#axis" href="#" role="tab" style="font-size: .8em !important">
                                CARD MIS TO BANK STATEMENT
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 d-flex align-items-center justify-content-end">
                    <div class="btn-group mb-1">
                    </div>
                </div>
            </div>

            {{-- Filters  for first tab --}}
            <div class="d-flex" style="gap: .5em; flex-wrap: wrap; @if($activeTab !=='store2card' ) display: none !important @endif">

                {{-- Back Button  --}}
                <div style="display:@if ($filtering) unset @else none @endif" class="">
                    <button wire:click="back" style="background: transparent; outline: none; border: none; padding: .5em .6em; font-size: 1em">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                </div>

                {{-- Brand filter  --}}
                <div class="">
                    <div wire:ignore style="width: 160px">
                        <select wire:ignore id="select2-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 10px !important; width: 100% !important">
                            <option selected disabled value="" class="dropdown-item">SELECT BRAND NAME</option>
                            <option value="" class="dropdown-item">All</option>

                            @foreach($brands as $item)

                            @php
                            $item = (array) $item;
                            @endphp

                            @if($item['Brand Name'] != '')
                            <option value="{{ $item['Brand Name'] }}">{{ $item["Brand Name"] }}</option>
                            @endif

                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Deposit Date  --}}
                <div class="">
                    <div wire:ignore style="width: 160px">
                        <select wire:ignore id="select222-dropdown" style="min-width: 130px; width: 160px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important;  min-width: 130px; width: 170px">

                            <option selected disabled value="" class="dropdown-item">SELECT TRANSACTION DATE</option>
                            <option value="" class="dropdown-item">ALL</option>

                            {{-- <option class="dropdown-list" value="">ALL</option>  --}}
                            @foreach($deptDt as $item)

                            @php
                            $item = (array) $item;
                            @endphp

                            @if($item['transactionDate'] != '')
                            <option class="dropdown-list" value="{{ $item['transactionDate'] }}">{{ $item["transactionDate"] }}</option>
                            @endif

                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Select data by bankNmae  --}}
                <div class="">
                    <div style="width: 150px" wire:ignore>
                        <select id="select2222-dropdown" style="width: 150px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">

                            <option selected disabled value="" class="dropdown-item">SELECT BANK NAME</option>
                            <option value="" class="dropdown-item">ALL</option>

                            @foreach($mainBankNames as $item)

                            @php
                            $item = (array) $item;
                            @endphp

                            @if($item['collectionBank'] != '')
                            <option class="dropdown-list" value="{{ $item['collectionBank'] }}">{{ $item["collectionBank"] }}</option>
                            @endif

                            @endforeach
                        </select>
                    </div>
                </div>


                {{-- Match status  --}}
                <div class="">
                    <div style="width: 160px" wire:ignore>
                        <select id="matchStatus" wire:model="matchStatus" style="width: 160px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">
                            <option selected value="" class="dropdown-item">SELECT MATCHED STATUS</option>
                            <option value="Matched" class="dropdown-item">Matched</option>
                            <option value="Not Matched" class="dropdown-item">Not Matched</option>
                        </select>
                    </div>
                </div>

                {{-- Search filter  --}}
                <div class="">
                    <div>
                        <form wire:ignore class="form d-flex gap-2" style="width: 160px" id="card-reconcilation-search-form">
                            @csrf
                            <input id="search" value="{{ $searchString }}" type="text" placeholder="Search..." class="form-control" style="height: 3.4vh !important;" />
                            <button class="" style="outline: none; border: none; padding: 0 .5em; border-radius: 4px">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>


                {{-- Date Filter  --}}
                <div>
                    <div wire:ignore>
                        <form id="tracker-card-recon-search-form" style="width: 170px" class="col-lg-7 d-flex gap-2">
                            <div>
                                <input id="startDate" style="border: 1px solid #0000003f ; border-radius: 4px; outline: none; font-size: .9em; color: #000; padding: .4em; font-family: inherit" type="date">
                            </div>
                            <div>
                                <input id="endDate" style="border: 1px solid #0000003f ; border-radius: 4px; outline: none; font-size: .9em; color: #000 ; padding: .4em; font-family: inherit" type="date">
                            </div>
                            <button class="" style="outline: none; border: none; padding: 0 .5em; border-radius: 4px">
                                <i class="fa fa-search"></i>
                            </button>

                        </form>
                    </div>
                </div>
            </div>

            {{-- Filters for second tab  --}}
            <div>
                <div class="d-flex gap-2" style="@if($activeTab !== 'card2bank') display: none !important @endif">

                    {{-- Back button  --}}
                    <div style="display:@if ($filtering) unset @else none @endif" class="">
                        <button wire:click="back" style="background: transparent; outline: none; border: none; padding: .5em 1em; font-size: 1em">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                    </div>

                    {{-- BankName filters   --}}
                    <div class="">
                        <div wire:ignore>
                            <select wire:model="selectedBank" id="select3-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 10px !important; width: 220px">
                                <option disabled selected class="dropdown-item">SELECT BANK NAME</option>
                                <option value="" class="dropdown-item">ALL</option>

                                @foreach($bankNames as $item)

                                @php
                                $item = (array) $item;
                                @endphp

                                @if($item['colBank'] != '')
                                <option value="{{ $item['colBank'] }}">{{ $item["colBank"] }}</option>
                                @endif

                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Match filter  --}}
                    <div class="">
                        <div style="width: 220px" wire:ignore>
                            <select id="matchStatus2" wire:model="matchStatus" style="width: 220px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">
                                <option selected value="" class="dropdown-item">SELECT MATCHED STATUS</option>
                                <option value="Matched" class="dropdown-item">Matched</option>
                                <option value="Not Matched" class="dropdown-item">Not Matched</option>
                            </select>
                        </div>
                    </div>

                    {{-- Search filter  --}}
                    <div class="">
                        <div>
                            <form class="form d-flex gap-2" style="width: 200px" id="cash2bank-reconcilation-search-form">
                                @csrf
                                <input id="search" type="text" placeholder="Search..." value="{{ $searchString }}" class="form-control" style="height: 3.4vh !important;" />
                                <button class="" style="outline: none; border: none; padding: 0 .5em; border-radius: 4px">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Date  filter  --}}
                    <div>
                        <div wire:ignore>
                            <form id="tracker-cash2bank-recon-search-form" class=" d-flex gap-2">
                                <div>
                                    <input id="startDate" value="{{ $startDate }}" style="border: 1px solid #0000003f ; border-radius: 4px; outline: none; font-size: .9em; color: #000; padding: .4em; font-family: inherit" type="date">
                                </div>
                                <div>
                                    <input id="endDate" value="{{ $endDate }}" style="border: 1px solid #0000003f ; border-radius: 4px; outline: none; font-size: .9em; color: #000 ; padding: .4em; font-family: inherit" type="date">
                                </div>

                                <button class="" style="outline: none; border: none; padding: 0 .5em; border-radius: 4px">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="d-flex justify-content-center gap-4 mt-2">
        <p style="font-size: 1em">Total Record: <span style="color: black; font-weight: 900;">{{ isset($cashRecons[0]->TotalCount) ? $cashRecons[0]->TotalCount : 0 }}</span></p>
        <p style="font-size: 1em">Matched: <span style="color: teal; font-weight: 900;">{{ isset($cashRecons[0]->matchedCount) ? $cashRecons[0]->matchedCount : 0 }}</span></p>
        <p style="font-size: 1em">Not Matched: <span style="color: lightcoral; font-weight: 900;">{{ isset($cashRecons[0]->notMatchedCount) ? $cashRecons[0]->notMatchedCount : 0 }}</span></p>
    </div>

    {{-- Display  --}}
    <div class="col-lg-12">
        {{-- Main sales table --}}
        <div class="w-100" style="overflow-x: scroll">

            {{-- Table --}}
            <table class="table table-responsive table-info">
                <thead>
                    @if($activeTab == 'store2card')
                    <tr>
                        <th class="left">Transaction Date</th>
                        <th class="left">STORE ID</th>
                        <th class="left">RETEK CODE</th>
                        <th class="left">BRAND</th>
                        <th class="left">Collection Bank</th>
                        <th class="left">Status</th>
                        <th class="left">Deposit Date</th>
                        <th class="left">CARD SALES</th>
                        <th class="left">Deposit Amount</th>
                        <th class="left">Diff Sale Deposit</th>
                    </tr>
                    @endif

                    @if($activeTab == 'card2bank')
                    <tr>
                        <th class="left">STORE ID</th>
                        <th class="left">RETEK CODE</th>
                        <th class="left">COLBANK</th>
                        <th class="left">Status</th>
                        <th class="left">Deposit Date</th>
                        <th class="left">Credit Date</th>
                        <th class="left">Bank Deposit Date</th>
                        <th class="left">MSF Commission</th>
                        <th class="left">GST Total</th>
                        <th class="left">Net Amount</th>
                        <th class="left">Credit Amount</th>
                        <th class="left">Difference Sales Deposit</th>
                    </tr>

                    @endif

                </thead>
                <tbody wire:loading.class='d-none'>

                    @if($activeTab == 'store2card')
                    @foreach ($cashRecons as $data)
                    <tr>
                        <td class="right"> {{ $data->transactionDate }} </td>
                        <td class="left"> {{ $data->storeID }} </td>
                        <td class="right"> {{ $data->retekCode }} </td>
                        <td class="right"> {{ $data->brand }} </td>
                        <td class="right"> {{ $data->collectionBank }} </td>
                        <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>
                        <td class="right"> {{ $data->depositDt }} </td>
                        <td class="left"> {{ $data->cardSale }} </td>
                        <td class="right"> {{ $data->depositAmount }} </td>
                        <td class="right"> {{ $data->diffSaleDeposit }} </td>
                    </tr>
                    @endforeach

                    @elseif ($activeTab == 'card2bank')
                    @foreach ($cashRecons as $data)
                    <tr>
                        <td class="right"> {{ $data->storeID }} </td>
                        <td class="left"> {{ $data->retekCode }} </td>
                        <td class="right"> {{ $data->colBank }} </td>
                        <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>
                        <td class="right"> {{ $data->depositDt }} </td>
                        <td class="right"> {{ $data->crDt }} </td>
                        <td class="right"> {{ $data->bankDepositDt }} </td>
                        <td class="right"> {{ $data->msfComm }} </td>
                        <td class="right"> {{ $data->gstTotal }} </td>
                        <td class="right"> {{ $data->netAmount }} </td>
                        <td class="right"> {{ $data->creditAmount }} </td>
                        <td class="right"> {{ $data->diffSaleDeposit }} </td>
                    </tr>
                    @endforeach



                    @endif
                </tbody>
            </table>

            {{-- Show no data available --}}
            @if($cashRecons->count() == 0)
            <p class="showEmptyAlertData">No data available</p>
            @endif

            {{-- Loader  --}}
            <div wire:loading.class='show-loading-spinner' class="loading-spinner">
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span>Loading</span>
            </div>

        </div>

        {{-- Pagination  --}}
        <div wire:loading.class="d-none" class="mt-4">
            {{ in_array($activeTab, $hasPagination) ?  $cashRecons->links() : '' }}
        </div>

    </div>

    {{-- filter scripts  --}}
    <script>
        const filterIDs = ['select2-dropdown', 'select22-dropdown', 'select222-dropdown', 'startDate', 'endDate'];

        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {

            $j('.searchField').select2();


            $j('#select2-dropdown').on('change', function(e) {
                @this.set('brand', e.target.value);
            });


            $j('#select22-dropdown').on('change', function(e) {
                @this.set('mainStore', e.target.value);
            });


            $j('#select222-dropdown').on('change', function(e) {
                @this.set('mainDeptDT', e.target.value);
            });


            $j('#select3-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('selectedBank', e.target.value == "" ? null : e.target.value);
            });

            $j('#matchStatus').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('matchStatus', e.target.value);
            });


            $j('#matchStatus2').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('matchStatus', e.target.value);
            });


            $j('#select2222-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('searchBankName', e.target.value);
            });

        });

    </script>

</div>
