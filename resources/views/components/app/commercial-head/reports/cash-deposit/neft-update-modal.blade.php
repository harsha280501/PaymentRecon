<div wire:key="{{ $data->UID }}">
    <style>
        .error {
            color: red !important;
        }

    </style>

    <!-- Bootstrap modal -->
    <div wire:ignore class="modal fade" id="main{{ $data->UID }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div wire:ignore class="modal-dialog modal-dialog-centered" role="document" style="max-width:80%;">
            <div wire:ignore class="modal-content">
                <div wire:ignore class="modal-header">
                    <h5 class=" modal-title">RTGS / NEFT Deposit Entry</h5>
                    <button type="button" class="close" @click="open = false" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div wire:ignore class="modal-body" x-data="{
                    errors: null,

                    remarks: '{{ $data->remarks }}',
                    storeID: '{{ $data->storeID }}',
                    saleDate: '{{ $data->salesDate }}',
                    retekCode: '{{ $data->retekCode }}',
                    tender: '',
                    id: '{{ $data->UID }}',

                    validateInputs() {

                        this.errors = { storeID: null, retekCode: null, saleDate: null, remarks: null, tender: null };

                        if (!this.storeID || !/^\d{4}$/.test(this.storeID)) {
                            this.errors.storeID = 'Store ID is required and must be 4 digits.';
                        }
                        if (!this.retekCode || !/^\d{5}$/.test(this.retekCode)) {
                            this.errors.retekCode = 'Retek Code is required and must be 5 digits.';
                        }
                        if (!this.saleDate) {
                            this.errors.saleDate = 'Sales Date is required.';
                        }
                        if (!this.remarks) {
                            this.errors.remarks = 'Remarks are required.';
                        }
                        if (!this.tender) {
                            this.errors.tender = 'Please select a tender.';
                        }

                        if(this.errors.storeID != null || this.errors.retekCode != null || this.errors.saleDate != null  || this.errors.remarks != null || this.errors.tender != null) {
                            return false;
                        }

                        return true;
                    }
                }">

                    <div class="row g-3 mb-4">
                        <!-- Deposit Slip No -->
                        <h5 class="text-black">Store Remarks</h5>

                        <div class="col-md-4">
                            <label for="depositSlipNo" class="form-label">Credit Date</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ Carbon\Carbon::parse($data->creditDate)->format('d-m-Y') }}</h5>
                        </div>

                        <!-- Amount -->
                        <div class="col-md-4">
                            <label for="amount" class="form-label">Deposit Date</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}</h5>
                        </div>

                        <!-- Date -->
                        <div class="col-md-4">
                            <label for="date" class="form-label">Account Number</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->accountNo }}</h5>
                        </div>

                        <!-- Bank -->
                        <div class="col-md-4">
                            <label for="bank" class="form-label">Bank</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->colBank }}</h5>
                        </div>

                        <div class="col-md-4">
                            <label for="bankBranch" class="form-label">Bank Branch</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->transactionBr }}</h5>
                        </div>

                        <!-- State -->
                        <div class="col-md-4">
                            <label for="state" class="form-label">Credit Amount</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->credit }}</h5>
                        </div>

                        <div class="col-md-4">
                            <label for="salesDateFrom" class="form-label">Debit Amount</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->debit }}</h5>
                        </div>

                        @if($data->remarks != null)
                        <div class="col-md-4">
                            <label for="salesDateFrom" class="form-label">Remarks</label>
                            <h5 style="border-bottom: 2px solid rgba(128, 128, 128, 0.397); padding-bottom: 1.2em" class=" text-black">{{ $data->remarks }}</h5>
                        </div>
                        @endif
                    </div>

                    <div class="row align-items-start">
                        <div class="col-lg-4">
                            <label for="">Store ID <span style="color: red;">*</span></label>

                            <div style="position: relative; transform: translate(0,0);">
                                <div wire:ignore class="" x-init="() => {
                                        this.selectFilter = $j($refs.selectFilter).select2({
                                            dropdownParent: $j($refs.selectFilter).parent(),
                                        })
            
                                        this.selectFilter.on('select2:select', (event) => {    
                                            storeID = event.target.value.split(',')[0]
                                            retekCode = event.target.value.split(',')[1]
                                        });
                                    }">

                                    <select x-ref="selectFilter" data-placeholder="SELECT A STORE" style="width: 100%; padding: 1em;">
                                        <option></option>
                                        <option value=" ">None</option>

                                        @foreach($stores as $item)
                                        @php
                                        $item = (array) $item;
                                        @endphp
                                        <option value="{{ $item['storeID'] . ',' . $item['retekCode'] }}">{{
                                                $item['storeID'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <span x-text="errors.storeID" class="error"></span>
                        </div>

                        <div class="col-lg-4">
                            <label for="">Retek Code <span style="color: red;">*</span></label>
                            <input type="number" class="form-control" disabled x-model="retekCode" placeholder="Eg: 00000">
                            <span x-text="errors.retekCode" class="error"></span>
                        </div>


                        <div class="col-lg-4">
                            <label for="">Sales Date <span style="color: red;">*</span></label>
                            <input x-model="saleDate" type="date" class="form-control" placeholder="Eg: 00000">
                            <span x-text="errors.saleDate" class="error"></span>
                        </div>


                        <div class="col-lg-4 form-group mt-4">
                            <label>Sales Tender <span style="color: red;">*</span></label>
                            <select x-model="tender" class="form-control">
                                <option value="" selected>SELECT SALES TENDER</option>

                                <option value="Cash">Cash</option>
                                <option value="HDFC Card">HDFC Card</option>
                                <option value="ICICI Card">ICICI Card</option>
                                <option value="SBI Card">SBI Card</option>
                                <option value="AMEX Card">AMEX Card</option>
                                <option value="HDFC UPI">HDFC UPI</option>
                                <option value="WALLET PAYTM">WALLET PAYTM</option>
                                <option value="WALLET PHONEPE">WALLET PHONEPE</option>

                            </select>
                            <span x-text="errors.tender" class="error"></span>
                        </div>


                        <div class="form-group col-lg-8 mt-4">
                            <label for="">Remarks</label>
                            <textarea x-model="remarks" id="remarks" style="height: 15vh;" type="text" placeholder="Enter comments." class="form-control"></textarea>
                            <span x-text="errors.remarks" class="error"></span>
                        </div>

                        <div class="w-100 d-flex justify-content-end">
                            <button @click="() => {
                                
                                if(!validateInputs()) {
                                    return false;
                                }

                                confirmAction(async () => {
                                    $wire.save({ storeID, retekCode, saleDate, tender, remarks, id})
                                }, 'Are you sure you want to update the transaction?.');

                            }" class="btn btn-success" style="width: fit-content; "><i class="fa-solid fa-check"></i> Submit</button>
                        </div>
                    </div>

                </div>


                <div class="modal-footer">
                    <div wire:loading.class="d-block" style="display: none; text-align:left; margin: 0 1em; flex: 1; color: #000">
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
