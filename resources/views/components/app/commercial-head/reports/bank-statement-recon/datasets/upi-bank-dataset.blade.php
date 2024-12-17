@foreach ($cashRecons as $data)
<tr>
    <td class="left"> {{ $data->crDt }} </td>
    <td class="left"> {{ $data->depositDt }} </td>
    <td class="left"> {{ $data->storeID }} </td>
    <td class="left"> {{ $data->retekCode }} </td>
    <td class="left"> {{ $data->colBank }} </td>
    <td class="left"> @if( $data->status == "Not Matched") <span class="redtext">{{ $data->status }}</span> @else <span class="greentext">{{ $data->status }}</span> @endif </td>
    <td class="left"> {{ $data->bankDepositDt }} </td>
    <td class="right"> {{ $data->creditAmount }} </td>
    <td class="right"> {{ $data->netAmount }} </td>
    <td class="right"> {{ $data->adjAmount }} </td>
    <td class="right"> {{ $data->diffSaleDeposit }} </td>
</tr>
@endforeach
