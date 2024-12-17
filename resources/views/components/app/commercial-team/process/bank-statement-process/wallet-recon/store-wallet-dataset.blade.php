<tr>
    <td>{{ Carbon\Carbon::parse($data->exDepDate)->format('d-m-Y') }}</td>
    <td>{{ $data->retekCode }}</td>
    <td>{{ $data->brand }}</td>
    <td>{{ number_format($data->amount, 2) }}</td>
    <td>{{ number_format($data->depositAmount, 2) }}</td>
    <td>{{ number_format($data->diffSaleDeposit, 2) }}</td>
    <td>{{ $data->status }}</td>
    <td>
        <a href="#" style="font-size: 1.1em" data-bs-toggle="modal" data-bs-target="#exampleModalCenter_{{ $data->walletSalesRecoUID }}">View</a>
    </td>
</tr>
