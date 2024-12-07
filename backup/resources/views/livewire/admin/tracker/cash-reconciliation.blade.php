<div>
    <div class="row">
        <div class="col-lg-12 ">
            <div class="row mb-4">
                <div class="col-lg-9">
                    <ul class="nav nav-tabs justify-content-start" role="tablist">
                        <li class="nav-item">
                            <a wire:click="switchTab('store2cash')" class="nav-link @if($activeTab === 'store2cash') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#hdfc" role="tab" style="font-size: .8em !important" href="#">Store To CASH MIS
                            </a>
                        </li>
                        <li class="nav-item">
                            <a wire:click="switchTab('cash2bank')" class="nav-link @if($activeTab === 'cash2bank') active tab-active @endif" data-bs-toggle="
                            tab" data-bs-target="#axis" role="tab" style="font-size: .8em !important" href="#">
                                CASH MIS to Bank Statement
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 d-flex align-items-center justify-content-end">
                    <div class="btn-group mb-1">
                    </div>
                </div>
            </div>

            <div>

                <div class="d-flex gap-2" style="@if($activeTab !== 'store2cash') display: none !important @endif">
                    <div style="display:@if ($filtering) unset @else none @endif" class="">
                        <button wire:click="back" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                    </div>

                    <div class="">
                        <div wire:ignore>
                            <select wire:model="brand" id="select2-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 10px !important; width: 220px">
                                <option disabled selected class="dropdown-item">SELECT BRAND NAME</option>
                                <option value="" class="dropdown-item">ALL</option>

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


                    <div class="">
                        <div style="width: 160px" wire:ignore>
                            <select id="matchStatus" wire:model="matchStatus" style="width: 160px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">
                                <option selected value="" class="dropdown-item">SELECT MATCHED STATUS</option>
                                <option value="Matched" class="dropdown-item">Matched</option>
                                <option value="Not Matched" class="dropdown-item">Not Matched</option>
                            </select>
                        </div>
                    </div>

                    <div class="">
                        <div>
                            <form class="form d-flex gap-2" style="width: 150px" id="cash-reconcilation-search-form">
                                @csrf
                                <input id="search" type="text" placeholder="Search..." value="{{ $searchString }}" class="form-control" style="height: 3.4vh !important;" />
                                <button class="" style="outline: none; border: none; padding: 0 .5em; border-radius: 4px">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div>
                        <div wire:ignore>
                            <form id="tracker-cash-recon-search-form" class="d-flex gap-1">
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


            {{-- cash to Bank  --}}
            <div>
                <div class="d-flex gap-2" style="@if($activeTab !== 'cash2bank') display: none !important @endif">
                    <div style="display:@if ($filtering) unset @else none @endif" class="">
                        <button wire:click="back" style="background: transparent; outline: none; border: none; padding: .5em 1em; font-size: 1em">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                    </div>

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

                    <div class="">
                        <div style="width: 220px" wire:ignore>
                            <select id="matchStatus2" wire:model="matchStatus" style="width: 220px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">
                                <option selected value="" class="dropdown-item">SELECT MATCHED STATUS</option>
                                <option value="Matched" class="dropdown-item">Matched</option>
                                <option value="Not Matched" class="dropdown-item">Not Matched</option>
                            </select>
                        </div>
                    </div>

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

    <div class="col-lg-12">
        {{-- Main sales table --}}
        <div class="w-100" style="overflow-x: scroll">
            <table class="table table-responsive table-info">
                <thead>

                    @if($activeTab == 'store2cash')
                    <tr>
                        <th class="left">Exp Deposit Date</th>
                        <th class="right">STORE ID</th>
                        <th class="right">RETAK CODE</th>
                        <th class="left">Brand Code</th>
                        <th class="right">Reco Status</th>
                        <th class="right">Pickup Bank</th>
                        <th class="right">Bank Cash Pickup Date</th>
                        <th class="right">Deposit Amount</th>
                        <th class="right">Store Cash Sale</th>
                        <th class="right">Difference</th>
                    </tr>
                    @endif

                    @if($activeTab == 'cash2bank')
                    <tr>
                        <th class="left">STORE ID</th>
                        <th class="right">RETEK CODE</th>
                        <th class="right">COL BANK</th>
                        <th class="left">Location</th>
                        <th class="right">Status</th>
                        <th class="right">Credit Date</th>
                        <th class="right">Deposit Date</th>
                        <th class="right">Depost Slip No</th>
                        <th class="right">Deposit Amount</th>
                        <th class="right">Credit Amount</th>
                        {{-- <th class="right">Reference No.</th>  --}}
                        <th class="right">Difference Sale Deposit</th>
                    </tr>
                    @endif

                </thead>
                <tbody wire:loading.class='d-none'>
                    @if($activeTab == 'store2cash')

                    @foreach ($cashRecons as $data)
                    <tr>
                        <td class="left"> {{ $data->expDepositDate }} </td>
                        <td class="right"> {{ $data->storeID }} </td>
                        <td class="right"> {{ $data->retekCode }} </td>
                        <td class="left"> {{ $data->brandCode }} </td>
                        <td class="right"> @if( $data->sourceBankRecoStatus == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->sourceBankRecoStatus }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->sourceBankRecoStatus }}</span> @endif </td>
                        <td class="right"> {{ $data->sourcePickupBank }} </td>
                        <td class="right"> {{ $data->bankCashPickupDate }} </td>
                        <td class="right"> {{ $data->depositAmount }} </td>
                        <td class="right"> {{ $data->sourceCashSale }} </td>
                        <td class="right"> {{ $data->sourceBankDifference }} </td>

                    </tr>
                    @endforeach

                    @endif

                    @if($activeTab == 'cash2bank')

                    @foreach ($cashRecons as $data)
                    <tr>
                        <td class="left"> {{ $data->storeID }} </td>
                        <td class="right"> {{ $data->retekCode }} </td>
                        <td class="right"> {{ $data->colBank }} </td>
                        <td class="left" style="width: 350px;">
                            {{-- <!-- Set a specific width for the cell -->  --}}
                            <div style="white-space: normal;">
                                {{-- <!-- Allow text to wrap within the cell -->  --}}
                                {{ $data->locationName }}
                            </div>
                        </td>

                        <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>
                        <td class="right"> {{ $data->crDt }} </td>
                        <td class="right"> {{ $data->depositDt }} </td>
                        <td class="right"> {{ $data->depostSlipNo }} </td>
                        <td class="right"> {{ $data->depositAmount }} </td>
                        <td class="right"> {{ $data->creditAmount }} </td>
                        <td class="right"> {{ $data->diffSaleDeposit }} </td>
                    </tr>
                    @endforeach

                    @endif

                </tbody>
            </table>


            @if($cashRecons->count() == 0) <p class="showEmptyAlertData">No data available</p>

            @endif

            <div wire:loading.class='show-loading-spinner' class="loading-spinner">
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span>Loading</span>
            </div>
        </div>
        <div wire:loading.class="d-none" class="mt-4">
            {{ in_array($activeTab, $hasPagination) ?  $cashRecons->links() : '' }}
        </div>

    </div>

    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {
            $j('#select2-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('brand', e.target.value);
            });

            $j('#select22-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('mainStore', e.target.value);
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
