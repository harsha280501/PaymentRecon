<div x-data="{
    start: null,
    end: null,
    reset(){
        this.start = null
        this.end = null
    },
    loading: false,
    open: false,  
}" x-init="() => {
    Livewire.on('direct-deposit:success', () => {
        succesMessageConfiguration('Inserted Successfully.');
        window.location.reload();
    });

    Livewire.on('direct-deposit:failed', (message) => {
        console.log(message);
        errorMessageConfiguration('Something went wrong!, Please try again.');
        return false;
    });
}">

    <x-app.commercial-head.direct-deposit.filters :months="$_months" :filtering="$filtering" :stores="$stores" />


    <div class="col-lg-12 mt-3">
        <x-scrollable.scrollable :dataset="$dataset">
            <x-scrollable.scroll-head>
                <tr>
                    <th>Store ID</th>
                    <th>Retek Code</th>

                    <th>
                        <div class="d-flex align-items-center gap-2">
                            <span>Sales Date</span>
                            <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                        </div>
                    </th>
                    <th>Status</th>
                    <th>Deposit SlipNo</th>
                    <th style="text-align: right !important">Amount</th>
                    <th>Bank</th>
                    <th>View</th>
                </tr>
            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>
                @foreach ($dataset as $data)
                <tr>
                    <td>{{ $data->storeID }}</td>
                    <td>{{ $data->retekCode }}</td>

                    <td>{{ Carbon\Carbon::parse($data->directDepositDate)->format('d-m-Y') }}</td>
                    <td style="@if($data->status == 'Rejected')font-weight: 700; color: red; @elseif($data->status == 'Approved') font-weight: 700; color: green; @else text-dark @endif"> {{ $data->status }}</td>
                    <td>{{ $data->depositSlipNo }}</td>
                    <td style="text-align: right !important">{{ $data->amount }}</td>
                    <td>{{ $data->bank }}</td>
                    <td><a href="#" class="" data-bs-toggle="modal" @click="open = true" data-bs-target="#Model_{{ $data->directDepositUID }}" wire:key="{{ base64_encode('d0owon3yxy') }}"><i class="fa-solid fa-eye"></i></a></td>
                </tr>

                <x-app.commercial-head.direct-deposit.update-modal :id="$data->directDepositUID" :data="$data" />
                @endforeach
            </x-scrollable.scroll-body>
        </x-scrollable.scrollable>
    </div>

    <x-app.commercial-head.direct-deposit.upload-modal />

</div>
