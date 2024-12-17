<div>

    {{--
    <x-app.commercial-head.approval-process.sap-recon-process.tabs :activeTab="$activeTab" /> --}}

    {{-- Filter --}}
    <x-app.commercial-head.approval-process.sap-recon-process.filters>

        <x-app.commercial-head.approval-process.sap-recon-process.main-filters storeId="select01-dropdown" show="card" :activeTab="$activeTab" :filtering="$filtering" :stores="$card_stores" />
    </x-app.commercial-head.approval-process.sap-recon-process.filters>

    <section>
        <x-app.commercial-head.approval-process.sap-recon-process.counts :activeTab="$activeTab" :cashRecons="$cashRecons" />
    </section>


    <div class="col-lg-12">
        {{-- Main sales table --}}
        <x-scrollable.scrollable :dataset="$cashRecons">
            <x-scrollable.scroll-head>

                @if($activeTab == 'card')
                <x-app.commercial-head.approval-process.sap-recon-process.headers.card-bank-headers />
                @endif
            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>

                @if($activeTab == 'card')
                <x-app.commercial-head.approval-process.sap-recon-process.datasets.card-bank-dataset :cashRecons="$cashRecons" />
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
                
                $j('#approval-filter').on('change', function(e) {
                    @this.set('filtering', true);
                    @this.set('status', e.target.value);
                });
            });

        </script>
    </div>
