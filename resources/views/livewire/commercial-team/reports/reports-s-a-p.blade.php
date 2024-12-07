<div x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    }
}">
    <div class="row mt-3">
        <div class="col-lg-12 mb-3">
            <div class="d-flex gap-2 d-flex-mob" style="flex-wrap: wrap">

                <div style="display:@if ($filtering) unset @else none @endif" class="">
                    <button @click="() => {
                        $wire.back()
                        reset()    
                    }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>



                <x-filters.stores :stores="$stores" />

                <div>
                    <x-filters.location-brand :cities="$cities" :brands="$brands" />
                </div>

                <x-filters.months :months="$_months" />
                <x-filters.date-filter />
                <x-filters.simple-export />
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        {{-- Main sales table --}}
        <x-scrollable.scrollable :dataset="$reports">
            <x-scrollable.scroll-head>
                <tr>
                    <th class="left">
                        <div class="d-flex align-items-center gap-2">
                            <span>Sale Date</span>
                            <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                        </div>
                    </th>


                    <th>Store ID</th>
                    <th>Retek Code</th>
                    <th>Brand Desc</th>
                    <th>City</th>
                    <th style="text-align: right !important">AMEX</th>
                    <th style="text-align: right !important">HDFC</th>
                    <th style="text-align: right !important">ICICI</th>
                    <th style="text-align: right !important">SBI</th>
                    <th style="text-align: right !important">UPI-HDFC</th>
                    <th style="text-align: right !important">CASH</th>
                    <th style="text-align: right !important">PAYTM</th>
                    <th style="text-align: right !important">PHONE PE</th>
                    <th style="text-align: right !important">Total</th>
                    <th style="text-align: right !important">Vouchgram</th>
                    <th style="text-align: right !important">Gift. Vr. Reedemed</th>
                    <th style="text-align: right !important">Grand Total</th>
                </tr>
            </x-scrollable.scroll-head>

            <x-scrollable.scroll-body>
                @foreach ($reports as $data)
                <tr data-id="{{ $data->CALDAY }}">
                    <td class="left"> {{ !$data->CALDAY ? '' : Carbon\Carbon::parse($data->CALDAY)->format('d-m-Y') }} </td>
                    <td class="right"> {{ $data->{'Store ID'} }} </td>
                    <td class="right"> {{ $data->{'RETEK_CODE'} }} </td>
                    <td class="left"> {{ $data->{'Brand Desc'} }} </td>
                    <td class="left"> {{ $data->{'City'} }} </td>
                    <td style="text-align: right !important" class="right"> {{ $data->{'PAMX'} }} </td>
                    <td style="text-align: right !important" class="right"> {{ $data->{'PHDF'} }} </td>
                    <td style="text-align: right !important" class="right"> {{ $data->{'PICI'} }} </td>
                    <td style="text-align: right !important" class="right"> {{ $data->{'PSBI'} }} </td>
                    <td style="text-align: right !important" class="right"> {{ $data->{'HDFCUPI'} }} </td>
                    <td style="text-align: right !important" class="right"> {{ $data->{'CASH'} }} </td>
                    <td style="text-align: right !important" class="right"> {{ $data->{'MPAY'} }} </td>
                    <td style="text-align: right !important" class="right"> {{ $data->{'MPHP'} }} </td>
                    <td style="text-align: right !important" class="right"> {{ $data->{'STORE'} }} </td>
                    <td style="text-align: right !important" class="right"> {{ $data->{'Vouchgram'} }} </td>
                    <td style="text-align: right !important" class="right"> {{ $data->{'GIFT'} }} </td>
                    <td style="text-align: right !important" class="right"> {{ $data->{'GrandTotal'} }} </td>
                </tr>
                @endforeach
            </x-scrollable.scroll-body>
        </x-scrollable.scrollable>
    </div>
</div>
