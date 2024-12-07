@foreach ($cashRecons as $data)
<tr>
    <td class="left"> {{ $data->storeID }} </td>
    <td class="right"> {{ $data->retekCode }} </td>
    <td class="right"> {{ $data->colBank }} </td>
    <td class="left" style="width: 350px;">

        <div style="white-space: normal;">

            {{ $data->locationName }}
        </div>
    </td>

    <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>
    <td class="right"> {{ Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }} </td>
    <td class="right"> {{ Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }} </td>
    <td class="right"> {{ $data->depostSlipNo }} </td>
    <td class="right"> {{ number_format($data->depositAmount, 2) }} </td>
    <td class="right"> {{ number_format($data->creditAmount, 2) }} </td>
    <td class="right"> {{ number_format($data->diffSaleDeposit, 2) }} </td>
</tr>
@endforeach
