<section id="recent" class="process-page" x-data="{
    start:null,
    end:null,
    reset(){
        this.start = null
        this.end=null
    }
}">

    <div>
        <x-app.store-user.process.mpos-cash-recon.filters :activeTab="$activeTab" :mainBanks="$main_banks" :filtering="$filtering" :months="$_months" />
    </div>

    @if($activeTab == 'main')
    <x-app.store-user.process.mpos-cash-recon.mpos-main.mpos-cash-recon :activeTab="$activeTab" :orderBy="$orderBy" :dataset=" $dataset">
        <x-scrollable.scroll-body>
            @foreach ($dataset as $data)
            <tr>
                <td>{{ !$data->mposDate ? '' : Carbon\Carbon::parse($data->mposDate)->format('d-m-Y') }}</td>
                <td>{{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}</td>
                <td>{{ $data->bankDropID }}</td>
                <td style="text-align: right !important">{{ $data->bankDropAmountF }}</td>
                <td style="text-align: right !important">{{ $data->tenderAmountF }}</td>
                <td style="text-align: right !important">{{ $data->depositAmountF }}</td>
                <td style="text-align: right !important">{{ $data->bank_cash_differenceF }}</td>
                <td style="font-weight: 700; color: @if($data->status == 'Matched') teal @else red @endif">{{
                    $data->status }}</td>


                <td style="
                    @if(in_array($data->reconStatus, ['disapprove', 'Rejected'])) 
                        color: red; 
                        font-weight: 700; 
                    @elseif(in_array($data->reconStatus, ['Pending for Approval']))
                        color: purple; 
                        font-weight: 700; 
                    @else 
                        color: inherit; 
                    @endif
                ">{{ $data->reconStatus == 'disapprove' ? 'Rejected' : $data->reconStatus }}</td>
 
                <td><a href="#" data-bs-target="#exampleModalCenter_{{ $data->CashTenderBkDrpUID }}" style="font-size: 1.1em" data-bs-toggle="modal">View</a></td>
            </tr>

            <div class="modal fade" id="exampleModalCenter_{{ $data->CashTenderBkDrpUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:98%;" x-data="{
                    sale: '{{ $data->calculatedDifference }}',
                    tenderAmount: parseFloat('{{ $data->tenderAmount }}'),
                    bankDrop: parseFloat('{{ $data->depositAmount }}'),
                    recons: [{id: 1, item: 'Cash Deposit by Store'}],
                    loading: false,
                    hasItems: [],
                    clicked: false,
                    isOpen: false,


                    _check (saleSum) {
                        console.log('Into checking');
                        const _check = parseFloat(saleSum).toFixed(2) - parseFloat(this.sale);
                        return _check >= 100 == true || _check <= -100 == true
                    },

                    calculation(tenderAmount, bankDropAmount, tenderAdj, bankAdj) {
                        return tenderAmount + tenderAdj - (bankDropAmount + bankAdj) == 0
                    },

                    // creating an item
                    create(data) {
                        this.recons = [...this.recons, data]
                    },

                    // removing an item
                    remove(id) {
                        this.recons = this.recons.filter(item => item.id !== id)
                    },

                    hasItem() {
                        return this.recons.map(item => item.item)
                    },
                    
                    async submit(id) {
                        
                        
                        // validating the forms
                        if(!MainFormvalidate(id)){
                            this.clicked = false
                            return false
                        }

                        // sale amount check
                        const saleAmount = this.recons.map(item => item.amount),
                            saleSum = saleAmount.reduce((sum, value) => parseFloat(sum) + parseFloat(value), 0)

                        
                        if(this._check(saleSum)) {
                            errorMessageConfiguration('The Sale amount cannot be less than or greater than Plus or Minus 100 difference')
                            return false
                        } 

                        confirmAction(async () => {
                            this.loading = true
                            await mainSubmit(this.recons, this.$el.dataset.primaryId, saleSum, 0, 0)
                            this.loading = false
                        }, 'Are you sure you want to send item for Approval?');

                        return true
                    }
                }">
                    {{-- modal body --}}
                    <x-app.store-user.process.mpos-cash-recon.mpos-main.popup-model :data="$data">
                        <div class="modal-body" style="position: unset">
                            <x-app.store-user.process.mpos-cash-recon.mpos-main.popup-headers :data="$data" />

                            <h5>Reconciliation Window </h5>
                            <x-app.store-user.process.mpos-cash-recon.mpos-main.recon-window :data="$data" />
                            <br>
                            {{-- Manual Entry --}}
                            <h4 style="text-transform: uppercase; color: #000 !important; background: #f0f0f0; text-align: center; padding: .8em 0">
                                Store Response</h4>
                            <div>
                                {{-- Add Process --}}
                                <x-app.store-user.process.mpos-cash-recon.mpos-main.add-recon-button ::recons="recons" />
                                <x-app.store-user.process.mpos-cash-recon.mpos-main.manual-entry :data="$data">
                                    <template x-for="recon in recons">
                                        <x-app.store-user.process.mpos-cash-recon.mpos-main.cash-process-entry ::recon="recon" :data="$data" :remarks="$remarks" />
                                    </template>
                                </x-app.store-user.process.mpos-cash-recon.mpos-main.manual-entry>
                                <x-app.store-user.process.mpos-cash-recon.mpos-main.get-amount-totals :data="$data" />

                                <div class="d-flex gap-3 justify-content-end align-items-center mt-4">
                                    <template x-if="'{{ (($data->summed_adjustment - $data->bank_cash_difference) > 100) || ($data->summed_adjustment - $data->bank_cash_difference) < -100 }}' && ('{{ !$data->isPendingForPartialApproval }}') && !loading">
                                        <button @click="() => {
                                                submit($event.target.dataset.id)
                                            }" data-primary-id="{{ $data->CashTenderBkDrpUID }}" data-id="exampleModalCenter_{{ $data->CashTenderBkDrpUID }}" type="submit" class="btn btn-success green">Submit</button>
                                    </template>
                                </div>
                            </div>
                            <br>
                            {{-- History --}}
                            <h5 style="border-bottom: 2px solid #00000023;" class="pb-2">History</h5>
                            <x-app.store-user.process.mpos-cash-recon.mpos-main.history :data="$data" />
                            <br>
                        </div>
                        {{-- modal footer --}}
                        <x-app.store-user.process.mpos-cash-recon.popup-model-footer :data="$data">
                            <div x-show="loading" style="display: flex; text-align:left; margin: 0 1em; flex: 1; color: #000">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span>Loading ...</span>
                            </div>
                        </x-app.store-user.process.mpos-cash-recon.popup-model-footer>
                        {{-- Popup modal end --}}
                    </x-app.store-user.process.mpos-cash-recon.mpos-main.popup-model>
                </div>
            </div>

            @endforeach
        </x-scrollable.scroll-body>
    </x-app.store-user.process.mpos-cash-recon.mpos-main.mpos-cash-recon>
    @endif


    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();

        document.addEventListener('livewire:load', function() {

            $j('#select1-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('bank', e.target.value);
            });

            $j('#select2-dropdown2').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('bank', e.target.value);
            });

            $j('#select2-dropdown1').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('bank', e.target.value);
            });
        });

    </script>

</section>
