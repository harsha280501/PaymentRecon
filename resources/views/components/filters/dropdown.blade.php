<script>
    var $j = jQuery.noConflict();

    function _get() {
        const navigator = window.navigator
    }

    function _selectFilter() {

        this.selectFilter = $j(this.$refs.selectFilter).select2();

        this.selectFilter.val(getUrlParams('bank')).trigger("change");
        this.selectFilter.on("select2:select", (event) => {
            this.$wire["{{ $keys }}"] = event.target.value;
            this.$wire.emit('update:dropdown');
            this.$wire.filtering = true;
        });

        this.$wire.on('resetAll', (event) => {
            this.selectFilter.val("").trigger("change");
        })
    }

</script>

<div x-init="_selectFilter" wire:ignore>
    <select x-ref="selectFilter" data-placeholder="{{ $initialValue }}" class="w-mob-100" style="width: 200px">

        <option></option>
        <option value=" ">All</option>
        @foreach($dataset as $item)
        @php
        $item = (array) $item;
        @endphp
        <option value="{{ $item[$keys] }}">{{ $item[$keys] }}</option>
        @endforeach
    </select>
</div>
