<div class="modal fade" id="main{{ $id }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:1300px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bank MSI</h5>
                <div class="right">
                    {{-- <button type="button" class="btn btn-success green">Save</button>  --}}
                    <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>

            <div class="modal-body">
                <div class="row p-4  main-admin">

                    {{-- <div class="col-6 col-lg-4" style="border-right: 1px solid #80808047;">  --}}

                    <div>
                        <h5>Bank Name</h5>
                        <p>{{$data->bankName ? $data->bankName : 'No data'}}</p>
                    </div>

                    <div>

                        <h5>Pickup PT Code</h5>
                        <p>{{$data->pickupPTCode ? $data->pickupPTCode : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Transaction Type</h5>
                        <p>{{$data->transactionType ? $data->transactionType : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>TRCR</h5>
                        <p>{{$data->TRCR ? $data->TRCR : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Customer Code</h5>
                        <p>{{$data->customerCode ? $data->customerCode : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>PRD Code</h5>
                        <p>{{$data->PRDCode ? $data->PRDCode : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Location Name</h5>
                        <p>{{$data->locationName ? $data->locationName : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Deposit Date</h5>
                        <p>{{$data->depositDate ? $data->depositDate : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Adjustment Date</h5>
                        <p>{{$data->adjustmentDate ? $data->adjustmentDate : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Credit Date</h5>
                        <p>{{$data->creditDate ? $data->creditDate : 'No data'}}</p>
                    </div>
                    {{-- </div>  --}}

                    {{-- <div class="col-6 col-lg-4" style="border-right: 1px solid #80808047;">  --}}
                    <div>
                        <h5>Deposit Slip No</h5>
                        <p>{{$data->depositSlipNo ? $data->depositSlipNo : 'No data'}}</p>
                    </div>
                    <div>
                        <h5>Deposit Amount</h5>
                        <p>{{$data->depositAmount ? $data->depositAmount : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Store Respons Entry</h5>
                        <p>{{$data->adjustmentAmount ? $data->adjustmentAmount : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Return Reason</h5>
                        <p>{{$data->returnReason ? $data->returnReason : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>HIR Code</h5>
                        <p>{{$data->HIRCode ? $data->HIRCode : 'No data'}}</p>
                    </div>


                    <div>
                        <h5>HIR Name</h5>
                        <p>{{$data->HIRName ? $data->HIRName : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Deposit Branch</h5>
                        <p>{{$data->depositBranch ? $data->depositBranch : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Deposit Branch Name</h5>
                        <p>{{$data->depositBranchName ? $data->depositBranchName : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Location Short</h5>
                        <p>{{$data->locationShort ? $data->locationShort : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>CLG Type</h5>
                        <p>{{$data->CLGType ? $data->CLGType : 'No data'}}</p>
                    </div>
                    {{-- </div>  --}}
                    {{-- <div class="col-6 col-lg-4" style="border-right: 1px solid #80808047;">  --}}
                    <div>
                        <h5>CLG Date</h5>
                        <p>{{$data->CLGDate ? $data->CLGDate : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Record Date</h5>
                        <p>{{$data->recordDate ? $data->recordDate : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Return Date</h5>
                        <p>{{$data->returnDate ? $data->returnDate : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Revised Date</h5>
                        <p>{{$data->revisedDate ? $data->revisedDate : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Realisation Date</h5>
                        <p>{{$data->realisationDate ? $data->realisationDate : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Pickup Date</h5>
                        <p>{{$data->pickupDate ? $data->pickupDate : 'No data'}}</p>
                    </div>


                    <div>
                        <h5>Division Code</h5>
                        <p>{{$data->divisionCode ? $data->divisionCode : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Division Name</h5>
                        <p>{{$data->divisionName ? $data->divisionName : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Adjustment</h5>

                        <p>{{$data->adjustment ? $data->adjustment : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>No Of Installment</h5>

                        <p>{{$data->noOfInstallment ? $data->noOfInstallment : 'No data'}}</p>
                    </div>

                    {{-- </div>  --}}

                    {{-- <div class="col-6 col-lg-4" style="border-right: 1px solid #80808047;">  --}}


                    <div>
                        <h5>Recovered Amount</h5>
                        <p>{{$data->recoveredAmount ? $data->recoveredAmount : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Sub Customer Code</h5>

                        <p>{{$data->subCustomerCode ? $data->subCustomerCode : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Sub Customer Name</h5>

                        <p>{{$data->subCustomerName ? $data->subCustomerName : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>DS Addl Info Code 1</h5>

                        <p>{{$data->dsAddlInfoCode1 ? $data->dsAddlInfoCode1 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>DS Addl Info 1</h5>

                        <p>{{$data->dsAddlInfo1 ? $data->dsAddlInfo1 : 'No data'}}</p>
                    </div>

                    <div>

                        <h5>DS Addl Info Code 2</h5>
                        <p>{{$data->dsAddlInfoCode2 ? $data->dsAddlInfoCode2 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>DS Addl Info 2</h5>
                        <p>{{$data->dsAddlInfo2 ? $data->dsAddlInfo2 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>DS Addl Info Code 3</h5>

                        <p>{{$data->dsAddlInfoCode3 ? $data->dsAddlInfoCode3 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>DS Addl Info 3</h5>

                        <p>{{$data->dsAddlInfo3 ? $data->dsAddlInfo3 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>DS Addl Info Code 4</h5>
                        <p>{{$data->dsAddlInfoCode4 ? $data->dsAddlInfoCode4 : 'No data'}}</p>
                    </div>

                    {{-- </div>  --}}

                    {{-- <div class="col-6 col-lg-4" style="border-right: 1px solid #80808047;">  --}}


                    <div>
                        <h5>DS Addl Info 4</h5>

                        <p>{{$data->dsAddlInfo4 ? $data->dsAddlInfo4 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>DS Addl Info Code 5</h5>

                        <p>{{$data->dsAddlInfoCode5 ? $data->dsAddlInfoCode5 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>DS Addl Info 5</h5>

                        <p>{{$data->dsAddlInfo5 ? $data->dsAddlInfo5 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Inst SL</h5>

                        <p>{{$data->instSL ? $data->instSL : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Inst No</h5>

                        <p>{{$data->instNo ? $data->instNo : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Inst Date</h5>

                        <p>{{$data->instDate ? $data->instDate : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Inst Amount</h5>

                        <p>{{$data->instAmount ? $data->instAmount : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Inst Type</h5>

                        <p>{{$data->instType ? $data->instType : 'No data'}}</p>
                    </div>




                    <div>
                        <h5>Inst Amount Breakup</h5>

                        <p>{{$data->instAmountBreakup ? $data->instAmountBreakup : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Adj Amount</h5>

                        <p>{{$data->adjAmount ? $data->adjAmount : 'No data'}}</p>
                    </div>

                    {{-- </div>  --}}



                    {{-- <div class="col-6 col-lg-4" style="border-right: 1px solid #80808047;">  --}}

                    <div>
                        <h5>Recovered Amt</h5>

                        <p>{{$data->recoveredAmt ? $data->recoveredAmt : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Reversal Amt</h5>

                        <p>{{$data->reversalAmt ? $data->reversalAmt : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Drn On</h5>

                        <p>{{$data->drnOn ? $data->drnOn : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Drn On Location</h5>
                        <p>{{$data->drnOnLocation ? $data->drnOnLocation : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Drn Bk</h5>

                        <p>{{$data->drnBk ? $data->drnBk : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Drn Br</h5>

                        <p>{{$data->drnBr ? $data->drnBr : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Sub Cust</h5>
                        <p>{{$data->subCust ? $data->subCust : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Sub Cust Name</h5>

                        <p>{{$data->subCustName ? $data->subCustName : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Dr Cod</h5>
                        <p>{{$data->drCod ? $data->drCod : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Drawer Name</h5>
                        <p>{{$data->drawerName ? $data->drawerName : 'No data'}}</p>
                    </div>

                    {{-- </div>  --}}



                    {{-- <div class="col-6 col-lg-4" style="border-right: 1px solid #80808047;">  --}}


                    <div>
                        <h5>Return Amount</h5>


                        <p>{{$data->returnAmount ? $data->returnAmount : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Ins Addl Info Code 1</h5>


                        <p>{{$data->insAddlInfoCode1 ? $data->insAddlInfoCode1 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Ins Addl Info 1</h5>


                        <p>{{$data->insAddlInfo1 ? $data->insAddlInfo1 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Ins Addl Info Code 2</h5>


                        <p>{{$data->insAddlInfoCode2 ? $data->insAddlInfoCode2 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Ins Addl Info 2</h5>


                        <p>{{$data->insAddlInfo2 ? $data->insAddlInfo2 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Ins Addl Info Code 3</h5>

                        <p>{{$data->insAddlInfoCode3 ? $data->insAddlInfoCode3 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Ins Addl Info 3</h5>

                        <p>{{$data->insAddlInfo3 ? $data->insAddlInfo3 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>insAddlInfoCode4</h5>

                        <p>{{$data->insAddlInfoCode4 ? $data->insAddlInfoCode4 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Ins Addl Info 4</h5>

                        <p>{{$data->insAddlInfo4 ? $data->insAddlInfo4 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Ins Addl Info Code 5</h5>
                        <p>{{$data->insAddlInfoCode5 ? $data->insAddlInfoCode5 : 'No data'}}</p>
                    </div>

                    {{-- </div>  --}}

                    {{-- <div class="col-6 col-lg-4" style="border-right: 1px solid #80808047;">  --}}


                    <div>
                        <h5>insAddlInfo5</h5>

                        <p>{{$data->insAddlInfo5 ? $data->insAddlInfo5 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Remarks 1</h5>

                        <p>{{$data->remarks1 ? $data->remarks1 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Remarks 2</h5>

                        <p>{{$data->remarks2 ? $data->remarks2 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Remarks 3</h5>

                        <p>{{$data->remarks3 ? $data->remarks3 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Pooled Ac No</h5>

                        <p>{{$data->pooledAcNo ? $data->pooledAcNo : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Pooled Dept Amt</h5>

                        <p>{{$data->pooledDeptAmt ? $data->pooledDeptAmt : 'No data'}}</p>
                    </div>


                    <div>
                        <h5>Dept Date</h5>

                        <p>{{$data->deptDate ? $data->deptDate : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Pool Sl</h5>

                        <p>{{$data->poolSl ? $data->poolSl : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Row Type</h5>

                        <p>{{$data->rowType ? $data->rowType : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Entry Id</h5>
                        <p>{{$data->entryId ? $data->entryId : 'No data'}}</p>
                    </div>
                    {{-- </div>  --}}

                    {{-- <div class="col-6 col-lg-4" style="border-right: 1px solid #80808047;">  --}}
                    <div>
                        <h5>Type Of En</h5>
                        <p>{{$data->typeOfEn ? $data->typeOfEn : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>E1</h5>
                        <p>{{$data->e1 ? $data->e1 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>E2</h5>
                        <p>{{$data->e2 ? $data->e2 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>E3</h5>
                        <p>{{$data->e3 ? $data->e3 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Record Updated On</h5>
                        <p>{{$data->recordUpdatedOn ? $data->recordUpdatedOn : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Addl Field 1</h5>
                        <p>{{$data->addl_field_1 ? $data->addl_field_1 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Addl Field 2</h5>
                        <p>{{$data->addl_field_2 ? $data->addl_field_2 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Addl Field 3</h5>
                        <p>{{$data->addl_field_3 ? $data->addl_field_3 : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Is Active</h5>
                        <p>{{$data->isActive ? $data->isActive : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Created By</h5>

                        <p>{{$data->createdBy ? $data->createdBy : 'No data'}}</p>
                    </div>

                    {{-- </div>  --}}

                    {{-- <div class="col-6 col-lg-4" style="border-right: 1px solid #80808047;">  --}}

                    <div>
                        <h5>Created Date</h5>
                        <p>{{$data->createdDate ? $data->createdDate : 'No data'}}</p>
                    </div>

                    <div>
                        <h5>Modified By</h5>

                        <p>{{$data->modifiedBy ? $data->modifiedBy : 'No data'}}</p>
                    </div>

                    <div>

                        <h5>Modified Date</h5>
                        <p>{{$data->modifiedDate ? $data->modifiedDate : 'No data'}}</p>
                    </div>
                    {{-- </div>  --}}
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-success green">Save</button>
        <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
    </div>
</div>
</div>
</div>
