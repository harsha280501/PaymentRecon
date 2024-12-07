<div>
    {{-- <div class="row mb-2">
        <x-filters.date-filter />
    </div> --}}
    <div class="row mt-3">
        <x-app.commercial-head.reports.recon-summary.reconciliation-filters :filtering="$filtering" :stores="$stores" />
    </div>

    <x-livewire.CommercialHead.reconsummary-table-headers :dataset="$datas">
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
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">₹ 0.00</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">₹ 0.00</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">₹ 0.00</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->CASH }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->CARD }} / {{ $data->UPI }} / {{ $data->WALLET }} </td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->sales_total }}</td>
                <td class="right">{{ $data->total_cash_collection }}</td>
                <td class="right">{{ $data->total_card_collection }} / {{ $data->total_upi_collection }} / {{ $data->total_wallet_collection }}</td>
                <td class="right">{{ $data->collection_total }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->total_cash_difference }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->total_card_difference }}</td>
                <td style="background: rgba(0, 0, 0, 0.034)">{{ $data->difference }}</td>
            </tr>


            @endforeach


        </x-scrollable.scroll-body>
    </x-livewire.CommercialHead.reconsummary-table-headers>

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
