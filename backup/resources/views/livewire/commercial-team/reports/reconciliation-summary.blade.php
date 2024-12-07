<div>
    {{-- <div class="row mb-2">
        <x-filters.date-filter />
    </div> --}}
    <div class="row mt-3">
        <x-app.commercial-team.reports.recon-summary.reconciliation-filters :filtering="$filtering" :stores="$stores"
            :months="$_months" />
    </div>


    <div class="d-flex justify-content-center mt-2" style="flex-direction: column;">
        <div class="d-flex justify-content-center flex-column flex-md-row gap-md-4 align-items-center mb-4">
            {{-- Total Count --}}
            <div class="flex-main">
                <p style="font-size: 1.01em; color: #000; margin: 0">Total Sales: </p>
                <span style="color: black; font-weight: 900;">{{ isset($datas[0]->TOTAL_SALES_SUM) ?
                    $datas[0]->TOTAL_SALES_SUM : 0 }}</span>
            </div>

            <div class="flex-main">
                <p style="font-size: 1.01em; color: #000; margin: 0">Total Collection: </p>
                <span style="color: teal; font-weight: 900;">{{ isset($datas[0]->TOTAL_COLL_SUM) ?
                    $datas[0]->TOTAL_COLL_SUM : 0 }}</span>
            </div>

            <div class="flex-main">
                <p style="font-size: 1.01em; color: #000; margin: 0">Total Difference: </p>
                <span style="color: lightcoral; font-weight: 900;">{{ isset($datas[0]->TOTAL_DIFF_SUM) ?
                    $datas[0]->TOTAL_DIFF_SUM : 0 }}</span>
            </div>
        </div>
    </div>


    <x-livewire.CommercialTeam.reconsummary-table-headers :orderBy="$orderBy" :dataset="$datas">
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr>
                <td class="right"> {{ $data->{'Store ID'} }} </td>
                <td class="right"> {{ $data->{'RETEK Code'} }} </td>
                <td class="right"> {{ $data->{'StoreTypeasperBrand'} }} </td>
                <td class="right"> {{ $data->{'Brand Desc'} }} </td>
                <td class="right"> {{ $data->{'Region'} }} </td>
                <td class="right"> {{ $data->{'Location'} }} </td>
                <td class="right"> {{ $data->{'City'} }} </td>
                <td class="right"> {{ $data->{'State'} }} </td>
                <td class="right">{{ Carbon\Carbon::parse($data->CALDAY)->format('d-m-Y') }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->CASH }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->CARD }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->UPI }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->WALLET }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->sales_total }}</td>
                <td class="right">{{ $data->total_cash_collection }}</td>
                <td class="right">{{ $data->total_card_collection }}</td>
                <td class="right">{{ $data->total_upi_collection }}</td>
                <td class="right">{{ $data->total_wallet_collection }}</td>
                <td class="right">{{ $data->collection_total }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->total_cash_difference }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->total_card_difference }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->total_upi_difference }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->total_wallet_difference }}</td>
                <td style="background: rgba(0, 0, 0, 0.034)">{{ $data->difference }}</td>
            </tr>


            @endforeach


        </x-scrollable.scroll-body>
        </x-livewire.CommercialTeam.reconsummary-table-headers>

        <script>
            var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {
            $j('#select1-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });
        });

        </script>
</div>