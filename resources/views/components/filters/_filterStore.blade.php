<script>
    var $j = jQuery.noConflict();

    function initializeFilter(filterRef, config) {
        const {
            route,
            placeholder,
            minLength,
            clearBtnRef,
            wireField,
            customLang,
            currentTab
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
                    search: params.term,
                    currentTab: currentTab
                }),
                processResults: data => ({
                    results: data.results.map(item => ({
                        id: item.id,
                        text: item.text,
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
        const url = new URL(window.location.href);
        const currentTab = url.searchParams.get('t');

        // Store Filter
        this.selectFilterStore = initializeFilter(this.$refs._store_filter, {
            route: '{{ route($route) }}',
            placeholder: 'SELECT A STORE',
            minLength: 2,
            clearBtnRef: this.$refs._clear_store,
            wireField: '_store',
            currentTab: currentTab,
            onSelect: (value) => {
                this.$wire.store = value;
                this.filtering = true;
            },
            onClear: () => {
                this.$wire.store = '';
                this.filtering = false;
            },
            customLang: {
                inputTooShort: () => 'Please enter 2 or more numbers',
            },
        });
    }
</script>

<div x-data="{ _store: '' }" x-init="initializeFilters" style="display: flex; gap: 20px;">
    <!-- Store Filter -->
    <div wire:ignore style="position: relative; width: 200px;">
        <select x-ref="_store_filter" class="w-mob-200" style="width: 100%; height: 40px;"></select>
        <button x-ref="_clear_store" type="button" class="clear-btn">×</button>
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
        top: 26%;
        right: 20px;
        transform: translateY(-50%);
        z-index: 1;
        cursor: pointer;
    }

    .clear-btn:hover {
        color: #ff0000;
    }
</style>
