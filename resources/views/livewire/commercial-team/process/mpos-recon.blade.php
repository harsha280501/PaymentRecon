<section id="recent" class="process-page" x-data="{
    start:null,
    end:null,
    reset(){
        this.start = null
        this.end=null
    }
}">

    <div>
        <x-app.commercial-team.process.mpos-cash-recon.filters :activeTab="$activeTab" :mainBanks="$main_banks" :filtering="$filtering" :months="$_months" :stores="$stores" />
    </div>

    @if($activeTab == 'main')
    <x-app.commercial-team.process.mpos-cash-recon.mpos-main.mpos-cash-recon :activeTab="$activeTab" :orderBy="$orderBy" :dataset=" $dataset">
        <x-scrollable.scroll-body>
            @foreach ($dataset as $data)
            <tr>
                <td>{{ !$data->mposDate ? '' : Carbon\Carbon::parse($data->mposDate)->format('d-m-Y') }}</td>
                <td>{{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}</td>
                <td>{{ $data->storeID }}</td>
                <td>{{ $data->retekCode }}</td>
                <td>{{ $data->brand }}</td>
                <td>{{ $data->bankDropID }}</td>
                <td style="text-align: right !important">{{ $data->tenderAmountF }}</td>
                <td style="text-align: right !important">{{ $data->bankDropAmountF }}</td>
                <td style="text-align: right !important">{{ $data->depositAmountF }}</td>
                <td style="text-align: right !important">{{ $data->bank_cash_differenceF }}</td>
                <td style="text-align: right !important">{{ $data->calculatedDifference }}</td>
                <td style="text-align: right !important">{{ $data->summed_adjustment }}</td>
                <td style="font-weight: 700; color: @if($data->status == 'Matched') teal @else red @endif">{{
                    $data->status }}</td>
                <td>
                    {{ $data->reconStatus == 'disapprove' ? 'Rejected' : $data->reconStatus }}
                </td>
                <td><a href="#" data-bs-target="#exampleModalCenter_{{ $data->CashTenderBkDrpUID }}" style="font-size: 1.1em" data-bs-toggle="modal">View</a></td>
            </tr>

            <div class="modal fade" id="exampleModalCenter_{{ $data->CashTenderBkDrpUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:98%;" x-data="{
                    sale: '{{ $data->bank_cash_difference }}',
                    summed_amount: '{{ $data->summed_adjustment }}',
                    tenderAmount: parseFloat('{{ $data->tenderAmount }}'),
                    bankDrop: parseFloat('{{ $data->depositAmount }}'),
                    recons: [{id: 1, item: 'Cash Deposit by Store'}],
                    loading: false,
                    hasItems: [],
                    clicked: false,
                    isOpen: false,

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
 
              
                        if(totalRecon > Math.abs(this.sale)) {
                            errorMessageConfiguration('The Adjustment Entry should not be greater than the Difference')
                            return false;
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
                    <x-app.commercial-team.process.mpos-cash-recon.mpos-main.popup-model :data="$data">
                        <div class="modal-body" style="position: unset">
                            <x-app.commercial-team.process.mpos-cash-recon.mpos-main.popup-headers :data="$data" />

                            <h5>Reconciliation Window </h5>
                            <x-app.commercial-team.process.mpos-cash-recon.mpos-main.recon-window :data="$data" />
                            <br>
                            {{-- Manual Entry --}}
                            <h4 style="text-transform: uppercase; color: #000 !important; background: #f0f0f0; text-align: center; padding: .8em 0">
                                Store Response</h4>
                            <div>
                                {{-- Add Process --}}
                                <x-app.commercial-team.process.mpos-cash-recon.mpos-main.add-recon-button ::recons="recons" />
                                <x-app.commercial-team.process.mpos-cash-recon.mpos-main.manual-entry :data="$data">
                                    <template x-for="recon in recons">
                                        <x-app.commercial-team.process.mpos-cash-recon.mpos-main.cash-process-entry ::recon="recon" :data="$data" :remarks="$remarks" />
                                    </template>
                                </x-app.commercial-team.process.mpos-cash-recon.mpos-main.manual-entry>
                                <x-app.commercial-team.process.mpos-cash-recon.mpos-main.get-amount-totals :data="$data" />

                                {{-- total --}}

                                <div class="d-flex gap-3 justify-content-end align-items-center mt-4">
                                    <template x-if="(parseFloat(summed_amount) - parseFloat(sale)) != 0">
                                        <button @click="() => {
                                                submit($event.target.dataset.id)
                                            }" data-primary-id="{{ $data->CashTenderBkDrpUID }}" data-id="exampleModalCenter_{{ $data->CashTenderBkDrpUID }}" type="submit" class="btn btn-success green">Submit</button>
                                    </template>
                                </div>
                            </div>
                            <br>
                            {{-- History --}}
                            <h5 style="border-bottom: 2px solid #00000023;" class="pb-2">History</h5>
                            <x-app.commercial-team.process.mpos-cash-recon.mpos-main.history :data="$data" />
                            <br>
                        </div>
                        {{-- modal footer --}}
                        <x-app.commercial-team.process.mpos-cash-recon.popup-model-footer :data="$data">
                            <div x-show="loading" style="display: flex; text-align:left; margin: 0 1em; flex: 1; color: #000">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span>Loading ...</span>
                            </div>
                        </x-app.commercial-team.process.mpos-cash-recon.popup-model-footer>
                        {{-- Popup modal end --}}
                    </x-app.commercial-team.process.mpos-cash-recon.mpos-main.popup-model>
                </div>
            </div>

            @endforeach
        </x-scrollable.scroll-body>
    </x-app.commercial-team.process.mpos-cash-recon.mpos-main.mpos-cash-recon>
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
