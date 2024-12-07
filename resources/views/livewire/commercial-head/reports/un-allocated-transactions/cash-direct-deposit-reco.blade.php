<div x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null;
        this.end = null;
    }


}" x-init="() => {
    Livewire.on('cash-deposit:success', () => {
        succesMessageConfiguration('Cash Deposit Updated Successfully')
        window.location.reload()
    })
    Livewire.on('file:imported', () => {
        succesMessageConfiguration('Cash Deposit Uploaded Successfully')
        window.location.reload()
    })

    Livewire.on('cash-deposit:failed', (message) => {
        errorMessageConfiguration('Error, Something went wrong!.., please try again!')
        window.location.reload()
    })
}">

    
    <div wire:ignore>
        <x-app.commercial-head.reports.unallocated.tabs  :filtering="$filtering" :activeTab="$activeTab" />
    </div>

    <div>
        <x-selection.checkboxes :selectionHas="$selectionHas">

            <x-app.commercial-head.reports.cash-deposit.filters :filtering="$filtering" :accountNo="$accountNo" :branches="$branches" :months="$_months" />
            <x-app.commercial-head.reports.unallocated.partials.cash-deposit-totals :dataset="$totals" />

            <div class="col-lg-12 mt-3" style="overflow: hidden">
                <x-scrollable.scrollable :dataset="$cashRecons">
                    <x-scrollable.scroll-head>

                        <tr>
                            <th scope="col" class="left" wire:key="3e68c0541bfa3de72f1c4c6375b61bd562554950d9416fc289a284cc9ac2e298">
                                <x-selection.check-all :selectionHas="$selectionHas" />
                            </th>
                            <th scope="col" class="left">Account No.</th>
                            <th scope="col" class="left">Store ID</th>
                            <th scope="col" class="left">Retek Code</th>
                            <th scope="col" class="left">Sales Date</th>
                            <th scope="col">
                                <div class="d-flex align-items-center gap-2 left">
                                    <span>Deposit Date</span>
                                    <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                                </div>
                            </th>
                            <th scope="col" class="left">Col Bank</th>
                            <th scope="col" class="left">Sales Tender</th>
                            <th scope="col" class="left">Description</th>
                            <th scope="col" class="left">Transaction Branch</th>
                            <th scope="col" class="right">Credit Amount</th>
                            <th scope="col" class="right">Debit Amount</th>
                            <th scope="col" class="left">Action</th>
                        </tr>

                    </x-scrollable.scroll-head>
                    <x-scrollable.scroll-body>

                        @foreach ($cashRecons as $data)
                        <tr wire:key="47e6abd91dc1dafbc4ab04def0e22550de757959fdf119d5c00e8b4e752bba69">
                            <td class="left" scope="row" wire:key="521d9b1ad9b758ad1ff7ffbb046f96d9c54ccdd75f03f6c8f503862da6201778">
                                <x-selection.check-list :selectionHas="$selectionHas" :data="$data" />
                            </td>

                            <td class="left"> {{ $data->accountNo }} </td>
                            <td class="left"> {{ $data->storeID }} </td>
                            <td class="left"> {{ $data->retekCode }} </td>
                            <td class="left"> {{ !$data->salesDate ? '' : Carbon\Carbon::parse($data->salesDate)->format('d-m-Y') }} </td>
                            <td class="left"> {{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }} </td>
                            <td class="left"> {{ $data->colBank }} </td>
                            <td class="left"> {{ $data->tender }} </td>

                            <td class="left" style="width: 350px;">
                                <div style="white-space: normal;">
                                    {{ $data->description }}
                                </div>
                            </td>

                            <td class="left"> {{ $data->transactionBr }} </td>
                            <td class="right"> {{ $data->credit }} </td>
                            <td class="right"> {{ $data->debit }} </td>
                            <td class="left">
                                <button data-bs-target="#main{{ $data->UID }}" style="background: transparent; border: none; outline: none;" data-bs-toggle="modal">
                                    <i class="fa-solid fa-eye text-primary"></i>
                                </button>
                            </td>
                            <div  wire:key="2cdc756b8fba50f585775372ca53247f0360846d12b4e832771d5ca28b0bfc0f">
                                <x-app.commercial-head.reports.cash-deposit.update-modal :data="$data" />
                            </div>
                        </tr>
                        @endforeach

                    </x-scrollable.scroll-body>
                </x-scrollable.scrollable>
            </div>
        </x-selection.checkboxes>

        <x-app.commercial-head.reports.cash-deposit.import-modal :message="$message" />

        <script>
            var $j = jQuery.noConflict();
            $j('.searchField').select2();

            document.addEventListener('livewire:load', function() {
                $j('#select1-dropdown').on('change', function(e) {
                    @this.set('filtering', true);
                    @this.set('branch', e.target.value);
                });
            });

        </script>
    </div>

</div>
