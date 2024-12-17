@foreach ($cashRecons as $data)
<tr>
    <td class="left"> {{ Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }} </td>
    <td class="left"> {{ Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }} </td>
    <td class="right"> {{ $data->storeID }} </td>
    <td class="right"> {{ $data->retekCode }} </td>
    <td class="left"> {{ $data->{'Brand Desc'} }} </td>
    <td class="right"> {{ $data->colBank }} </td>
    <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>

    <td class="right" style="text-align: right !important"> {{ number_format($data->creditAmount, 2) }} </td>
    <td class="right" style="text-align: right !important"> {{ number_format($data->depositAmount, 2) }} </td>
    <td class="right" style="text-align: right !important"> {{ number_format($data->diffSaleDeposit, 2) }} </td>
    {{-- <td class="left"> {{ Carbon\Carbon::parse($data->approvedDt)->format('d-m-Y') }} </td> --}}
    {{-- <td class="left"> {{ $data->approvedBy }} </td> --}}
    <td class="left"> {{ $data->reconStatus }} </td>
    <td class="left" style="text-align: right !important"> {{ $data->adjAmount }} </td>
    <td class="left" style="text-align: right !important"> {{ $data->reconDifference }} </td>
    <td class="left"> {{ Carbon\Carbon::parse($data->processDt)->format('d-m-Y') }} </td>
    <td class="left"> {{ $data->approvalRemarks }} </td>
    {{-- <td class="right" 1style="font-weight: 700; color: green;"> {{ intval($data->sourceBankDifference) }} </td> --}}
    <td class="right"><a data-bs-toggle="modal" data-bs-target="#exampleModalCenter_{{ $data->cardMisBankStRecoUID }}" href="#">View</a></td>
</tr>

