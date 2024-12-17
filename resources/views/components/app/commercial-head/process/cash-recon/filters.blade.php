<div class="">
    <div class="my-2 flex-wrap d-flex d-flex-mob gap-2 align-items-center @if($activeTab != 'cash') d-none @endif">

        <div class="@if(!$filtering) d-none @endif">
            <button @click="()=>{
                $wire.back()
                reset()
            }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>


        <div wire:ignore class="mt-1">
            <select id="select01-dropdown" class="custom-select select2 form-control searchField " data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                <option selected disabled value="" class="dropdown-item">SELECT STORE ID</option>
                <option value="" class="dropdown-item">ALL</option>

                @foreach($cashStores as $item)

                @php
                $item = (array) $item;
                @endphp

                @if($item['storeID'] != '')
                <option class="dropdown-list" value="{{ $item['storeID'] }}">{{ $item["storeID"] }}</option>
                @endif

                @endforeach
            </select>
        </div>

        <div wire:ignore class="mt-1">
            <select id="select11-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                <option selected disabled value="" class="dropdown-item">SELECT RETEK CODE</option>
                <option value="" class="dropdown-item">ALL</option>

                @foreach($cashCodes as $item)

                @php
                $item = (array) $item;
                @endphp

                @if($item['retekCode'] != '')
                <option class="dropdown-list" value="{{ $item['retekCode'] }}">{{ $item["retekCode"] }}</option>
                @endif

                @endforeach
            </select>
        </div>

        <x-filters.months :months="$months" />
        <x-filters.dropdown :dataset="$locations" initialValue="SELECT A LOCATION" keys="Location" />

        {{-- datefilter --}}
        <x-filters.date-filter />
        <x-filters.simple-export />

    </div>
    <div class="my-2 d-flex d-flex-mob gap-2 align-items-center @if($activeTab != 'card') d-none @endif">

        <div class="@if(!$filtering) d-none @endif">
            <button @click="()=>{
                $wire.back()
                reset()
            }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>


        <div wire:ignore class="mt-1">
            <select id="select02-dropdown" class="custom-select select2 form-control searchField " data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                <option selected disabled value="" class="dropdown-item">SELECT STORE ID</option>
                <option value="" class="dropdown-item">ALL</option>

                @foreach($cardStores as $item)

                @php
                $item = (array) $item;
                @endphp

                @if($item['storeID'] != '')
                <option class="dropdown-list" value="{{ $item['storeID'] }}">{{ $item["storeID"] }}</option>
                @endif

                @endforeach
            </select>
        </div>

        <div wire:ignore class="mt-1">
            <select id="select12-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                <option selected disabled value="" class="dropdown-item">SELECT RETEK CODE</option>
                <option value="" class="dropdown-item">ALL</option>

                @foreach($cardCodes as $item)

                @php
                $item = (array) $item;
                @endphp

                @if($item['retekCode'] != '')
                <option class="dropdown-list" value="{{ $item['retekCode'] }}">{{ $item["retekCode"] }}</option>
                @endif

                @endforeach
            </select>
        </div>



        {{-- datefilter --}}
        <x-filters.date-filter />
        <x-filters.simple-export />

    </div>

    {{-- Wallet --}}

    <div class="my-2 d-flex d-flex-mob gap-2 align-items-center @if($activeTab != 'wallet') d-none @endif">

        <div class="@if(!$filtering) d-none @endif">
            <button @click="()=>{
                $wire.back()
                reset()
            }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>


        <div wire:ignore class="mt-1">
            <select id="select03-dropdown" class="custom-select select2 form-control searchField " data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                <option selected disabled value="" class="dropdown-item">SELECT STORE ID</option>
                <option value="" class="dropdown-item">ALL</option>

                @foreach($walletStores as $item)

                @php
                $item = (array) $item;
                @endphp

                @if($item['storeID'] != '')
                <option class="dropdown-list" value="{{ $item['storeID'] }}">{{ $item["storeID"] }}</option>
                @endif

                @endforeach
            </select>
        </div>

        <div wire:ignore class="mt-1">
            <select id="select13-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                <option selected disabled value="" class="dropdown-item">SELECT RETEK CODE</option>
                <option value="" class="dropdown-item">ALL</option>

                @foreach($walletCodes as $item)

                @php
                $item = (array) $item;
                @endphp

                @if($item['retekCode'] != '')
                <option class="dropdown-list" value="{{ $item['retekCode'] }}">{{ $item["retekCode"] }}</option>
                @endif

                @endforeach
            </select>
        </div>

        {{-- datefilter --}}
        <x-filters.date-filter />
        <x-filters.simple-export />
    </div>

    {{-- UPI --}}
    <div class="my-2 d-flex d-flex-mob gap-2 align-items-center @if($activeTab != 'upi') d-none @endif">

        <div class="@if(!$filtering) d-none @endif">
            <button @click="()=>{
                $wire.back()
                reset()
            }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>


        <div wire:ignore class="mt-1">
            <select id="select04-dropdown" class="custom-select select2 form-control searchField " data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                <option selected disabled value="" class="dropdown-item">SELECT STORE ID</option>
                <option value="" class="dropdown-item">ALL</option>

                @foreach($upiStores as $item)

                @php
                $item = (array) $item;
                @endphp

                @if($item['storeID'] != '')
                <option class="dropdown-list" value="{{ $item['storeID'] }}">{{ $item["storeID"] }}</option>
                @endif

                @endforeach
            </select>
        </div>

        <div wire:ignore class="mt-1">
            <select id="select14-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                <option selected disabled value="" class="dropdown-item">SELECT RETEK CODE</option>
                <option value="" class="dropdown-item">ALL</option>

                @foreach($upiCodes as $item)

                @php
                $item = (array) $item;
                @endphp

                @if($item['retekCode'] != '')
                <option class="dropdown-list" value="{{ $item['retekCode'] }}">{{ $item["retekCode"] }}</option>
                @endif

                @endforeach
            </select>
        </div>

        {{-- datefilter --}}
        <x-filters.date-filter />
        <x-filters.simple-export />
    </div>
</div>
