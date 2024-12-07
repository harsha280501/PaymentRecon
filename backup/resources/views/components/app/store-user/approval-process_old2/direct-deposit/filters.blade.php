<div class="row mt-2">
    <div class="col-lg-12">
        <div>
            <div class="d-flex d-flex-mob d-flex-tab gap-2">

                <div style="display:@if ($filtering) unset @else none @endif" class="">
                    <button @click="() => {
                    $wire.back()
                    reset()
                }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>

                <x-filters.months :months="$months" />
                <div style="flex:1;">
                    <x-filters.date-filter />
                    <x-filters.simple-export />
                </div>
            </div>
        </div>
    </div>
</div>