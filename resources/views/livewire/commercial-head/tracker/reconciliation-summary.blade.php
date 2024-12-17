<div>
    {{-- <div class="row mb-2">
        <x-filters.date-filter />
    </div> --}}
    <div class="row mt-3">
        <x-app.commercial-head.reports.recon-summary.reconciliation-filters :filtering="$filtering" :stores="$stores" :months="$_months" />
    </div>


    <div class="d-flex justify-content-center mt-2" style="flex-direction: column;">
        <div class="d-flex justify-content-center flex-column flex-md-row gap-md-4 align-items-center mb-4">
            {{-- Total Count --}}
            <div class="flex-main">
                <p class="mainheadtext">Total Sales: </p>
                <span class="blackh">{{ isset($datas[0]->TOTAL_SALES_SUM) ? $datas[0]->TOTAL_SALES_SUM : 0 }}</span>
            </div>

            <div class="flex-main">
                <p class="mainheadtext">Total Collection: </p>
                <span class="tealh">{{ isset($datas[0]->TOTAL_COLL_SUM) ? $datas[0]->TOTAL_COLL_SUM : 0 }}</span>
            </div>

            <div class="flex-main">
                <p class="mainheadtext">Total Difference: </p>
                <span class="lightcoralh">{{ isset($datas[0]->TOTAL_DIFF_SUM) ? $datas[0]->TOTAL_DIFF_SUM : 0 }}</span>
            </div>
        </div>
    </div>


    <x-livewire.CommercialHead.reconsummary-table-headers :orderBy="$orderBy" :dataset="$datas">
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr>
                <td class="left"> {{ $data->{'Store ID'} }} </td>
                <td class="left"> {{ $data->{'RETEK Code'} }} </td>
                <td class="left"> {{ $data->{'StoreTypeasperBrand'} }} </td>
                <td class="left"> {{ $data->{'Brand Desc'} }} </td>
                <td class="left"> {{ $data->{'Region'} }} </td>
                <td class="left"> {{ $data->{'Location'} }} </td>
                <td class="left"> {{ $data->{'City'} }} </td>
                <td class="left"> {{ $data->{'State'} }} </td>
                <td class="left">{{ Carbon\Carbon::parse($data->CALDAY)->format('d-m-Y') }}</td>
                <td class="right allcard-salesheader">{{ $data->CASH }}</td>
                <td class="right allcard-salesheader">{{ $data->CARD }}</td>
                <td class="right allcard-salesheader">{{ $data->UPI }}</td>
                <td class="right allcard-salesheader">{{ $data->WALLET }}</td>
                <td class="right allcard-salesheader">{{ $data->sales_total }}</td>
                <td class="right">{{ $data->total_cash_collection }}</td>
                <td class="right">{{ $data->total_card_collection }}</td>
                <td class="right">{{ $data->total_upi_collection }}</td>
                <td class="right">{{ $data->total_wallet_collection }}</td>
                <td class="right">{{ $data->collection_total }}</td>
                <td class="right allcard-salesheader">{{ $data->total_cash_difference }}</td>
                <td class="right allcard-salesheader">{{ $data->total_card_difference }}</td>
                <td class="right allcard-salesheader">{{ $data->total_upi_difference }}</td>
                <td class="right allcard-salesheader">{{ $data->total_wallet_difference }}</td>
                <td class="right allcard-salesheader">{{ $data->difference }}</td>
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
