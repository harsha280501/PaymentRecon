<div x-data>
    <div class="row mt-3">
        <x-app.commercial-head.reports.mpos.filters :stores="$stores" :filtering="$filtering" :months="$_months" :cities="$cities" :brands="$brands" />
    </div>

    <x-app.commercial-head.reports.mpos.table-headers :orderBy="$orderBy" :dataset="$datas">
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr data-id="{{ $data->{'Store ID'} }}">
                <td class="left"> {{ Carbon\Carbon::parse($data->Date)->format('d-m-Y') }} </td>
                <td class="right"> {{ $data->{'Store ID'} }} </td>
                <td class="right"> {{ $data->{'RETEK Code'} }} </td>
                <td class="right"> {{ $data->{'Brand Desc'} }} </td>
                <td class="right"> {{ $data->{'City'} }} </td>
                <td style="text-align: right !important" class="left"> {{ $data->{'Cash'} }} </td>
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
    </x-app.commercial-head.reports.mpos.table-headers>

    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        $j('#select22-dropdown').on('change', function(e) {
            @this.set('filtering', true);
            @this.set('store', e.target.value);
        });

    </script>

</div>
