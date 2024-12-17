<tr>
    <td>{{ $data->storeID }}</td>
    <td>{{ $data->retekCode }}</td>
    <td>{{ $data->colBank }}</td>
    <td>{{ $data->tid }}</td>
    <td>{{ Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
    <td>{{ Carbon\Carbon::parse($data->creditDt)->format('d-m-Y') }}</td>
    <td>{{ number_format($data->depositAmount, 2) }}</td>
    <td>{{ number_format($data->gstTotal, 2) }}</td>
    <td>{{ number_format($data->netAmount, 2) }}</td>
    <td>{{ number_format($data->creditAmount, 2) }}</td>
    <td>{{ number_format($data->diffSaleDeposit, 2) }}</td>
    <td>{{ $data->bankRrefORutrNo }}</td>
    <td style="font-weight: 700; color: @if($data->status == 'Matched') teal @else red @endif">{{ $data->status }}</td>
    <td>{{ $data->reconStatus }}</td>
    <td><a href="#" data-bs-target="#exampleModalCenter_{{ $data->walletMisBankStRecoUID }}" style="font-size: 1.1em" data-bs-toggle="modal">View</a></td>
</tr>
