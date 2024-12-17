<div>
    <div style="display: none"
        class="my-2 gap-2 align-items-center @if ($activeTab == 'card') d-flex flex-column flex-md-row @endif">

        <div class="@if (!$filtering) d-none @endif">
            <button @click="()=>{
                $wire.back()
                reset()
            }"
                style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>


        <div class="w-mob-100" style="margin-top: 10px">
            <div wire:ignore class="w-mob-100">
                <select id="select1-dropdown" class="custom-select select2 form-control searchField w-mob-100"
                    data-live-search="true" data-bs-toggle="dropdown"
                    style="height: 15px !important; width: 250px !important">
                    <option selected disabled value="" class="dropdown-item">SELECT BANK NAMES</option>
                    <option value="" class="dropdown-item">ALL</option>
                    @foreach ($cardBanks as $bank)
                    @php
                    $bank = (array) $bank;
                    @endphp
                    <option class="dropdown-list" value="{{ $bank['banks'] }}">{{ $bank['banks'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <x-filters.months :months="$months" />

        <x-filters.date-filter />
        <x-filters.simple-export />

    </div>
</div>