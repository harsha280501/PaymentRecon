<div class="modal fade" id="exampleModalCenterSecondTab_{{ $data->cashMisBkStRecoUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document" style="max-width:90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cash to Bank Statement Reconciliation</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="modal-body" x-data="{isOpen: false}" style="position: unset">
                <form class="forms-sample">
                    <div class="row" style="margin-bottom: -20px">
                        <h5>Reconciliation dashboard</h5>
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
                    </div>
                    <div class="row" style="margin-bottom: -20px">
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
                                    <h5>{{ Carbon\Carbon::parse($data->processDt)->format('d-m-Y')
                                        }}</h5>
                                </label>
                            </div>
                        </div>

                    </div>
                </form>
                <h5>Reconciliation Window </h5>
                <section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">
                    @if($data->reconStatus == 'disapprove')
                    <div class="row cash-pickup">
                        <div class="col-lg-3">
                            <h5>Sales Date</h5>
                        </div>

                        <div class="col-lg-2">
                            <h5>Credit Amount</h5>
                        </div>
                        <div class="col-lg-2">
                            <h5>Collection Amount</h5>
                        </div>
                        <div class="col-lg-2">
                            <h5>Difference [Sale-Collection]</h5>
                        </div>
                        <div class="col-lg-3">
                            <h5>Reason for Disapproval</h5>
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
                        <div class="col-lg-2">
                            {{ number_format($data->diffSaleDeposit, 2) }}
                        </div>
                        <div class="col-lg-3">
                            {{ $data->approvalRemarks }}
                        </div>
                    </div>
                    @else
                    <div class="row cash-pickup">
                        <div class="col-lg-3">
                            <h5>Sales Date</h5>
                        </div>

                        <div class="col-lg-3">
                            <h5>Credit Amount</h5>
                        </div>
                        <div class="col-lg-3">
                            <h5>Collection Amount</h5>
                        </div>
                        <div class="col-lg-3">
                            <h5>Difference [Sale-Collection]</h5>
                        </div>

                    </div>

                    <div class="row cash-pickup-item">
                        <div class="col-lg-3">
                            {{ Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}
                        </div>

                        <div class="col-lg-3">
                            {{ number_format($data->creditAmount, 2) }}
                        </div>
                        <div class="col-lg-3">
                            {{ number_format($data->depositAmount, 2) }}
                        </div>
                        <div class="col-lg-3">
                            {{ number_format($data->diffSaleDeposit, 2) }}
                        </div>
                    </div>
                    @endif

                </section>
                <br>

                <h5>Manual Entry By Store for reconciliation</h5>
                <section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">

                    <div class="row cash-pickup">
                        <div class="col-lg-3">
                            <h5>Item</h5>
                        </div>
                        <div class="col-lg-1 text-center">
                            <h5>Bank Name</h5>
                        </div>
                        <div class="col-lg-1 text-center">
                            <h5>Credit Date</h5>
                        </div>

                        <div class="col-lg-2 text-center">
                            <h5>Ref. No.
                            </h5>
                        </div>

                        <div class="col-lg-1 text-center">
                            <h5>Amount</h5>
                        </div>

                        <div class="col-lg-1 text-center">
                            <h5>Difference</h5>
                        </div>
                        <div class="col-lg-1 text-center">
                            <h5>Supporting Documents</h5>
                        </div>

                        <div class="col-lg-2">
                            <h5>Remarks</h5>
                        </div>


                    </div>

                    @php
                    $mainReconData = DB::table('MLF_Outward_CashMISBankStReco_ApprovalProcess')
                    ->where('cashMisBkStRecoUID' ,$data->cashMisBkStRecoUID)
                    ->get();
                    @endphp

                    @foreach ($mainReconData as $main)
                    <div class="row mainUploadItems cash-pickup-item">
                        <div class="col-lg-3">
                            {{ $main->item }}
                        </div>
                        <div class="col-lg-1 text-center">
                            {{ $main->bankName }}
                        </div>
                        <div class="col-lg-1 text-center">
                            {{ Carbon\Carbon::parse($main->creditDate)->format('d-m-Y') }}
                        </div>

                        <div class="col-lg-2 text-center">
                            {{ $main->slipnoORReferenceNo }}
                        </div>
                        <div class="col-lg-1 text-center">
                            {{ number_format($main->amount, 2) }}
                        </div>
                        <div class="col-lg-1 text-center">
                            {{ number_format($main->differenceAmount, 2) }}
                        </div>

                        <div class="col-lg-1 pt-2 d-flex gap-3 justify-content-center align-items-start">
                            <x-viewer.widget document="{{ url('/') }}/storage/app/public/reconciliation/cash-reconciliation/cash-bank/{{ $main->supportDocupload }}" />
                        </div>

                        <div class="col-lg-2">
                            {{ $main->remarks }}
                        </div>


                    </div>
                    @endforeach

                    <div class="d-flex justify-content-end mt-4 mb-3 gap-3">
                        <div class="form-group">
                            <label for="">Sale Amount</label>
                            <input disabled type="text" placeholder="Rs. 0.00" id="recon-amount" value="{{ number_format($data->creditAmount, 2) }}" class="form-control">
                        </div>

                        @php
                        $depositAmount = DB::table('MLF_Outward_CashMISBankStReco_ApprovalProcess')
                        ->where('cashMisBkStRecoUID' ,$data->cashMisBkStRecoUID)
                        ->sum('differenceAmount');

                        @endphp


                        <div class="form-group">
                            <label for="">Deposit Amount</label>
                            <input disabled type="text" placeholder="Rs. 0.00" id="recon-deposit-amount" value="{{ number_format($data->depositAmount, 2) }}" class="form-control">
                        </div>


                        <div class="form-group">
                            <label for="">Store Respons Entry</label>
                            <input disabled type="text" placeholder="Rs. 0.00" id="recon-deposit-amount" value="{{ number_format($data->adjAmount, 2) }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Approval Status</label>
                            <select id="approvalStatus" class="form-control" style="width: 300px">
                                <option selected value="">Select Approval Status</option>
                                <option value="approve">Approve</option>
                                <option value="disapprove">Reject</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Remarks</label>
                            <textarea id="remarks" style="width: 400px; height: 15vh;" type="text" placeholder="Enter the comments" class="form-control"></textarea>
                        </div>
                    </div>
                </section>

            </div>
            <div class="modal-footer">

                <div class="footer-loading-btn" style="display: none; text-align:left; margin: 0 1em; flex: 1; color: #000">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span>Loading ...</span>
                </div>

                <button x-data @click="(e) => cashApproval(e, 'exampleModalCenterSecondTab_{{ $data->cashMisBkStRecoUID }}')" style="" data-id="{{ $data->cashMisBkStRecoUID }}" type="button" id="modalSubmitButton" class="btn btn-success green">Save</button>
                <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>
