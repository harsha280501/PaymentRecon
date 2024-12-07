<div>
    <div class="my-2 gap-2 align-items-center d-flex flex-column flex-md-row">

        <div class="@if (!$filtering) d-none @endif">
            <button @click="()=>{
                $wire.back()
                reset()
            }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>


        <div>
            <x-filters.stores :stores="$stores" keys="storeID" />
        </div>

        <div>
            <x-filters.months :months="$months" />
        </div>

        <x-filters.date-filter />
        <x-filters.simple-export />

    </div>
</div>
