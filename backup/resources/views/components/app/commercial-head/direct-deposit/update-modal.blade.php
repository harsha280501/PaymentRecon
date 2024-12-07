<div x-init="() => {
    Livewire.on('success', () => {
        succesMessageConfiguration('Successfully uploaded')
        loading = false
        open = false
        window.location.reload(true)
    })
}">
    <!-- Bootstrap modal -->
    <div wire:ignore.self class="modal fade" id="Model_{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div wire:ignore.self class="modal-dialog modal-dialog-centered" role="document" style="max-width:80%;">
            <div wire:ignore.self class="modal-content">
                <div wire:ignore.self class="modal-header">
                    <h5 class=" modal-title">Direct Deposit Approve</h5>
                    <button type="button" class="close" @click="open = false" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div wire:ignore.self class="modal-body">

                    <div class="forms-sample" style="border-bottom: 2px solid rgba(19, 19, 19, 0.329); margin-bottom: 1em">
                        <div class="row" style="margin-bottom: -20px">
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
                                        <h5>Region : </h5>
                                    </label>
                                    <label for="exampleInputUsername1">
                                        <h5>{{ $data->region }}</h5>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: -20px">

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">
                                        <h5>SAP Code : </h5>
                                    </label>
                                    <label for="exampleInputUsername1">
                                        <h5>{{ intval($data->sapCode) }}</h5>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row g-3 mb-4">
                        <!-- Deposit Slip No -->
                        <h5 class="text-black">Store Remarks</h5>

                        <div class="col-md-4">
                            <label for="depositSlipNo" class="form-label">Deposit Slip No</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->depositSlipNo }}</h5>
                        </div>

                        <!-- Amount -->
                        <div class="col-md-4">
                            <label for="amount" class="form-label">Amount</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->amount }}</h5>
                        </div>

                        <!-- Date -->
                        <div class="col-md-4">
                            <label for="date" class="form-label">Sales Date</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->directDepositDate }}</h5>
                        </div>

                        <!-- Bank -->
                        <div class="col-md-4">
                            <label for="bank" class="form-label">Bank</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->bank }}</h5>
                        </div>

                        <!-- Account No -->
                        <div class="col-md-4">
                            <label for="accountNo" class="form-label">Account No</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->accountNo }}</h5>
                        </div>

                        <!-- Bank Branch -->
                        <div class="col-md-4">
                            <label for="bankBranch" class="form-label">Bank Branch</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->bankBranch }}</h5>
                        </div>

                        <!-- Location -->
                        <div class="col-md-4">
                            <label for="location" class="form-label">Location</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->location }}</h5>
                        </div>

                        <!-- City -->
                        <div class="col-md-4">
                            <label for="city" class="form-label">City</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->city }}</h5>
                        </div>

                        <!-- State -->
                        <div class="col-md-4">
                            <label for="state" class="form-label">State</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->state }}</h5>
                        </div>

                        <!-- Sales Date From -->
                        <div class="col-md-4">
                            <label for="salesDateFrom" class="form-label">Sales Date From</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->salesDateFrom }}</h5>
                        </div>

                        <!-- Sales Date To -->
                        <div class="col-md-4">
                            <label for="salesDateTo" class="form-label">Sales Date To</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->salesDateTo }}</h5>
                        </div>

                        <!-- Cash Deposit By -->
                        <div class="col-md-4">
                            <label for="cashDepositBy" class="form-label">Cash Deposit By</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->cashDepositBy }}</h5>
                        </div>

                        <!-- Other Remarks -->
                        <div class="col-md-4">
                            <label for="cashDepositBy" class="form-label">Other Remarks</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->otherRemarks }}</h5>
                        </div>

                        <!-- Reason -->
                        <div class="col-md-4">
                            <label for="reason" class="form-label">Reason</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class="text-black">{{ $data->reason }}</h5>
                        </div>

                        <div class="col-md-4">
                            <label for="reason" class="form-label">Deposit Slip Proof</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class="text-black"><a href="{{ url('/') }}/storage/app/public/direct-deposit/{{ $data->depositSlipProof }}" download style="text-decoration: none"><i class="fa-solid fa-download"></i> Download</a></h5>
                        </div>
                    </div>


                    <div class="row align-items-start" x-data="{
                        remarks: null,
                        status: null,
                        id: '{{ $data->directDepositUID }}'
                    }">
                        <div class="col-lg-4">
                            <label for="">Status</label>
                            <select x-model="status" class="form-control">
                                <option selected value="">Select Approval Status</option>
                                <option value="Approved">Approve</option>
                                <option value="Rejected">Reject</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-8">
                            <label for="">Remarks</label>
                            <textarea x-model="remarks" id="remarks" style="height: 15vh;" type="text" placeholder="Enter the comments" class="form-control"></textarea>
                        </div>

                        <div class="w-100 d-flex justify-content-end">
                            <button @click="() => {
                                loading = true

                                if(!status || !remarks) {
                                    errorMessageConfiguration('All Fields are required')
                                    return
                                }
                                
                                $wire.update(id, status, remarks)
                                {{-- succesMessageConfiguration('Successfully uploaded')  --}}
                                {{-- window.location.reload(true) --}}
                            }" class="btn btn-success" style="width: fit-content"><i class="fa-solid fa-check"></i> Submit</button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div x-show="loading" style="display: none; text-align:left; margin: 0 1em; flex: 1; color: #000">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span>Loading ...</span>
                    </div>
                    <button type="button" class="btn btn-secondary" @click="open = false" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
