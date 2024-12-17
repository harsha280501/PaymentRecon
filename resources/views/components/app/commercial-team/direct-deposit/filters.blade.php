<div class="row mt-2">
    <div class="col-lg-12">
        <div>
            <div class="d-flex d-flex-mob d-flex-tab gap-2 align-items-center">

                <div style="display:@if ($filtering) unset @else none @endif" class="">
                    <button @click="() => {
                    $wire.back()
                    reset()
                }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>

                <x-filters.stores :stores="$stores" />

                <x-filters.months :months="$months" />
                <div style="flex:1;">
                    <x-filters.date-filter />
                </div>


                <x-filters.simple-export />

                <div class="w-mob-100">
                    <button 
                        data-bs-target="#upload-direct-deposit"
                        data-bs-toggle="modal"
                        type="button" 
                        class="btn mb-1 w-mob-100 py-2 mt-1" 
                        style="background: #32CD32; color: #fcf8f8;width:140px; font-size: 17px !important;" >
                        Import</button>
                </div>
            </div>
        </div>
    </div>
</div>
