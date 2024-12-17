@foreach ($cashRecons as $data)
<tr>
    <td class="right"> {{ $data->storeID }} </td>
    <td class="left"> {{ $data->retekCode }} </td>
    <td class="right"> {{ $data->colBank }} </td>
    <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>
    <td class="right"> {{ $data->depositDt }} </td>
    <td class="right"> {{ $data->crDt }} </td>
    <td class="right"> {{ $data->bankDepositDt }} </td>
    <td class="right"> {{ $data->msfComm }} </td>
    <td class="right"> {{ $data->gstTotal }} </td>
    <td class="right"> {{ $data->netAmount }} </td>
    <td class="right"> {{ $data->creditAmount }} </td>
    <td class="right"> {{ $data->diffSaleDeposit }} </td>
</tr>
@endforeach
