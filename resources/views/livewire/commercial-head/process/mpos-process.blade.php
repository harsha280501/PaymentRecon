<section id="recent" class="process-page" x-data="{
    start: getUrlParams('from'),
    end: getUrlParams('to'),
    reset(){
        this.start = null
        this.end = null
    },

    isOpen:true
}">

    <x-app.commercial-head.process.mpos-recon.filters :stores="$stores" :storesone="$storesone" :storestwo="$storestwo" :storesthree="$storesthree" :storesfive="$storesfive" :codes="$codes" :codesone="$codesone" :codestwo="$codestwo" :codesthree="$codesthree" :codesfive="$codesfive" :filtering="$filtering" :activeTab="$activeTab" :months="$_months" :locations="$locations" />
    {{-- <span x-text="isOpen"></span> --}}
    <div class="row">
        <div class="col-lg-12">
            @if($activeTab == 'main')
            <x-scrollable.scrollable :dataset="$dataset">
                <x-scrollable.scroll-head>
                    <x-app.commercial-head.process.mpos-recon.mposbank-main-table-headers :orderBy="$orderBy" />
                </x-scrollable.scroll-head>
                <x-scrollable.scroll-body>
                    @foreach ($dataset as $data)
                    <x-app.commercial-head.process.mpos-recon.mposbank-main-table-dataset :data="$data" />
                    {{-- Modal --}}
                    <x-app.commercial-head.process.mpos-recon.main-modal :data="$data" />

                    @endforeach
                </x-scrollable.scroll-body>
            </x-scrollable.scrollable>
            @endif
        </div>
    </div>


    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {

            $j('#select1-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });

            $j('#select2-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });

            $j('#select3-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });

            $j('#select4-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });

            $j('#select5-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });

            $j('#select6-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });

            $j('#select7-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });

            $j('#select100-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });

            $j('#select8-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });
            $j('#select9-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });

            $j('#select10-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });

            $j('#select101-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });
            // $j('#select3-dropdown').on('change', function(e) {
            //     @this.set('filtering', true);
            //     @this.set('bank', e.target.value);
            // });
        });

    </script>

</section>
