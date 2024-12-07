<div x-data="{
    start: null,
    end: null,
    reset(){
        this.start = null
        this.end = null
    }
}">
    <div class="row">
        <div class="col-lg-12">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs justify-content-start" role="tablist">
                        <li class="nav-item">
                            <a @click="() => {
                                $wire.switchTab('mposbankrecon')
                                reset()
                            }" class="nav-link @if($activeTab === 'mposbankrecon') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#hdfc" style="font-size: .9em !important" href="#" role="tab">MPOS CASH TENDER TO BANK DROP RECONCILITION
                            </a>
                        </li>
                        <li class="nav-item">
                            <a @click="() => {
                                $wire.switchTab('mposmisrecon')
                                reset()
                            }" class="nav-link @if($activeTab === 'mposmisrecon') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                                BANK DROP TO CASH MIS RECONCILIATION
                            </a>
                        </li>

                        <li class="nav-item">
                            <a @click="() => {
                                $wire.switchTab('mposcardrecon')
                                reset()
                            }" class="nav-link @if($activeTab === 'mposcardrecon') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                                CARD RECONCILIATION
                            </a>
                        </li>

                        <li class="nav-item">
                            <a @click="() => {
                                $wire.switchTab('mposwalletrecon')
                                reset()
                            }" class="nav-link @if($activeTab === 'mposwalletrecon') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                                WALLET RECONCILIATION
                            </a>
                        </li>

                        <li class="nav-item">
                            <a @click="() => {
                                $wire.switchTab('mpossaprecon')
                                reset()
                            }" class="nav-link @if($activeTab === 'mpossaprecon') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                                SAP RECONCILIATION
                            </a>
                        </li>


                        <li class="nav-item">
                            <a @click="() => {
                                $wire.switchTab('mpossapcardrecon')
                                reset()
                            }" class="nav-link @if($activeTab === 'mpossapcardrecon') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                                SAP CARD RECONCILIATION
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 d-flex align-items-center justify-content-end">
                    <div class="btn-group mb-1">
                    </div>
                </div>
            </div>

            {{-- filter for the first tab  --}}
            <div class="d-flex d-flex-mob" style="gap: .5em; flex-wrap: wrap; @if($activeTab !=='mposbankrecon' ) display: none !important @endif">

                <div style="display:@if ($filtering) unset @else none @endif" class="">
                    <button @click="() => {
                        $wire.back()
                        reset()
                    }" style="background: transparent; outline: none; border: none; padding: .5em 1em; font-size: 1em">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                </div>

                <div wire:ignore class="">
                    <select id="select01-dropdown" class="custom-select select2 form-control searchField " data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                        <option selected disabled value="" class="dropdown-item">SELECT STORE ID</option>
                        <option value="" class="dropdown-item">ALL</option>

                        @foreach($stores as $item)

                        @php
                        $item = (array) $item;
                        @endphp

                        @if($item['storeID'] != '')
                        <option class="dropdown-list" value="{{ $item['storeID'] }}">{{ $item["storeID"] }}</option>
                        @endif

                        @endforeach
                    </select>
                </div>

                <div wire:ignore class="">
                    <select id="select11-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style=" width: 230px">
                        <option selected disabled value="" class="dropdown-item">SELECT RETEK CODE</option>
                        <option value="" class="dropdown-item">ALL</option>

                        @foreach($codes as $item)

                        @php
                        $item = (array) $item;
                        @endphp

                        @if($item['retekCode'] != '')
                        <option class="dropdown-list" value="{{ $item['retekCode'] }}">{{ $item["retekCode"] }}</option>
                        @endif

                        @endforeach
                    </select>
                </div>



                {{-- Match filter  --}}
                <div class="">
                    <div style="width: 150px" wire:ignore>
                        <select id="select21-dropdown" wire:model="matchStatus" style="width: 150px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">
                            <option selected value="" class="dropdown-item">SELECT MATCHED STATUS</option>
                            <option value="Matched" class="dropdown-item">Matched</option>
                            <option value="Not Matched" class="dropdown-item">Not Matched</option>
                        </select>
                    </div>
                </div>



                <x-filters.date-filter />

            </div>


            {{-- Filters for second tab  --}}
            <div>
                <div class="d-flex d-flex-mob gap-2" style="@if($activeTab !== 'mposmisrecon') display: none !important @endif">
                    {{-- Back button  --}}
                    <div style="display:@if ($filtering) unset @else none @endif" class="">
                        <button @click="() => {
                            $wire.back()
                            reset()
                        }" style="background: transparent; outline: none; border: none; padding: .5em 1em; font-size: 1em">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                    </div>

                    <div wire:ignore class="">
                        <select id="select02-dropdown" class="custom-select select2 form-control searchField " data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                            <option selected disabled value="" class="dropdown-item">SELECT STORE ID</option>
                            <option value="" class="dropdown-item">ALL</option>

                            @foreach($storesOne as $item)

                            @php
                            $item = (array) $item;
                            @endphp

                            @if($item['storeID'] != '')
                            <option class="dropdown-list" value="{{ $item['storeID'] }}">{{ $item["storeID"] }}</option>
                            @endif

                            @endforeach
                        </select>
                    </div>

                    <div wire:ignore class="">
                        <select id="select12-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                            <option selected disabled value="" class="dropdown-item">SELECT RETEK CODE</option>
                            <option value="" class="dropdown-item">ALL</option>

                            @foreach($codesOne as $item)

                            @php
                            $item = (array) $item;
                            @endphp

                            @if($item['retekCode'] != '')
                            <option class="dropdown-list" value="{{ $item['retekCode'] }}">{{ $item["retekCode"] }}</option>
                            @endif

                            @endforeach
                        </select>
                    </div>


                    {{-- Match filter  --}}
                    <div class="">
                        <div style="width: 220px" wire:ignore>
                            <select id="select22-dropdown" wire:model="matchStatus" style="width: 220px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">
                                <option selected value="" class="dropdown-item">SELECT MATCHED STATUS</option>
                                <option value="Matched" class="dropdown-item">Matched</option>
                                <option value="Not Matched" class="dropdown-item">Not Matched</option>
                            </select>
                        </div>
                    </div>


                    <x-filters.date-filter />


                </div>
            </div>

            <div>
                <div class="d-flex d-flex-mob gap-2" style="@if($activeTab !== 'mposcardrecon') display: none !important @endif">

                    <div style="display:@if ($filtering) unset @else none @endif" class="">
                        <button @click="() => {
                            $wire.back()
                            reset()
                        }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                    </div>

                    <div wire:ignore class="">
                        <select id="select03-dropdown" class="custom-select select2 form-control searchField " data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                            <option selected disabled value="" class="dropdown-item">SELECT STORE ID</option>
                            <option value="" class="dropdown-item">ALL</option>

                            @foreach($storesTwo as $item)

                            @php
                            $item = (array) $item;
                            @endphp

                            @if($item['storeID'] != '')
                            <option class="dropdown-list" value="{{ $item['storeID'] }}">{{ $item["storeID"] }}</option>
                            @endif

                            @endforeach
                        </select>
                    </div>

                    <div wire:ignore class="">
                        <select id="select13-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                            <option selected disabled value="" class="dropdown-item">SELECT RETEK CODE</option>
                            <option value="" class="dropdown-item">ALL</option>

                            @foreach($codesTwo as $item)

                            @php
                            $item = (array) $item;
                            @endphp

                            @if($item['retekCode'] != '')
                            <option class="dropdown-list" value="{{ $item['retekCode'] }}">{{ $item["retekCode"] }}</option>
                            @endif

                            @endforeach
                        </select>
                    </div>

                    <div class="">
                        <div style="width: 150px" wire:ignore>
                            <select id="select31-dropdown" style="width: 150px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">

                                <option selected disabled value="" class="dropdown-item">SELECT BANK NAME</option>
                                <option value="" class="dropdown-item">ALL</option>

                                @foreach($banks as $item)

                                @php
                                $item = (array) $item;
                                @endphp

                                @if($item['tenderType'] != '')
                                <option class="dropdown-list" value="{{ $item['tenderType'] }}">{{ $item["tenderType"] }}</option>
                                @endif

                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="">
                        <div style="width: 220px" wire:ignore>
                            <select id="select23-dropdown" wire:model="matchStatus" style="width: 220px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">
                                <option selected value="" class="dropdown-item">SELECT MATCHED STATUS</option>
                                <option value="Matched" class="dropdown-item">Matched</option>
                                <option value="Not Matched" class="dropdown-item">Not Matched</option>
                            </select>
                        </div>
                    </div>


                    <x-filters.date-filter />


                </div>
            </div>

            <div>
                <div class="d-flex d-flex-mob gap-2" style="@if($activeTab !== 'mposwalletrecon') display: none !important @endif">

                    <div style="display:@if ($filtering) unset @else none @endif" class="">
                        <button @click="() => {
                            $wire.back()
                            reset()
                        }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                    </div>

                    <div wire:ignore class="">
                        <select id="select04-dropdown" class="custom-select select2 form-control searchField " data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                            <option selected disabled value="" class="dropdown-item">SELECT STORE ID</option>
                            <option value="" class="dropdown-item">ALL</option>

                            @foreach($storesThree as $item)

                            @php
                            $item = (array) $item;
                            @endphp

                            @if($item['storeID'] != '')
                            <option class="dropdown-list" value="{{ $item['storeID'] }}">{{ $item["storeID"] }}</option>
                            @endif

                            @endforeach
                        </select>
                    </div>

                    <div wire:ignore class="">
                        <select id="select14-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                            <option selected disabled value="" class="dropdown-item">SELECT RETEK CODE</option>
                            <option value="" class="dropdown-item">ALL</option>

                            @foreach($codesThree as $item)

                            @php
                            $item = (array) $item;
                            @endphp

                            @if($item['retekCode'] != '')
                            <option class="dropdown-list" value="{{ $item['retekCode'] }}">{{ $item["retekCode"] }}</option>
                            @endif

                            @endforeach
                        </select>
                    </div>

                    <div class="">
                        <div style="width: 150px" wire:ignore>
                            <select id="select32-dropdown" style="width: 150px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">

                                <option selected disabled value="" class="dropdown-item">SELECT BANK NAME</option>
                                <option value="" class="dropdown-item">ALL</option>

                                @foreach($banks2 as $item)

                                @php
                                $item = (array) $item;
                                @endphp

                                @if($item['tenderType'] != '')
                                <option class="dropdown-list" value="{{ $item['tenderType'] }}">{{ $item["tenderType"] }}</option>
                                @endif

                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="">
                        <div style="width: 220px" wire:ignore>
                            <select id="select24-dropdown" wire:model="matchStatus" style="width: 220px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">
                                <option selected value="" class="dropdown-item">SELECT MATCHED STATUS</option>
                                <option value="Matched" class="dropdown-item">Matched</option>
                                <option value="Not Matched" class="dropdown-item">Not Matched</option>
                            </select>
                        </div>
                    </div>


                    <x-filters.date-filter />


                </div>
            </div>

            <div>
                <div class="d-flex d-flex-mob gap-2" style="@if($activeTab !== 'mpossaprecon') display: none !important @endif">

                    <div style="display:@if ($filtering) unset @else none @endif" class="">
                        <button @click="() => {
                            $wire.back()
                            reset()
                        }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                    </div>

                    <div wire:ignore class="">
                        <select id="select05-dropdown" class="custom-select select2 form-control searchField " data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                            <option selected disabled value="" class="dropdown-item">SELECT STORE ID</option>
                            <option value="" class="dropdown-item">ALL</option>

                            @foreach($storesFour as $item)

                            @php
                            $item = (array) $item;
                            @endphp

                            @if($item['storeID'] != '')
                            <option class="dropdown-list" value="{{ $item['storeID'] }}">{{ $item["storeID"] }}</option>
                            @endif

                            @endforeach
                        </select>
                    </div>

                    <div wire:ignore class="">
                        <select id="select15-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                            <option selected disabled value="" class="dropdown-item">SELECT RETEK CODE</option>
                            <option value="" class="dropdown-item">ALL</option>

                            @foreach($codesFour as $item)

                            @php
                            $item = (array) $item;
                            @endphp

                            @if($item['retekCode'] != '')
                            <option class="dropdown-list" value="{{ $item['retekCode'] }}">{{ $item["retekCode"] }}</option>
                            @endif

                            @endforeach
                        </select>
                    </div>



                    <div class="">
                        <div style="width: 220px" wire:ignore>
                            <select id="select25-dropdown" wire:model="matchStatus" style="width: 220px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">
                                <option selected value="" class="dropdown-item">SELECT MATCHED STATUS</option>
                                <option value="Matched" class="dropdown-item">Matched</option>
                                <option value="Not Matched" class="dropdown-item">Not Matched</option>
                            </select>
                        </div>
                    </div>

                    <x-filters.date-filter />
                </div>
            </div>

            <div>
                <div class="d-flex d-flex-mob gap-2" style="@if($activeTab !== 'mpossapcardrecon') display: none !important @endif">

                    <div style="display:@if ($filtering) unset @else none @endif" class="">
                        <button @click="() => {
                    $wire.back()
                    reset()
                }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                    </div>

                    <div wire:ignore class="">
                        <select id="select06-dropdown" class="custom-select select2 form-control searchField " data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                            <option selected disabled value="" class="dropdown-item">SELECT STORE ID</option>
                            <option value="" class="dropdown-item">ALL</option>

                            @foreach($storesFive as $item)

                            @php
                            $item = (array) $item;
                            @endphp

                            @if($item['storeID'] != '')
                            <option class="dropdown-list" value="{{ $item['storeID'] }}">{{ $item["storeID"] }}</option>
                            @endif

                            @endforeach
                        </select>
                    </div>

                    <div wire:ignore class="">
                        <select id="select16-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                            <option selected disabled value="" class="dropdown-item">SELECT RETEK CODE</option>
                            <option value="" class="dropdown-item">ALL</option>

                            @foreach($codesFive as $item)

                            @php
                            $item = (array) $item;
                            @endphp

                            @if($item['retekCode'] != '')
                            <option class="dropdown-list" value="{{ $item['retekCode'] }}">{{ $item["retekCode"] }}</option>
                            @endif

                            @endforeach
                        </select>
                    </div>

                    <div class="">
                        <div style="width: 150px" wire:ignore>
                            <select id="select33-dropdown" style="width: 150px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">

                                <option selected disabled value="" class="dropdown-item">SELECT BANK NAME</option>
                                <option value="" class="dropdown-item">ALL</option>

                                @foreach($banks3 as $item)

                                @php
                                $item = (array) $item;
                                @endphp

                                @if($item['tenderDesc'] != '')
                                <option class="dropdown-list" value="{{ $item['tenderDesc'] }}">{{ $item["tenderDesc"] }}</option>
                                @endif

                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="">
                        <div style="width: 220px" wire:ignore>
                            <select id="select26-dropdown" wire:model="matchStatus" style="width: 220px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">
                                <option selected value="" class="dropdown-item">SELECT MATCHED STATUS</option>
                                <option value="Matched" class="dropdown-item">Matched</option>
                                <option value="Not Matched" class="dropdown-item">Not Matched</option>
                            </select>
                        </div>
                    </div>


                    <x-filters.date-filter />


                </div>
            </div>
        </div>
    </div>


    @if($activeTab !== 'processed')
    <div class="d-flex justify-content-center gap-4 mt-2">
        <p style="font-size: 1em">Total Record: <span style="color: black; font-weight: 900;">{{ isset($cashRecons[0]->TotalCount) ? $cashRecons[0]->TotalCount : 0 }}</span></p>
        <p style="font-size: 1em">Matched: <span style="color: teal; font-weight: 900;">{{ isset($cashRecons[0]->matchedCount) ? $cashRecons[0]->matchedCount : 0 }}</span></p>
        <p style="font-size: 1em">Not Matched: <span style="color: lightcoral; font-weight: 900;">{{ isset($cashRecons[0]->notMatchedCount) ? $cashRecons[0]->notMatchedCount : 0 }}</span></p>
    </div>
    @endif


    @if($activeTab == 'processed')
    <div class="d-flex justify-content-center gap-4 mt-2">
        <p style="font-size: 1em;">Total Record: <span style="color: black; font-weight: 900;">{{ isset($cashRecons[0]->TotalCount) ? $cashRecons[0]->TotalCount : 0 }}</span></p>
    </div>
    @endif


    <div class="col-lg-12">
        {{-- Main sales table --}}
        <x-scrollable.scrollable :dataset="$cashRecons">
            <x-scrollable.scroll-head>
                @if($activeTab == 'mposbankrecon')
                <tr>
                    <th class="left">Mpos Date</th>
                    <th class="left">Store ID</th>
                    <th class="left">Retek Code</th>
                    <th class="left">Brand</th>
                    <th class="left">Status</th>
                    <th class="left">Recon Status</th>
                    <th class="left">Bank Drop ID</th>
                    <th class="left">Tender Amount</th>
                    <th class="left">Bank Drop Amount</th>
                    <th class="left">Difference Amount</th>
                    <th class="left">Tender Adjustment</th>
                    <th class="left">Bank Drop Adjustment</th>
                </tr>
                @elseif($activeTab == 'mposmisrecon')
                <tr>
                    <th class="left">Desposit Date</th>
                    <th class="left">Store ID</th>
                    <th class="left">Retek Code</th>
                    <th class="left">Brand</th>
                    <th class="left">Status</th>
                    <th class="left">Recon Status</th>
                    <th class="left">Desposit SlipNo</th>
                    <th class="left">Bank Drop Amount</th>
                    <th class="left">Desposit Amount</th>
                    <th class="left">Difference Amount</th>
                    <th class="left">Bank Drop Adjustment</th>
                    <th class="left">Deposit Adjustment</th>
                </tr>

                @elseif($activeTab == 'mposcardrecon')
                <tr>
                    <th class="left">Mpos Date</th>
                    <th class="left">Store ID</th>
                    <th class="left">Retek Code</th>
                    <th class="left">Brand</th>
                    <th class="left">Tender Type</th>
                    <th class="left">Status</th>
                    <th class="left">Recon Status</th>
                    <th class="left">Tender Amount</th>
                    <th class="left">Desposit Amount</th>
                    <th class="left">Difference Cardsales</th>
                    <th class="left">Store Respons Entry</th>
                </tr>

                @elseif($activeTab == 'mposwalletrecon')
                <tr>
                    <th class="left">Mpos Date</th>
                    <th class="left">Store ID</th>
                    <th class="left">Retek Code</th>
                    <th class="left">Brand</th>
                    <th class="left">Tender Type</th>
                    <th class="left">Status</th>
                    <th class="left">Recon Status</th>
                    <th class="left">Tender Amount</th>
                    <th class="left">Desposit Amount</th>
                    <th class="left">Difference Walletsales</th>
                    <th class="left">Store Respons Entry</th>

                </tr>

                @elseif($activeTab == 'mpossaprecon')
                <tr>
                    <th class="left">Tender Date</th>
                    <th class="left">Store ID</th>
                    <th class="left">Retek Code</th>
                    <th class="left">Brand</th>
                    {{-- <th class="left">Tender Type</th> --}}
                    <th class="left">Status</th>
                    <th class="left">Recon Status</th>
                    <th class="left">Cash</th>
                    <th class="left">Tender Value</th>
                </tr>

                @elseif($activeTab == 'mpossapcardrecon')
                <tr>
                    <th class="left">Tender Date</th>
                    <th class="left">Store ID</th>
                    <th class="left">Retek Code</th>
                    <th class="left">Brand</th>
                    <th class="left">Tender Desc</th>
                    <th class="left">Status</th>
                    <th class="left">Recon Status</th>
                    <th class="left">Card Amount</th>
                    <th class="left">Tender Amount</th>
                </tr>
                @endif
            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>
                @if($activeTab == 'mposbankrecon')
                @foreach ($cashRecons as $data)
                <tr>
                    <td class="right">{{ Carbon\Carbon::parse($data->mposDate)->format('d-m-Y') }}</td>
                    <td class="right">{{ $data->storeID }}</td>
                    <td class="right">{{ $data->retekCode }}</td>
                    <td class="right">{{ $data->brand }}</td>
                    <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>
                    <td class="right">{{ $data->reconStatus }}</td>
                    <td class="right">{{ $data->bankDropID }}</td>
                    <td class="right">{{ $data->tenderAmount }}</td>
                    <td class="right">{{ $data->bankDropAmount }}</td>
                    <td class="right">{{ $data->DiffAmount }}</td>
                    <td class="right">{{ !$data->tenderAdj  ? '0.00' : $data->tenderAdj }}</td>
                    <td class="right">{{ !$data->bankAdj ? '0.00' : $data->bankAdj }}</td>
                </tr>
                @endforeach

                @elseif($activeTab == 'mposmisrecon')
                @foreach ($cashRecons as $data)

                <tr>
                    <td class="right">{{ Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}</td>
                    <td class="right">{{ $data->storeID }}</td>
                    <td class="right">{{ $data->retekCode }}</td>
                    <td class="right">{{ $data->brand }}</td>
                    <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>
                    <td class="right">{{ $data->reconStatus }}</td>
                    <td class="right">{{ $data->depositSlipNo }}</td>
                    <td class="right">{{ $data->bankDropAmount }}</td>
                    <td class="right">{{ $data->depositAmount }}</td>
                    <td class="right">{{ $data->DiffAmount }}</td>
                    <td class="right">{{ !$data->tenderAdj  ? '0.00' : $data->tenderAdj }}</td>
                    <td class="right">{{ !$data->bankAdj ? '0.00' : $data->bankAdj }}</td>

                </tr>
                @endforeach

                @elseif($activeTab == 'mposcardrecon')

                @foreach ($cashRecons as $data)
                <tr>
                    <td class="right">{{ Carbon\Carbon::parse($data->mposDate)->format('d-m-Y') }}</td>
                    <td class="right">{{ $data->storeID }}</td>
                    <td class="right">{{ $data->retekCode }}</td>
                    <td class="right">{{ $data->brand }}</td>
                    <td class="right">{{ $data->tenderType }}</td>
                    <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>
                    <td class="right">{{ $data->reconStatus }}</td>
                    <td class="right">{{ $data->tenderAmount }}</td>
                    <td class="right">{{ !$data->depositAmount ? '0.00' : $data->depositAmount }}</td>
                    <td class="right">{{ $data->differenceCardSales }}</td>
                    <td class="right">{{ $data->adjAmount }}</td>
                </tr>
                @endforeach


                @elseif($activeTab == 'mposwalletrecon')
                @foreach ($cashRecons as $data)
                <tr>
                    <td class="right">{{ Carbon\Carbon::parse($data->mposDate)->format('d-m-Y') }}</td>
                    <td class="right">{{ $data->storeID }}</td>
                    <td class="right">{{ $data->retekCode }}</td>
                    <td class="right">{{ $data->brand }}</td>
                    <td class="right">{{ $data->tenderType }}</td>
                    <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>
                    <td class="right">{{ $data->reconStatus }}</td>
                    <td class="right">{{ $data->tenderAmount }}</td>
                    <td class="right">{{ !$data->depositAmount  ? '0.00' : $data->depositAmount }}</td>
                    <td class="right">{{ $data->differenceWalletSales }}</td>
                    <td class="right">{{ !$data->adjAmount  ? '0.00' : $data->adjAmount }}</td>
                </tr>
                @endforeach

                @elseif($activeTab == 'mpossaprecon')
                @foreach ($cashRecons as $data)
                <tr>
                    <td class="right">{{ Carbon\Carbon::parse($data->tenderDate)->format('d-m-Y') }}</td>
                    <td class="right">{{ $data->storeID }}</td>
                    <td class="right">{{ $data->retekCode }}</td>
                    <td class="right">{{ $data->brand }}</td>
                    {{-- <td class="right">{{ $data->tenderType }}</td> --}}
                    <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>
                    <td class="right">{{ $data->reconStatus }}</td>
                    <td class="right">{{ $data->cash }}</td>
                    <td class="right">{{ $data->tenderValue }}</td>

                </tr>

                @endforeach


                @elseif($activeTab == 'mpossapcardrecon')
                @foreach ($cashRecons as $data)
                <tr>
                    <td class="right">{{ Carbon\Carbon::parse($data->tenderDate)->format('d-m-Y') }}</td>
                    <td class="right">{{ $data->storeID }}</td>
                    <td class="right">{{ $data->retekCode }}</td>
                    <td class="right">{{ $data->brand }}</td>
                    <td class="right">{{ $data->tenderDesc }}</td>
                    <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>
                    <td class="right">{{ $data->reconStatus }}</td>
                    <td class="right">{{ $data->cardAmount }}</td>
                    <td class="right">{{ $data->tenderAmount }}</td>

                </tr>

                @endforeach
                @endif
            </x-scrollable.scroll-body>
        </x-scrollable.scrollable>

    </div>


    {{-- filter scripts  --}}
    <script>
        const filterIDs = ['select2-dropdown', 'select22-dropdown', 'select222-dropdown', 'startDate', 'endDate'];

        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {

            $j('.searchField').select2();



            $j('#select22-dropdown').on('change', function(e) {
                @this.set('mainStore', e.target.value);
            });

            //match status
            $j('#select21-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('matchStatus', e.target.value);
            });
            $j('#select22-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('matchStatus', e.target.value);
            });
            $j('#select23-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('matchStatus', e.target.value);
            });
            $j('#select24-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('matchStatus', e.target.value);
            });
            $j('#select25-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('matchStatus', e.target.value);
            });
            $j('#select26-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('matchStatus', e.target.value);
            });


            // $j('#processed-dropdown').on('change', function(e) {
            //     @this.set('mainStore', e.target.value);
            // });
            //codes
            $j('#select11-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });
            $j('#select12-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });
            $j('#select13-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });
            $j('#select14-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });
            $j('#select15-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });
            $j('#select16-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });

            //store
            $j('#select01-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });
            $j('#select02-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });
            $j('#select03-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });
            $j('#select04-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });
            $j('#select05-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });
            $j('#select06-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });




            //bank
            $j('#select31-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('bank', e.target.value);
            });
            $j('#select32-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('bank', e.target.value);
            });
            $j('#select33-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('bank', e.target.value);
            });
        });

    </script>


</div>
