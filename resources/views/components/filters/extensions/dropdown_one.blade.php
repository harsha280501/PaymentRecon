<script>
    var $j = jQuery.noConflict();

    function _selectFilterExtOne() {

        this.selectFilterOne = $j(this.$refs.selectFilterOne).select2();

        this.selectFilterOne.on("select2:select", (event) => {
            this.$wire["{{ $keys }}"] = event.target.value;
            this.$wire.filtering = true;
        });

        this.$wire.on('resetAll', (event) => {
            this.selectFilterOne.val("").trigger("change");
        })
    }

</script>

<div x-init="_selectFilterExtOne" wire:ignore>
    <select x-ref="selectFilterOne" data-placeholder="{{ $initialValue }}" class="w-mob-100" style="width: 200px">

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
