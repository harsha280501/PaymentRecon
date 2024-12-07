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


        <div class="w-mob-100" style="margin-top: 7px">
            <div class="w-mob-100" wire:ignore>
                <select id="select1-dropdown" class="custom-select select2 form-control searchField w-mob-100"
                    style="width: 220px" data-live-search="true" data-bs-toggle="dropdown">

                    <option value="" class="dropdown-item">SELECT STORE ID</option>
                    <option value="" class="dropdown-item">ALL</option>
                    {{-- <option selected value="6136" class="dropdown-item">6136</option> --}}

                    @foreach($stores as $item)

                    @php
                    $item = (array) $item;
                    @endphp

                    @if($item['Store ID'] != '')
                    <option class="dropdown-list" value="{{ $item['Store ID'] }}">{{ $item["Store ID"] }}</option>
                    @endif

                    @endforeach
                </select>
            </div>
        </div>

        <div class="w-mob-100" style="margin-top: 7px">
            <x-filters.months :months="$months" />
        </div>

        <div class="w-mob-100" style="margin-top: 7px">
            <x-filters.date-filter />
        </div>
        <x-filters.simple-export />
    </div>
</div>