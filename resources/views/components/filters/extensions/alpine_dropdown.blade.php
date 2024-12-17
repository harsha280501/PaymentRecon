<script>
    var $j = jQuery.noConflict();

    function _alpineJsFilter() {

        this.alpinSelectFilter = $j(this.$refs.alpinSelectFilter).select2();

        this.alpinSelectFilter.on("select2:select", (event) => {
            this.$wire["{{ $keys }}"] = event.target.value;
            // this.$wire.filtering = true;
        });

        this.$wire.on('resetAll', (event) => {
            this.alpinSelectFilter.val("").trigger("change");
        })
    }

</script>

<div x-init="_alpineJsFilter" wire:ignore>
    <select x-ref="alpinSelectFilter" data-placeholder="{{ $initialValue }}" class="w-mob-100" style="width: 200px">

        <option></option>
        <option value="">All</option>
        @foreach($dataset as $item)
        @php
        $item = (array) $item;
        @endphp
        <option value="{{ $item[$keys] }}">{{ $item[$keys] }}</option>
        @endforeach
    </select>
</div>
