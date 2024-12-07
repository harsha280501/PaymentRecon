<div x-data="{
    start: null,
    end: null,
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
    <x-selection.checkboxes :selectionHas="$selectionHas">

        <x-app.commercial-head.reports.cash-deposit.filters :filtering="$filtering" :accountNo="$accountNo" :branches="$branches" :months="$_months" />

        <div class="col-lg-12 mt-3" style="overflow: hidden">
            <x-scrollable.scrollable :dataset="$cashRecons">
                <x-scrollable.scroll-head>

                    <tr>
                        <th scope="col" class="left">
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
                        <th scope="col" class="left">Description</th>
                        <th scope="col" class="left">Transaction Branch</th>
                        <th scope="col" class="right">Credit Amount</th>
                        <th scope="col" class="right">Debit Amount</th>
                        <th scope="col" class="left">Action</th>
                    </tr>

                </x-scrollable.scroll-head>
                <x-scrollable.scroll-body>

                    @foreach ($cashRecons as $data)
                    <tr wire:key="{{ $data->UID }}">
                        <td class="left" scope="row">
                            <x-selection.check-list :selectionHas="$selectionHas" :data="$data" />
                        </td>

                        <td class="left"> {{ $data->accountNo }} </td>
                        <td class="left"> {{ $data->storeID }} </td>
                        <td class="left"> {{ $data->retekCode }} </td>
                        <td class="left"> {{ !$data->salesDate ? '' : Carbon\Carbon::parse($data->salesDate)->format('d-m-Y') }} </td>
                        <td class="left"> {{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }} </td>
                        <td class="left"> {{ $data->colBank }} </td>

                        <td class="left" style="width: 300px;">
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
                        <x-app.commercial-head.reports.cash-deposit.update-modal :data="$data" />
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
