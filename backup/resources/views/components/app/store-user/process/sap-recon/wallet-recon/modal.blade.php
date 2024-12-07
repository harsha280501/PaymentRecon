<div class="modal fade" id="exampleModalCenter_{{ $data->walletSalesRecoUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:98%;" x-data="{
        sale: '{{ $data->calculatedDifference }}',
        recons: [{id: 1, item: 'Rectification Entry - Bank Statement'}],
        loading: false,
        hasItems: [],
        clicked: false,
        isOpen: false,

        // creating an item
        create(data) {
            this.recons = [...this.recons, data]
        },
        // removing an item
        remove(id) {
            this.recons = this.recons.filter(item => item.id !== id)
        }, 

        _check (saleSum) {
            console.log('Into checking');
            const _check = parseFloat(saleSum).toFixed(2) - parseFloat(this.sale);
            return _check >= 100 == true || _check <= -100 == true
        },

        // creating a new item 
        async submit(id) {

            // validating the forms
            if(!MainFormvalidate(id)){
                this.clicked = false
                return false
            }
            
            // sale amount check
            const saleAmount = this.recons.map(item => item.saleAmount),
                saleSum = saleAmount.reduce((sum, value) => parseFloat(sum) + parseFloat(value), 0)

            if(this._check(saleSum)) {
                errorMessageConfiguration('The Sale amount cannot be less than or greater than Plus or Minus 100 difference')
                return false
            } 

            confirmAction(async () => {
                this.loading = true
                await handleCardSubmit(this.recons, this.$el.dataset.primaryId, saleSum)
                this.loading = false
            }, 'Are you sure you want to send item for Approval?');
 
            return true;
        } 
    }">
        <x-app.store-user.process.sap-recon.wallet-recon.popup-model :data="$data">
            <div class="modal-body" style="position: unset">

                <x-app.store-user.process.sap-recon.wallet-recon.popup-headers :data="$data" />
                <br>

                <h5>Reconciliation Window </h5>
                <x-app.store-user.process.sap-recon.wallet-recon.recon-window :data="$data" />
                <br>

                <h4 style="text-transform: uppercase; color: #000 !important; background: #f0f0f0; text-align: center; padding: .8em 0">Store Response</h4>

                <div>
                    {{-- Add Process --}}
                    <x-app.store-user.process.sap-recon.wallet-recon.add-recon-button ::recons="recons" />
                    <x-app.store-user.process.sap-recon.wallet-recon.manual-entry :data="$data">
                        <template x-for="recon in recons">
                            <x-app.store-user.process.sap-recon.wallet-recon.cash-process-entry ::recon="recon" :data="$data" :remarks="$remarks" />
                        </template>
                    </x-app.store-user.process.sap-recon.wallet-recon.manual-entry>
                    <x-app.store-user.process.sap-recon.wallet-recon.get-amount-totals :data="$data" />



                    <div class="d-flex gap-3 justify-content-end align-items-center mt-4">
                        <template x-if="'{{ (($data->summed_adjustment - $data->diffSaleDeposit) > 100) || ($data->summed_adjustment - $data->diffSaleDeposit) < -100 }}' && ('{{ !$data->isPendingForPartialApproval }}') && !loading">
                            <button @click="submit($event.target.dataset.id)" data-primary-id="{{ $data->walletSalesRecoUID }}" data-id="exampleModalCenter_{{ $data->walletSalesRecoUID }}" type="submit" class="btn btn-success green">Submit</button>
                        </template>
                    </div>
                </div>
                <br />

                <h5 style="border-bottom: 2px solid #00000023;" class="pb-2">History</h5>
                <x-app.store-user.process.sap-recon.wallet-recon.history :data="$data" />
                <br />
            </div>
            {{-- modal footer --}}
            <x-app.store-user.process.sap-recon.wallet-recon.popup-model-footer :data="$data">
                <div x-show="loading" style="display: flex; text-align:left; margin: 0 1em; flex: 1; color: #000">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span>Loading ...</span>
                </div>
            </x-app.store-user.process.sap-recon.wallet-recon.popup-model-footer>
        </x-app.store-user.process.sap-recon.wallet-recon.popup-model>
    </div>
</div>
