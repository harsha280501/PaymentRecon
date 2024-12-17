<section id="recent" class="process-page" x-data="{
    start:null,
    end:null,
    reset(){
        this.start = null
        this.end=null
    }
}">

    <x-app.commercial-team.process.sap-recon.wallet-recon.filters :activeTab="$activeTab" :filtering="$filtering" :walletBanks="$walletBanks" :months="$_months" :stores="$stores" />


    <x-app.commercial-team.process.sap-recon.wallet-recon.process-page :orderBy=" $orderBy" :dataset="$dataset">
        <x-scrollable.scroll-body>

            @if($activeTab == 'wallet')
            @foreach ($dataset as $data)
            <tr>
                <td>{{ !$data->transactionDate ? '' : Carbon\Carbon::parse($data->transactionDate)->format('d-m-Y') }}</td>
                <td>{{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}</td>
                <td>{{ $data->storeID }}</td>
                <td>{{ $data->retekCode }}</td>
                <td>{{ $data->brand }}</td>
                <td>{{ $data->collectionBank }}</td>
                <td style="text-align: right !important">{{ number_format($data->walletSale, 2) }}</td>
                <td style="text-align: right !important">{{ number_format($data->depositAmount, 2) }}</td>
                <td style="text-align: right !important">{{ number_format($data->diffSaleDeposit, 2) }}</td>
                <td style="text-align: right !important">{{ $data->calculatedDifference }}</td>
                <td style="text-align: right !important">{{ $data->summed_adjustment }}</td>

                <td style="font-weight: 700; color: @if($data->status == 'Matched') teal @else red @endif">{{
                    $data->status }}
                </td>
                <td>
                    {{ $data->reconStatus == 'disapprove' ? 'Rejected' : $data->reconStatus }}
                </td>

                <td><a href="#" data-bs-target="#exampleModalCenter_{{ $data->walletSalesRecoUID }}" style="font-size: 1.1em" data-bs-toggle="modal">View</a></td>
            </tr>
            {{-- modal --}}
            <x-app.commercial-team.process.sap-recon.wallet-recon.modal :data="$data" :remarks="$remarks" />
            @endforeach
            @endif

        </x-scrollable.scroll-body>
    </x-app.commercial-team.process.sap-recon.wallet-recon.process-page>

    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {

            $j('#select1-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('bank', e.target.value);
            });
            $j('#select2-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('bank', e.target.value);
            });
        });

    </script>

</section>
