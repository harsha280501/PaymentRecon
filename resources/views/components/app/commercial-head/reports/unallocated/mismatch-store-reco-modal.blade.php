<div class="modal fade" wire:ignore x-data="{
    data: {
        storeID: '',
        retekCode: '',
        colBank: '',
        id: '{{ $data->storeMissingUID }}',

        errors: {
            storeID: null,
            retekCode: null,
            colBank: null,
        },
    },

    
    reset(){
        this.data.errors = {
            storeID: null,
            retekCode: null,
            colBank: null,
        }
    },




    validate() {

        this.reset();

        // Validate Store ID
        if (!this.data.storeID || isNaN(this.data.storeID) || this.data.storeID.length !== 4) {
            this.data.errors.storeID = 'Store ID must be 4 digits and numeric.';
        }

        if (!['AXIS Cash', 'ICICI Cash', 'HDFC', 'SBICASHMumbai', 'SBICASHMIS', 'IDFC', 'HDFC Card', 'ICICI Card', 'SBI Card', 'AMEX Card', 'HDFC UPI', 'WALLET PAYTM', 'WALLET PHONEPAY'].includes(this.data.colBank)) {
            this.data.errors.colBank =  'Collection Bank is invalid.';
        }


        if(this.data.errors.storeID != null || this.data.errors.colBank != null) {
            return false;
        }

        if(this.data.storeID != null && this.data.colBank != null) {
            return true;
        }

        return false;
    },



    onSubmit() {


        if(!this.validate()){
            return false;
        }

        confirmAction(() => { 
            loading = true
            $wire.recon(this.data)
            loading = false
        }, 'Are you sure you want to update this Unallocated Collection?');
    }


}" id="upload_modal_{{ $data->storeMissingUID }}">
    <div wire:ignore.self class="modal-dialog modal-dialog-centered" role="document" style="max-width: 1200px; padding: 2em;">
        <div wire:ignore.self class="modal-content">
            <form wire:ignore.self class="forms-sample">
                <div wire:ignore.self class="modal-header">
                    <h5 class="modal-title" wire:ignore.self>Mismatch Store Recon Update</h5>
                    <button type="button" wire:ignore.self class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                    </button>
                </div>
                <div class="modal-body" style="min-height: 50vh" wire:ignore.self>
                    <div wire:ignore.self>
                        <div class="row" wire:ignore.self>
                            <div wire:ignore class="row">
                                <div class="col-lg-4" wire:key="20ee285091fef161f234d5b4ac1f3066bc7cdec9c040caca0b49bed8f2c001e8_{{ rand() }}_{{ $data->storeMissingUID }}">
                                    <div class="form-group">
                                        <label>
                                            <h5 style="color: gray">Deposit Date</h5>
                                        </label>
                                        <p style="color: #000; font-weight: 500; margin-top: -10px; text-align: left">{{ !$data->depositDate ? '' : Carbon\Carbon::parse($data->depositDate)->format('d-m-Y') }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4" wire:key="20ee285091fef161f234d5b4ac1f3066bc7cdec9c040caca0b49bed8f2c001e8_{{ rand() }}_{{ $data->storeMissingUID }}">
                                    <div class="form-group">
                                        <label>
                                            <h5 style="color: gray">Collection Bank</h5>
                                        </label>
                                        <p style="color: #000; font-weight: 500; margin-top: -10px; text-align: left">{{ $data->colBank }}</p>
                                    </div>
                                </div>

                                <div class="col-lg-4" wire:key="20ee285091fef161f234d5b4ac1f3066bc7cdec9c040caca0b49bed8f2c001e8_{{ rand() }}_{{ $data->storeMissingUID }}">
                                    <div class="form-group">
                                        <label>
                                            <h5 style="color: gray">Store Update Remarks</h5>
                                        </label>
                                        <p style="color: #000; font-weight: 500; margin-top: -10px; text-align: left">{{ $data->storeUpdateRemarks }}</p>
                                    </div>
                                </div>


                                <div class="col-lg-4" wire:key="20ee285091fef161f234d5b4ac1f3066bc7cdec9c040caca0b49bed8f2c001e8_{{ rand() }}_{{ $data->storeMissingUID }}">
                                    <div class="form-group">
                                        <label>
                                            <h5 style="color: gray">Deposit Amount</h5>
                                        </label>
                                        <p style="color: #000; font-weight: 500; margin-top: -10px; text-align: left">{{ $data->depositAmount }}</p>
                                    </div>
                                </div>

                                <div class="col-lg-4" wire:key="20ee285091fef161f234d5b4ac1f3066bc7cdec9c040caca0b49bed8f2c001e8_{{ rand() }}_{{ $data->storeMissingUID }}">
                                    <div class="form-group">
                                        <label>
                                            <h5 style="color: gray">Store Response Entry</h5>
                                        </label>
                                        <p style="color: #000; font-weight: 500; margin-top: -10px; text-align: left">{{ $data->adjAmount }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div wire:ignore.self class="mt-5 row">
                            <div class="col-lg-4" wire:ignore.self>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">
                                        <h5>Store ID</h5>
                                    </label>
                                    <div style="position: relative; transform: translate(0,0);">
                                        <div wire:ignore class="" x-init="() => {
                                                this.selectFilter = $j($refs.selectFilter).select2({
                                                    dropdownParent: $j($refs.selectFilter).parent(),
                                                })
                    
                                                this.selectFilter.on('select2:select', (event) => {    
                                                    data.storeID = event.target.value.split(',')[0]
                                                    data.retekCode = event.target.value.split(',')[1]
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

                                    <div style="text-align: start;">
                                        <span style="color: red;" x-text="data.errors.storeID"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4" wire:ignore.self>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">
                                        <h5>Retek Code</h5>
                                    </label>
                                    <input type="number" class="form-control" disabled x-model="data.retekCode" placeholder="Eg: 00000">
                                    <div style="text-align: start;">
                                        <span style="color: red;" x-text="data.errors.retekCode"></span>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-4" wire:ignore.self>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">
                                        <h5>Tender [Collection Bank]</h5>
                                    </label>
                                    <div wire:ignore>
                                        <select id="select_tender_bank" class="form-select mt-1" x-model="data.colBank">

                                            <option style="padding: 0.5em 1em;" selected value="" class="form-item">
                                                SELECT A
                                                BANK</option>

                                            <option style="padding: 0.5em 1em;" value="AXIS Cash" class="form-item">AXIS Cash</option>
                                            <option style="padding: 0.5em 1em;" value="ICICI Cash" class="form-item">ICICI Cash</option>
                                            <option style="padding: 0.5em 1em;" value="HDFC" class="form-item">HDFC</option>
                                            <option style="padding: 0.5em 1em;" value="SBICASHMumbai" class="form-item">SBICASHMumbai</option>
                                            <option style="padding: 0.5em 1em;" value="SBICASHMIS" class="form-item">SBICASHMIS</option>
                                            <option style="padding: 0.5em 1em;" value="IDFC" class="form-item">IDFC</option>

                                            <option style="padding: 0.5em 1em;" value="HDFC Card" class="form-item">
                                                HDFC
                                                Card</option>
                                            <option style="padding: 0.5em 1em;" value="ICICI Card" class="form-item">ICICI
                                                Card</option>
                                            <option style="padding: 0.5em 1em;" value="SBI Card" class="form-item">
                                                SBI Card
                                            </option>
                                            <option style="padding: 0.5em 1em;" value="AMEX Card" class="form-item">
                                                AMEX
                                                Card</option>
                                            <option style="padding: 0.5em 1em;" value="HDFC UPI" class="form-item">
                                                HDFC UPI</option>

                                            <option style="padding: 0.5em 1em;" value="WALLET PAYTM" class="form-item">
                                                WALLET PAYTM</option>
                                            <option style="padding: 0.5em 1em;" value="WALLET PHONEPAY" class="form-item">WALLET PHONEPAY</option>
                                        </select>
                                    </div>
                                    <div style="text-align: start;">
                                        <span style="color: red;" x-text="data.errors.colBank"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" wire:ignore>

                    <div style="flex: 1">
                        <div class="footer-loading-btn" wire:loading.class="d-block" style="display: none; text-align:left; margin: 0 1em; flex: 1; color: #000">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span>Loading ...</span>
                        </div>
                    </div>

                    <div class="d-flex" style="gap: 3">
                        <button style="width: fit-content" type="submit" x-on:click.prevent="onSubmit" class="btn btn-success green">
                            Update
                        </button>
                        <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
