@foreach ($cashRecons as $data)
<tr>
    <td class="right"> {{ $data->transactionDate }} </td>
    <td class="left"> {{ $data->storeID }} </td>
    <td class="right"> {{ $data->retekCode }} </td>
    <td class="right"> {{ $data->brand }} </td>
    <td class="right"> {{ $data->collectionBank }} </td>
    <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>
    <td class="right"> {{ $data->depositDt }} </td>
    <td class="left"> {{ $data->cardSale }} </td>
    <td class="right"> {{ $data->depositAmount }} </td>
    <td class="right"> {{ $data->diffSaleDeposit }} </td>
</tr>
@endforeach
