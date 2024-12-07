<div x-data>

    {{-- Filters --}}
    <div class="mt-4">
        <x-app.commercial-head.exceptions.filters_list :filtering="$filtering" :months="$_months" :stores="$stores" :banks="$banks" />
    </div>



    <x-scrollable.scrollable :dataset="$dataset">
        <x-scrollable.scroll-head>
            <tr>
                <th class="left first-col sticky-col bggrey">
                    <div class="d-flex align-items-center gap-2">
                        <span>Deposit Date</span>
                        <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy('mposDate')" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                    </div>
                </th>

                <td class="left">Credit Date</td>
                <td class="left">Store ID</td>
                <td class="left">Retek Code</td>
                <td class="left">Brand Name</td>
                <td class="left">Location</td>
                <td class="left">Collection Bank</td>
                <td class="left">Transaction Type</td>
                <td class="right">Deposit Amount</td>
            </tr>
        </x-scrollable.scroll-head>
        <x-scrollable.scroll-body>
            @foreach ($dataset as $data)
            <tr>
                <td class="left">{{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}</td>
                <td class="left">{{ !$data->creditDate ? '' : Carbon\Carbon::parse($data->creditDate)->format('d-m-Y')}}</td>
                <td class="left">{{ $data->storeID }}</td>
                <td class="left">{{ $data->retekCode }}</td>
                <td class="left">{{ $data->brand }}</td>
                <td class="left">{{ $data->locationName }}</td>
                <td class="left">{{ $data->colBank }}</td>
                <td class="left">{{ $data->tranType }}</td>
                <td class="right">{{ $data->depositAmount }}</td>
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
    </x-scrollable.scrollable>
</div>
