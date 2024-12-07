<div x-data="{
    data: {
        storeID: '',
        retekCode: '',
        colBank: '',
        salesDate: ''
    },

    errors: {},
    loading: false,

    validate() {
        this.errors = {}; // Reset errors object

        // Validate Store ID
        {{-- if (!this.data.storeID || isNaN(this.data.storeID) || this.data.storeID.length !== 4) {
            this.errors.storeID = 'Store ID must be 4 digits and numeric.';
        }

        if (!this.data.retekCode || isNaN(this.data.retekCode) || this.data.retekCode.length !== 5) {
            this.errors.retekCode = 'Retek Code must be 5 digits and numeric.';
        } --}}


        if(Object.keys(this.errors).length) {
            return false;
        }

        return true;
    },

    submitForm() {
        // validating inputs
        if(!this.validate()) {
            return false;
        }


        // prepare the data
        const dataset = {
            
        };

        // Submit the form  
        confirmAction(() => { 
            loading = true
            $wire.update(dataset)
            loading = false
        }, 'Are you sure you want to create Store?');
    }

}" class="modal fade" id="sdkcskskdsfkxnskdldkzsdsdlksddlskoijfdskvm_{{ $data->walletSalesRecoUID }}" tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Wallet Reconciliation</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                </button>
            </div>
            <form @submit.prevent="submitForm">
                <div class="modal-body">

                    <form class="forms-sample">
                        <div class="row" style="margin-bottom: -20px">
                            {{-- <h5>Reconciliation dashboard</h5> --}}
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
                        </div>

                        <div class="row" style="margin-bottom: -20px">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">
                                        <h5>Collection Bank : </h5>
                                    </label>
                                    <label for="exampleInputUsername1">
                                        <h5>{{ $data->collectionBank }}</h5>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>


                    <h5>Reconciliation Item to Update</h5>
                    <section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">
                        <div class="row cash-pickup">
                            <div class="col-lg-2">
                                <h5>Sales Date</h5>
                            </div>
                            
                            <div class="col-lg-2">
                                <h5>Deposit Date</h5>
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

                            <div class="col-lg-2">
                                <h5>Store Response Entry</h5>
                            </div>
                        </div>

                        <div class="row cash-pickup-item">
                            <div class="col-lg-2">
                                {{ Carbon\Carbon::parse($data->transactionDate)->format('d-m-Y') }}
                            </div>
                            <div class="col-lg-2">
                                {{ Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}
                            </div>
                            <div class="col-lg-2">
                                {{ number_format($data->walletSale, 2) }}
                            </div>
                            <div class="col-lg-2">
                                {{ number_format($data->depositAmount, 2) }}
                            </div>
                            <div class="col-lg-2">
                                {{ number_format($data->diffSaleDeposit, 2) }}
                            </div>
                            <div class="col-lg-2">
                                -{{ number_format($data->depositAmount, 2) }}
                            </div>
                        </div>
                    </section>
                    <br>
                    <br>
                    <h5>New Reconciliation Item</h5>

                    <span style="color: red;">{{ $message }}</span>

                    <div class="row mt-3">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="Store opening Date">
                                    New Sale Date <span style="color: red;">*</span>:
                                </label>
                                <input type="date" placeholder="eg,.. " class="form-control mt-1" x-model="data.saleDate">
                                <span class="text-danger" x-text="errors.saleDate"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="store_id">
                                    New Store ID <span style="color: red;">*</span>:
                                </label>
                                <input type="number" placeholder="eg,.. 1002" class="form-control mt-1" x-model="data.storeID">
                                <span class="text-danger" x-show="errors.storeID" x-text="errors.storeID"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="retek_code">
                                    New Retek Code <span style="color: red;">*</span>:
                                </label>
                                <input type="number" placeholder="eg,.. 10021" class="form-control mt-1" x-model="data.retekCode">
                                <span class="text-danger" x-show="errors.retekCode" x-text="errors.retekCode"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="Store opening Date">
                                    New Tender (Collection Bank) <span style="color: red;">*</span>:
                                </label>
                                <div wire:ignore>
                                    <select id="select_tender_bank" class="form-select mt-1">
                                        <option style="padding: 0.5em 1em;" selected value="" class="form-item">SELECT A
                                            BANK</option>
                                        <option style="padding: 0.5em 1em;" value="" class="form-item">ALL</option>
                                        <option style="padding: 0.5em 1em;" value="Wallet Phonepay" class="form-item">Wallet Phonepay</option>
                                        <option style="padding: 0.5em 1em;" value="Wallet Paytm" class="form-item">Wallet Paytm</option>
                                      
                                        </select>
                                </div>

                                <span class="text-danger" x-show="errors.colBank" x-text="errors.colBank"></span>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="flex: 1">
                        <div class="loader repoLoader" style="display: none" wire:loading.class="d-block">
                            <div class="spinner-border spinner-border-sm" style="color: #000" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span>Loading ...</span>
                        </div>
                    </div>
                    <div class="d-flex" style="gap: 3">
                        <button type="submit" class="btn btn-success green">Save</button>
                        <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
