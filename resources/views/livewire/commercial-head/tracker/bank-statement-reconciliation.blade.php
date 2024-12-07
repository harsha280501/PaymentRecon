<div>

    <x-app.commercial-head.tracker.bank-statement-recon.tabs :activeTab="$activeTab" />

    {{-- Filter --}}
    <x-app.commercial-head.tracker.bank-statement-recon.filters>

        {{-- Store Cash filters --}}
        <x-app.commercial-head.tracker.bank-statement-recon.filters.cash-bank-filters :activeTab="$activeTab" :filtering="$filtering" :stores="$cash_stores" :codes="$cash_codes" :months="$_months" :locations="$locations" />

        {{-- cash to Bank --}}
        <x-app.commercial-head.tracker.bank-statement-recon.filters.card-bank-filters :activeTab="$activeTab" :filtering="$filtering" :stores="$card_stores" :codes="$card_codes" :months="$_months" />

        {{-- wallet to Bank --}}
        <x-app.commercial-head.tracker.bank-statement-recon.filters.wallet-bank-filters :activeTab="$activeTab" :filtering="$filtering" :stores="$wallet_stores" :codes="$wallet_codes" :months="$_months" />

        {{-- UPI to Bank --}}
        <x-app.commercial-head.tracker.bank-statement-recon.filters.upi-bank-filters :activeTab="$activeTab" :filtering="$filtering" :stores="$upi_stores" :codes="$upi_codes" :months="$_months" />


    </x-app.commercial-head.tracker.bank-statement-recon.filters>

    <section>
        <x-app.commercial-head.tracker.bank-statement-recon.counts :activeTab="$activeTab" :cashRecons="$cashRecons" />
    </section>


    <div class="col-lg-12">
        {{-- Main sales table --}}
        <x-scrollable.scrollable :dataset="$cashRecons">
            <x-scrollable.scroll-head>


                @if($activeTab == 'cash')
                <x-app.commercial-head.tracker.bank-statement-recon.headers.cash-bank-headers :orderBy="$orderBy" />
                @endif

                @if($activeTab == 'card')
                <x-app.commercial-head.tracker.bank-statement-recon.headers.card-bank-headers :orderBy="$orderBy" />
                @endif

                @if($activeTab == 'wallet')
                <x-app.commercial-head.tracker.bank-statement-recon.headers.wallet-bank-headers :orderBy="$orderBy" />
                @endif

                @if($activeTab == 'upi')
                <x-app.commercial-head.tracker.bank-statement-recon.headers.upi-bank-headers :orderBy="$orderBy" />
                @endif

            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>


                @if($activeTab == 'cash')
                <x-app.commercial-head.tracker.bank-statement-recon.datasets.cash-bank-dataset :cashRecons="$cashRecons" />
                @endif

                @if($activeTab == 'card')
                <x-app.commercial-head.tracker.bank-statement-recon.datasets.card-bank-dataset :cashRecons="$cashRecons" />
                @endif

                @if($activeTab == 'wallet')
                <x-app.commercial-head.tracker.bank-statement-recon.datasets.wallet-bank-dataset :cashRecons="$cashRecons" />
                @endif

                @if($activeTab == 'upi')
                <x-app.commercial-head.tracker.bank-statement-recon.datasets.upi-bank-dataset :cashRecons="$cashRecons" />
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
