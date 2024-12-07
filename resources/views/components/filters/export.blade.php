<div x-data="{ show: false, timeout: null }" class="ms-auto d-flex align-items-center gap-2 w-mob-100" style="width: 100px" x-init="@this.on('no-data', () => { 
        clearTimeout(timeout); show = true; timeout = setTimeout(() => { show = false }, 3000); 
})" style="position: relative">
    <p class="alert alert-sm alert-info" x-show="show" style="padding: .5em 1em; margin-top: 11px; position: absolute; z-index: 9999; width: 200px; right:10%">No Data to Export</p>

    <div class="btn-group export1 w-mob-100">
        <button type="button" class="dropdown-toggle d-flex btn mb-1 justify-content-center" style="background: #e7e7e7; color: #000;" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Export
        </button>
        <div style="z-index: 999999999 !important" class="dropdown-menu w-mob-100" aria-labelledby="dropdownMenuButton1">
            <a href="#" class="dropdown-item" wire:click.prevent="export('Yesterday')">Yesterday</a>
            <a href="#" class="dropdown-item" wire:click.prevent="export('ThisWeek')">This Week</a>
            <a href="#" class="dropdown-item" wire:click.prevent="export('ThisMonth')">This Month</a>
            <a href="#" class="dropdown-item" wire:click.prevent="export('LastMonth')">Last Month</a>
            <a href="#" class="dropdown-item" wire:click.prevent="export('SixMonths')">6 months</a>
            <a href="#" class="dropdown-item" wire:click.prevent="export('ThisQuarter')">This Quarter</a>
            <a href="#" class="dropdown-item" wire:click.prevent="export('LastQuarter')">Last Quarter</a>
            <a href="#" class="dropdown-item" wire:click.prevent="export('ThisYear')">This year (Apr - Mar)</a>
        </div>
    </div>
</div>
