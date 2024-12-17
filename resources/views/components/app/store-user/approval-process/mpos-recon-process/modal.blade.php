<div class="modal fade" id="exampleModalCenter_{{ $data->CashTenderBkDrpUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document" style="max-width:90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cash Reconciliation History</h5>
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
                                    <h5>{{ Carbon\Carbon::parse($data->processDt)->format('d-m-Y')
                                                            }}</h5>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-3" style="margin-top: -20px">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Bank Drop ID : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->bankDropID }}</h5>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-3" style="margin-top: -20px">
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Bank Drop Amount : </h5>
                                </label>
                                <label for="exampleInputUsername1">
                                    <h5>{{ $data->bankDropAmount }}</h5>
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
                            <h5>Tender Amount</h5>
                        </div>
                        <div class="col-lg-2">
                            <h5>Deposit Amount</h5>
                        </div>
                        <div class="col-lg-2">
                            <h5 style="text-align: start">Difference <br /> [Tender - Deposit]</h5>
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
                            {{ $data->tenderAmount }}
                        </div>
                        <div class="col-lg-2">
                            {{ $data->depositAmount }}
                        </div>
                        <div id="difference" class="col-lg-2">
                            {{ $data->bankCashDifference }}
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

                        <div class="col-lg-1">
                            <h5>Bank Name</h5>
                        </div>

                        <div class="col-lg-2">
                            <h5>Credit Date</h5>
                        </div>

                        <div class="col-lg-1">
                            <h5>Amount</h5>
                        </div>


                        <div class="col-lg-2 text-center">
                            <h5 class="text-center">Support Document</h5>
                        </div>

                        <div class="col-lg-2">
                            <h5>Store Remarks</h5>
                        </div>

                        <div class="col-lg-2">
                            <h5>Approval Status</h5>
                        </div>
                        <div class="col-lg-2">
                            <h5>Approved Date</h5>
                        </div>
                        <div class="col-lg-2">
                            <h5>Approved By</h5>
                        </div>
                    </div>

                    @php

                    $historyRecords =
                    \App\Models\Process\MPOS\MPOSCashTenderBankDropCashMISRecoApproval::where('CashTenderBkDrpUID',$data->CashTenderBkDrpUID)
                    ->orderBy('mposBkMISSalesUID', 'desc')
                    ->get();

                    @endphp

                    @foreach ($historyRecords as $item)

                    <div class="row mainUploadItems cash-pickup-item">


                        <div class="col-lg-2 text-start">
                            {{$item->item}}
                        </div>
                        <div class="col-lg-1">
                            {{$item->bankName}}
                        </div>
                        <div class="col-lg-2">
                            {{ !$item->creditDate ? '' : Carbon\Carbon::parse($item->creditDate)->format('d-m-Y') }}
                        </div>


                        <div class="col-lg-1">
                            {{ $item->amount }}
                        </div>

                        <div class="col-lg-2 text-center">
                            @if ($item->supportDocupload)
                            <a href="{{ url('/') }}/storage/app/public/reconciliation/mpos-reconciliation/store-mpos-bankmis/{{ $item->supportDocupload }}" download><i class="fa fa-download"></i></a>
                            @else
                            <p>NO FILE</p>
                            @endif
                        </div>

                        <div class="col-lg-2 text-start">
                            {{ $item->remarks }}
                        </div>

                        <div class="col-lg-2">
                            <span class="left"> @if($item->approveStatus == "Rejected") <span style="font-weight: 700; color: red;">{{ $item->approveStatus }}</span> @elseif($item->approveStatus == "Approved") <span style="font-weight: 700; color: green;">{{ ucfirst($item->approveStatus) }} </span> @else <span style="font-weight: 700; color: #000;">{{ ucfirst($item->approveStatus) }} </span> @endif </span>
                        </div>


                        <div class="col-lg-2 text-start">
                            {{ !$item->approvalDate ? '' : Carbon\Carbon::parse($item->approvalDate)->format('d-m-Y') }}
                        </div>

                        <div class="col-lg-2 text-start">
                            {{ \App\Models\User::find($item->approvedBy)?->name }}
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
