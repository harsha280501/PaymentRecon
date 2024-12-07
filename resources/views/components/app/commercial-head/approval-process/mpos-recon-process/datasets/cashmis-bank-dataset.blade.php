@foreach ($cashRecons as $data)
<tr>
    <td class="right">{{ Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}</td>
    <td class="right">{{ $data->storeID }}</td>
    <td class="right">{{ $data->retekCode }}</td>
    <td class="right">{{ $data->brand }}</td>
    <td class="right"> @if( $data->status == "Not Matched") <span style="font-weight: 700; color: red;">{{ $data->status }}</span> @else <span style="font-weight: 700; color: green;">{{ $data->status }}</span> @endif </td>
    <td class="right">{{ $data->reconStatus }}</td>
    <td class="right">{{ $data->depositSlipNo }}</td>
    <td class="right">{{ $data->bankDropAmount }}</td>
    <td class="right">{{ $data->depositAmount }}</td>
    <td class="right">{{ $data->DiffAmount }}</td>
    <td class="right">{{ !$data->tenderAdj  ? '0.00' : $data->tenderAdj }}</td>
    <td class="right">{{ !$data->bankAdj ? '0.00' : $data->bankAdj }}</td>
    <td class="right"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalCenter_{{ $data->mposCashBankMISSalesRecoUID }}">View</a></td>

    <div class="modal fade" id="exampleModalCenter_{{ $data->mposCashBankMISSalesRecoUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document" style="max-width:90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> BANK DROP TO CASH MIS RECONCILIATION History</h5>
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
                                        <h5>{{ $data->brand }}</h5>
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

                            <div class="col-lg-3" style="margin-top: -20px">
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
                                <h5>Deposit Date</h5>
                            </div>
                            <div class="col-lg-2">
                                <h5>Bank Drop Amount</h5>
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
                                {{ Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}
                            </div>
                            <div class="col-lg-2">
                                {{ $data->bankDropAmount }}
                            </div>
                            <div class="col-lg-2">
                                {{ $data->depositAmount }}
                            </div>
                            <div id="difference" class="col-lg-2">
                                {{ $data->saleReconDifferenceAmount }}
                            </div>
                            <div id="difference" class="col-lg-3">
                                {{ $data->approvalRemarks }}
                            </div>
                        </div>
                    </section>
                    <br>


                    <h5>History</h5>

                    <section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">

                        <div class="row cash-pickup">
                            <div class="col-lg-2">
                                <h5>Item</h5>
                            </div>

                            <div class="col-lg-2">
                                <h5>Bank Name</h5>
                            </div>


                            <div class="col-lg-2">
                                <h5>Credit Date</h5>
                            </div>

                            <div class="col-lg-2">
                                <h5>Reference No.</h5>
                            </div>

                            <div class="col-lg-2">
                                <h5>Amount</h5>
                            </div>


                            <div class="col-lg-2">
                                <h5>Support Document</h5>
                            </div>

                            <div class="col-lg-2">
                                <h5>Store Remarks</h5>
                            </div>

                            <div class="col-lg-3">
                                <h5>Approval Status</h5>
                            </div>
                        </div>

                        @php

                        $historyRecords = DB::table('MFL_Outward_MPOSCashBankMISSalesReco_ApprovalProcess')
                        ->where('mposCashBankMISSalesRecoUID',$data->mposCashBankMISSalesRecoUID)
                        ->get();

                        @endphp

                        @foreach ($historyRecords as $item)

                        <div class="row mainUploadItems cash-pickup-item">
                            {{-- style="border-bottom: 1px solid #000"  --}}

                            <div class="col-lg-2">
                                {{$item->item}}
                            </div>
                            <div class="col-lg-2  ">
                                {{$item->bankName}}
                            </div>
                            <div class="col-lg-2  ">
                                {{$item->creditDate}}
                            </div>
                            <div class="col-lg-2  ">
                                {{$item->slipnoORReferenceNo}}
                            </div>

                            <div class="col-lg-2 ">
                                {{ $item->amount}}
                            </div>

                            <div class="col-lg-2 ">
                                @if ($item->supportDocupload)
                                <a href="{{ url('/') }}/storage/app/public/reconciliation/mpos-reconciliation/store-mpos-bankmis/{{ $item->supportDocupload }}" download><i class="fa fa-download"></i> Download</a>
                                @else
                                <p>NO FILE</p>
                                @endif
                            </div>

                            <div class="col-lg-2 ">
                                {{ $item->remarks}}
                            </div>

                            <div class="col-lg-3 ">
                                {{ $item->approveStatus}}
                            </div>
                        </div>
                        @endforeach
                    </section>
                    <br>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</tr>

@endforeach
