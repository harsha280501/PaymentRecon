<div x-data="{
    _store: '',
    _brand: '',
    _location: ''
}" wire:ignore>

    <script>
        /**
         * Primary Datasource
         */
        async function _datasource(type, wire) {
            try {
                const data = await wire.filtersSyncDataset(type)
                return data;
            } catch (error) {
                console.log(error)
                return error;
            }
        }

        // create stores
        function _bankNameFilter() {

            this.selectFilterBankName = $j(this.$refs._bankName_filter).select2();
            _update(this.selectFilterBankName, 'bankName', 'SELECT A BANK', this.$wire);

            this.selectFilterBankName.on("select2:select", (event) => {
                this.$wire.bankName = event.target.value;
            });

            this.$wire.on('resetAll', (event) => {
                this.selectFilterBankName.val("").trigger("change");
                _update(this.selectFilterBankName, 'bankName', 'SELECT A BANK', this.$wire);
            })

            this.$wire.on('triggered:change', (event) => {
                // _update(this.selectFilterBankName, 'bankName', 'SELECT A BANK', this.$wire);
            })
        }


        // create brands
        function _slipFilter() {

            this.selectFilterSlip = $j(this.$refs._slip_filter).select2();
            _update(this.selectFilterSlip, 'slip', 'SELECT A SLIP NUMBER', this.$wire);


            this.selectFilterSlip.on("select2:select", (event) => {
                this.$wire.slip = event.target.value;
                this.$wire.filtering = true;
            });


            this.$wire.on('resetAll', (event) => {
                this.selectFilterSlip.val("").trigger("change");
                _update(this.selectFilterSlip, 'slip', 'SELECT A SLIP NUMBER', this.$wire);
            })


            this.$wire.on('triggered:change', (event) => {
                this.selectFilterSlip.val("").trigger("change");
                _update(this.selectFilterSlip, 'slip', 'SELECT A SLIP NUMBER', this.$wire);
            })
        }



        /**
         * Update brands in Select2 dropdown
         */
        async function _update(instance, type, initailValue, wire) {
            // Clear existing options
            const initialData = await _datasource(type + 's', wire);

            instance.empty();
            instance.append(new Option(initailValue, '  '));
            instance.append(new Option('ALL', '  '));

            initialData.forEach(item => {
                instance.append(new Option(Object.values(item)[0], Object.values(item)[0]));
            });

            instance.val(wire[type]).trigger("change");
        }

    </script>

    <div style="display: flex; align-items: center; justify-content: flex-start; height: inherit; gap: .5em" wire:ignore>
        <div x-init="_bankNameFilter" wire:ignore>
            <select x-ref="_bankName_filter" data-placeholder="SELECT A BANK" class="w-mob-100" style="width: 200px">
                <option></option>
                <option value=" ">All</option>
                <option value="testingChangeB">Store One</option>
            </select>
        </div>


        <div x-init="_slipFilter" wire:ignore>
            <select x-ref="_slip_filter" data-placeholder="SELECT A SLIP NUMBER" class="w-mob-100" style="width: 200px">
                <option></option>
                <option value=" ">All</option>
                <option value="testingChangeB">Brand One</option>
            </select>
        </div>
    </div>
</div>
