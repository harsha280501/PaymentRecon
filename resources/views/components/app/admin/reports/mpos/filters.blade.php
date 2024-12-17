<div class="col-lg-12 mb-3" x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    }
}">
    <div class="d-flex  gap-2 d-flex-mob">

        <div style="display:@if ($filtering) unset @else none @endif" class="">
            <button @click="() => {
                $wire.back()
                reset()    
            }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>



        <div class="">
            <div class="select mb-1">
                <select wire:model="datewise">
                    <option value="">All</option>
                    <option value="Yesterday">Yesterday</option>
                    <option value="ThisWeek">This Week</option>
                    <option value="ThisMonth">This month</option>
                    <option value="SixMonths">6 months</option>
                    <option value="ThisYear">This year</option>
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

                    @if($item['retekCode'] != '')
                    <option class="dropdown-list" value="{{ $item['retekCode'] }}">{{ $item["retekCode"] }}</option>
                    @endif

                    @endforeach
                </select>
            </div>
        </div>



        <form @submit.prevent="$wire.filterDate({start, end})" class="col-lg-7 d-flex d-flex-mob gap-2">
            <div>
                <input x-model="start" style="border: 1px solid #0000003f ; border-radius: 4px; outline: none; font-size: .9em; color: #000; padding: .3em; font-family: inherit" type="date">
            </div>
            <div>
                <input x-model="end" style="border: 1px solid #0000003f ; border-radius: 4px; outline: none; font-size: .9em; color: #000 ; padding: .3em; font-family: inherit" type="date">
            </div>
            <button class="btn-mob" style="border: none; outline: none; background: #e4e4e4; height: 70%; padding: .3em .5em; border-radius: 2px;" type="submit"><i class="fa fa-search"></i></button>
        </form>


        {{-- <div class="col-lg-4" style="float: right">
            <div class="btn-group export1" style="float: right">
                <button type="button" class="dropdown-toggle d-flex btn mb-1" style="background: #e7e7e7; color: #000;" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Export
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                 
                    <a href="#" class="dropdown-item" wire:click.prevent="export('Yesterday')">Yesterday</a>
                    <a href="#" class="dropdown-item" wire:click.prevent="export('ThisWeek')">This Week</a>
                    <a href="#" class="dropdown-item" wire:click.prevent="export('ThisMonth')">This Month</a>
                    <a href="#" class="dropdown-item" wire:click.prevent="export('SixMonths')">6 months</a>
                    <a href="#" class="dropdown-item" wire:click.prevent="export('ThisYear')">This year</a>
                </div>
            </div>
        </div> --}}

    </div>
</div>
