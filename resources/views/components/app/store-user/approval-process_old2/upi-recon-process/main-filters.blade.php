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

        <x-filters.months :months="$months" />
        <x-filters.date-filter />
        <x-filters.simple-export />
    </div>
</div>
