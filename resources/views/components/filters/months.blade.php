<script>
    var $j = jQuery.noConflict();

    function _store() {

        this.select2 = $j(this.$refs.select).select2();
        this.select2.on("select2:select", (event) => {

            // reset the dates filter
            this.$wire.emit('resets:dates');

            this.$wire.filterDate({
                start: event.target.value == '1978-01-01' ? null : event.target.value
                , end: event.target.value == '1978-01-01' ? null : getEndOfMonth(new Date(event.target.value))
            });
        });

        // resetting months
        Livewire.on('resets:months', () => {
            this.select2.val("").trigger("change");
        })

        this.$wire.on('resetAll', (event) => {
            this.select2.val("").trigger("change");
        })
    }

</script>

<div x-init="_store" wire:ignore>
    <select x-ref="select" data-placeholder="SELECT MONTH" class="w-mob-100" style="width: 200px" wire:ignore>
        <option></option>
        {{-- <option value="">All</option> --}}
        @foreach($months as $item)
        @php
        $item = (array) $item;
        @endphp
        <option value="{{ $item['startDate'] }}">{{ $item["month"] }}</option>
        @endforeach
    </select>
</div>
