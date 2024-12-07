<script>
    var $j = jQuery.noConflict();

    function _initLocation() {

        this._location = $j(this.$refs._location).select2();

        this._location.on("select2:select", (event) => {
            this.$wire._location = event.target.value;
            this.$wire.filtering = true;
        });

        this.$wire.on('resetAll', (event) => {
            this._location.val("").trigger("change");
        })
    }

</script>

<div x-init="_initLocation" wire:ignore>
    <select x-ref="_location" data-placeholder="SELECT A LOCATION" class="w-mob-100" style="width: 200px">

        <option></option>
        <option value="">All</option>
        @foreach($location as $item)
        @php
        $item = (array) $item;
        @endphp
        <option value="{{ isset($keys) ? $item[$keys] :  $item['Location'] }}">{{ isset($keys) ? $item[$keys] :
            $item['Location'] }}</option>
        @endforeach
    </select>
</div>
