<div>
    <div class="row mt-3">
        <div class="col-lg-12 mb-3">
            <div class="d-flex">
                <div class="col-lg-1">
                    <div class="select">
                        <select wire:model="dateFilter">
                            <option value="MPOSSales">All</option>
                            <option value="Yesterday">Yesterday</option>
                            <option value="ThisWeek">This Week</option>
                            <option value="ThisMonth">This month</option>
                            <option value="SixMonths">6 months</option>
                            <option value="ThisYear">This year</option>
                        </select>
                    </div>
                </div>

                <form id="amanager-mpos-search-form" class="col-lg-7 d-flex gap-2">

                    <div>
                        <input id="startDate" value="{{ $dates['start'] }}"
                            style="border: 1px solid #0000003f ; border-radius: 4px; outline: none; font-size: .9em; color: #000; padding: .3em; font-family: inherit"
                            type="date">
                    </div>
                    <div>
                        <input id="endDate" value="{{ $dates['end'] }}"
                            style="border: 1px solid #0000003f ; border-radius: 4px; outline: none; font-size: .9em; color: #000 ; padding: .3em; font-family: inherit"
                            type="date">
                    </div>
                    <button
                        style="border: none; outline: none; background: #e4e4e4; height: 70%; padding: .3em .5em; border-radius: 2px;"
                        type="submit"><i class="fa fa-search"></i></button>
                </form>


                <div class="col-lg-4" style="float: right">
                    <div class="btn-group export1" style="float: right">
                        <button type="button" class="dropdown-toggle d-flex btn mb-1"
                            style="background: #e7e7e7; color: #000;" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"> Export
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                            <a href="#" class="dropdown-item" wire:click.prevent="exportYesterday">Yesterday</a>
                            <a href="#" class="dropdown-item" wire:click.prevent="exportThisWeek">This Week</a>
                            <a href="#" class="dropdown-item" wire:click.prevent="exportThisMonth">This Month</a>
                            <a href="#" class="dropdown-item" wire:click.prevent="exportSixMonth">6 months</a>
                            <a href="#" class="dropdown-item" wire:click.prevent="exportThisYear">This year</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        {{-- Main sales table --}}
        <div class="w-100" style="overflow-x: scroll">
            <x-livewire.area-manager.mpos-table-headers>
                <tbody wire:loading.class='d-none'>
                    @foreach ($datas as $data)
                    <tr data-id="{{ $data->TENDERTYPE }}">
                        <td class="left"> {{ $data->Date }} </td>
                        <td class="right"> {{ $data->{'RETEK Code'} }} </td>
                        <td class="right"> {{ $data->{'Store Name'} }} </td>
                        <td class="left"> {{ $data->{'Tender Value'} }} </td>
                        <td class="right"> {{ $data->{'TENDERTYPE'} }} </td>
                        <td class="right"> {{ $data->{'Tender Description'} }} </td>
                        <td class="right"> {{ $data->{'Transaction Type'} }} </td>
                    </tr>
                    @endforeach
                </tbody>
                </x-livewire.area-manager.mpos-table-headers>

                @if($datas->count() == 0) <p class="showEmptyAlertData">No data available</p>
                @endif

                <div wire:loading.class='show-loading-spinner' class="loading-spinner">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span>Loading</span>
                </div>

                <div class="mt-4">
                    {{ $datas->links() }}
                </div>
        </div>

    </div>
</div>
