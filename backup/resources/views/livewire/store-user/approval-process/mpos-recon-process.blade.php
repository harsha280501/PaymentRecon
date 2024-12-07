<div>
    {{--
    <x-app.store-user.approval-process.mpos-recon-process.tabs :activeTab="$activeTab" /> --}}

    {{-- Filter --}}
    <x-app.store-user.approval-process.mpos-recon-process.filters>
        <x-app.store-user.approval-process.mpos-recon-process.main-filters show="main" :activeTab="$activeTab" :filtering="$filtering" :months="$_months" />
    </x-app.store-user.approval-process.mpos-recon-process.filters>
    {{-- counts --}}
    <section>
        <x-app.store-user.approval-process.mpos-recon-process.counts :activeTab="$activeTab" :cashRecons="$cashRecons" />
    </section>

    <div class="col-lg-12">
        {{-- Main sales table --}}
        <x-scrollable.scrollable :dataset="$cashRecons">
            <x-scrollable.scroll-head>

                @if($activeTab == 'main')
                <tr>
                    <th>Sales Date</th>
                    <th>Desposit Date</th>
                    <th>Bank Drop ID</th>
                    <th>Desposit SlipNo</th>
                    <th>Status</th>
                    <th>Reconcilation Status</th>
                    <th style="text-align: right !important">Tender Amount</th>
                    <th style="text-align: right !important">Deposit Amount</th>
                    <th style="text-align: right !important">Tender to CashMIS Diff <br>[Tender - Deposit]</th>
                    <th>Store Response Entry</th>
                    <th>History</th>
                </tr>
                @endif

            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>

                @if($activeTab == 'main')
                @foreach ($cashRecons as $data)
                <tr>
                    <td>{{ Carbon\Carbon::parse($data->mposDate)->format('d-m-Y') }}</td>
                    <td>{{ Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}</td>
                    <td>{{ $data->bankDropID }}</td>
                    <td>{{ $data->depositSlipNo }}</td>
                    <td> @if( $data->cashMISStatus == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->cashMISStatus }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->cashMISStatus }}</span> @endif </td>
                    <td class="left">
                        @if($data->reconStatus == "Rejected") <span style="font-weight: 700; color: red;">{{ $data->reconStatus }}</span>
                        @elseif($data->reconStatus == "Approved") <span style="font-weight: 700; color: green;">{{ $data->reconStatus }}</span>
                        @else <span style="font-weight: 700; color: black;">{{ $data->reconStatus }}</span>
                        @endif </td>
                    <td style="text-align: right !important">{{ $data->tenderAmount }}</td>
                    <td style="text-align: right !important">{{ $data->depositAmount }}</td>
                    <td style="text-align: right !important">{{ $data->bankCashDifference }}</td>
                    <td>{{ $data->adjAmount }}</td>

                    <td><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalCenter_{{ $data->CashTenderBkDrpUID }}">View</a></td>

                    <x-app.store-user.approval-process.mpos-recon-process.modal :data="$data" />

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
