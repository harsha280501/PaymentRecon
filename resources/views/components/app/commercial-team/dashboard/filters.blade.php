<div class="col-lg-12  grid-margin grid-margin-lg-0">
    <div class="row">
        {{-- <div class="col-lg-4"></div> --}}
        <div class="">
            {{-- d-flex justify-content-center align-items-center  --}}
            <form @submit.prevent="$wire.filter(_filter())" class="mb-1 ms-1 justify-mob main-start" style="display: flex; justify-content: center; align-items: center; gap: 1em;">


                <select class="w-main-100 mb-2 mb-md-0" x-model="timeline_" style="background-color: #fff; border: 1px solid skyblue; outline: none; font-size: 1em; padding: .2em; width: 200px" class="mainDashboardSelect">
                    <option value="">Select</option>
                    <option value="Yesterday">Yesterday</option>
                    <option value="ThisWeek">This Week</option>
                    <option value="LastWeek">Last Week</option>
                    <option value="ThisMonth">This Month</option>
                    <option value="LastMonth">Last Month</option>
                    <option value="ThisQuarter">This Quarter</option>
                    <option value="LastQuarter">Last Quarter</option>
                    <option value="ThisYear">This Year (Apr - Mar)</option>
                </select>

                <select class="w-main-100" x-model="tender_" style="background-color: #fff; border: 1px solid skyblue; outline: none; font-size: 1em; padding: .2em; width: 200px" class="mainDashboardSelect">
                    <option value="all">Select Tender</option>
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                    <option value="upi">UPI</option>
                    <option value="wallet">Wallet</option>
                </select>


                <div class="mt-2">
                    <x-filters.brand_location_store />
                </div>


                <input x-model="daterange_.start" id="startDate" class="date-filter w-main-100 mb-2 mb-md-0" value="" type="date">
                <input x-model="daterange_.end" class="date-filter w-main-100" id="endDate" type="date">


                <button class="btn-mob w-main-100 m-2" style="border: none; outline: none; background: #dbdbdbe7; padding: .4em .6em; border-radius: 2px;" type="submit"><i class="fa fa-search p-0"></i></button>
                <template x-if="filtering == true">
                    <button @click="() => {
                        reset()
                        $wire.back()
                    }" style="background: transparent; outline: none; border: none;">
                        <img style="width: 40px; object-fit: cover;" src="{{ asset('assets/images/reset-icon.png') }}" />
                    </button>
                </template>
            </form>

            {{ $slot }}
        </div>
    </div>
    <p style="display: flex; justify-content: center" x-text="dateError"></p>
</div>
