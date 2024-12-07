<div x-data class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="home-tab">
    <section id="sales">
        <div class="row">
            {{-- filters --}}
            <x-app.area-manager.dashboard.filters :stores="$stores">
                <x-spinner.index />
            </x-app.area-manager.dashboard.filters>
        </div>
    </section>
    {{-- tiles --}}
    <x-app.area-manager.dashboard.tile-wrap>
        <x-app.area-manager.dashboard.bank-layout>
            <div class="mt-4">
                <x-app.area-manager.dashboard.month-wise-sale :june="$june" :july="$july" :august="$august" :september="$september" :cardJune="$card_june" :cardJuly="$card_july" :cardAugust="$card_august" :cardSeptember="$card_september" />
            </div>

            <div class="my-4 ">
                <x-app.area-manager.dashboard.month-wise-collection :collections="$collections" />
            </div>

            <x-app.area-manager.dashboard.banks :tender="$tender" />

        </x-app.area-manager.dashboard.bank-layout>
    </x-app.area-manager.dashboard.tile-wrap>

    {{-- Tender wise sales --}}
    <x-app.area-manager.dashboard.tender-wise-sales :tender="$tender" />

    <x-app.area-manager.dashboard.tile-wrap>
        {{-- <x-app.area-manager.dashboard.header /> --}}
        <x-app.area-manager.dashboard.cards :tile="$tile" />
    </x-app.area-manager.dashboard.tile-wrap>


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


        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {
            $j('#select1-dropdown').on('change', function(e) {
                @this.set('store', e.target.value);
            });
        });

    </script>
</div>
