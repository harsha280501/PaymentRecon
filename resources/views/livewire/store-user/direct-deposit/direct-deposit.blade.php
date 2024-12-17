<div x-data="{
    start: null,
    end: null,
    reset(){
        this.start = null
        this.end = null
    }
}">

    <x-app.store-user.direct-deposit.filters :months="$_months" :filtering="$filtering" />
    <x-app.store-user.direct-deposit.create-modal :remarks="$remarks" />

    <div class="col-lg-12 mt-3">
        <x-scrollable.scrollable :dataset="$dataset">
            <x-scrollable.scroll-head>
                <tr>
                    {{-- <th style="background: #f0f0f0" colspan="4"></th> --}}
                    <th colspan="18">Cash Deposited</th>
                </tr>
                <tr style="background: #f0f0f0">
                    <th style="background: #dddddd">
                        <div class="d-flex align-items-center gap-2">
                            <span>Deposit Date</span>
                            {{-- {{ dd($orderBy) }} --}}
                            <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()" class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                        </div>
                    </th>
                    <th style="background: #dddddd">Status</th>
                    <th style="background: #dddddd">Deposit SlipNo</th>
                    <th style="background: #dddddd; text-align: right !important">Amount</th>
                    <th style="background: #dddddd">Bank</th>
                    <th style="background: #dddddd">Account No</th>
                    <th style="background: #dddddd">Bank Branch</th>
                    <th style="background: #dddddd">Location</th>
                    <th style="background: #dddddd">City</th>
                    <th style="background: #dddddd">State</th>
                    <th style="background: #dddddd">Sales Date</th>
                    {{-- <th style="background: #dddddd">Sales Date To</th> --}}
                    <th style="background: #dddddd">Bank Deposit</th>
                    <th style="background: #dddddd">Cash Deposit By</th>
                    {{--  <th style="background: #dddddd">Other Remarks</th> --}}
                    <th style="background: #dddddd">Sales Tender</th>
                    <th style="background: #dddddd">Reason for <br>Direct Deposit</th>
                    <th style="background: #dddddd" class="text-center">Deposit Slip Proof</th>
                    <th style="background: #dddddd" class="text-center">View</th>
                </tr>
            </x-scrollable.scroll-head>
            <x-scrollable.scroll-body>
                @foreach ($dataset as $data)
                <tr>
                    <td>{{ Carbon\Carbon::parse($data->directDepositDate)->format('d-m-Y') }}</td>
                    <td style="font-weight: 700; @if($data->status == 'Rejected') color: red; @elseif($data->status == 'Approved') color: green; @else text-dark @endif">
                        {{ $data->status }}</td>
                    <td>{{ $data->depositSlipNo }}</td>
                    <td style="text-align: right !important">{{ $data->amount }}</td>
                    <td>{{ $data->bank }}</td>
                    <td>{{ $data->accountNo }}</td>
                    <td>{{ $data->bankBranch }}</td>
                    <td>{{ $data->location }}</td>
                    <td>{{ $data->city }}</td>
                    <td>{{ $data->state }}</td>
                    <td>{{ $data->salesDateFrom }}</td>
                    {{-- <td>{{ $data->salesDateTo }}</td> --}}
                    <td>{{ $data->bankDeposit }}</td>
                    <td>{{ $data->cashDepositBy }}</td>
                    <td data-bs-toggle="tooltip" title="{{$data->otherRemarks }}">
                        <div style="width: 150px !important; text-overflow: ellipsis; overflow: hidden; word-break: break-all">
                            {{ $data->salesTender }}
                        </div>
                    </td>
                    <td>{{ $data->reason }}</td>
                    <td class="text-center"><a href="{{ url('/') }}/storage/app/public/direct-deposit/{{ $data->depositSlipProof }}" download style="text-decoration: none"><i class="fa-solid fa-download"></i></a></td>
                    <td class="text-center"><a href="#" title="View" data-bs-toggle="modal" data-bs-target="#Main_{{ $data->directDepositUID }}"><i class="fa-solid fa-eye"></i></a>
                    </td>
                </tr>

                <x-app.store-user.direct-deposit.view-modal :data="$data" />

                @endforeach
            </x-scrollable.scroll-body>
        </x-scrollable.scrollable>

    </div>
</div>
