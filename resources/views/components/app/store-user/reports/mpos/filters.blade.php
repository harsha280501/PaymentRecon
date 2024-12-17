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
            }"
                style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>

        {{-- <div class="w-mob-100">
            <div class="select mb-1 w-mob-100">
                <select wire:model="datewise">
                    <option value="">All</option>
                    <option value="Yesterday">Yesterday</option>
                    <option value="ThisWeek">This Week</option>
                    <option value="ThisMonth">This month</option>
                    <option value="SixMonths">6 months</option>
                    <option value="ThisQuarter">This Quarter</option>
                    <option value="LastQuarter">Last Quarter</option>
                    <option value="ThisYear">This Year (Apr - Mar)</option>
                </select>
            </div>
        </div> --}}
        <div style="margin-top: 7px" class="w-mob-100">
            <x-filters.months :months="$months" />
        </div>


        <x-filters.date-filter />
        <x-filters.simple-export />
    </div>
</div>