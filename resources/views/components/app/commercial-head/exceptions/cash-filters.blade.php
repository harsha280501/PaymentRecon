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

        <x-filters.dropdown :dataset="$banks" keys="bank" initialValue="SELECT BANK NAME" />


        <x-filters.location :location="$location" />

        <x-filters.months :months="$months" />
        <x-filters.date-filter />

        <x-filters.simple-export />

    </div>
</div>
