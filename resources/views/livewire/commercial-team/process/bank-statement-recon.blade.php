<section x-data="{

    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    }
}" id="recent" class="process-page">
    {{-- tab --}}
    <x-app.commercial-team.process.bank-statement-process.tabs :activeTab="$activeTab" />

    <x-app.commercial-team.process.bank-statement-process.filters :tab="$activeTab" show="cash" :filtering="$filtering" :codes="$cash_codes" :stores="$cash_stores" :months="$_months" />

    <x-app.commercial-team.process.bank-statement-process.filters :tab="$activeTab" show="card" :filtering="$filtering" :codes="$card_codes" :stores="$card_stores" :months="$_months" />

    <x-app.commercial-team.process.bank-statement-process.filters :tab="$activeTab" show="wallet" :filtering="$filtering" :codes="$wallet_codes" :stores="$wallet_stores" :months="$_months" />

    <x-app.commercial-team.process.bank-statement-process.filters :tab="$activeTab" show="upi" :filtering="$filtering" :codes="$upi_codes" :stores="$upi_stores" :months="$_months" />


    <div class="row">
        <div class="col-lg-12">
            <x-scrollable.scrollable :dataset="$dataset">
                <x-scrollable.scroll-head>
                    @if ($activeTab == 'cash')
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
                        <th>Collection Bank </th>
                        <th>Status</th>
                        <th>Credit Amount</th>
                        <th>Net Amount</th>
                        <th>Difference [Credit-Net]</th>
                        <th>Reconciliation Status</th>
                        <th>Submit Recon</th>
                    </tr>

                    @endif
                    @if ($activeTab == 'card')
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
                        <th>Collection Bank</th>
                        <th>Status</th>
                        <th>TID / MID</th>
                        <th>Credit Amount</th>
                        <th>Net Amount</th>
                        <th>Difference [Credit-Net]</th>
                        <th>Recon Status</th>
                        <th>Submit Recon</th>
                    </tr>
                    @endif

                    @if ($activeTab == 'wallet')
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
                        <th>Collection Bank</th>
                        <th>Status</th>
                        <th>TID / MID</th>
                        <th>Credit Amount</th>
                        <th>Net Amount</th>
                        <th>Difference [Credit-Net]</th>
                        <th>Recon Status</th>
                        <th>Submit Recon</th>
                    </tr>

                    @endif
                    @if ($activeTab == 'upi')
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
                        <th>Collection Bank</th>
                        <th>Status</th>
                        <th>TID / MID</th>
                        <th>Credit Amount</th>
                        <th>Net Amount</th>
                        <th>Difference [Credit-Net]</th>
                        <th>Recon Status</th>
                        <th>Submit Recon</th>
                    </tr>
                    @endif
                </x-scrollable.scroll-head>

                <x-scrollable.scroll-body>

                    @if ($activeTab == 'cash')
                    @foreach ($dataset as $data)
                    <tr>
                        <td>{{ !$data->crDt ? "" : Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}</td>
                        <td>{{ !$data->depositDt ? "" : Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                        <td>{{ $data->storeID }}</td>
                        <td>{{ $data->retekCode }}</td>
                        <td>{{ $data->brand }}</td>
                        <td>{{ $data->colBank }}</td>
                        <td style="font-weight: 700; color: @if($data->status == 'Matched') teal @else red @endif">{{ $data->status }}</td>
                        <td>{{ number_format($data->creditAmount, 2) }}</td>
                        <td>{{ number_format($data->depositAmount, 2) }}</td>
                        <td>{{ number_format($data->diffSaleDeposit, 2) }}</td>
                        <td>{{ $data->reconStatus }}</td>
                        <td><a href="#" data-bs-target="#exampleModalCenter_{{ $data->cashMisBkStRecoUID }}" style="font-size: 1.1em" data-bs-toggle="modal">View</a></td>
                    </tr>


                    <x-app.commercial-team.process.bank-statement-process.cash-recon.main-modal :data="$data" :remarks="$remarks" />

                    @endforeach
                    @endif

                    @if ($activeTab == 'card')
                    @foreach ($dataset as $data)

                    <tr>
                        <td>{{ !$data->crDt ? "" : Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}</td>
                        <td>{{ !$data->depositDt ? "" : Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                        <td>{{ $data->storeID }}</td>
                        <td>{{ $data->retekCode }}</td>
                        <td>{{ $data->{'Brand Desc'} }}</td>
                        <td>{{ $data->colBank }}</td>
                        <td style="font-weight: 700; color: @if($data->status == 'Matched') teal @else red @endif">{{ $data->status }}</td>
                        <td>{{ $data->tid }}</td>
                        <td>{{ number_format($data->depositAmount, 2) }}</td>
                        <td>{{ number_format($data->netAmount, 2) }}</td>
                        <td>{{ number_format($data->diffSaleDeposit, 2) }}</td>
                        <td>{{ $data->reconStatus }}</td>
                        <td><a href="#" data-bs-target="#exampleModalCenter_{{ $data->cardMisBankStRecoUID }}" style="font-size: 1.1em" data-bs-toggle="modal">View</a></td>
                    </tr>

                    <x-app.commercial-team.process.bank-statement-process.card-recon.main-modal :data="$data" :remarks="$remarks" />

                    @endforeach
                    @endif

                    @if ($activeTab == 'wallet')
                    @foreach ($dataset as $data)

                    <tr>
                        <td>{{ !$data->crDt ? "" : Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}</td>
                        <td>{{ !$data->depositDt ? "" : Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                        <td>{{ $data->storeID }}</td>
                        <td>{{ $data->retekCode }}</td>
                        <td>{{ $data->{'Brand Desc'} }}</td>
                        <td>{{ $data->colBank }}</td>
                        <td style="font-weight: 700; color: @if($data->status == 'Matched') teal @else red @endif">{{ $data->status }}</td>
                        <td>{{ $data->tid }}</td>
                        <td>{{ number_format($data->depositAmount, 2) }}</td>
                        <td>{{ number_format($data->netAmount, 2) }}</td>
                        <td>{{ number_format($data->diffSaleDeposit, 2) }}</td>
                        <td>{{ $data->reconStatus }}</td>
                        <td><a href="#" data-bs-target="#exampleModalCenter_{{ $data->walletMisBankStRecoUID }}" style="font-size: 1.1em" data-bs-toggle="modal">View</a></td>
                    </tr>


                    {{-- Modal --}}
                    <x-app.commercial-team.process.bank-statement-process.wallet-recon.wallet-bank-modal-popup :remarks="$remarks" :data="$data" />
                    @endforeach
                    @endif

                    @if ($activeTab == 'upi')
                    @foreach ($dataset as $data)

                    <tr>
                        <td>{{ !$data->crDt ? "" : Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}</td>
                        <td>{{ !$data->depositDt ? "" : Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                        <td>{{ $data->storeID }}</td>
                        <td>{{ $data->retekCode }}</td>
                        <td>{{ $data->{'Brand Desc'} }}</td>
                        <td>{{ $data->colBank }}</td>
                        <td style="font-weight: 700; color: @if($data->status == 'Matched') teal @else red @endif">{{ $data->status }}</td>
                        <td>{{ $data->tid }}</td>
                        <td>{{ $data->depositAmount }}</td>
                        <td>{{ $data->netAmount }}</td>
                        <td>{{ $data->diffSaleDeposit }}</td>
                        <td>{{ $data->reconStatus }}</td>

                        <td>
                            <a href="#" data-bs-target="#exampleModalCenter_{{ $data->cardMisBankStRecoUID }}" style="font-size: 1.1em" data-bs-toggle="modal">
                                View
                            </a>
                        </td>
                    </tr>

                    {{-- Modal --}}
                    <x-app.commercial-team.process.bank-statement-process.upi-recon.modal :remarks="$remarks" :data="$data" />
                    @endforeach
                    @endif
                </x-scrollable.scroll-body>
            </x-scrollable.scrollable>
        </div>

        <script>
            var $j = jQuery.noConflict();
            $j('.searchField').select2();

            $j('#cash-stores').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });

            $j('#card-stores').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });

            $j('#upi-stores').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });

            $j('#wallet-stores').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });


            $j('#cash-codes').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });

            $j('#card-codes').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });

            $j('#wallet-codes').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });

            $j('#upi-codes').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });

        </script>
</section>
