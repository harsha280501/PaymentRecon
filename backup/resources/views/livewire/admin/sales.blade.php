<div class="col-lg-12">
    {{-- Filter   --}}
    <div class="mb-2" style="float: left;">
        <label style="font-size: .9em">Filter</label>
        <select wire:model="dropdownFilter" class="form-control mt-1 mb-2" aria-controls="zero-config" style="height:30px; width: 100px">
            <option value="0" selected id="filterYesterday">All</option>
            <option value="1" id="filterYesterday">Yesterday</option>
            <option value="2" id="filterMonth">This month</option>
            <option value="3" id="filterYear">This year</option>
        </select>
    </div>

    {{-- Exports  --}}
    <div style="float: right;" class="dropdown mb-2">
        <button class="btn dropdown-toggle" style="font-family: inherit; border: 1px solid #00000063" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Export
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="{{ url('/') }}/admin/bank_mis/export/excel">Export as PDF</a></li>
        </ul>
    </div>

    {{-- Main sales table  --}}
    <x-livewire.admin.sales-table-headers>
        @foreach ($msi as $data)
        <tr>
            <td class="left"> {{ $data->bankName }} </td>
            <td class="right"> {{ $data->transactionType }} </td>
            <td class="right"> {{ $data->customerCode }} </td>
            <td class="left"> {{ $data->locationName }} </td>
            <td class="right"> {{ $data->depositDate }} </td>
            <td class="right"> {{ $data->adjustmentDate }} </td>

            <td class="right"> {{ $data->creditDate }} </td>
            <th class="right">{{ $data->depositSlipNo }}</th>
            <td class="right"> {{ $data->depositAmount }} </td>

            {{-- Actions  --}}
            <td class="right">
                <div class="dropdown ms-0 ml-md-4 mt-2 mt-lg-0">
                    <a class="dropdown-toggle d-flex " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">View</a>
                    <div class="dropdown-menu dropdown-menu-right text-dark" aria-labelledby="dropdownMenuButton1">
                        <button class="dropdown-item pe-5 ps-2 m-1 pb-0" style="border: none; outline:none; background: transparent; color: #000 !important; font-size: 1em" data-bs-toggle="modal" data-bs-target="#main{{ $data->mflAxisPosCashRawUID }}">View</button>
                    </div>
                </div>
            </td>
            <x-modals.admin-bank-msi-modal :id="$data->mflAxisPosCashRawUID" :data="$data" />
        </tr>
        @endforeach
    </x-livewire.admin.sales-table-headers>

    {{ $msi->links() }}

</div>
