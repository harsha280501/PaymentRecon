<div>

    <x-app.commercial-head.approval-process.mpos-recon-process.filters>
        <x-app.commercial-head.approval-process.mpos-recon-process.main-filters storeId="select100-dropdown" show="main" :activeTab="$activeTab" :filtering="$filtering" :stores="$storesM" />

    </x-app.commercial-head.approval-process.mpos-recon-process.filters>
    {{-- counts --}}
    <section>
        <x-app.commercial-head.approval-process.mpos-recon-process.counts :activeTab="$activeTab" :cashRecons="$cashRecons" />
    </section>

    <div class="col-lg-12">
        {{-- Main sales table --}}
        <x-scrollable.scrollable :dataset="$cashRecons">
            <x-scrollable.scroll-head>

                @if($activeTab == 'main')
                <tr>
                    <th class="left">Sales Date</th>
                    <th class="left">Desposit Date</th>
                    <th class="left">Store ID</th>
                    <th class="left">Retek Code</th>
                    <th class="left">Brand Name</th>
                    <th class="left">Colleciton Bank</th>
                    <th class="left">Tender to BankMIS Status</th>
                    <th class="left">Reconciliation Status</th>
                    <th class="left">Bank Drop ID</th>
                    <th class="left">Desposit SlipNo</th>
                    <th class="left" style="text-align: right !important">Tender Amount</th>
                    <th class="left" style="text-align: right !important">Deposit Amount</th>
                    <th class="left" style="text-align: right !important">Tender to CashMIS Diff <br>[Tender - Deposit]</th>
                    <th class="left">Store Response Entry</th>
                    <th class="left">History</th>
                </tr>
                @endif

            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>

                @if($activeTab == 'main')
                @foreach ($cashRecons as $data)
                <tr>
                    <td class="right">{{ !$data->mposDate ? '' : Carbon\Carbon::parse($data->mposDate)->format('d-m-Y') }}</td>
                    <td class="right">{{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}</td>
                    <td class="right">{{ $data->storeID }}</td>
                    <td class="right">{{ $data->retekCode }}</td>
                    <td class="right">{{ $data->brand }}</td>
                    <td class="right">{{ $data->colBank }}</td>

                    <td class="left"> @if( $data->cashMISStatus == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->cashMISStatus }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->cashMISStatus }}</span> @endif </td>

                    <td class="left">
                        @if($data->reconStatus == "Rejected") <span style="font-weight: 700; color: red;">{{ $data->reconStatus }}</span>
                        @elseif($data->reconStatus == "Approved") <span style="font-weight: 700; color: green;">{{ $data->reconStatus }}</span>
                        @else <span style="font-weight: 700; color: black;">{{ $data->reconStatus }}</span>
                        @endif </td>

                    <td class="right">{{ $data->bankDropID }}</td>
                    <td class="right">{{ $data->depositSlipNo }}</td>

                    <td class="right">{{ $data->tenderAmount }}</td>
                    <td class="right">{{ $data->depositAmount }}</td>
                    <td class="right">{{ $data->bankCashDifference }}</td>

                    <td class="right">{{ $data->adjAmount }}</td>
                    <td class="right"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalCenter_{{ $data->CashTenderBkDrpUID }}">View</a></td>

                    <x-app.commercial-head.approval-process.mpos-recon-process.modal :data="$data" />
                </tr>
                @endforeach
                @endif

            </x-scrollable.scroll-body>
        </x-scrollable.scrollable>


        <script>
            var $j = jQuery.noConflict();
            $j('.searchField').select2();


            document.addEventListener('livewire:load', function() {
                $j('#select100-dropdown').on('change', function(e) {
                    @this.set('filtering', true);
                    @this.set('store', e.target.value);
                });


                $j('#approval-filter').on('change', function(e) {
                    @this.set('filtering', true);
                    @this.set('status', e.target.value);
                });
            });

        </script>

    </div>
