<tr>
    <td>{{ Carbon\Carbon::parse($data->businessDropDate)->format('d-m-Y') }}</td>
    <td>{{ $data->storeID }}</td>
    <td>{{ $data->retekCode }}</td>
    <td>{{ $data->brand }}</td>
    <td>{{ number_format($data->bankDropAmount, 2) }}</td>
    <td>{{ number_format($data->depositAmount, 2) }}</td>
    <td>{{ number_format($data->differenceAmount, 2) }}</td>

    <td style="font-weight: 700; color: @if($data->status === 'Matched') teal @else red @endif">
        {{ $data->status }}
    </td>
    <td>{{ $data->reconStatus }}</td>

    <td> <a href="#" style="font-size: 1.1em" data-bs-target="#exampleModalCenterSecondTab_{{ $data->mposCashBankMISSalesRecoUID }}" data-bs-toggle="modal">View</a></td>
</tr>
