<tr>
    <td>{{ Carbon\Carbon::parse($data->tenderDate)->format('d-m-Y') }}</td>
    <td>{{ $data->storeID }}</td>
    <td>{{ $data->retekCode }}</td>
    <td>{{ $data->brand }}</td>
    <td>{{ number_format($data->tenderValue, 2) }}</td>
    <td>{{ number_format($data->cash, 2) }}</td>
    <td>{{ number_format($data->difference, 2) }}</td>

    <td style="font-weight: 700; color: @if($data->status === 'Matched') teal @else red @endif">
        {{ $data->status }}
    </td>
    <td>{{ $data->reconStatus }}</td>

    {{-- <td> <a href="#" style="font-size: 1.1em" data-bs-target="#exampleModalCenterSecondTab_{{ $data->mposSapSalesRecoUID }}" data-bs-toggle="modal">View</a></td> --}}
</tr>
