<script>
    var $j = jQuery.noConflict();

    /**
     * Initialize the select2 for locations
     */
    function initializeBrandSelect2() {
        var brandSelect2 = $j(this.$refs.brand).select2();

        brandSelect2.on("select2:select", (event) => {
            this.$wire.emit('update:brand');
            // Trigger the filtering process in Livewire 
            this.$wire.Brand = event.target.value;
            this.$wire.filtering = true;
        });

        // Livewire event listener to reset locations when triggered
        this.$wire.on('resetAll', (event) => {
            brandSelect2.val("").trigger("change");
        });
    }

    /**
     * Initialize the select2 for brands
     */
    function initializeStoreIDSelect2() {
        var storeSelect = $j(this.$refs.storeSelect).select2();

        // Initialize brands with initial data
        updateStores(storeSelect);

        storeSelect.on("select2:select", (event) => {
            // Set the selected brand in Livewire component
            this.$wire.store = event.target.value;
            this.$wire.filtering = true;
        });

        // Livewire event listener to update brands when city is updated
        Livewire.on('update:brand', () => {
            updateStores(storeSelect);
            this.$wire.store = '';
        });

        // Livewire event listener to reset brands when triggered
        this.$wire.on('resetAll', (event) => {
            // Clear and update brands
            updateStores(storeSelect);
            storeSelect.val("").trigger("change");
        });
    }

    /**
     * Update brands in Select2 dropdown
     */
    function updateStores(select2Instance) {
        // Clear existing options
        select2Instance.empty();

        // Initial data for brands
        const initialBrandsData = @entangle('stores');

        // Append new options
        select2Instance.append(new Option('SELECT A STORE ID', '  '));
        select2Instance.append(new Option('ALL', '  '));
        initialBrandsData.initialValue.forEach(item => {
            select2Instance.append(new Option(item.store, item.store));
        });

        // Trigger change to reflect the new options
        select2Instance.trigger("change");
    }

</script>

<div class="d-flex gap-2 align-items-center">
    <div x-init="initializeBrandSelect2" wire:ignore>
        <select x-ref="brand" data-placeholder="SELECT A BRAND" class="w-mob-100" style="width: 200px">
            <option></option>
            <option value="   ">All</option>
            @foreach($brands as $item)
            @php
            $item = (array) $item;
            @endphp
            <option value="{{ isset($brandKey) ? $item[$brandKey] :  $item['Brand'] }}">{{ isset($brandKey) ? $item[$brandKey] : $item['Brand'] }}</option>
            @endforeach
        </select>
    </div>

    <div x-init="initializeStoreIDSelect2" wire:ignore>
        <select x-ref="storeSelect" data-placeholder="SELECT A STORE ID" class="w-mob-100" style="width: 200px">
            <option></option>
            <option value="   ">All</option>
            {{-- Data will be inserted by Alpine.js --}}
        </select>
    </div>
</div>
