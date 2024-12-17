<div class="col-lg-12 col-sm-4 grid-margin  grid-margin-lg-0" style="width: 100% !important">
    <div class="row">

        <div class="">

            <form @submit.prevent="$wire.filter(_filter())" class="mb-1 ms-1 justify-mob flex-column flex-lg-row" style="display: flex; justify-content: center; align-items: center; gap: 1em; ">
                <label style="color: #000; width: 100px">Select Range:</label>
                <div style=" border-radius: 5px; display: flex; justify-content: center; align-items: center; width: fit-content; gap: .3em; ;" class="flex-wrap">

                    <div class="">
                        <div class="dropdown">
                            <select x-model="timeline_" style="background-color: #fff; border: 1px solid skyblue; outline: none; font-size: 1em; padding: .2em; width: 200px" class="mainDashboardSelect w-mob-100 mb-1">
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

                            <select x-model="tender_" style="background-color: #fff; border: 1px solid skyblue; outline: none; font-size: 1em; padding: .2em; width: 200px" class="mainDashboardSelect w-mob-100 mb-1">
                                <option value="all">Select Tender</option>
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="upi">UPI</option>
                                <option value="wallet">Wallet</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <input x-model="daterange_.start" id="startDate" class="date-filter w-mob-100 mb-1" value="" style="" type="date">
                        <input x-model="daterange_.end" class="date-filter w-mob-100 mb-1" id="endDate" type="date">
                    </div>
                </div>
                <button class="btn-mob w-mob-100 mb-1" style="border: none; outline: none; background: #dbdbdbe7; padding: .4em .6em; border-radius: 2px;" type="submit"><i class="fa fa-search p-0"></i></button>
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
