<div x-data="{
    start: null,
    end: null,
    reset() {
        this.start = null
    }
}">
    <div class="col-lg-12 mb-3">
        <div class="d-flex align-items-center gap-2 d-flex-mob">

            <div style="display:@if ($filtering) unset @else none @endif" class="">
                <button @click="() => {
                $wire.back()
                reset()
            }"
                    style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </div>

            <x-filters.months :months="$_months" />
            <x-filters.date-filter />
            <x-filters.simple-export />

        </div>
    </div>

    <div style="display: block;text-align: center;">
        <p style="font-size: 1.2em; color: #000; font-weight: 700;">Balance as on
            <span style="color: green;">
                {{ !$startDate ? now()->format('d-m-Y') : Carbon\Carbon::parse($startDate)->format('d-m-Y') }}
            </span>
        </p>
    </div>

    <div class="col-lg-12 wrapper">
        <x-scrollable.scrollable :dataset="$datas">
            <x-scrollable.scroll-head>
                <tr>
                    <th>Date</th>
                    <th style="text-align: right !important">Opening Balance</th>
                    <th style=" text-align: right !important">Sales</th>
                    <th style="text-align: right !important">Collection</th>
                    <th style="text-align: right !important">Store Response</th>
                    <th style="text-align: right !important">Closing Balance
                        <br>[OpenBal+Sales-Collection-StoreResponse]
                    </th>
                </tr>
            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>

                @foreach ($datas as $data)
                    <tr>
                        <td class="left">{{ \Carbon\Carbon::parse($data->Date)->format('d-m-Y') }}</td>
                        <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">
                            {{ $data->OP_TOTAL }}</td>
                        <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">
                            {{ $data->SALES_TOTAL }}</td>
                        <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">
                            {{ $data->COLL_TOTAL }}</td>
                        <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">
                            {{ $data->adjustmentTotal }}</td>
                        <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">
                            {{ $data->CL_TOTAL }} </td>
                    </tr>
                @endforeach

            </x-scrollable.scroll-body>
        </x-scrollable.scrollable>
    </div>

    {{-- filter scripts --}}
    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {

            $j('#outstanding_storeFilter').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });
        });
    </script>
</div>
