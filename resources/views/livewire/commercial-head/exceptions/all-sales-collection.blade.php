<div>
    <div class="row mt-3">
        <x-app.commercial-head.reports.recon-summary.filters :filtering="$filtering" :stores="$stores" />
    </div>

    <x-app.commercial-head.reports.recon-summary.table-headers :dataset="$datas">
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ Carbon\Carbon::parse($data->CALDAY)->format('d-m-Y') }}</td>
                {{-- <td class="right">{{ $data-> }}</td> --}}
                <td class="right">{{ $data->storeID }}</td>
                <td class="right">{{ $data->retekCode }}</td>
                <td class="right">{{ $data->CARD }}</td>
                <td class="right">{{ $data->UPI }}</td>
                <td class="right">{{ $data->WALLET }}</td>
                <td class="right">{{ $data->sales_total }}</td>
                <td style="font-weight: 700; color: @if($data->status == 'Matched') green @else red @endif">{{ $data->status }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->HDFC }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->AMEX }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->SBI }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->ICICI }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->UPIH }}</td>

                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->PhonePe }}</td>
                <td class="right" style="background: rgba(0, 0, 0, 0.034)">{{ $data->PayTM }}</td>

                <td class="right">{{ $data->total_card_collection }}</td>
                <td class="right">{{ $data->total_upi_collection }}</td>
                <td class="right">{{ $data->total_wallet_collection }}</td>
                <td class="right">{{ $data->collection_total }}</td>

                <td>{{ $data->difference }}</td>
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
    </x-app.commercial-head.reports.recon-summary.table-headers>


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
