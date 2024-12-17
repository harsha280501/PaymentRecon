<div class="my-3 d-flex w-100 gap-3" style="justify-content: flex-end; align-items: center">

    <div class="@if(!$filtering) d-none @endif">
        <button wire:click="back" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
    </div>

    <div style="flex: 1">
        <div wire:ignore class="mt-1">
            <select id="select1-dropdown" class="custom-select select2 form-control searchField " data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
                <option selected disabled value="" class="dropdown-item">SELECT STORE ID</option>
                <option value="" class="dropdown-item">ALL</option>

                @foreach($stores as $item)

                @php
                $item = (array) $item;
                @endphp

                @if($item['storeID'] != '')
                <option class="dropdown-list" value="{{ $item['storeID'] }}">{{ $item["storeID"] }}</option>
                @endif

                @endforeach
            </select>
        </div>
    </div>

    <div>
        <h5 style="color: #000; font-size: .9em">COUNT: <span style="color: #000; font-weight: 900; font-size: 1.2em !important">{{ isset($dataset[0]) ? $dataset[0]?->count : 0 }}</span></h5>
    </div>

    {{-- <form wire:ignore class="d-flex d-flex-mob gap-2" @submit.prevent="$wire.filename = select">
        <div>
            <input class="form-control form-control-dark" x-model="select" style="border: 1px solid #00000015 ; border-radius: 3px; outline: none; font-size: .9em; color: #000; padding: .4em; font-family: inherit; border: 1px solid #00000031" type="text" placeholder="Filename">
        </div>
        <button class="btn-mob" style="border: none; outline: none; background: #dbdbdbe7; padding: .3em .5em; border-radius: 2px;" type="submit"><i class="fa fa-search"></i></button>
    </form> --}}
</div>
