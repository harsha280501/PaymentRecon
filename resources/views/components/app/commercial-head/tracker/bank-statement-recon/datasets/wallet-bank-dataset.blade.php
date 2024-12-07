@foreach ($cashRecons as $data)
<tr>
    <td class="left"> {{ Carbon\Carbon::parse($data->creditDt)->format('d-m-Y') }} </td>
    <td class="left"> {{ Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }} </td>
    <td class="left"> {{ $data->storeID }} </td>
    <td class="left"> {{ $data->retekCode }} </td>
    <td class="left"> {{ $data->colBank }} </td>
    <td class="left"> @if( $data->status == "Not Matched") <span class="redtext">{{ $data->status }}</span> @else <span class="greentext">{{ $data->status }}</span> @endif </td>
    <td class="right"> {{ $data->msfComm }} </td>
    <td class="right" > {{ number_format($data->creditAmount, 2) }} </td>
    <td class="right" > {{ number_format($data->depositAmount, 2) }} </td>
    <td class="right" > {{ number_format($data->diffSaleDeposit, 2) }} </td>
</tr>
@endforeach
