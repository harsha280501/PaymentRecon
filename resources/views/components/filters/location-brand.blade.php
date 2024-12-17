<script>
    var $j = jQuery.noConflict();

    /**
     * Initialize the select2 for locations
     */
    function initializeLocationSelect2() {
        var locationsSelect2 = $j(this.$refs.location).select2();

        locationsSelect2.on("select2:select", (event) => {
            this.$wire.emit('update:city');
            // Trigger the filtering process in Livewire 
            this.$wire._city = event.target.value;
            this.$wire.filtering = true;
        });

        // Livewire event listener to reset locations when triggered
        this.$wire.on('resetAll', (event) => {
            locationsSelect2.val("").trigger("change");
        });
    }

    /**
     * Initialize the select2 for brands
     */
    function initializeBrandsSelect2() {
        var brandsSelect2 = $j(this.$refs.brands).select2();

        // Initialize brands with initial data
        updateBrands(brandsSelect2);

        brandsSelect2.on("select2:select", (event) => {
            // Set the selected brand in Livewire component
            this.$wire._brand = event.target.value;
            this.$wire.filtering = true;
        });

        // Livewire event listener to update brands when city is updated
        Livewire.on('update:city', () => {
            updateBrands(brandsSelect2);
        });

        // Livewire event listener to reset brands when triggered
        this.$wire.on('resetAll', (event) => {
            // Clear and update brands
            updateBrands(brandsSelect2);
            brandsSelect2.val("").trigger("change");
        });
    }

    /**
     * Update brands in Select2 dropdown
     */
    function updateBrands(select2Instance) {
        // Clear existing options
        select2Instance.empty();

        // Initial data for brands
        const initialBrandsData = @entangle('brands');

        // Append new options
        select2Instance.append(new Option('SELECT A BRAND', '   '));
        select2Instance.append(new Option('ALL', '   '));
        initialBrandsData.initialValue.forEach(item => {
            select2Instance.append(new Option(item.Brand, item.Brand));
        });

        // Trigger change to reflect the new options
        select2Instance.trigger("change");
    }

</script>

<div class="d-flex gap-2 align-items-center">
    <div x-init="initializeLocationSelect2" wire:ignore>
        <select x-ref="location" data-placeholder="SELECT A CITY" class="w-mob-100" style="width: 200px">
            <option></option>
            <option value="  ">All</option>
            @foreach($cities as $item)
            @php
            $item = (array) $item;
            @endphp
            <option value="{{ isset($keys) ? $item[$keys] :  $item['City'] }}">{{ isset($keys) ? $item[$keys] : $item['City'] }}</option>
            @endforeach
        </select>
    </div>

    <div x-init="initializeBrandsSelect2" wire:ignore>
        <select x-ref="brands" data-placeholder="SELECT A BRAND" class="w-mob-100" style="width: 200px">
            <option></option>
            {{-- Data will be inserted by Alpine.js --}}
        </select>
    </div>
</div>
