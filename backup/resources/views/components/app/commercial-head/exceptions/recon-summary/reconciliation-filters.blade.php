<div class="col-lg-12 mb-3" x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    }
}">
    <div class="d-flex align-items-center gap-2 d-flex-mob">

        <div style="display:@if ($filtering) unset @else none @endif" class="">
            <button @click="() => {
                $wire.back()
                reset()
            }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>


        <div style="margin-top: 7px">
            <div style="width: 220px" wire:ignore>
                <select id="select1-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown">

                    <option value="" class="dropdown-item">SELECT STORE ID</option>
                    <option value="" class="dropdown-item">ALL</option>
                    <option selected value="6136" class="dropdown-item">6136</option>

                    @foreach($stores as $item)

                    @php
                    $item = (array) $item;
                    @endphp

                    @if($item['Store ID'] != '')
                    <option class="dropdown-list" value="{{ $item['Store ID'] }}">{{ $item["Store ID"] }}</option>
                    @endif

                    @endforeach
                </select>
            </div>
        </div>

        <x-filters.date-filter />

        <div style="flex: 1">
        </div>
        <div class="">
            <div class="btn-group export1">
                <button type="button" class="dropdown-toggle d-flex btn mb-1" style="background: #e7e7e7; color: #000;"
                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Export
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <a href="#" class="dropdown-item" wire:click.prevent="export('Yesterday')">Yesterday</a>
                    <a href="#" class="dropdown-item" wire:click.prevent="export('ThisWeek')">This Week</a>
                    <a href="#" class="dropdown-item" wire:click.prevent="export('ThisMonth')">This Month</a>
                    <a href="#" class="dropdown-item" wire:click.prevent="export('SixMonths')">6 months</a>
                    <a href="#" class="dropdown-item" wire:click.prevent="export('ThisQuarter')">This Quarter</a>
                    <a href="#" class="dropdown-item" wire:click.prevent="export('LastQuarter')">Last Quarter</a>
                    <a href="#" class="dropdown-item" wire:click.prevent="export('ThisYear')">This year(Apr-Mar)</a>
                </div>
            </div>
        </div>
    </div>
</div>
