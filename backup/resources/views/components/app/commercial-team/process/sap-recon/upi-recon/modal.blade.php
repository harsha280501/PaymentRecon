<div class="modal fade" id="exampleModalCenter_{{ $data->cardSalesRecoUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div x-data="{
        sale: '{{ $data->diffSaleDeposit }}',
        summed_amount: '{{ $data->summed_adjustment }}',
        recons: [{id: 1, item: 'Manual sales not reflected'}],
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
        
        // creating a new item 
        async submit(id) {
            this.summed_amount = !this.summed_amount ? 0 : this.summed_amount 

            // validating the forms
            if(!MainFormvalidate(id)){
                this.clicked = false
                return false
            }

            // sale amount check
            const saleAmount = this.recons.map(item => item.amount),
                saleSum = saleAmount.reduce((sum, value) => parseFloat(sum) + parseFloat(value), 0)

            const totalRecon = Math.abs(parseFloat(this.summed_amount) + saleSum);

            
            if(this.sale < 0 && saleSum > 0) {
                errorMessageConfiguration('The Adjustment amount cannot be positive if the difference is negative')
                return false;
            } 

            if(this.sale > 0 && saleSum < 0) {
                errorMessageConfiguration('The Adjustment amount cannot be negative if the difference is positive')
                return false;
            }


            // sale amount is greater the difference
            if(totalRecon > Math.abs(this.sale)) {
                errorMessageConfiguration('The Adjustment Entry should not be greater than the Difference')
                return false;
            } 

            confirmAction(async () => {
                this.loading = true
                await upiApproval(this.recons, this.$el.dataset.primaryId, saleSum)
                this.loading = false
            }, 'Are you sure you want to send item for Approval?');

            return true;
        }

    }" class="modal-dialog modal-dialog-centered" role="document" style="max-width:98%;">
        <x-app.commercial-team.process.sap-recon.upi-recon.popup-model :data="$data">
            <div class="modal-body" style="position: unset">

                <x-app.commercial-team.process.sap-recon.upi-recon.popup-headers :data="$data" />
                <br>

                <h5>Reconciliation Window </h5>
                <x-app.commercial-team.process.sap-recon.upi-recon.recon-window :data="$data" />
                <br>

                <h4 style="text-transform: uppercase; color: #000 !important; background: #f0f0f0; text-align: center; padding: .8em 0">
                    Store Response</h4>
                <div>

                    <x-app.commercial-team.process.sap-recon.upi-recon.add-recon-button ::recons="recons" />
                    <x-app.commercial-team.process.sap-recon.upi-recon.manual-entry :data="$data">
                        <template x-for="recon in recons">
                            <x-app.commercial-team.process.sap-recon.upi-recon.cash-process-entry ::recon="recon" :data="$data" :remarks="$remarks" />
                        </template>
                    </x-app.commercial-team.process.sap-recon.upi-recon.manual-entry>
                    <x-app.commercial-team.process.sap-recon.upi-recon.get-amount-totals :data="$data" />

                    {{-- total --}}
                    <div class="d-flex gap-3 justify-content-end align-items-center mt-4">
                        {{-- save form --}}
                        <template x-if="'{{ $data->reconStatus }}' != 'Pending for Approval' && clicked == false">
                            <button @click="() => {
                                submit($event.target.dataset.id)
                            }" data-primary-id="{{ $data->cardSalesRecoUID }}" data-id="exampleModalCenter_{{ $data->cardSalesRecoUID }}" type="submit" class="btn btn-success green">Submit</button>
                        </template>
                    </div>
                </div>
                <br />

                <h5 style="border-bottom: 2px solid #00000023;" class="pb-2">History</h5>
                <x-app.commercial-team.process.sap-recon.upi-recon.history :data="$data" />
                <br />
            </div>
            {{-- modal footer --}}
            <x-app.commercial-team.process.sap-recon.upi-recon.popup-model-footer :data="$data">
                <div x-show="loading" style="display: flex; text-align:left; margin: 0 1em; flex: 1; color: #000">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span>Loading ...</span>
                </div>
            </x-app.commercial-team.process.sap-recon.upi-recon.popup-model-footer>
        </x-app.commercial-team.process.sap-recon.upi-recon.popup-model>
    </div>
</div>
