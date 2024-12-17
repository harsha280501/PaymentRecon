<div class="my-2 d-flex gap-2  align-items-center" style="display: @if($tab !== $show) none !important ; @endif">
    <div class="@if(!$filtering) d-none @endif" style="margin-top: 7px">
        <button @click="() => {
            $wire.back()
            reset()    
        }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
    </div>

    <div style="margin-top: 7px !important">
        <div wire:ignore class="">
            <select id="{{ $show }}-stores" style="width: 220px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 15px !important;">
                <option selected disabled value="" class="dropdown-item">SELECT STORE ID</option>
                <option value="" class="dropdown-item">ALL</option>
                @foreach ($stores as $bank)
                @php
                $bank = (array) $bank;
                @endphp
                <option class="dropdown-list" value="{{ $bank['storeID'] }}">{{ $bank['storeID'] }}</option>
                @endforeach

            </select>
        </div>
    </div>
    {{-- <div style="margin-top: 7px !important">
        <div wire:ignore class="">
            <x-filters.months :months="$months" />
        </div>
    </div> --}}

    <x-filters.date-filter />
    <x-filters.simple-export />
</div>
