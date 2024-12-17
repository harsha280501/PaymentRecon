<div class="col-lg-12 mb-3" style="@if($tab != 'overall-summary') display: none @endif">
    <div class="d-flex align-items-center gap-2 d-flex-mob">

        <div style="display:@if ($filtering) unset @else none @endif" class="">
            <button @click="() => {
                $wire.back()
                resetOne()    
            }"
                style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </div>

        <div class="w-mob-100" style="margin-top: 7px">
            <div wire:ignore class="w-mob-100">
                <select id="outstanding_storeFilter" style="width: 220px"
                    class="custom-select select2 form-control searchField w-mob-100" data-live-search="true"
                    data-bs-toggle="dropdown">

                    <option value="" class="dropdown-item" selected>SELECT STORE ID</option>
                    <option value="" class="dropdown-item">ALL</option>

                    @foreach($stores as $item)

                    @php
                    $item = (array) $item;
                    @endphp

                    @if($item['retekCode'] != '')
                    <option class="dropdown-list" value="{{ $item['retekCode'] }}">{{ $item["retekCode"] }}</option>
                    @endif

                    @endforeach
                </select>
            </div>
        </div>


        <div class="w-mob-100" style="margin-top: 7px">
            <div>
                <div>
                    <form @submit.prevent="$wire.filterDate({start, end: start})"
                        class="d-flex d-flex-mob gap-1 timeline-filter">
                        <div>
                            <input x-model="start" id="startDate" class="date-filter w-mob-100" type="date">
                        </div>
                        <button class="btn-mob w-mob-100 p-md-2 px-2 py-1"
                            style="outline: none; border: none; padding: 0 .5em; border-radius: 4px">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>



        <x-filters.simple-export />


    </div>
</div>