@foreach ($cashRecons as $data)
<tr>
    <td class="left"> {{ Carbon\Carbon::parse($data->creditDt)->format('d-m-Y') }} </td>
    <td class="left"> {{ Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }} </td>
    <td class="left"> {{ $data->storeID }} </td>
    <td class="left"> {{ $data->retekCode }} </td>
    <td class="left"> {{ $data->colBank }} </td>
    <td class="left"> @if( $data->status == "Not Matched") <span class="redtext">{{ $data->status }}</span> @else <span class="greentext">{{ $data->status }}</span> @endif </td>
    <td class="right"> {{ $data->bankRrefORutrNo }} </td>
    <td class="right"> {{ $data->netAmount }} </td>
    <td class="right"> {{ $data->creditAmount }} </td>
    <td class="right"> {{ $data->adjAmount }} </td>
    <td class="right"> {{ $data->diffSaleDeposit }} </td>
    <td class="left" data-bs-toggle="tooltip" title="{{ $data->storeGroupingRemarks }}"> <p style="width: 300px; text-overflow: ellipsis; overflow: hidden;">{{ $data->storeGroupingRemarks }} </p></td>
</tr>
@endforeach
