<div>
    <div class="row mt-3">
        <x-app.commercial-head.exceptions.cash-filters :banks="$banks" :filtering="$filtering" :months="$_months" :location="$locations" />
    </div>

    <x-app.commercial-head.exceptions.cash.table-headers :dataset="$datas" :orderBy="$orderBy">
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr data-id="{{ $data->{'storeID'} }}">
                <td class="left"> {{ Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }} </td>
                <td class="right"> {{ $data->{'colBank'} }} </td>
                <td class="right"> {{ $data->{'pkupPtCode'} }} </td>
                <td class="right"> {{ $data->{'depositAmount'} }} </td>
                <td class="left"> {{ $data->{'depSlipNo'} }} </td>
                <td class="left"> {{ $data->{'locationShort'} }} </td>
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
    </x-app.commercial-head.exceptions.cash.table-headers>



    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        $j('#select22-dropdown').on('change', function(e) {
            @this.set('filtering', true);
            @this.set('store', e.target.value);
        });

    </script>

</div>
