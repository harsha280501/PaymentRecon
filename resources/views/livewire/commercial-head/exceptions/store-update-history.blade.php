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
                        <span>Updated Date</span>
                        <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy('updatedDate')" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                    </div>
                </th>
				
				<td class="left">Deposit Date</td>
                <td class="left">New Store ID</td>
                <td class="left">Old Store ID</td>
                <td class="left">Collection Bank</td>
                <td class="left">Remarks</td>
            </tr>
        </x-scrollable.scroll-head>
        <x-scrollable.scroll-body>
            @foreach ($dataset as $data)
            <tr>
                <td class="left">{{ !$data->updatedDate ? '' : Carbon\Carbon::parse($data->updatedDate)->format('d-m-Y') }}</td>
				<td class="left">{{ !$data->depositDt ? '' : Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                <td class="left">{{ $data->newStoreID }}</td>
                <td class="left">{{ $data->oldStoreID }}</td>
                <td class="left">{{ $data->colBank }}</td>
                <td class="left">{{ $data->remarks }}</td>
            </tr>
            @endforeach
        </x-scrollable.scroll-body>
    </x-scrollable.scrollable>
</div>
