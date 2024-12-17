<div>
    <div class="col-lg-12">
        {{-- Main sales table --}}
        <div class="w-100" style="overflow-x: scroll">
            <x-livewire.CommercialHead.store-master-header>
                <tbody wire:loading.class='d-none'>
                    @foreach ($datas as $data)
                    <tr>
                        <td class="right"> {{ $data->{'Store ID'} }} </td>
                        <td class="right"> {{ $data->{'Store Name'} }} </td>
                        <td class="right"> {{ $data->{'Legacy Code'} }} </td>
                        <td class="right"> {{ $data->{'RETEK Code'} }} </td>
                        <td class="right"> {{ $data->{'Brand Desc'} }} </td>
                        <td class="right"> {{ $data->{'Region'} }} </td>
                        <td class="right"> {{ $data->{'Store Type'} }} </td>
                        <td class="right"> {{ $data->{'Location'} }} </td>
                        <td class="right"> {{ $data->{'CITY'} }} </td>
                        <td class="right"> {{ $data->{'State'} }} </td>
                        <td class="right"> {{ $data->{'PIN Code'} }} </td>

                    </tr>
                    @endforeach
                </tbody>
                </x-livewire.admin.sales-table-headers>

                @if($datas->count() == 0) <p class="showEmptyAlertData">No data available</p>
                @endif

                <div wire:loading.class='show-loading-spinner' class="loading-spinner">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span>Loading</span>
                </div>

                <div class="mt-4">
                    {{ $datas->links() }}
                </div>

        </div>

    </div>
</div>
