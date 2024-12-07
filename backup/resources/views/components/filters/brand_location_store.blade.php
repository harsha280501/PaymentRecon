<div x-data="{
    _store: '',
    _brand: '',
    _location: ''
}">

    <script>
        // initializing memory cleared select 2
        var $j = jQuery.noConflict();

        /**
         * Primary Datasource
         */
        async function _datasource(type, wire) {
            try {
                const data = await wire._get_dataset(type)
                return data;
            } catch (error) {
                return error;
            }
        }

        // create stores
        function _storesFilter() {

            this.selectFilterStore = $j(this.$refs._store_filter).select2();
            _update(this.selectFilterStore, '_store', 'SELECT A STORE', this.$wire);

            this.selectFilterStore.on("select2:select", (event) => {
                this.$wire._store = event.target.value;
            });

            this.$wire.on('resetAll', (event) => {
                this.selectFilterStore.val("").trigger("change");
                _update(this.selectFilterStore, '_store', 'SELECT A STORE', this.$wire);
            })

            this.$wire.on('triggered:change', (event) => {
                _update(this.selectFilterStore, '_store', 'SELECT A STORE', this.$wire);
            })
        }


        // create brands
        function _brandsFilter() {

            this.selectFilterBrand = $j(this.$refs._brand_filter).select2();

            _update(this.selectFilterBrand, '_brand', 'SELECT A BRAND', this.$wire);

            this.selectFilterBrand.on("select2:select", (event) => {
                this.$wire._brand = event.target.value;
            });

            this.$wire.on('resetAll', (event) => {
                this.selectFilterBrand.val("").trigger("change");
                _update(this.selectFilterBrand, '_brand', 'SELECT A BRAND', this.$wire);

            })

            this.$wire.on('triggered:change', (event) => {
                _update(this.selectFilterBrand, '_brand', 'SELECT A BRAND', this.$wire);
            })
        }


        // create location
        function _locationsFilter() {

            this.selectFilterLocation = $j(this.$refs._location_filter).select2();
            _update(this.selectFilterLocation, '_location', 'SELECT A LOCATION', this.$wire);

            this.selectFilterLocation.on("select2:select", (event) => {
                this.$wire._location = event.target.value;
            });

            this.$wire.on('resetAll', (event) => {
                this.selectFilterLocation.val("").trigger("change");
                _update(this.selectFilterLocation, '_location', 'SELECT A LOCATION', this.$wire);
            })

            this.$wire.on('triggered:change', (event) => {
                _update(this.selectFilterLocation, '_location', 'SELECT A LOCATION', this.$wire);
            })
        }


        /**
         * Update brands in Select2 dropdown
         */
        async function _update(instance, type, initailValue, wire) {
            // Clear existing options
            instance.empty();
            const initialData = await _datasource(type + 's', wire);

            instance.append(new Option(initailValue, '  '));
            instance.append(new Option('ALL', '  '));

            initialData.forEach(item => {
                instance.append(new Option(Object.values(item)[0], Object.values(item)[0]));
            });

            instance.val(wire[type]).trigger("change");
        }

    </script>

    <div style="display: flex; align-items: center; justify-content: flex-start; height: inherit; gap: .5em">
        <div x-init="_brandsFilter" wire:ignore>
            <select x-ref="_brand_filter" data-placeholder="SELECT A BRAND" class="w-mob-100" style="width: 200px">

                <option></option>
                <option value=" ">All</option>
                <option value="testingChangeB">Brand One</option>
            </select>
        </div>

        <div x-init="_storesFilter" wire:ignore>
            <select x-ref="_store_filter" data-placeholder="SELECT A STORE" class="w-mob-100" style="width: 200px">

                <option></option>
                <option value=" ">All</option>
                <option value="testingChangeB">Store One</option>
            </select>
        </div>

        <div x-init="_locationsFilter" wire:ignore>
            <select x-ref="_location_filter" data-placeholder="SELECT A LOCATION" class="w-mob-100" style="width: 200px">

                <option></option>
                <option value=" ">All</option>
                <option value="testingChangeB">Location One</option>
            </select>
        </div>

    </div>
</div>
