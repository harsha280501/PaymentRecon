<div x-data>
    <div class="row mt-3">
        <x-app.store-user.reports.mpos.filters :filtering="$filtering" :months="$_months" />
    </div>

    <x-app.store-user.reports.mpos.table-headers :orderBy="$orderBy" :dataset="$datas">
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr data-id="{{ $data->{'Store ID'} }}">
                <td colspan="4" class="left"> {{ !$data->Date ? '' : Carbon\Carbon::parse($data->Date)->format('d-m-Y') }} </td>
                <td colspan="1" style="text-align: right !important"> {{ $data->{'Cash'} }} </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
    </x-app.store-user.reports.mpos.table-headers>
</div>
