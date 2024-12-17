@foreach ($cashRecons as $data)
<tr>
    <td class="left"> {{ $data->expDepositDate }} </td>
    <td class="right"> {{ $data->storeID }} </td>
    <td class="right"> {{ $data->retekCode }} </td>
    <td class="left"> {{ $data->brandCode }} </td>
    <td class="right"> @if( $data->sourceBankRecoStatus == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->sourceBankRecoStatus }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->sourceBankRecoStatus }}</span> @endif </td>
    <td class="right"> {{ $data->sourcePickupBank }} </td>
    <td class="right"> {{ $data->bankCashPickupDate }} </td>
    <td class="right"> {{ number_format($data->depositAmount, 2) }} </td>
    <td class="right"> {{ number_format($data->sourceCashSale, 2) }} </td>
    <td class="right"> {{ number_format($data->sourceBankDifference, 2) }} </td>
</tr>
@endforeach
