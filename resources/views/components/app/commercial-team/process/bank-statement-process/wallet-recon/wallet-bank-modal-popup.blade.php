<div class="modal fade" id="exampleModalCenter_{{ $data->walletMisBankStRecoUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:98%;" x-data="{
        sale: '{{ $data->diffSaleDeposit }}',
        recons: [{id: 1, item: 'Rectification Entry - Wallet MIS'}],
        loading: false,
        hasItems: [],
        // creating an item
        create(data) {
            this.recons = [...this.recons, data]
        },
        // removing an item
        remove(id) {
            this.recons = this.recons.filter(item => item.id !== id)
        }, 
        // creating a new item 
        submit(id) {
            
            // validating the forms
            if(!MainFormvalidate(id)){
                return false
            }

            // sale amount check
            const saleAmount = this.recons.map(item => item.amount),
                saleSum = saleAmount.reduce((sum, value) => parseFloat(sum) + parseFloat(value), 0)

            // sale amount is greater the difference
            if(parseFloat(saleSum).toFixed(2) != parseFloat(this.sale)) {
                errorMessageConfiguration('The amount cannot be less than or greater than difference')
                return false
            }

          
            confirmAction(async () => {
                this.loading = true
                await walletApproval(this.recons, this.$el.dataset.primaryId, saleSum)
                this.loading = false
            }, 'Are you sure you want to send item for Approval?');

            return true;
        }
    }">
        {{-- modal body --}}
        <x-app.commercial-team.process.bank-statement-process.wallet-recon.popup-model :data="$data">
            <div class="modal-body" style="position: unset">
                <x-app.commercial-team.process.bank-statement-process.wallet-recon.popup-headers :data="$data" />

                <h5>Reconciliation Window </h5>
                <x-app.commercial-team.process.bank-statement-process.wallet-recon.recon-window :data="$data" />
                <br>
                {{-- Manual Entry --}}
                <h5>Entry By Store for reconciliation</h5>
                <div>
                    {{-- Add Process --}}
                    <x-app.commercial-team.process.bank-statement-process.wallet-recon.add-recon-button ::recons="recons" />
                    <x-app.commercial-team.process.bank-statement-process.wallet-recon.manual-entry :data="$data">
                        <template x-for="recon in recons">
                            <x-app.commercial-team.process.bank-statement-process.wallet-recon.cash-process-entry :remarks="$remarks" ::recon="recon" :data="$data" />
                        </template>
                    </x-app.commercial-team.process.bank-statement-process.wallet-recon.manual-entry>
                    <x-app.commercial-team.process.bank-statement-process.wallet-recon.get-amount-totals :data="$data" />

                    {{-- total --}}
                    <div class="d-flex gap-3 justify-content-end align-items-center mt-4">
                        {{-- save form --}}
                        <template x-if="'{{ $data->reconStatus }}' != 'Pending for Approval'">
                            <button @click="submit($event.target.dataset.id)" data-primary-id="{{ $data->walletMisBankStRecoUID }}" data-id="exampleModalCenter_{{ $data->walletMisBankStRecoUID }}" type="submit" class="btn btn-success green">Save</button>
                        </template>
                    </div>
                </div>
                <br>
                {{-- History --}}
                <h5 style="border-bottom: 2px solid #00000023;" class="pb-2">History</h5>
                <x-app.commercial-team.process.bank-statement-process.wallet-recon.history :data="$data" />
                <br>
            </div>
            {{-- modal footer --}}
            <x-app.commercial-team.process.bank-statement-process.wallet-recon.popup-model-footer :data="$data">
                <div x-show="loading" style="display: none; text-align:left; margin: 0 1em; flex: 1; color: #000">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span>Loading ...</span>
                </div>
            </x-app.commercial-team.process.bank-statement-process.wallet-recon.popup-model-footer>
            {{-- Popup modal end --}}
        </x-app.commercial-team.process.bank-statement-process.wallet-recon.popup-model>
    </div>
</div>
