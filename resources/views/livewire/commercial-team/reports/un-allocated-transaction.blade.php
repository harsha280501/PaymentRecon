<div x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    }
}" x-init="() => console.log('loaded ...')">

    <div class="row mb-2">
        <div class="col-lg-12">
            <ul class="nav nav-tabs justify-content-start" role="tablist">
                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('cash')
                        reset()
                    }"
                        class="nav-link @if ($activeTab === 'cash') active tab-active @endif" data-bs-toggle="tab"
                        data-bs-target="#hdfc" style="font-size: .9em !important" href="#" role="tab">Cash
                        Transactions
                    </a>
                </li>

                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('card')
                        reset()
                    }"
                        class="nav-link @if ($activeTab === 'card') active tab-active @endif" data-bs-toggle="tab"
                        data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                        Card Transactions
                    </a>
                </li>

                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('upi')
                        reset()
                    }"
                        class="nav-link @if ($activeTab === 'upi') active tab-active @endif" data-bs-toggle="tab"
                        data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                        Upi Transactions
                    </a>
                </li>

                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('wallet')
                        reset()
                    }"
                        class="nav-link @if ($activeTab === 'wallet') active tab-active @endif" data-bs-toggle="tab"
                        data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                        Wallet Transactions
                    </a>
                </li>
            </ul>
        </div>

        <div class="row mt-3">
            <x-app.commercial-head.reports.unallocated.filters :filtering="$filtering" :months="$_months" :tab="$activeTab" />
        </div>

        {{-- Totals --}}
        <x-app.commercial-head.reports.unallocated.totals :filtering="$filtering" :datas="$datas" :activeTab="$activeTab" />


        {{-- Table --}}
        <x-app.commercial-head.reports.unallocated.table-headers :orderBy="$orderBy" :dataset="$datas" :activeTab="$activeTab"
            :startdate="$startDate" :enddate="$endDate">

            <x-scrollable.scroll-body>
                @if ($activeTab == 'cash')
                    @foreach ($datas as $data)
                        <tr data-id="{{ $data->{'storeID'} }}">
                            <td class="left">
                                {{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}
                            </td>
                            <td class="left"> {{ $data->{'pkupPtCode'} }} </td>
                            <td class="left"> {{ $data->{'depSlipNo'} }} </td>
                            <td class="left"> {{ $data->{'colBank'} }} </td>
                            <td class="left"> {{ $data->{'locationShort'} }} </td>
                            <td class="right"> {{ $data->{'depositAmount'} }} </td>
                            <td><button style="border: none; outline: none; background: transparent;"
                                    class="text-primary" data-bs-target="#{{ $data->className }}"
                                    data-bs-toggle="modal">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <x-app.commercial-head.reports.unallocated.partials.cash-modal :data="$data" />
                    @endforeach
                @endif
                @if ($activeTab == 'card')
                    @foreach ($datas as $data)
                        <tr data-id="{{ $data->{'storeID'} }}">
                            <td class="left">
                                {{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}
                            </td>
                            <td class="left"> {{ $data->{'pkupPtCode'} }} </td>
                            <td class="left"> {{ $data->{'colBank'} }} </td>
                            <td class="right"> {{ $data->{'depositAmount'} }} </td>
                            <td><button style="border: none; outline: none; background: transparent;"
                                    class="text-primary" data-bs-target="#{{ $data->className }}"
                                    data-bs-toggle="modal">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <x-app.commercial-head.reports.unallocated.partials.card-modal :data="$data" />
                    @endforeach
                @endif

                @if ($activeTab == 'upi')
                    @foreach ($datas as $data)
                        <tr data-id="{{ $data->{'storeID'} }}">
                            <td class="left">
                                {{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}
                            </td>
                            <td class="left"> {{ $data->{'pkupPtCode'} }} </td>
                            <td class="left"> {{ $data->{'colBank'} }} </td>
                            <td class="right"> {{ $data->{'depositAmount'} }} </td>
                            <td><button style="border: none; outline: none; background: transparent;"
                                    class="text-primary" data-bs-target="#{{ $data->className }}"
                                    data-bs-toggle="modal">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <x-app.commercial-head.reports.unallocated.partials.upi-modal :data="$data" />
                    @endforeach
                @endif

                @if ($activeTab == 'wallet')
                    @foreach ($datas as $data)
                        <tr data-id="{{ $data->{'storeID'} }}">
                            <td class="left">
                                {{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}
                            </td>
                            <td class="left"> {{ $data->{'pkupPtCode'} }} </td>
                            <td class="left"> {{ $data->{'colBank'} }} </td>
                            <td class="left"> {{ $data->{'storeName'} }} </td>
                            <td class="right"> {{ $data->{'depositAmount'} }} </td>
                            <td><button style="border: none; outline: none; background: transparent;"
                                    class="text-primary" data-bs-target="#{{ $data->className }}"
                                    data-bs-toggle="modal">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <x-app.commercial-head.reports.unallocated.partials.wallet-modal :data="$data" />
                    @endforeach
                @endif
            </x-scrollable.scroll-body>
        </x-app.commercial-head.reports.unallocated.table-headers>
    </div>
</div>
