<div x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    },
    resetOne() {
        this.start = null
    }
}">

    <div class="row mb-2">
        <div class="col-lg-12">
            <ul class="nav nav-tabs justify-content-start" role="tablist">
                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('overall-summary')
                        reset()
                    }" class="nav-link @if($activeTab === 'overall-summary') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                        Outstanding Summary
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-lg-3 d-flex align-items-center justify-content-end">
            <div class="btn-group mb-1">
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <x-app.store-user.reports.other-reports.overall-filter :filtering="$filtering" :months="$_months" />
    </div>


    <x-app.store-user.reports.other-reports.table-headers :orderBy="$orderBy" :dataset="$datas" :activeTab="$activeTab" :startdate="$startdate" :enddate="$enddate">

        @if($activeTab == 'overall-summary')
        <x-scrollable.scroll-body>
            @foreach ($datas as $data)
            <tr>
                <td class="right">{{ $data->retekCode }}</td>

                <td class="right" style=" background: rgba(0, 0, 0, 0.034)">{{
                    (($startdate != null && $enddate != null) && ($startdate == $enddate))
                    ? Carbon\Carbon::parse($startdate)->format('d-m-Y')
                    : $data->month
                    }}
                </td>

                <td style="text-align: right !important; background: rgba(253, 253, 253, 0.493)">{{ $data->OP_CASH }}</td>
                <td style="text-align: right !important; background: rgba(253, 253, 253, 0.493)">{{ $data->OP_CARD }}</td>
                <td style="text-align: right !important; background: rgba(253, 253, 253, 0.493)">{{ $data->OP_UPI }}</td>
                <td style="text-align: right !important; background: rgba(253, 253, 253, 0.493)">{{ $data->OP_WALLET }}</td>

                <td style="text-align: right !important; background: rgba(0, 0, 0, 0.034)">{{ $data->SALES_CASH }}</td>
                <td style="text-align: right !important; background: rgba(0, 0, 0, 0.034)">{{ $data->SALES_CARD }}</td>
                <td style="text-align: right !important; background: rgba(0, 0, 0, 0.034)">{{ $data->SALES_UPI }}</td>
                <td style="text-align: right !important; background: rgba(0, 0, 0, 0.034)">{{ $data->SALES_WALLET }}</td>

                <td style="text-align: right !important; background: rgba(253, 253, 253, 0.493)">{{ $data->COLL_CASH }}</td>
                <td style="text-align: right !important; background: rgba(253, 253, 253, 0.493)">{{ $data->COLL_CARD }}</td>
                <td style="text-align: right !important; background: rgba(253, 253, 253, 0.493)">{{ $data->COLL_UPI }}</td>
                <td style="text-align: right !important; background: rgba(253, 253, 253, 0.493)">{{ $data->COLL_WALLET }}</td>

                <td style="text-align: right !important; background: rgba(0, 0, 0, 0.034)">{{ $data->CL_CASH }}</td>
                <td style="text-align: right !important; background: rgba(0, 0, 0, 0.034)">{{ $data->CL_CARD }}</td>
                <td style="text-align: right !important; background: rgba(0, 0, 0, 0.034)">{{ $data->CL_UPI }}</td>
                <td style="text-align: right !important; background: rgba(0, 0, 0, 0.034)">{{ $data->CL_WALLET }}</td>
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
        @endif

    </x-app.store-user.reports.other-reports.table-headers>


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
