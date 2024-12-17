<script>
    var $j = jQuery.noConflict();

    // Common Filter Initialization
    function _initializeFilter(filterRef, route, placeholder, minLength, customLangSetting = false) {
        let languageSettings = {};
        if (customLangSetting) {
            languageSettings = {
                inputTooShort: function() {
                    return 'Please enter ' + minLength + ' or more numbers';
                }
            };
        }

        return $j(filterRef).select2({
            placeholder: placeholder,
            minimumInputLength: minLength,
            language: languageSettings,
            ajax: {
                url: route,
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                    };
                },
                processResults: function(data) {
                    const results = data.original.map(item => ({
                        id: item[Object.keys(item)[0]], // Dynamic property key
                        text: item[Object.keys(item)[0]] // Dynamic property key
                    }));
                    return {
                        results: results
                    };
                }
            }
        });
    }

    // Brand Filter
    function _brandsFilter() {
        this.selectFilterBrand = _initializeFilter(
            this.$refs._brand_filter,
            '{{ route('searchBrands') }}',
            'SELECT A BRAND',
            2
        );

        this.selectFilterBrand.on('select2:select', (event) => {
            this.$wire._brand = event.target.value;
            $j(this.$refs._clear_brand).show();
        });

        // Clear button handler for Brand filter
        $j(this.$refs._clear_brand).on('click', () => {
            $j(this.$refs._brand_filter).val(null).trigger('change');
            this.$wire._brand = '';
            $j(this.$refs._clear_brand).hide();
        }).hide(); // Hide initially
    }

    // Store Filter
    function _storesFilter() {
        this.selectFilterStore = _initializeFilter(
            this.$refs._store_filter,
            '{{ route('searchStores') }}',
            'SELECT A STORE',
            2,
            true
        );

        this.selectFilterStore.on('select2:select', (event) => {
            this.$wire._store = event.target.value;
            $j(this.$refs._clear_store).show();
        });

        // Clear button handler for Store filter
        $j(this.$refs._clear_store).on('click', () => {
            $j(this.$refs._store_filter).val(null).trigger('change');
            this.$wire._store = '';
            $j(this.$refs._clear_store).hide();
        }).hide();
    }

    // Location Filter
    function _locationsFilter() {
        this.selectFilterLocation = _initializeFilter(
            this.$refs._location_filter,
            '{{ route('searchLocations') }}',
            'SELECT A LOCATION',
            3
        );

        this.selectFilterLocation.on('select2:select', (event) => {
            this.$wire._location = event.target.value;
            $j(this.$refs._clear_location).show();
        });

        // Clear button handler for Location filter
        $j(this.$refs._clear_location).on('click', () => {
            $j(this.$refs._location_filter).val(null).trigger('change');
            this.$wire._location = '';
            $j(this.$refs._clear_location).hide();
        }).hide();
    }
</script>

<div x-data="{ _store: '', _brand: '', _location: '' }" style="display: flex; gap: 20px;">
    <!-- Brand Filter -->
    <div x-init="_brandsFilter" wire:ignore style="position: relative; width: 250px;">
        <select x-ref="_brand_filter" wire:model.defer="_brand" class="w-mob-200"
            style="width: 100%; padding-right: 30px; height: 40px;"></select>
        <button x-ref="_clear_brand" type="button" class="clear-btn"
            style="position: absolute; top: 37%; right: 25px; transform: translateY(-50%); z-index: 1;">×</button>
    </div>

    <!-- Store Filter -->
    <div x-init="_storesFilter" wire:ignore style="position: relative; width: 200px;">
        <select x-ref="_store_filter" wire:model.defer="_store" class="w-mob-200"
            style="width: 100%; padding-right: 30px; height: 40px;"></select>
        <button x-ref="_clear_store" type="button" class="clear-btn"
            style="position: absolute; top: 35%; right: 20px; transform: translateY(-50%); z-index: 1;">×</button>
    </div>

    <!-- Location Filter -->
    <div x-init="_locationsFilter" wire:ignore style="position: relative; width: 200px;">
        <select x-ref="_location_filter" wire:model.defer="_location" class="w-mob-200"
            style="width: 100%; padding-right: 30px; height: 40px;"></select>
        <button x-ref="_clear_location" type="button" class="clear-btn"
            style="position: absolute; top: 35%; right: 20px; transform: translateY(-50%); z-index: 1;">×</button>
    </div>
</div>

<style>
    .clear-btn {
        background: transparent;
        color: rgb(94, 58, 58);
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        font-size: 22px;
        font-weight: bold;
        line-height: 1;
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .clear-btn:hover {
        color: #ff0000;
        cursor: pointer;
    }
</style>
