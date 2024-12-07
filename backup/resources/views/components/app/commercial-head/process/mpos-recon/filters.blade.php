<div class="d-flex align-items-center d-flex-mob mt-2 mb-2" style="gap: .5em; flex-wrap: wrap;">
    <div class=" @if(!$filtering) d-none @endif">
        <button @click="() => {
                        $wire.back()
                        reset()
                    }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
    </div>



    <div>
        <x-filters.stores :stores="$storesfive" keys="storeID" />
    </div>


    <x-filters.months :months="$months" />

    <x-filters.extensions.dropdown_one :dataset="$locations" keys="Location" initialValue="SELECT A LOCATION" />

    <div class="w-mob-100">
        <x-filters.date-filter />
    </div>
    <x-filters.simple-export />
</div>
