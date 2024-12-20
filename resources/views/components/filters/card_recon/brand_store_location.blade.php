    <script>
        var $j = jQuery.noConflict();

        function initializeFilter(filterRef, config) {
            const {
                route,
                placeholder,
                minLength,
                clearBtnRef,
                wireField,
                customLang
            } = config;

            const selectFilter = $j(filterRef).select2({
                placeholder: placeholder,
                minimumInputLength: minLength,
                language: customLang || {},
                ajax: {
                    url: route,
                    dataType: 'json',
                    delay: 250,
                    data: params => ({
                        search: params.term
                    }),
                    processResults: data => ({
                        results: data.original.map(item => ({
                            id: item[Object.keys(item)[0]], // Dynamic key
                            text: item[Object.keys(item)[0]],
                        }))
                    }),
                },
            });

            // Clear button logic
            selectFilter.on('select2:select', function(event) {
                config.onSelect(event.target.value);
                $j(clearBtnRef).show();
            });

            $j(clearBtnRef).on('click', function() {
                $j(filterRef).val(null).trigger('change');
                config.onClear();
                $j(clearBtnRef).hide();
            }).hide();

            return selectFilter;
        }

        function initializeFilters() {
            // Bank Filter
            this.selectFilterBank = initializeFilter(this.$refs._bank_filter, {
                route: '{{ route('reconSearch', 'banks') }}',
                placeholder: 'SELECT A BANK',
                minLength: 2,
                clearBtnRef: this.$refs._clear_bank,
                wireField: '_bank',
                onSelect: value => this.$wire.bank = value,
                onClear: () => this.$wire.bank = '',
            });

            // Store Filter
            this.selectFilterStore = initializeFilter(this.$refs._store_filter, {
                route: '{{ route('reconSearch', 'stores') }}',
                placeholder: 'SELECT A STORE',
                minLength: 2,
                clearBtnRef: this.$refs._clear_store,
                wireField: '_store',
                onSelect: value => this.$wire.store = value,
                onClear: () => this.$wire.store = '',
                customLang: {
                    inputTooShort: () => 'Please enter 2 or more characters',
                },
            });

            // Location Filter
            this.selectFilterLocation = initializeFilter(this.$refs._location_filter, {
                route: '{{ route('reconSearch', 'locations') }}',
                placeholder: 'SELECT A LOCATION',
                minLength: 3,
                clearBtnRef: this.$refs._clear_location,
                wireField: '_location',
                onSelect: value => this.$wire.Location = value,
                onClear: () => this.$wire.Location = '',
            });
        }
    </script>
    <div x-data="{ _store: '', _bank: '', _location: '' }" x-init="initializeFilters" style="display: flex; gap: 20px;">
        <!-- Bank Filter -->
        <div wire:ignore style="position: relative; width: 250px;">
            <select x-ref="_bank_filter" class="w-mob-200" style="width: 100%; height: 40px;"></select>
            <button x-ref="_clear_bank" type="button" class="clear-btn">×</button>
        </div>

        <!-- Store Filter -->
        <div wire:ignore style="position: relative; width: 200px;">
            <select x-ref="_store_filter" class="w-mob-200" style="width: 100%; height: 40px;"></select>
            <button x-ref="_clear_store" type="button" class="clear-btn">×</button>
        </div>

        <!-- Location Filter -->
        <div wire:ignore style="position: relative; width: 200px;">
            <select x-ref="_location_filter" class="w-mob-200" style="width: 100%; height: 40px;"></select>
            <button x-ref="_clear_location" type="button" class="clear-btn">×</button>
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
            font-size: 24px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 33%;
            right: 20px;
            transform: translateY(-50%);
            z-index: 1;
            cursor: pointer;
        }

        .clear-btn:hover {
            color: #ff0000;
        }
    </style>
