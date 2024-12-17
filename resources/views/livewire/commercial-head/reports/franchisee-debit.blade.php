<div x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null;
        this.end = null
    }
}">

    <x-app.commercial-head.reports.franchise-debit.filters :filtering="$filtering" :brands="$brands" :stores="$stores" :banks="$banks" :months="$_months" />

    <div class="col-lg-12 mt-3" style="overflow: hidden">
        <x-scrollable.scrollable :dataset="$cashRecons">
            <x-scrollable.scroll-head>

                <tr>
                    <th scope="col" class="left">Store ID</th>
                    <th scope="col" class="left">Brand</th>
                    <th scope="col" class="left">Tender</th>
                    <th scope="col">
                        <div class="d-flex align-items-center gap-2 left">
                            <span>Sales Period</span>
                            <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                        </div>
                    </th>
                    <th scope="col" class="left">Date Of Debit</th>
                    <th scope="col" class="left">Document No</th>
                    <th scope="col" class="right">Amount</th>
                </tr>

            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>

                @foreach ($cashRecons as $data)
                <tr>
                    <td class="left">{{ $data->storeID }}</td>
                    <td class="left">{{ $data->brand }}</td>
                    <td class="left">{{ $data->colBank }}</td>
                    <td class="left"> {{ !$data->salesPeriod ? '' : Carbon\Carbon::parse($data->salesPeriod)->format('d-m-Y') }} </td>
                    <td class="left"> {{ !$data->dateOfDebit ? '' : Carbon\Carbon::parse($data->dateOfDebit)->format('d-m-Y') }} </td>
                    <td class="left">{{ $data->docNo }}</td>
                    <td class="right"> {{ $data->debit }} </td>
                </tr>
                @endforeach

            </x-scrollable.scroll-body>
        </x-scrollable.scrollable>
    </div>



    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {
            $j('#select1-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('brand', e.target.value);
            });
            $j('#select2-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('bank', e.target.value);
            });
        });

    </script>
</div>
