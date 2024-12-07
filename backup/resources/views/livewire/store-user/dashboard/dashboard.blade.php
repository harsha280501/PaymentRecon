<div x-data="display" class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
    {{-- tiles --}}
    <div class="card" style="margin: 0 !important" id="dash">
        <section id="sales">
            <div class="row">
                <x-app.store-user.dashboard.filters>
                    <x-spinner.index />
                </x-app.store-user.dashboard.filters>
            </div>
        </section>

        <x-app.store-user.dashboard.bank-layout>
            <div class="mt-4">
                <section id="topcust">
                    <div class="row">

                        @if($tender_ == 'all')
                        <x-app.store-user.dashboard.datasets.dataset-initial :initial="$dataset_initial" :timeline="$timeline_" :showFullStatsFor="$showFullStatsFor" :from="$from" :to="$to" />
                        @endif

                        @if($tender_ == 'card')
                        <x-app.store-user.dashboard.datasets.dataset-card :initial="$dataset_initial" :timeline="$timeline_" :showFullStatsFor="$showFullStatsFor" :from="$from" :to="$to" />
                        @endif


                        @if($tender_ == 'upi')
                        <x-app.store-user.dashboard.datasets.dataset-upi :initial="$dataset_initial" :timeline="$timeline_" :showFullStatsFor="$showFullStatsFor" :from="$from" :to="$to" />
                        @endif

                        @if($tender_ == 'wallet')
                        <x-app.store-user.dashboard.datasets.dataset-wallet :initial="$dataset_initial" :timeline="$timeline_" :showFullStatsFor="$showFullStatsFor" :from="$from" :to="$to" />
                        @endif

                        @if($tender_ == 'cash')
                        <x-app.store-user.dashboard.datasets.dataset-cash :initial="$dataset_initial" :timeline="$timeline_" :showFullStatsFor="$showFullStatsFor" :from="$from" :to="$to" />
                        @endif
                    </div>
                </section>
            </div>

            {{-- <x-app.store-user.dashboard.banks :tender="$banks_initial" :tenderStatus="$tender_" /> --}}
            {{-- </div> --}}
        </x-app.store-user.dashboard.bank-layout>
    </div>

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

    </script>
</div>
