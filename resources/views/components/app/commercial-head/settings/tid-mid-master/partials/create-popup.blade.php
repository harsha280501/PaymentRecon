<div class="modal fade" wire:ignore wire:key="2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824" id="{{ $id }}" tabindex="1" role="dialog" aria-labelledby="repo" aria-hidden="true" x-data="{
        form: {
            MID: '',
            {{-- POS: '', --}}
            storeID: '',
            oldRetekCode: '',
            newRetekCode: '',
            brandName: '',
            Status: '',
            openingDt: '',
            closureDate: '',
            conversionDt: '',
            {{-- relevance: '',
            EDCServiceProvider: '' --}}
        },
        errors: {},
        loading: false,


        validate() {

            this.errors = {};
            
            if (!this.form.MID) {
                this.errors.MID = 'MID is required';
            }

            if (!this.form.storeID) {
                this.errors.storeID = 'Store ID is required';
            } else if (!/^\d{4}$/.test(this.form.storeID)) {
                this.errors.storeID = 'Store ID must be exactly 4 digits';
            }

            if (this.form.oldRetekCode && !/^\d{5}$/.test(this.form.oldRetekCode)) {
                this.errors.oldRetekCode = 'Old Retek Code must be exactly 5 digits';
            }

            if (!this.form.newRetekCode) {
                this.errors.newRetekCode = 'New Retek Code is required';
            } else if (!/^\d{5}$/.test(this.form.newRetekCode)) {
                this.errors.newRetekCode = 'New Retek Code must be exactly 5 digits';
            }

            if (!this.form.brandName) {
                this.errors.brandName = 'Brand Name is required';
            }

            if (!this.form.Status) {
                this.errors.Status = 'Status is required';
            }


            return Object.keys(this.errors).length === 0;
        },

        submitForm() {
            if (!this.validate()) {
                return false;
            }


            confirmAction(() => { 
                this.loading = true
                $wire.createTID(this.form)
                this.loading = false
            }, 'Are you sure you want to create MID/TID?');
        }
    }" x-init="() => {

    Livewire.on('tid:success', () => {
        succesMessageConfiguration('TID/MID Added Successfully')
        window.location.reload()
    })

    Livewire.on('tid:failed', ({message}) => {
        errorMessageConfiguration(message)
        return false;
    })
}">
    <div class="modal-dialog modal-dialog-centered" wire:ignore.self role="document" style="max-width: 1200px !important; padding: 2em">
        <div class="modal-content" wire:ignore.self>
            <form @submit.prevent="submitForm" wire:ignore.self>
                <div class="modal-header" wire:ignore.self>
                    <h5 class="modal-title">Create MID/TID</h5>
                    <div class="right">
                        <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <div class="modal-body" wire:ignore>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label style="color:#000">MID/TID <span style='color: red'>*</span></label>
                            <input type="number" placeholder="Eg: 120012..." class="form-control" x-model="form.MID">
                            <span x-show="errors.MID" class="text-danger" x-text="errors.MID"></span>
                        </div>
                        {{-- <div class="form-group col-lg-6">
                            <label style="color:#000">POS</label>
                            <input type="number" placeholder="Eg: 232121..." class="form-control" x-model="form.POS">
                            <span x-show="errors.POS" class="text-danger" x-text="errors.POS"></span>
                        </div> --}}
                        <div class="form-group col-lg-6">
                            <label style="color:#000">Store ID <span style='color: red'>*</span></label>
                            <input type="number" placeholder="Eg: 0000" class="form-control" x-model="form.storeID">
                            <span x-show="errors.storeID" class="text-danger" x-text="errors.storeID"></span>
                        </div>
                    </div>
                    <div class="row">
                      
                        <div class="form-group col-lg-6">
                            <label style="color:#000">Old Retek Code</label>
                            <input type="number" placeholder="Eg: 00000" class="form-control" x-model="form.oldRetekCode">
                            <span x-show="errors.oldRetekCode" class="text-danger" x-text="errors.newRetekCode"></span>
                        </div>
                        <div class="form-group col-lg-6">
                            <label style="color:#000">New Retek Code <span style='color: red'>*</span></label>
                            <input type="number" placeholder="Eg: 00000" class="form-control" x-model="form.newRetekCode">
                            <span x-show="errors.newRetekCode" class="text-danger" x-text="errors.newRetekCode"></span>
                        </div>
                    </div>
                    <div class="row">
                       
                        <div class="form-group col-lg-6">
                            <label style="color:#000">Brand Name <span style='color: red'>*</span></label>
                            <input type="text" class="form-control" x-model="form.brandName">
                            <span x-show="errors.brandName" class="text-danger" x-text="errors.brandName"></span>
                        </div>
                        <div class="form-group col-lg-6">
                            <label style="color:#000">Status (International Business/Closed/Operational/Other Status)<span style='color: red'>*</span></label>
                            <input type="text" class="form-control" x-model="form.Status">
                            <span x-show="errors.Status" class="text-danger" x-text="errors.Status"></span>
                        </div>
                    </div>
                    <div class="row">
                       

                        <div class="form-group col-lg-6">
                            <label style="color:#000">Store Opening Date</label>
                            <input type="date" class="form-control" x-model="form.openingDt">
                            <span x-show="errors.openingDt" class="text-danger" x-text="errors.openingDt"></span>
                        </div>
                        <div class="form-group col-lg-6">
                            <label style="color:#000">Closure Date</label>
                            <input type="date" class="form-control" x-model="form.closureDate">
                            <span x-show="errors.closureDate" class="text-danger" x-text="errors.closureDate"></span>
                        </div>
                    </div>
                    <div class="row">
                       
                        <div class="form-group col-lg-6">
                            <label style="color:#000">Date of Conversion</label>
                            <input type="date" class="form-control" x-model="form.conversionDt">
                            <span x-show="errors.conversionDt" class="text-danger" x-text="errors.conversionDt"></span>
                        </div>
                        <div class="form-group col-lg-6">
                            <label style="color:#000">Select TID Type<span style='color: red'>*</span></label>
                            <select class="form-control" x-model="form.TIDFilter">
                                <option value="" disabled selected>Select TID</option>
                                <option value="AMEX">AMEX TID</option>
                                <option value="ICICI">ICICI TID</option>
                                <option value="SBI">SBI TID</option>
                                <option value="HDFC">HDFC TID</option>
                            </select>
                            <span x-show="errors.TIDFilter" class="text-danger" x-text="errors.TIDFilter"></span>
                        </div>
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <div style="flex: 1">
                        <div class="loader repoLoader" x-show="loading">
                            <div class="spinner-border spinner-border-sm" style="color: #000" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span>Loading ...</span>
                        </div>
                    </div>

                    <div class="d-flex" style="gap: 3">
                        <button 
                        type="submit" 
                        class="btn btn-success green" 
                        :disabled="!form.TIDFilter">Save
                        </button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
