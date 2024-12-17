<tr>

    <td>{{ !$data->mposDate ? '' : Carbon\Carbon::parse($data->mposDate)->format('d-m-Y') }}</td>
    <td>{{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}</td>
    <td>{{ $data->storeID }}</td>
    <td>{{ $data->retekCode }}</td>
    <td>{{ $data->brand }}</td>
    <td>{{ $data->colBank }}</td>
    <td style="font-weight: 700; color: @if($data->status == 'Matched') teal @else red @endif">{{ $data->status }}</td>
    <td>{{ $data->bankDropID }}</td>
    <td style="text-align: right !important">{{ $data->bankDropAmount }}</td>
    <td style="text-align: right !important">{{ $data->tenderAmountF }}</td>
    <td style="text-align: right !important">{{ $data->depositAmountF }}</td>
    <td style="text-align: right !important">{{ $data->bank_cash_differenceF }}</td>
    <td style="text-align: right !important">{{ $data->calculatedDifference }}</td>
    <td style="text-align: right !important">{{ $data->summed_adjustment }}</td>
    <td>
        {{ $data->reconStatus == 'disapprove' ? 'Rejected' : $data->reconStatus }}
    </td>
    <td><a href="#" style="font-size: 1.1em" data-bs-target="#exampleModalCenterThirdTab_{{ $data->CashTenderBkDrpUID }}" data-bs-toggle="modal">View</a></td>
</tr>
