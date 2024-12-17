<tr>
    <td>{{ Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}</td>
    <td>{{ $data->retekCode }}</td>
    <td>{{ $data->storeID }}</td>
    <td>{{ $data->retekCode }}</td>
    <td>{{ $data->brand }}</td>
    <td>{{ $data->tid }}</td>
    <td>{{ number_format($data->creditAmount, 2) }}</td>
    <td>{{ $data->colBank }}</td>
    <td>{{ Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
    <td>{{ number_format($data->depositAmount) }}</td>
    <td>{{ number_format($data->diffSaleDeposit, 2) }}</td>

    <td style="font-weight: 700; color: @if($data->status === 'Matched') teal @else red @endif">
        {{ $data->status }}
    </td>
    <td>{{ $data->reconStatus == 'disapprove' ? 'Rejected' :  $data->reconStatus }}</td>

    <td> <a href="#" style="font-size: 1.1em" data-bs-target="#exampleModalCenterSecondTab_{{ $data->cardMisBankStRecoUID }}" data-bs-toggle="modal">View</a></td>
</tr>
