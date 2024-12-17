<div x-data='{
    start: null,
    end: null,

    reset() {
        this.start = null
        this.end = null
    }
}'>

    <x-app.commercial-head.reports.bank-statement-recon.tabs :activeTab="$activeTab" />

    <div>
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
                <x-filters.brand_location_store />
            </div>

            <div>
                <x-filters.months :months="$_months" />
            </div>


            <div style=" @if ($activeTab == 'upi') display: none; @endif">
                <x-filters._filter key="ZGpubmtzeG1hc2t4bW1zYWM" arr="bank" update="bank" initialValue="SELECT A BANK" data="banks" />
            </div>


            <div class="">
                <div style="width: 160px" wire:ignore>
                    <select id="select21-dropdown" style="width: 160px;" class="custom-select select2 form-control searchField" data-live-search="true" data-bs-toggle="dropdown" style="height: 8px !important">
                        <option selected value="" class="dropdown-item">SELECT MATCHED STATUS</option>
                        <option value="Matched" class="dropdown-item">Matched</option>
                        <option value="Not Matched" class="dropdown-item">Not Matched</option>
                    </select>
                </div>
            </div>

            <x-filters.date-filter />
            <x-filters.simple-export />
        </div>
    </div>


    <div class="d-flex justify-content-center mt-4" style="flex-direction: column;">

        <div class="d-flex justify-content-center flex-column flex-md-row gap-md-4 align-items-center">
            <p class="mainheadtext">Total Record: <span class="blackh">{{
                    isset($_totals[0]->TotalCount) ? $_totals[0]->TotalCount : 0 }}</span></p>
            <p class="mainheadtext">Matched: <span class="tealh">{{
                    isset($_totals[0]->MatchedCount) ?
                    $_totals[0]->MatchedCount : 0 }}</span></p>
            <p class="mainheadtext">Not Matched: <span class="lightcoralh">{{
                    isset($_totals[0]->NotMatchedCount) ?
                    $_totals[0]->NotMatchedCount : 0 }}</span></p>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-center gap-4 align-items-center mb-4">
            <div class="flex-main padding-top10">
                <p class="mainheadtext ">Credit Amount: </p>
                <span class="blackh">{{ isset($_totals[0]->sales_total) ?
                    $_totals[0]->sales_total : 0 }}</span>
            </div>
            <div class="flex-main padding-top10">
                <p class="mainheadtext">Net Amount: </p>
                <span class="tealh">{{ isset($_totals[0]->collection_total) ?
                    $_totals[0]->collection_total : 0 }}</span>
            </div>
            <div class="flex-main padding-top10">
                <p class="mainheadtext">Store Response Entry: </p>
                <span class="bluetext">{{ isset($_totals[0]->adjustment_total) ?
                    $_totals[0]->adjustment_total : 0 }}</span>
            </div>

            <div class="flex-main padding-top10">
                <p class="mainheadtext">Difference[Net Amount - Credit Amount. - Store Response]: </p>
                <span class="lightcoralh">{{ isset($_totals[0]->difference_total) ?
                    $_totals[0]->difference_total : 0 }}</span>
            </div>
        </div>
    </div>


    <div class="col-lg-12">
        {{-- Main sales table --}}
        <x-scrollable.scrollable :dataset="$cashRecons">
            <x-scrollable.scroll-head>

                @if($activeTab == 'cash')
                <x-app.commercial-head.reports.bank-statement-recon.headers.cash-bank-headers :orderBy="$orderBy" />
                @endif

                @if($activeTab == 'card')
                <x-app.commercial-head.reports.bank-statement-recon.headers.card-bank-headers :orderBy="$orderBy" />
                @endif

                @if($activeTab == 'wallet')
                <x-app.commercial-head.reports.bank-statement-recon.headers.wallet-bank-headers :orderBy="$orderBy" />
                @endif

                @if($activeTab == 'upi')
                <x-app.commercial-head.reports.bank-statement-recon.headers.upi-bank-headers :orderBy="$orderBy" />
                @endif

            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>


                @if($activeTab == 'cash')
                <x-app.commercial-head.reports.bank-statement-recon.datasets.cash-bank-dataset :cashRecons="$cashRecons" />
                @endif

                @if($activeTab == 'card')
                <x-app.commercial-head.reports.bank-statement-recon.datasets.card-bank-dataset :cashRecons="$cashRecons" />
                @endif

                @if($activeTab == 'wallet')
                <x-app.commercial-head.reports.bank-statement-recon.datasets.wallet-bank-dataset :cashRecons="$cashRecons" />
                @endif

                @if($activeTab == 'upi')
                <x-app.commercial-head.reports.bank-statement-recon.datasets.upi-bank-dataset :cashRecons="$cashRecons" />
                @endif

            </x-scrollable.scroll-body>
        </x-scrollable.scrollable>


        <script>
            var $j = jQuery.noConflict();
            $j('.searchField').select2();



            document.addEventListener('livewire:load', function() {
                $j('#select01-dropdown').on('change', function(e) {
                    @this.set('filtering', true);
                    @this.set('store', e.target.value);
                });


                $j('#select02-dropdown').on('change', function(e) {
                    @this.set('filtering', true);
                    @this.set('store', e.target.value);
                });


                $j('#select03-dropdown').on('change', function(e) {
                    @this.set('filtering', true);
                    @this.set('store', e.target.value);
                });


                $j('#select04-dropdown').on('change', function(e) {
                    @this.set('filtering', true);
                    @this.set('store', e.target.value);
                });


                $j('#select11-dropdown').on('change', function(e) {
                    @this.set('filtering', true);
                    @this.set('code', e.target.value);
                });


                $j('#select12-dropdown').on('change', function(e) {
                    @this.set('filtering', true);
                    @this.set('code', e.target.value);
                });


                $j('#select13-dropdown').on('change', function(e) {
                    @this.set('filtering', true);
                    @this.set('code', e.target.value);
                });


                $j('#select14-dropdown').on('change', function(e) {
                    @this.set('filtering', true);
                    @this.set('code', e.target.value);
                });


                $j('#select21-dropdown').on('change', function(e) {
                    @this.set('filtering', true);
                    @this.set('status', e.target.value);
                });


                $j('#select22-dropdown').on('change', function(e) {
                    @this.set('filtering', true);
                    @this.set('status', e.target.value);
                });


                $j('#select23-dropdown').on('change', function(e) {
                    @this.set('filtering', true);
                    @this.set('status', e.target.value);
                });
                

                $j('#select24-dropdown').on('change', function(e) {
                    @this.set('filtering', true);
                    @this.set('status', e.target.value);
                });
            });

        </script>

    </div>
</div>
