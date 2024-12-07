<div>
    <style>
        #history .table {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        #history .table-header,
        #history .table-row {
            display: table-row;
        }

        #history .table-cell {
            display: table-cell;
            padding: 8px;
            /* border: 1px solid #ddd;*/
            text-align: left;
        }

        #history .table-header {
            font-weight: bold;
            /* background-color: #f9f9f9; */
        }

    </style>

    <x-app.commercial-head.approval-process.bank-statement-process.tabs :activeTab="$activeTab" />

    {{-- Filter --}}
    <x-app.commercial-head.approval-process.bank-statement-process.filters>

        {{-- Store Cash filters --}}
        <x-app.commercial-head.approval-process.bank-statement-process.filters.cash-bank-filters :activeTab="$activeTab" :filtering="$filtering" :stores="$cash_stores" :codes="$cash_codes" />

        {{-- cash to Bank  --}}
        <x-app.commercial-head.approval-process.bank-statement-process.filters.card-bank-filters :activeTab="$activeTab" :filtering="$filtering" :stores="$card_stores" :codes="$card_codes" />

        {{-- wallet to Bank  --}}
        <x-app.commercial-head.approval-process.bank-statement-process.filters.wallet-bank-filters :activeTab="$activeTab" :filtering="$filtering" :stores="$wallet_stores" :codes="$wallet_codes" />

        {{-- UPI to Bank  --}}
        <x-app.commercial-head.approval-process.bank-statement-process.filters.upi-bank-filters :activeTab="$activeTab" :filtering="$filtering" :stores="$upi_stores" :codes="$upi_codes" />

    </x-app.commercial-head.approval-process.bank-statement-process.filters>

    <section>
        <x-app.commercial-head.approval-process.bank-statement-process.counts :activeTab="$activeTab" :cashRecons="$cashRecons" />
    </section>


    <div class="col-lg-12">
        {{-- Main sales table --}}
        <x-scrollable.scrollable :dataset="$cashRecons">
            <x-scrollable.scroll-head>

                @if($activeTab == 'cash')
                <x-app.commercial-head.approval-process.bank-statement-process.headers.cash-bank-headers />
                @endif

                @if($activeTab == 'card')
                <x-app.commercial-head.approval-process.bank-statement-process.headers.card-bank-headers />
                @endif

                @if($activeTab == 'wallet')
                <x-app.commercial-head.approval-process.bank-statement-process.headers.wallet-bank-headers />
                @endif

                @if($activeTab == 'upi')
                <x-app.commercial-head.approval-process.bank-statement-process.headers.upi-bank-headers />
                @endif

            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>

                @if($activeTab == 'cash')
                <x-app.commercial-head.approval-process.bank-statement-process.datasets.cash-bank-dataset :cashRecons="$cashRecons" />
                @endif

                @if($activeTab == 'card')
                <x-app.commercial-head.approval-process.bank-statement-process.datasets.card-bank-dataset :cashRecons="$cashRecons" />
                @endif

                @if($activeTab == 'wallet')
                <x-app.commercial-head.approval-process.bank-statement-process.datasets.wallet-bank-dataset :cashRecons="$cashRecons" />
                @endif

                @if($activeTab == 'upi')
                <x-app.commercial-head.approval-process.bank-statement-process.datasets.upi-bank-dataset :cashRecons="$cashRecons" />
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
            });

        </script>

    </div>
