<section id="recent" class="process-page" x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null;
        this.end = null;
    }
}">

    <div class="row mb-4">
        <div class="col-lg-9">
            <ul class="nav nav-tabs justify-content-start" role="tablist">
                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('cash')
                        reset()   
                    }" class="nav-link @if($activeTab === 'cash') active tab-active @endif" data-bs-toggle="tab" href="#" role="tab" style="font-size: .8em !important">
                        CASH MIS TO BANK STATEMENT RECON
                    </a>
                </li>
                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('card')
                        reset()   
                    }" class="nav-link @if($activeTab === 'card') active tab-active @endif" data-bs-toggle="
                            tab" href="#" role="tab" style="font-size: .8em !important">
                        CARD MIS TO BANK STATEMENT RECON
                    </a>
                </li>

                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('upi')
                        reset()   
                    }" class="nav-link @if($activeTab === 'upi') active tab-active @endif" data-bs-toggle="
                            tab" href="#" role="tab" style="font-size: .8em !important">
                        UPI MIS TO BANK STATEMENT RECON
                    </a>
                </li>

                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('wallet')
                        reset()   
                    }" class="nav-link @if($activeTab === 'wallet') active tab-active @endif" data-bs-toggle="
                            tab" href="#" role="tab" style="font-size: .8em !important">
                        WALLET MIS TO BANK STATEMENT RECON
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-lg-3 d-flex align-items-center justify-content-end">
            <div class="btn-group mb-1">
            </div>
        </div>
    </div>

    <x-app.commercial-head.process.cash-recon.filters :filtering="$filtering" :activeTab="$activeTab" :cashStores="$cash_stores" :cardStores="$card_stores" :walletStores="$wallet_stores" :upiStores="$upi_stores" :cashCodes="$cash_codes" :walletCodes="$wallet_codes" :upiCodes="$upi_codes" :cardCodes="$card_codes" :locations="$locations" :months="$_months" />

    <div class="row">
        <div class="col-lg-12">

            <x-scrollable.scrollable :dataset="$dataset">
                <x-scrollable.scroll-head>

                    @if($activeTab == 'cash')

                    <tr>
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Credit Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                            </div>
                        </th>
                        <th>Deposit Date</th>
                        <th>Store ID</th>
                        <th>Retek Code</th>
                        <th>Brand</th>
                        <th>Location</th>
                        <th>Collection Bank</th>
                        <th>Status</th>
                        <th>Ref no.</th>
                        <th>Slip No.</th>
                        <th style="text-align: right !important">Credit Amount</th>
                        <th style="text-align: right !important">Deposit Amount</th>
                        <th style="text-align: right !important">Difference Amount</th>
                        <th>Recon Status</th>
                        <th>Submit Recon</th>
                    </tr>
                    @endif

                    @if($activeTab == 'card')

                    <tr>
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Credit Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                            </div>
                        </th>
                        <th>Deposit Date</th>
                        <th>Store ID</th>
                        <th>Retek Code</th>
                        <th>Brand</th>
                        <th>Location</th>
                        <th>Collection Bank</th>
                        <th>Status</th>
                        {{-- <th>Ref no.</th> --}}
                        <th>TID/MID</th>
                        <th style="text-align: right !important">Credit Amount</th>
                        <th style="text-align: right !important">Deposit Amount</th>
                        <th style="text-align: right !important">Difference Amount</th>
                        <th>Recon Status</th>
                        <th>Submit Recon</th>
                    </tr>

                    @endif


                    @if($activeTab == 'wallet')

                    <tr>
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Credit Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                            </div>
                        </th>
                        <th>Deposit Date</th>
                        <th>Store ID</th>
                        <th>Retek Code</th>
                        <th>Brand</th>
                        <th>Location</th>
                        <th>Collection Bank</th>
                        <th>Status</th>
                        <th>TID/MID</th>
                        <th style="text-align: right !important">Credit Amount</th>
                        <th style="text-align: right !important">Deposit Amount</th>
                        <th style="text-align: right !important">Difference Amount</th>
                        <th>Recon Status</th>
                        <th>Submit Recon</th>
                    </tr>

                    @endif

                    @if($activeTab == 'upi')
                    <tr>
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Credit Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                            </div>
                        </th>
                        <th>Deposit Date</th>
                        <th>Store ID</th>
                        <th>Retek Code</th>
                        <th>Brand</th>
                        <th>Location</th>
                        <th>Collection Bank</th>
                        <th>Status</th>
                        <th>TID/MID</th>
                        <th style="text-align: right !important">Credit Amount</th>
                        <th style="text-align: right !important">Deposit Amount</th>
                        <th style="text-align: right !important">Difference Amount</th>
                        <th>Recon Status</th>
                        <th>Submit Recon</th>
                    </tr>
                    @endif


                </x-scrollable.scroll-head>

                <x-scrollable.scroll-body>

                    @if($activeTab == 'cash')

                    @foreach ($dataset as $data)
                    <tr>
                        <td>{{ !$data->crDt ? '' : Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}</td>
                        <td>{{ !$data->depositDt ? '' : Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                        <td>{{ $data->storeID }}</td>
                        <td>{{ $data->retekCode }}</td>
                        <td>{{ $data->brand }}</td>
                        <td>{{ $data->Location }}</td>
                        <td>{{ $data->colBank }}</td>
                        <td style="font-weight: 700; color: @if($data->status === 'Matched') teal @else red @endif">
                            {{ $data->status }}
                        </td>
                        <td>{{ $data->refNo }}</td>
                        <td>{{ $data->depostSlipNo }}</td>

                        <td style="text-align: right !important">{{ number_format($data->creditAmount) }}</td>
                        <td style="text-align: right !important">{{ number_format($data->depositAmount, 2) }}</td>
                        <td style="text-align: right !important">{{ number_format($data->diffSaleDeposit, 2) }}</td>
                        <td>{{ $data->reconStatus == 'disapprove' ? 'Rejected' : $data->reconStatus }}</td>

                        <td>
                            <a href="#" style="font-size: 1.1em" data-bs-target="#exampleModalCenterSecondTab_{{ $data->cashMisBkStRecoUID }}" data-bs-toggle="modal">View</a>
                        </td>
                    </tr>

                    <x-app.commercial-head.process.cash-recon.main-modal :data="$data" />


                    @endforeach

                    @endif

                    @if($activeTab == 'card')

                    @foreach ($dataset as $data)
                    <tr>
                        <td>{{ !$data->crDt ? '' : Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}</td>
                        <td>{{ !$data->depositDt ? '' : Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                        <td>{{ $data->storeID }}</td>
                        <td>{{ $data->retekCode }}</td>
                        <td>{{ $data->brand }}</td>
                        <td>{{ $data->Location }}</td>
                        <td>{{ $data->colBank }}</td>
                        <td style="font-weight: 700; color: @if($data->status === 'Matched') teal @else red @endif">
                            {{ $data->status }}
                        </td>

                        <td>{{ $data->tid }}</td>
                        <td style="text-align: right !important">{{ number_format($data->creditAmount) }}</td>
                        <td style="text-align: right !important">{{ number_format($data->depositAmount, 2) }}</td>
                        <td style="text-align: right !important">{{ number_format($data->diffSaleDeposit, 2) }}</td>
                        <td>{{ $data->reconStatus == 'disapprove' ? 'Rejected' : $data->reconStatus }}</td>


                        <td> <a href="#" style="font-size: 1.1em" data-bs-target="#exampleModalCenterSecondTab_{{ $data->cardMisBankStRecoUID }}" data-bs-toggle="modal">View</a></td>
                    </tr>


                    <x-app.commercial-head.process.card-recon.main-modal :data="$data" />

                    @endforeach

                    @endif

                    @if($activeTab == 'wallet')

                    @foreach ($dataset as $data)
                    <tr>
                        <td>{{ !$data->crDt ? '' : Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}</td>
                        <td>{{ !$data->depositDt ? '' : Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                        <td>{{ $data->storeID }}</td>
                        <td>{{ $data->retekCode }}</td>
                        <td>{{ $data->brand }}</td>
                        <td>{{ $data->Location }}</td>
                        <td>{{ $data->colBank }}</td>
                        <td style="font-weight: 700; color: @if($data->status === 'Matched') teal @else red @endif">
                            {{ $data->status }}
                        </td>

                        <td>{{ $data->tid }}</td>
                        <td style="text-align: right !important">{{ number_format($data->creditAmount) }}</td>
                        <td style="text-align: right !important">{{ number_format($data->depositAmount, 2) }}</td>
                        <td style="text-align: right !important">{{ number_format($data->diffSaleDeposit, 2) }}</td>
                        <td>{{ $data->reconStatus == 'disapprove' ? 'Rejected' : $data->reconStatus }}</td>

                        <td> <a href="#" style="font-size: 1.1em" data-bs-target="#exampleModalCenterSecondTab_{{ $data->walletMisBankStRecoUID }}" data-bs-toggle="modal">View</a></td>
                    </tr>
                    <x-app.commercial-head.process.wallet-recon.bank-popup-modal :data="$data" />

                    @endforeach

                    @endif

                    @if($activeTab == 'upi')

                    @foreach ($dataset as $data)
                    <x-app.commercial-head.process.upi-recon.upi-bank-table-dataset :data="$data" />
                    {{-- Modal --}}
                    <x-app.commercial-head.process.upi-recon.modal :data="$data" />
                    @endforeach

                    @endtab
                </x-scrollable.scroll-body>
            </x-scrollable.scrollable>
        </div>
    </div>

    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();


        document.addEventListener('livewire:load', function() {

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


        });

    </script>

</section>
