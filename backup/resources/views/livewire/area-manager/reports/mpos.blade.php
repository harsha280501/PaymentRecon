<div>
    <div class="row mt-3">
        <x-app.area-manager.reports.mpos.filters :stores="$stores" :filtering="$filtering" />
    </div>

    <x-app.area-manager.reports.mpos.table-headers :dataset="$datas">
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr data-id="{{ $data->{'Store ID'} }}">
                <td class="left"> {{ Carbon\Carbon::parse($data->Date)->format('d-m-Y') }} </td>
                <td class="right"> {{ $data->{'Store ID'} }} </td>
                <td class="right"> {{ $data->{'RETEK Code'} }} </td>
                <td class="right"> {{ $data->{'Brand Desc'} }} </td>
                <td class="right"> {{ $data->{'TOTAL'} }} </td>
                {{-- <td class="left"> {{ $data->{'AMAZON'} }} </td> --}}
                <td class="left"> {{ $data->{'Amex Offline Card'} }} </td>
                <td class="left"> {{ $data->{'Cash'} }} </td>
                <td class="left"> {{ $data->{'Customer Advance'} }} </td>
                {{-- <td class="left"> {{ $data->{'Falcon'} }} </td> --}}
                <td class="left"> {{ $data->{'HDFC Reco'} }} </td>
                <td class="left"> {{ $data->{'HDFC UPI'} }} </td>
                <td class="left"> {{ $data->{'ICICI Reco'} }} </td>
                <td class="left"> {{ $data->{'Innoviti Card'} }} </td>
                <td class="left"> {{ $data->{'Innoviti Phonepe'} }} </td>
                <td class="left"> {{ $data->{'Innoviti UPI'} }} </td>
                {{-- <td class="left"> {{ $data->{'Online COD'} }} </td> --}}
                {{-- <td class="left"> {{ $data->{'Online Prepay'} }} </td> --}}
                {{-- <td class="left"> {{ $data->{'Online Return'} }} </td> --}}
                {{-- <td class="left"> {{ $data->{'Other CC'} }} </td> --}}
                <td class="left"> {{ $data->{'Paytm'} }} </td>
                <td class="left"> {{ $data->{'Paytm QR'} }} </td>
                <td class="left"> {{ $data->{'PhonePe'} }} </td>
                <td class="left"> {{ $data->{'Plutus'} }} </td>
                {{-- <td class="left"> {{ $data->{'QC GC Redemption'} }} </td> --}}
                <td class="left"> {{ $data->{'SBI Reco'} }} </td>
                {{-- <td class="left"> {{ $data->{'Store Credit'} }} </td> --}}
                {{-- <td class="left"> {{ $data->{'TataCliq'} }} </td> --}}
                {{-- <td class="left"> {{ $data->{'UBI Reco'} }} </td> --}}
                {{-- <td class="left"> {{ $data->{'Vouchergram'} }} </td> --}}
                {{-- <td class="left"> {{ $data->{'WESTBURYFL'} }} </td> --}}
                {{-- <td class="left"> {{ $data->{'OTHERS'} }} </td> --}}
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
    </x-app.area-manager.reports.mpos.table-headers>



    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        $j('#select22-dropdown').on('change', function(e) {
            @this.set('filtering', true);
            @this.set('store', e.target.value);
        });

    </script>

</div>
