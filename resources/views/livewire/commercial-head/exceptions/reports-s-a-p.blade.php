<div x-data>
    <div class="row mt-3">
        <div class="col-lg-12 mb-3">
            <div class="d-flex gap-2 d-flex-mob">


                <div style="display:@if ($filtering) unset @else none @endif" class="">
                    <button wire:click="back" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>

                <div class="">
                    <div class="select mb-1">
                        <select wire:model="datewise">
                            <option value="SAPSales">All</option>
                            <option value="Yesterday">Yesterday</option>
                            <option value="ThisWeek">This Week</option>
                            <option value="ThisMonth">This month</option>
                            <option value="SixMonths">6 months</option>
                            <option value="ThisQuarter">This Quarter</option>
                            <option value="LastQuarter">Last Quarter</option>
                            <option value="ThisYear">This year(Apr-Mar)</option>
                        </select>
                    </div>
                </div>

                <div class="">
                    <div style="width: 220px" wire:ignore>
                        <select id="select22-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown">

                            <option selected value="" class="dropdown-item">SELECT STORE ID</option>
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


                <form wire:ignore id="sap-search-form" class="d-flex d-flex-mob gap-2 align-items-center" style="flex: 1; margin-top: -10px;">
                    <div>
                        <input id="startDate" class="date-filter" type="date">
                    </div>
                    <div>
                        <input id="endDate" class="date-filter" type="date">
                    </div>
                    <button class="btn-mob" style="border: none; outline: none; background: #e4e4e4;  padding: .3em .5em; border-radius: 2px;" type="submit"><i class="fa fa-search"></i></button>
                </form>



                <div class="col-lg-4" style="float: right">
                    <div class="btn-group export1" style="float: right">
                        <button type="button" class="dropdown-toggle d-flex btn mb-1" style="background: #e7e7e7; color: #000;" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Export
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            {{-- <a class="dropdown-item" wire:click.prevent="export">Export Excel</a> --}}
                            <a href="#" class="dropdown-item" wire:click.prevent="export('Yesterday')">Yesterday</a>
                            <a href="#" class="dropdown-item" wire:click.prevent="export('ThisWeek')">This Week</a>
                            <a href="#" class="dropdown-item" wire:click.prevent="export('ThisMonth')">This Month</a>
                            <a href="#" class="dropdown-item" wire:click.prevent="export('SixMonths')">6 months</a>
                            <a href="#" class="dropdown-item" wire:click.prevent="export('ThisQuater')">This Quarter</a>
                            <a href="#" class="dropdown-item" wire:click.prevent="export('LastQuarter')">Last Quarter</a>
                            <a href="#" class="dropdown-item" wire:click.prevent="export('ThisYear')">This year(Apr-Mar)</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        {{-- Main sales table --}}
        <x-scrollable.scrollable :dataset="$reports">
            <x-scrollable.scroll-head>
                <tr>
                    <th>Sale Date</th>
                    <th>Store ID</th>
                    <th>Retek Code</th>
                    <th>Brand Desc</th>
                    <th>AMEX</th>
                    <th>HDFC</th>
                    <th>ICICI</th>
                    <th>SBI</th>
                    <th>UPI OTHERS</th>
                    <th>UPI-HDFC</th>
                    <th>CASH</th>
                    <th>PAYTM</th>
                    <th>PHONE PE</th>
                    <th>Total</th>
                </tr>
            </x-scrollable.scroll-head>

            <x-scrollable.scroll-body>
                @foreach ($reports as $data)
                <tr data-id="{{ $data->CALDAY }}">
                    <td class="left"> {{ Carbon\Carbon::parse($data->CALDAY)->format('d-m-Y') }} </td>
                    <td class="right"> {{ $data->{'Store ID'} }} </td>
                    <td class="right"> {{ $data->{'RETEK_CODE'} }} </td>
                    <td class="left"> {{ $data->{'Brand Desc'} }} </td>
                    <td class="right"> {{ $data->{'PAMX'} }} </td>
                    <td class="right"> {{ $data->{'PHDF'} }} </td>
                    <td class="right"> {{ $data->{'PICI'} }} </td>
                    <td class="right"> {{ $data->{'PSBI'} }} </td>
                    <td class="right"> {{ $data->{'UPIA'} }} </td>
                    <td class="right"> {{ $data->{'UPIH'} }} </td>
                    <td class="right"> {{ $data->{'CASH'} }} </td>
                    <td class="right"> {{ $data->{'MPAY'} }} </td>
                    <td class="right"> {{ $data->{'MPHP'} }} </td>
                    <td class="right"> {{ $data->{'STORE'} }} </td>
                </tr>
                @endforeach
            </x-scrollable.scroll-body>
        </x-scrollable.scrollable>
    </div>
</div>

<script>
    var $j = jQuery.noConflict();
    $j('.searchField').select2();


    $j('#select22-dropdown').on('change', function(e) {
        @this.set('filtering', true);
        @this.set('store', e.target.value);
    });

</script>
</div>
