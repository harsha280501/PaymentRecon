{{-- Table auto scrollable --}}
<div wire:key="{{ base64_encode('hello-world') }}" x-data="{

    height: '45vh',

    getHeight() {
        // get the footer position
        const footer = document.querySelector('.footer')
        //  get table position
        const table = this.$refs.mainTable
        return ((footer.offsetTop - table.offsetTop) - 30)
    },

    getWidth() {
        const table = $refs.mainTable
        return table.clientWidth + 'px';
    }

}" class="w-100" x-init="() => {
    @this.on('resetAll', (data) => {
        @this.loadMore()
    })
}" wire:key="7bd44209af7bea2881c7242c0aa22be775b41372d9399a12ed682c87a67dd823" :style="{ overflowX: 'scroll', maxHeight: 'calc(100vh - 350px)', minHeight: '45vh', height: getHeight() > 1 ? getHeight() + 'px' : '45vh' }">

    {{-- main table goes in here --}}
    <table wire:key="ab3c08deba1ce2f76e402a7fd7dcb3b7d1265622203706fd49109c95e9bcddca" x-ref="mainTable" class="table table-info">
        {{ $slot }}
    </table>

    @if(count($dataset) > 7)
    {{-- scroll trigger --}}
    <div wire:key="027c91a5bf3d65b903ac23c803deb02346f0da64821141841cc53fa37a01b335" :style="{width: getWidth()}" class="mb-3" x-data="{
        observe() {
            const observer = new IntersectionObserver(items => {
                items.forEach(item => {
                    if(item.isIntersecting) {
                        // calls a function called load more
                        @this.loadMore();
                        @this.emit('scrolled')
                    }
                })
            })
            // obsrve this div
            observer.observe(this.$el);
        }
    }" x-init="observe()">
    </div>




    @endif
    @if(count($dataset) == 0) <p class="text-center mb-3">No data available</p>
    @endif

    {{-- Spinner --}}
    <x-spinner.index />
</div>
