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
                <x-filters.date-filter />
                <div style="flex:1; margin-top: -4px !important">
                    <x-filters.simple-export />
                </div>

                <div wire:ignore>
                    <button class="btn-success btn btn-sm" data-bs-toggle="modal" data-bs-target="#create-model-for-direct-deposit" wire:key="{{ base64_encode('d0owon3yxy') }}"><i class="fa-solid fa-plus"></i><span class="ps-2">New Deposit</span></button>
                </div>
            </div>
        </div>
    </div>
</div>
