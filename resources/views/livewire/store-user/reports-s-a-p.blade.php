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
            <div class="d-flex gap-2 d-flex-mob align-items-center">
                <div style="display:@if ($filtering) unset @else none @endif" class="">
                    <button @click="() => {
                        $wire.back()
                        reset()    
                    }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>
                <div style="margin-top: 7px" class="w-mob-100">
                    <x-filters.months :months="$_months" />
                </div>

                <x-filters.date-filter />


                <x-filters.simple-export />
            </div>
        </div>
    </div>


    <div class="col-lg-12">

        <x-livewire.storeuser.sap-table-headers :orderBy="$orderBy" :dataset="$reports">
            <x-scrollable.scroll-body>
                @foreach ($reports as $data)
                <tr data-id="{{ $data->CALDAY }}">
                    <td class="left"> {{ !$data->CALDAY ? '' : Carbon\Carbon::parse($data->CALDAY)->format('d-m-Y') }} </td>
                    <td style="text-align: right !important"> {{ $data->{'PAMX'} }} </td>
                    <td style="text-align: right !important"> {{ $data->{'PHDF'} }} </td>
                    <td style="text-align: right !important"> {{ $data->{'PICI'} }} </td>
                    <td style="text-align: right !important"> {{ $data->{'PSBI'} }} </td>
                    {{-- <td style="text-align: right !important"> {{ $data->{'UPIA'} }} </td> --}}
                    <td style="text-align: right !important"> {{ $data->{'HDFCUPI'} }} </td>
                    <td style="text-align: right !important"> {{ $data->{'CASH'} }} </td>
                    <td style="text-align: right !important"> {{ $data->{'MPAY'} }} </td>
                    <td style="text-align: right !important"> {{ $data->{'MPHP'} }} </td>
                    <td style="text-align: right !important"> {{ $data->{'STORE'} }} </td>
                    <td style="text-align: right !important"> {{ $data->{'Vouchgram'} }} </td>
                    <td style="text-align: right !important"> {{ $data->{'GIFT'} }} </td>
                    <td style="text-align: right !important"> {{ $data->{'GrandTotal'} }} </td>
                </tr>
                @endforeach
            </x-scrollable.scroll-body>
        </x-livewire.storeuser.sap-table-headers>



        <script>
            var $j = jQuery.noConflict();
            $j('.searchField').select2();


            $j('#select22-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });

        </script>
    </div>
