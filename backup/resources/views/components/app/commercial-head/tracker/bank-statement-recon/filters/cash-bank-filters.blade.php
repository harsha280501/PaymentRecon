<div x-data='{
    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    }
}'>
    <div class="d-flex d-flex-mob gap-2" style="@if($activeTab !== 'cash') display: none !important @endif">
        <div style="display:@if ($filtering) unset @else none @endif" class="">
            <button @click="() => {
                $wire.back()
                reset()
            }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>

        <div x-on: wire:ignore class="">
            <select id="select01-dropdown" class="custom-select select2 form-control searchField " data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                <option selected disabled value="" class="dropdown-item">SELECT STORE ID</option>
                <option value="" class="dropdown-item">ALL</option>

                @foreach($stores as $item)

                @php
                $item = (array) $item;
                @endphp

                @if($item['storeId'] != '')
                <option class="dropdown-list" value="{{ $item['storeId'] }}">{{ $item["storeId"] }}</option>
                @endif

                @endforeach
            </select>
        </div>

        <x-filters.months :months="$months" />

        <div class="">
            <div style="width: 160px" wire:ignore>
                <select id="select21-dropdown" style="width: 160px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">
                    <option selected value="" class="dropdown-item">SELECT MATCHED STATUS</option>
                    <option value="Matched" class="dropdown-item">Matched</option>
                    <option value="Not Matched" class="dropdown-item">Not Matched</option>
                </select>
            </div>
        </div>
        <x-filters.extensions.dropdown_one :dataset="$locations" keys="Location" initialValue="SELECT A LOCATION" />

        <x-filters.date-filter />
        <x-filters.simple-export />
    </div>
</div>
