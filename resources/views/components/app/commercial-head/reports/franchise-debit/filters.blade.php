<div class="mt-3">
    <div class="d-flex d-flex-mob gap-2 flex-wrap">
        <div style="display:@if ($filtering) unset @else none @endif" class="">
            <button @click="() => {
                    $wire.back()
                    reset()
                }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>

        <div>
            <x-filters.dropdown :dataset="$stores" keys="store" initialValue="SELECT A STORE" />
        </div>

        <div class="w-mob-100">
            <div class="w-mob-100" wire:ignore>
                <select id="select1-dropdown" class="custom-select select2 form-control searchField w-mob-100" style="width: 220px" data-live-search="true" data-bs-toggle="dropdown">

                    <option value="" class="dropdown-item">SELECT A BRAND</option>
                    <option value="" class="dropdown-item">ALL</option>

                    @foreach($brands as $item)

                    @php
                    $item = (array) $item;
                    @endphp

                    @if($item['brand'] != '')
                    <option class="dropdown-list" value="{{ $item['brand'] }}">{{ $item["brand"] }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>


        <div class="w-mob-100">
            <div class="w-mob-100" wire:ignore>
                <select id="select2-dropdown" class="custom-select select2 form-control searchField w-mob-100" style="width: 220px" data-live-search="true" data-bs-toggle="dropdown">

                    <option value="" class="dropdown-item">SELECT A BANK</option>
                    <option value="" class="dropdown-item">ALL</option>

                    @foreach($banks as $item)

                    @php
                    $item = (array) $item;
                    @endphp

                    @if($item['bank'] != '')
                    <option class="dropdown-list" value="{{ $item['bank'] }}">{{ $item["bank"] }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <x-filters.months :months="$months" />
        </div>

        <x-filters.date-filter />
        <x-filters.simple-export />
    </div>
</div>
