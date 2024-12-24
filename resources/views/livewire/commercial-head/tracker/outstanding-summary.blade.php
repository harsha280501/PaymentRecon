<div x-data="{
    start: null,
    end: null,
    reset(){
        this.start = null
    }
}">


    <div class="col-lg-12 mb-3">
        <div class="d-flex align-items-center gap-2 d-flex-mob">

            <div style="display:@if ($filtering) unset @else none @endif" class="">
                <button @click="() => {
                $wire.back()
                reset()
            }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </div>



            <div class="w-mob-100">
                <div wire:ignore class="w-mob-100">
                    <select id="outstanding_storeFilter" style="width: 220px" class="custom-select select2 form-control searchField w-mob-100" data-live-search="true" data-bs-toggle="dropdown">

                        <option value="" class="dropdown-item" selected>SELECT STORE ID</option>
                        <option value="" class="dropdown-item">ALL</option>

                        @foreach($stores as $item)

                        @php
                        $item = (array) $item;
                        @endphp

                        @if($item['storeID'] != '')
                        <option class="dropdown-list" value="{{ $item['storeID'] }}">{{ $item["storeID"] }}</option>
                        @endif

                        @endforeach
                    </select>
                </div>
            </div>


            <div class="w-mob-100" style="margin-top: 7px">
                <div>
                    <div>
                        <form @submit.prevent="$wire.filterDate({start, end: start})" class="d-flex d-flex-mob gap-1 timeline-filter">
                            <div>
                                <input x-model="start" id="startDate" class="date-filter w-mob-100" type="date">
                            </div>
                            <button class="btn-mob w-mob-100 p-md-2 px-2 py-1" style="outline: none; border: none; padding: 0 .5em; border-radius: 4px">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
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
                    <th>Store ID</th>
                    <th>Retek Code</th>
                    <th>Brand</th>
                    <th style="text-align: right !important">Opening Balance</th>
                    <th style="text-align: right !important">Sales</th>
                    <th style="text-align: right !important">Collection</th>
                    <th style="text-align: right !important">Store Response</th>

                    <th style="text-align: center !important">
                        <div>Closing Balance</div>
                        <div style="font-size: 1.1em; font-weight: normal;">[Sales-Collection-Store Response]</div>
                    </th>
                </tr>
            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>

                @foreach ($datas as $data)
                <tr>
                    <td class="left">{{ $data->storeID }}</td>
                    <td class="left">{{ $data->retekCode }}</td>
                    <td class="left">{{ $data->brand }}</td>
                    <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->OP_TOTAL }}</td>
                    <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->SALES_TOTAL }}</td>
                    <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->COLL_TOTAL }}</td>
                    <td class="right" style="background: rgba(0, 0, 0, 0.034); text-align: right !important">{{ $data->adjustmentTotal }}</td>
                    <td class="center" style="background: rgba(0, 0, 0, 0.034); text-align: center !important">{{ $data->CL_TOTAL }}</td>
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
