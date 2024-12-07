<div x-data>
    <div class="d-flex d-flex-mob gap-2" style="@if($activeTab !== 'store2card') display: none !important @endif">
        <div style="display:@if ($filtering) unset @else none @endif" class="">
            <button @click="() => {
                $wire.back()
                reset()
            }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>

        <div wire:ignore class="">
            <select id="select01-dropdown" class="custom-select select2 form-control searchField " data-live-search="true" data-bs-toggle="dropdown" style="width: 230px">
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

        <div wire:ignore class="">
            <select id="select11-dropdown" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style=" width: 230px">
                <option selected disabled value="" class="dropdown-item">SELECT RETEK CODE</option>
                <option value="" class="dropdown-item">ALL</option>

                @foreach($codes as $item)

                @php
                $item = (array) $item;
                @endphp

                @if($item['retekCode'] != '')
                <option class="dropdown-list" value="{{ $item['retekCode'] }}">{{ $item["retekCode"] }}</option>
                @endif

                @endforeach
            </select>
        </div>

        <div class="">
            <div style="width: 150px" wire:ignore>
                <select id="select21-dropdown" style="width: 150px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">

                    <option selected disabled value="" class="dropdown-item">SELECT BANK NAME</option>
                    <option value="" class="dropdown-item">ALL</option>

                    @foreach($banks as $item)

                    @php
                    $item = (array) $item;
                    @endphp

                    @if($item['colBank'] != '')
                    <option class="dropdown-list" value="{{ $item['colBank'] }}">{{ $item["colBank"] }}</option>
                    @endif

                    @endforeach
                </select>
            </div>
        </div>


        <div class="">
            <div style="width: 160px" wire:ignore>
                <select id="select31-dropdown" style="width: 160px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">
                    <option selected value="" class="dropdown-item">SELECT MATCHED STATUS</option>
                    <option value="Matched" class="dropdown-item">Matched</option>
                    <option value="Not Matched" class="dropdown-item">Not Matched</option>
                </select>
            </div>
        </div>

        <div>
            <div wire:ignore>
                <form @submit.prevent="$wire.filterDate({start, end})" class="d-flex d-flex-mob gap-1">
                    <div>
                        <input x-model="start" id="startDate" style="border: 1px solid #0000003f ; border-radius: 4px; outline: none; font-size: .9em; color: #000; padding: .4em; font-family: inherit" type="date">
                    </div>
                    <div>
                        <input x-model="end" id="endDate" style="border: 1px solid #0000003f ; border-radius: 4px; outline: none; font-size: .9em; color: #000 ; padding: .4em; font-family: inherit" type="date">
                    </div>

                    <button class="btn-mob" style="outline: none; border: none; padding: 0 .5em; border-radius: 4px">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
