<div wire:ignore.self wire:key="594cc079bd8cfc21da9982bbb58b43a721f051745a9ebe81a2eff5ba2cc774d8" class="modal fade" wire:key="{{ $data->className . '_' . $data->UID }}" id="{{ $data->className }}" x-data="{
        storeID: '{{ $data->storeID }}',
        retekCode: '{{ $data->retekCode }}',
        remarks: '{{ $data->unAllocatedRemarks }}',
        salesDate: '{{ $data->salesDate }}',
        itemID: '{{ $data->storeMissingUID }}',
        bank: '{{ $data->colBank }}',
        UID: '{{ $data->UID }}',
        loading: false,

        errors: {
            storeID: null,
            retekCode: null,
            remarks: null
        },


        reset(){
            this.errors = {
                storeID: null,
                retekCode: null,
                remarks: null
            }
        },

        validate() {

            this.reset();

            // Validate Store ID
            if (!this.storeID || isNaN(this.storeID) || this.storeID.length !== 4) {
                this.errors.storeID = 'Store ID must be 4 digits and numeric.';
            }
            
            // Validate RetekCode
            if (!this.retekCode || isNaN(this.retekCode) || this.retekCode.length !== 5) {
                this.errors.retekCode = 'Retek Code must be 5 digits and numeric.';
            }
            
            // Validate Remarks
            if (!this.remarks) {
                this.errors.remarks =  'Remarks cannot be empty.';
            }

            
            if (!this.salesDate || !this.isValidDate(this.salesDate)) {
                this.errors.salesDate =  'Sales Date is not Valid';
            }


            if(this.errors.storeID != null || this.errors.retekCode != null || this.errors.remarks != null) {
                return false;
            }

            if(this.storeID != null && this.retekCode != null && this.remarks != null) {
                return true;
            }

            return false;
        },


        submit() {

            if(!this.validate()){
                return false;
            }

            confirmAction(() => {
                $wire.updateUnAllocated({ 
                    storeID: this.storeID, 
                    retekCode: this.retekCode, 
                    remarks: this.remarks,
                    salesDate: this.salesDate,
                    itemID: this.itemID,
                    bank: this.bank,
                    UID: this.UID
                });
            }, 'Are you sure you want to update this storeID missing transaction?');
        },


        isValidDate(dateString) {
            const date = new Date(dateString);
            return !isNaN(date.getTime());
        },

         isValidDateWithFormat(dateString) {
            const regex = /^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/;
            return regex.test(dateString);
        }
    }">
    <div wire:ignore.self class="modal-dialog modal-dialog-centered" role="document" style="max-width: 1200px; padding: 2em;">
        <div wire:ignore.self class="modal-content">
            <form wire:ignore.self class="forms-sample">
                <div wire:ignore.self class="modal-header">
                    <h5 class="modal-title" wire:ignore.self >{{ $header }}</h5>
                    <button type="button" wire:ignore.self class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                    </button>
                </div>
                <div class="modal-body" style="min-height: 50vh" wire:ignore.self>
                    <div class="row" wire:ignore.self >
                        <div wire:ignore>
                            {{ $slot }}
                        </div>
                        <div class="col-lg-4" wire:ignore.self>
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Store ID</h5>
                                </label>
                                <input type="number" class="form-control" x-model="storeID" placeholder="Eg: 0000">
                                <div style="text-align: start;">
                                    <span x-text="errors.storeID" style="color: red;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" wire:ignore.self>
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Retek Code</h5>
                                </label>
                                <input type="number" class="form-control" x-model="retekCode" placeholder="Eg: 00000">
                                <div style="text-align: start;">
                                    <span x-text="errors.retekCode" style="color: red;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" wire:ignore.self>
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Sales Date</h5>
                                </label>
                                <input type="date" class="form-control" x-model="salesDate" >
                                <div style="text-align: start;">
                                    <span x-text="errors.salesDate" style="color: red;"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4" wire:ignore.self>
                            <div class="form-group">
                                <label for="exampleInputUsername1">
                                    <h5>Un Allocated Remarks</h5>
                                </label>
                                <textarea placeholder="Remarks ..." class="form-control form-control-lg" x-model="remarks"></textarea>
                                <div style="text-align: start;">
                                    <span x-text="errors.remarks" style="color: red;"></span>
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
                        <button style="width: fit-content" type="submit" x-on:click.prevent="submit" class="btn btn-success green">
                            Update
                        </button>
                        <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
