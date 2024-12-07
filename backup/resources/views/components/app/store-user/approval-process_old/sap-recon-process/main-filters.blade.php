<div x-data='{
    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    }
}'>
    <div class="d-flex d-flex-mob gap-2" style="@if($activeTab !== $show) display: none !important @endif">
        <div style="display:@if ($filtering) unset @else none @endif" class="">
            <button @click="() => {
                $wire.back()
                reset()
            }" style="background: transparent; outline: none; border: none; padding: .5em 1em; font-size: 1em">
                <i class="fa fa-arrow-left"></i>
            </button>
        </div>

        <div wire:ignore class="">
            <select id="approval-filter" class="custom-select select2 form-control searchField " data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                <option selected disabled value="" class="dropdown-item">SELECT APPROVAL STATUS</option>
                <option value="" class="dropdown-item">ALL</option>
                <option class="dropdown-list" value="approve">Approved</option>
                <option class="dropdown-list" value="disapprove">Rejected</option>
            </select>
        </div>

        <x-filters.months :months="$months" />
        <x-filters.date-filter />
        <x-filters.simple-export />

    </div>
</div>
