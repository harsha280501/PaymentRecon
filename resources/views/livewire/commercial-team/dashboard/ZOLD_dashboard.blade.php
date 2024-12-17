<div x-data="display" class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
    {{-- tiles --}}
    <div class="card" style="margin: 0 !important" id="dash">
        <section id="sales">
            <div class="row">
                <x-app.commercial-team.dashboard.filters :stores="$stores" :brands="$brands" :locations="$locations">
                    <x-spinner.index />
                </x-app.commercial-team.dashboard.filters>
            </div>
        </section>

        <x-app.commercial-team.dashboard.bank-layout>

            <div class="mt-4">
                <section id="topcust">
                    <div class="row">

                        @if($tender_ == 'all')
                        <x-app.commercial-team.dashboard.datasets.dataset-initial :initial="$dataset_initial" :timeline="$timeline_" :showFullStatsFor="$showFullStatsFor" :storeData="$s_store" :store="$store" />
                        @endif

                        @if($tender_ == 'card')
                        <x-app.commercial-team.dashboard.datasets.dataset-card :initial="$dataset_initial" :timeline="$timeline_" :showFullStatsFor="$showFullStatsFor" :storeData="$s_store" :store="$store" />
                        @endif

                        @if($tender_ == 'upi')
                        <x-app.commercial-team.dashboard.datasets.dataset-upi :initial="$dataset_initial" :timeline="$timeline_" :showFullStatsFor="$showFullStatsFor" :storeData="$s_store" :store="$store" />
                        @endif

                        @if($tender_ == 'wallet')
                        <x-app.commercial-team.dashboard.datasets.dataset-wallet :initial="$dataset_initial" :timeline="$timeline_" :showFullStatsFor="$showFullStatsFor" :storeData="$s_store" :store="$store" />
                        @endif


                        @if($tender_ == 'cash')
                        <x-app.commercial-team.dashboard.datasets.dataset-cash :initial="$dataset_initial" :timeline="$timeline_" :showFullStatsFor="$showFullStatsFor" :storeData="$s_store" :store="$store" />
                        @endif
                    </div>
                </section>
            </div>


            {{-- <x-app.commercial-team.dashboard.banks :tender="$banks_initial" :tenderStatus="$tender_" /> --}}

    </div>
    </x-app.commercial-team.dashboard.bank-layout>


    <script>
        const increamentsCounter = (targer, time = 200, start = 0) => {
            return {
                current: 0
                , target: targer
                , time: time
                , start: start
                , updatecounter: function() {
                    start = this.start;
                    const increment = (this.target - start) / this.time;
                    const handle = setInterval(() => {
                        if (this.current < this.target) this.current += increment;
                        else {
                            clearInterval(handle);
                            this.current = this.target;
                        }
                    }, 1);
                }
            , };
        };

    </script>

    <script>
        $(document).ready(function() {

            // Enable Bootstrap tooltips on page load
            $('[data-bs-toggle="tooltip"]').tooltip({
                placement: 'right'
            });

            // Ensure Livewire updates re-instantiate tooltips
            if (typeof window.Livewire !== 'undefined') {
                window.Livewire.hook('message.processed', (message, component) => {
                    $('[data-bs-toggle="tooltip"]').tooltip('dispose').tooltip({
                        placement: 'right'
                    });
                });
            }
        });

        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        function _store() {
            this.select2 = $j(this.$refs.select).select2();
            this.select2.on("select2:select", (event) => {
                this.storeId = event.target.value;
            });
            this.$watch("storeId", (value) => {
                this.select2.val(value).trigger("change");
            });
        }

        function _brand() {
            this.brandSelect = $j(this.$refs._selectBrand).select2();
            this.brandSelect.on("select2:select", (event) => {
                this.brand = event.target.value;
            });

            this.$watch("brand", (value) => {
                this.brandSelect.val(value).trigger("change");
            });
        }


        function _location() {
            this._selectLocation = $j(this.$refs._selectLocation).select2();
            this._selectLocation.on("select2:select", (event) => {
                this.location = event.target.value;
            });
            this.$wire.on('resetAll', (event) => {
                this._selectLocation.val("").trigger("change");
            })
        }

    </script>
</div>
