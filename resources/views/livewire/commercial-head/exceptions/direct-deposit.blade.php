<div x-data>


    <div class="col-lg-12 mb-3" x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    }
}">
        <div class="d-flex gap-2 d-flex-mob mt-2">

            <div style="display:@if ($filtering) unset @else none @endif" class="">
                <button @click="() => {
                    $wire.back()
                    reset()    
                }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </div>


            @php
            $remarks = [['remarks' => 'DIRECT DEPOSIT'], ['remarks' => 'RTGS/NEFT Transaction'], ['remarks' => 'Unallocated Insert']];
            @endphp
            <x-filters.extensions.dropdown_one :dataset="$remarks" keys="remarks" initialValue="SELECT DEPOSIT THROUGH" />

            <x-filters.dropdown :dataset="$stores" keys="store" initialValue="SELECT A STORE" />

            <x-filters.months :months="$_months" />
            <div>
                <x-filters.date-filter />
            </div>
            <x-filters.simple-export />
        </div>
    </div>


    <div class="text-center">
        <h1 class="h4" style="color: #000;">Total Deposit: <span class="text-primary">{{ isset($dataset[0]->totalAmount) ? $dataset[0]->totalAmount : '0' }}</span></h1>
    </div>

    <x-scrollable.scrollable :dataset="$dataset">
        <x-scrollable.scroll-head>
            <tr>
                <th class="left first-col sticky-col bggrey">
                    <div class="d-flex align-items-center gap-2">
                        <span>Deposit Date</span>
                        <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy('mposDate')" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                    </div>
                </th>

                <td class="left">Credit Date</td>
                <td class="left">Store ID</td>
                <td class="left">Retek Code</td>
                <td class="left">Brand</td>
                <td class="left">Location</td>
                <td class="left">Deposit Through</td>
                <td class="left">Collection Bank</td>
                <td class="right">Deposit Amount</td>

            </tr>
        </x-scrollable.scroll-head>
        <x-scrollable.scroll-body>
            @foreach ($dataset as $data)
            <tr>
                <td class="left">{{ !$data->depositDt ? '' : Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                <td class="left">{{ !$data->crDt ? '' : Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}</td>
                <td class="left">{{ $data->storeID }}</td>
                <td class="left">{{ $data->retekCode }}</td>
                <td class="left">{{ $data->brand }}</td>
                <td class="left">{{ $data->locationName }}</td>
                <td class="left">{{ $data->depositThrough }}</td>
                <td class="left">{{ $data->colBank }}</td>
                <td class="right">{{ $data->depositAmount }}</td>
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
    </x-scrollable.scrollable>


    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {
            $j('#status').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('status', e.target.value);
            });
        });

    </script>


</div>
