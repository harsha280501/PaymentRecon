<div class="col-lg-12 col-sm-4 grid-margin  grid-margin-lg-0">
    <div class="row">
        {{-- <div class="col-lg-4"></div> --}}
        <div x-data="{
            from: null,
            to: null,
            selected: 'ThisYear',
            filtering: false

        }" class=" d-flex justify-content-center align-items-center gap-2">

            <div x-show="filtering">
                <button @click="() => {
                    $wire.back()
                    
                    from = null
                    to = null
                    selected = 'ThisYear'
                    filtering = false
                }" style="background: transparent; outline: none; border: none; align-self: center; font-size: 1.3em; margin-top: 0em; padding: .2em .6em">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </div>

            <div style="flex: 1"></div>
            <div class="mb-2">
                <div class="dropdown">
                    <label>Select Range :</label>
                    <select x-model="selected" x-on:change="() => {
                        $wire.datewise(selected) 
                        from = null
                        to = null,
                        filtering = true
                    }" style="background-color: #fff; border: 1px solid skyblue; outline: none; font-size: 1em; padding: .2em; width: 200px" class="mainDashboardSelect" onchange="counter();">
                        <option value="">Select</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="ThisWeek">This Week</option>
                        <option value="LastWeek">Last Week</option>
                        <option value="ThisMonth">This Month</option>
                        <option value="LastMonth">Last Month</option>
                        <option selected value="ThisYear">This Year</option>
                    </select>
                </div>
            </div>

            <div class="ms-1" wire:ignore>
                <div wire:ignore>
                    <select wire:ignore id="select1-dropdown" style=" width: 300px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important;  min-width: 130px; width: 150px">

                        <option selected disabled value="" class="dropdown-item">SELECT STORE ID</option>
                        <option value="" class="dropdown-item">ALL</option>

                        @foreach($stores as $item)

                        @php
                        $item = (array) $item;
                        @endphp

                        @if ($item['retekCode'] != '')
                        <option class="dropdown-list" value="{{ $item['retekCode'] }}">{{ $item["retekCode"] }}</option>
                        @endif

                        @endforeach
                    </select>
                </div>
            </div>

            <form x-on:submit.prevent="() => {
                $wire.filterDate({from, to})
                selected = ''
                filtering = true
            }" class=" mb-2 ms-1" style="flex: 2 !important;">
                <div>
                    <input x-model="from" id="startDate" value="" style="border: 1px solid #0000003f ; border-radius: 4px; outline: none; font-size: .9em; color: #000; padding: .3em; font-family: inherit" type="date">
                    <input x-model="to" id="endDate" style="border: 1px solid #0000003f ; border-radius: 4px; outline: none; font-size: .9em; color: #000 ; padding: .3em; font-family: inherit" type="date">
                    <button class="btn-mob" style="border: none; outline: none; background: #dbdbdbe7; padding: .3em .5em; border-radius: 2px;" type="submit"><i class="fa fa-search p-0"></i></button>
                </div>
            </form>
            {{ $slot }}
        </div>
    </div>
</div>
