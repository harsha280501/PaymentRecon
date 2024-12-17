<tr>
    <td>{{ Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}</td>
    <td>{{ $data->retekCode }}</td>
    <td>{{ $data->{'Brand Desc'} }}</td>
    <td>{{ $data->colBank }}</td>
    <td>{{ $data->tid }}</td>
    <td>{{ number_format($data->depositAmount, 2) }}</td>
    <td>{{ $data->colBank }}</td>
    <td>{{ Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
    <td>{{ $data->merCode }}</td>
    <td>{{ number_format($data->netAmount, 2) }}</td>
    <td>{{ number_format($data->diffSaleDeposit, 2) }}</td>
    <td>{{ $data->status }}</td>
    <td>{{ $data->reconStatus }}</td>
    <td><a href="#" data-bs-target="#exampleModalCenter_{{ $data->cardMisBankStRecoUID }}" style="font-size: 1.1em" data-bs-toggle="modal">View</a></td>
</tr>
