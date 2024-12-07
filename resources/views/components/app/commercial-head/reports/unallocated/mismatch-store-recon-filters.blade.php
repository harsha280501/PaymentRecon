<div class="col-lg-12 mb-3" wire:key="f5cbadba09e2e5857c4d3dfe6bdcdc28156fd6dc0567a4aa1b8e4348e0507e89">
    <div class="d-flex  gap-2 d-flex-mob">

        <div style="display:@if ($filtering) unset @else none @endif" class="">
            <button @click="() => {
                $wire.back()
                reset()    
            }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>

        <x-filters._filter data="banks" arr="bank" key="SGVsbG9rbmRrbmNkYwfkod2nm" update="bank" initialValue="SELECT A BANK" />

        <x-filters.months :months="$months" />
        <x-filters.date-filter />


        <div style="
flex: 1
"></div>
        <button data-bs-toggle="modal" data-bs-target="#import-modal" class="bg-success btn mb-1 w-mob-100 py-2 mt-1" style="background: #3682cd; color: #fcf8f8; width: 140px; font-size: 17px !important;">Import</button>

        <div>

            <div style="display: flex; justify-content: space-between; align-items: center; gap: 1em; padding-right: 3em">
                <div style="flex: 1"></div>
                <div x-data="{ show: false, timeout: null }" class="d-flex align-items-center gap-2 w-mob-100" style="width: 100px; " x-init="@this.on('no-data', () => {
            clearTimeout(timeout); show = true; timeout = setTimeout(() => { show = false }, 3000);
        })" style="position: relative">
                    <p class="alert alert-sm alert-info" x-show="show" style="padding: .5em 1em; margin-top: 11px; position: absolute; z-index: 9999; width: 200px; right:10%">
                        No
                        Data
                        to Export</p>

                    <div class="w-mob-100">
                        <button type="button" class="btn mb-1 w-mob-100 py-2 mt-1" style="background: #3682cd; color: #fcf8f8;width:140px; font-size: 17px !important;" wire:click.prevent="export">
                            Export Excel </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
