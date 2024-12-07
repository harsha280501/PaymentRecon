<div class="modal fade" id="exampleModalCenter_{{ $data->cardSalesRecoUID }}" tabindex="1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:98%;">
        <x-app.store-user.process.sap-recon.upi-recon.popup-model :data="$data">
            <div x-data="{
                sale: '{{ $data->diffSaleDeposit }}',
                recons: [{id: 1, item: 'Manual sales not reflected'}],
                loading: false,
                hasItems: [],
                // creating an item
                create(data) {
                    this.recons = [data, ...this.recons ]
                },
                // removing an item
                remove(id) {
                    this.recons = this.recons.filter(item => item.id !== id)
                }, 
                // creating a new item 
                submit(id) {
                    this.loading = true;
                    
                    // validating the forms
                    if(!MainFormvalidate(id)){
                        return false
                    }

                    // sale amount check
                    const saleAmount = this.recons.map(item => item.amount),
                        saleSum = saleAmount.reduce((sum, value) => parseFloat(sum) + parseFloat(value), 0)

                    // sale amount is greater the difference
                    if(parseFloat(saleSum).toFixed(2) != parseFloat(this.sale)) {
                        errorMessageConfiguration('The Sale amount cannot be less than or greater than difference')
                        return false
                    }

                    // form submit
                    upiSubmit(this.recons, this.$el.dataset.primaryId, saleSum)
                    this.loading = false

                    return true;
                }
            }" class="modal-body">

                <x-app.store-user.process.sap-recon.upi-recon.popup-headers :data="$data" />
                <br>

                <h5>Reconciliation Window </h5>
                <x-app.store-user.process.sap-recon.upi-recon.recon-window :data="$data" />
                <br>

                <h4
                    style="text-transform: uppercase; color: #000 !important; background: #f0f0f0; text-align: center; padding: .8em 0">
                    Store Response</h4>
                <div>
                    {{-- Add Process --}}
                    <x-app.store-user.process.sap-recon.upi-recon.add-recon-button ::recons="recons" />
                    <x-app.store-user.process.sap-recon.upi-recon.manual-entry :data="$data">
                        <template x-for="recon in recons">
                            <x-app.store-user.process.sap-recon.upi-recon.cash-process-entry ::recon="recon"
                                :data="$data" :remarks="$remarks" />
                        </template>
                    </x-app.store-user.process.sap-recon.upi-recon.manual-entry>
                    <x-app.store-user.process.sap-recon.upi-recon.get-amount-totals :data="$data" />

                    {{-- total --}}
                    <div class="d-flex gap-3 justify-content-end align-items-center mt-4">
                        {{-- save form --}}
                        <template x-if="'{{ $data->reconStatus }}' != 'Pending for Approval'">
                            <button @click="submit($event.target.dataset.id)"
                                data-primary-id="{{ $data->cardSalesRecoUID }}"
                                data-id="exampleModalCenter_{{ $data->cardSalesRecoUID }}" type="submit"
                                class="btn btn-success green">Submit</button>
                        </template>
                    </div>
                </div>
                <br />

                <h5 style="border-bottom: 2px solid #00000023;" class="pb-2">History</h5>
                <x-app.store-user.process.sap-recon.upi-recon.history :data="$data" />
                <br />
            </div>
            {{-- modal footer --}}
            <x-app.store-user.process.sap-recon.upi-recon.popup-model-footer :data="$data">
                <div x-show="loading" style="display: none; text-align:left; margin: 0 1em; flex: 1; color: #000">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span>Loading ...</span>
                </div>
            </x-app.store-user.process.sap-recon.upi-recon.popup-model-footer>
        </x-app.store-user.process.sap-recon.upi-recon.popup-model>
    </div>
</div>