<div class="modal fade" id="exampleModalCenter_{{ $data->cardMisBankStRecoUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered " role="document" style="max-width:90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Card/UPI to Bank Statement Reconciliation History</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="modal-body">

                <form class="forms-sample">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Store ID : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->storeID }} </h5>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Retek Code : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->retekCode }}</h5>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Brand : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->{'Brand Desc'} }}</h5>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Location : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->Location }}</h5>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: -20px; margin-bottom: -20px;">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Pickup Bank : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->colBank }}</h5>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Reconciliation Date : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ Carbon\Carbon::parse($data->processDt)->format('d-m-Y') }}</h5>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>

                <h5>Reconciliation Window </h5>
                <section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">

                    <div class="row cash-pickup">
                        <div class="col-lg-3">
                            <h5>Sales Date</h5>
                        </div>
                        <div class="col-lg-2">
                            <h5>Sales Amount</h5>
                        </div>
                        <div class="col-lg-2">
                            <h5>Collection Amount</h5>
                        </div>
                        <div class="col-lg-2">
                            <h5>Difference [Sale-Collection]</h5>
                        </div>

                        <div class="col-lg-3">
                            <h5>Approval Remarks</h5>
                        </div>

                    </div>

                    <div class="row cash-pickup-item">
                        <div class="col-lg-3">
                            {{ Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}
                        </div>
                        <div class="col-lg-2">
                            {{ number_format($data->creditAmount, 2) }}
                        </div>
                        <div class="col-lg-2">
                            {{ number_format($data->depositAmount, 2) }}
                        </div>
                        <div id="difference" class="col-lg-2">
                            {{ number_format($data->diffSaleDeposit, 2) }}
                        </div>
                        <div id="difference" class="col-lg-3">
                            {{ $data->approvalRemarks }}
                        </div>
                    </div>
                </section>
                <br>


                <h5>History</h5>

                <div class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">


                    <div class="table-header">
                        <div class="table-cell">
                            <h5>Item</h5>
                        </div>
                        <div class="table-cell">
                            <h5>Credit Date</h5>
                        </div>
                        <div class="table-cell">
                            <h5>Credit Amount</h5>
                        </div>
                        <div class="table-cell">
                            <h5>Slip No.</h5>
                        </div>
                        <div class="table-cell">
                            <h5>Bank Name</h5>
                        </div>
                        <div class="table-cell">
                            <h5>Store Remarks</h5>
                        </div>
                        <div class="table-cell">
                            <h5>Approval Status</h5>
                        </div>
                        <div class="table-cell">
                            <h5>Supporting Document</h5>
                        </div>
                    </div>

                    {{-- <div class="row cash-pickup">
                        <div class="col-lg-2">
                            <h5>Item</h5>
                        </div>
                        <div class="col-lg-2">
                            <h5>Credit Date</h5>
                        </div>

                        <div class="col-lg-2">
                            <h5>Credit Amount</h5>
                        </div>

                        <div class="col-lg-2">
                            <h5>Slip No.</h5>
                        </div>
                        <div class="col-lg-2">
                            <h5>Bank Name</h5>
                        </div>
                        <div class="col-lg-2">
                            <h5>Store Remarks</h5>
                        </div>
                        <div class="col-lg-3">

                            <h5>Approval Status</h5>
                        </div>

                        <div class="col-lg-2 ">
                            <h5>Supporting Documnet</h5>
                        </div>
                    </div> --}}

                    @php

                    $historyRecords = DB::table('MLF_Outward_CardMISBankStReco_ApprovalProcess')
                    ->where('cardMisBkStRecoUID',$data->cardMisBankStRecoUID)
                    ->get();

                    @endphp

                    @foreach ($historyRecords as $item)

                    <div class="table-row mainUploadItems cash-pickup-item">
                        <div class="table-cell">
                            {{$item->item}}
                        </div>
                        <div class="table-cell">
                            {{ Carbon\Carbon::parse($item->creditDate)->format('d-m-Y')}}
                        </div>
                        <div class="table-cell">
                            {{ number_format($item->amount, 2) }}
                        </div>
                        <div class="table-cell">
                            {{ $item->slipnoORReferenceNo}}
                        </div>
                        <div class="table-cell">
                            {{ $item->bankName}}
                        </div>
                        <div class="table-cell">
                            {{ $item->remarks}}
                        </div>
                        <div class="table-cell">
                            {{ $data->reconStatus == 'disapprove' ? 'Rejected' :  $data->reconStatus }}
                        </div>
                        <div class="table-cell">
                            <x-viewer.widget document="{{ url('/') }}/storage/app/public/reconciliation/upi-reconciliation/upi-bank/{{ $item->supportDocupload }}" />
                        </div>
                    </div>


                    {{-- <div class="row mainUploadItems cash-pickup-item">
                        {{-- style="border-bottom: 1px solid #000"  --}}
                    <div class="col-lg-2 ">
                        {{$item->item}}
                    </div>

                    <div class="col-lg-2">
                        {{ Carbon\Carbon::parse($item->creditDate)->format('d-m-Y')}}
                    </div>

                    <div class="col-lg-2">
                        {{ number_format($item->amount, 2) }}
                    </div>


                    <div class="col-lg-2">
                        {{ $item->slipnoORReferenceNo}}
                    </div>

                    <div class="col-lg-2">
                        {{ $item->bankName}}
                    </div>
                    <div class="col-lg-2">
                        {{ $item->remarks}}
                    </div>
                    <div class="col-lg-3">
                        {{ $data->reconStatus == 'disapprove' ? 'Rejected' :  $data->reconStatus }}
                    </div>
                    <div class="col-lg-2">
                        <x-viewer.widget document="{{ url('/') }}/storage/app/public/reconciliation/upi-reconciliation/upi-bank/{{ $item->supportDocupload }}" />
                    </div>
                </div> --}}

                @endforeach
            </div>
            <br>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn grey" data-bs-dismiss="modal">Close</button>
        </div>

    </div>
</div>
</div>


@endforeach
