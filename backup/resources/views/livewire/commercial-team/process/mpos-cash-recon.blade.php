<section id="recent" class="process-page" x-data="{
    start:null,
    end:null,
    reset(){
        this.start = null
        this.end=null
    }
}">

    <div>
        <x-app.commercial-team.process.mpos-cash-recon.filters :activeTab="$activeTab" :filtering="$filtering" :months="$_months" :stores="$stores" />
    </div>

    @if($activeTab == 'main')
    <x-app.commercial-team.process.mpos-cash-recon.mpos-main.mpos-cash-recon :activeTab="$activeTab" :dataset=" $dataset">
        <x-scrollable.scroll-body>
            @foreach ($dataset as $data)
            <tr>
                <td>{{ Carbon\Carbon::parse($data->mposDate)->format('d-m-Y') }}</td>
                <td>{{ Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}</td>
                <td>{{ $data->storeID }}</td>
                <td>{{ $data->retekCode }}</td>
                <td>{{ $data->brand }}</td>
                <td>{{ $data->bankDropID }}</td>
                <td>{{ $data->tenderAmountF }}</td>                                
                <td>{{ $data->bankDropAmountF }}</td>
                <td>{{ $data->depositAmountF }}</td>
                <td>{{ $data->bank_cash_differenceF }}</td>
                <td style="font-weight: 700; color: @if($data->status == 'Matched') teal @else red @endif">{{ $data->status }}</td>
                <td>
                    {{ $data->reconStatus == 'disapprove' ? 'Rejected' : $data->reconStatus }}
                </td>
                <td><a href="#" data-bs-target="#exampleModalCenter_{{ $data->CashTenderBkDrpUID }}" style="font-size: 1.1em" data-bs-toggle="modal">View</a></td>
            </tr>

            <div class="modal fade" id="exampleModalCenter_{{ $data->CashTenderBkDrpUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:98%;">
                    {{-- modal body --}}
                    <x-app.commercial-team.process.mpos-cash-recon.mpos-main.popup-model :data="$data">
                        <div x-data="{
                                    sale: '{{ $data->bank_cash_difference }}',
                                    tenderAmount: parseFloat('{{ $data->tenderAmount }}'),
                                    bankDrop: parseFloat('{{ $data->depositAmount }}'),
                                    recons: [{id: 1, item: 'Cash Deposit by Store'}],
                                    loading: false,
                                    hasItems: [],

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
                                  
                                    submit(id) {
                                        this.loading = true
                                   

                                        // validating the forms
                                        if(!MainFormvalidate(id)){
                                            return false
                                        }

                                        // splitting the manual sale
                                        const splittedRecons = this.recons.map(item => {
                                            if (item.item == 'Manual store sale') { // checking if the item is manual sale
                                                return {...item, tenderAdj: parseFloat(item.amount)}
                                            } else {
                                                return {...item, bankAdj: parseFloat(item.amount)}
                                            }
                                        });

                                        // getting totals
                                        const totalAmount = splittedRecons.map(item => item.amount || 0)
                                        const tenderAdjs = splittedRecons.map(item => item.tenderAdj || 0)
                                        const bankAdj = splittedRecons.map(item => item.bankAdj || 0)

                                        // getting sums
                                        const totals = totalAmount.reduce((sum, value) => parseFloat(sum) + parseFloat(value), 0)
                                        const tender = tenderAdjs.reduce((sum, value) => parseFloat(sum) + parseFloat(value), 0)
                                        const bank = bankAdj.reduce((sum, value) => parseFloat(sum) + parseFloat(value), 0)

                                        if(!this.calculation(this.tenderAmount, this.bankDrop, tender, bank)){
                                            errorMessageConfiguration('The Difference did not match')
                                            return false    
                                        }

                                        // form submit
                                        cashApproval(splittedRecons, this.$el.dataset.primaryId, totals, tender, bank)
                                        this.loading = false
        
                                        return true
                                    }
                                }" class="modal-body">
                            <x-app.commercial-team.process.mpos-cash-recon.mpos-main.popup-headers :data="$data" />

                            <h5>Reconciliation Window </h5>
                            <x-app.commercial-team.process.mpos-cash-recon.mpos-main.recon-window :data="$data" />
                            <br>
                            {{-- Manual Entry --}}
                            <h4 style="text-transform: uppercase; color: #000 !important; background: #f0f0f0; text-align: center; padding: .8em 0">Store Response</h4>
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
                                    {{-- save form --}}
                                    <template x-if="'{{ $data->reconStatus }}' != 'Pending for Approval'">
                                        <button @click="submit($event.target.dataset.id)" data-primary-id="{{ $data->CashTenderBkDrpUID }}" data-id="exampleModalCenter_{{ $data->CashTenderBkDrpUID }}" type="submit" class="btn btn-success green">Submit</button>
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
                            <div x-show="loading" style="display: none; text-align:left; margin: 0 1em; flex: 1; color: #000">

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

            $j('#select01-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });
        });

    </script>

</section>
