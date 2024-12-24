<script>
    var $j = jQuery.noConflict();

    function _storeMain() {

        this.select3 = $j(this.$refs.stores).select2();
        this.select3.val(getUrlParams('store')).trigger("change");

        this.select3.on("select2:select", (event) => {
            this.$wire.store = event.target.value;
            this.$wire.filtering = true;
        });

        this.$wire.on('resetAll', (event) => {
            console.log('Reset Emmitted');
            this.select3.val("").trigger("change");
        });
    }

</script>

<div x-init="_storeMain" wire:ignore>
    <select x-ref="stores" data-placeholder="SELECT STORE ID" class="w-mob-100" style="width: 200px">

        <option></option>
        <option value=" ">All</option>
        @foreach($stores as $item)
        @php
        $item = (array) $item;
        @endphp
        <option value="{{ isset($keys) ? $item[$keys] :  $item['storeID'] }}">{{ isset($keys) ? $item[$keys] :
            $item['storeID'] }}</option>
        @endforeach
    </select>
</div>
