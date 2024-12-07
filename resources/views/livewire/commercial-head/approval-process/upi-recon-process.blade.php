<div>
    <x-app.commercial-head.approval-process.upi-recon-process.filters>
        <x-app.commercial-head.approval-process.upi-recon-process.main-filters storeId="select01-dropdown" show="upi" :activeTab="$activeTab" :filtering="$filtering" :stores="$card_stores" />
    </x-app.commercial-head.approval-process.upi-recon-process.filters>
    
    <section>
        <x-app.commercial-head.approval-process.upi-recon-process.counts :activeTab="$activeTab" :cashRecons="$cashRecons" />
    </section>

    <div class="col-lg-12 mt-2">
        {{-- Main sales table --}} 
        <x-scrollable.scrollable :dataset="$cashRecons">
            <x-scrollable.scroll-head>

                @if($activeTab == 'upi')
                <x-app.commercial-head.approval-process.upi-recon-process.headers.card-bank-headers />
                @endif
            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>

                @if($activeTab == 'upi')
                <x-app.commercial-head.approval-process.upi-recon-process.datasets.card-bank-dataset :cashRecons="$cashRecons" />
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
