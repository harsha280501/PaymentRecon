<script>
    var $j = jQuery.noConflict();


    /**
     * Initialize the select2 for brands
     */
    function initializeStoreIDSelect2() {
        var storeSelect2 = $j(this.$refs.stores).select2();

        // Initialize brands with initial data
        updateStoreIDWhenBrandIsChanged(storeSelect2);

        storeSelect2.on("select2:select", (event) => {
            // Set the selected brand in Livewire component
            this.$wire.store = event.target.value;
            this.$wire.filtering = true;
        });


        // Livewire event listener to update brands when city is updated
        Livewire.on('update:dropdown', () => {
            updateStoreIDWhenBrandIsChanged(storeSelect2);
        });
        // this.$wire.emit('update:dropdown_three');

        // Livewire event listener to reset brands when triggered
        this.$wire.on('resetAll', (event) => {
            // Clear and update brands
            updateStoreIDWhenBrandIsChanged(storeSelect2);
            storeSelect2.val("").trigger("change");
        });
    }


    // update dom
    function updateStoreIDWhenBrandIsChanged(select2Instance) {
        // Clear existing options
        select2Instance.empty();

        // Initial data for brands
        const initialBrandsData = @entangle('storesM');

        console.log(initialBrandsData.initialValue);

        // Append new options
        // select2Instance.append(new Option('SELECT STORE ID', '   '));
        // initialBrandsData.initialValue.forEach(item => {
        //     select2Instance.append(new Option(item.store, item.store));
        // });

        // Trigger change to reflect the new options
        select2Instance.trigger("change");
    }

</script>


<div class="d-flex gap-2 align-items-center">
    <div x-init="initializeStoreIDSelect2" wire:ignore>
        <select x-ref="stores" data-placeholder="SELECT A STORE ID" class="w-mob-100" style="width: 200px">
            <option></option>
            {{-- Data will be inserted by Alpine.js --}}
        </select>
    </div>
</div>
