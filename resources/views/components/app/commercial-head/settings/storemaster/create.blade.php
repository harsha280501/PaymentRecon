<div x-data="{
    data: {
        MGPSapCode: null,
        storeID: null,
        retekCode: null,
        newIONo: null,
        brandDesc: null,
        storeTypeasperBrand: null,
        channel: null,
        franchiseeName: null,
        storeOpeningDate: null,
        status: null,
        storeClosingDate: null,
        location: null,
        city: null,
        state: null,
        address: null,
        pinCode: null,
        located: null,
        region: null,
        storeManagerName: null,
        contactNo: null,
        ARMEmailId: null,
        RMEmailId: null,
        NROMEmailId: null,
        RCMmail: null,
        correctStoreEmailId: null,
        HOContact: null,
        RDEmailId: null,
    },

    errors: {},
    loading: false,

    validate() {
        this.errors = {}; // Reset errors object

        if(!this.data.MGPSapCode) {
            this.errors.MGPSapCode = 'MGP SAP Code is required';
        }

        // Validate Store ID
        if (!this.data.storeID || isNaN(this.data.storeID) || this.data.storeID.length !== 4) {
            this.errors.storeID = 'Store ID must be 4 digits and numeric.';
        }

        if (!this.data.retekCode || isNaN(this.data.retekCode) || this.data.retekCode.length !== 5) {
            this.errors.retekCode = 'Retek Code must be 5 digits and numeric.';
        }

        if(!this.data.brandDesc) {
            this.errors.brandDesc = 'Brand Description is required';
        }

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
            'MGP SAP code': this.data.MGPSapCode,
            'NEW SAP code': this.data.storeID,
            'Retak code': this.data.retekCode,
            'New IO No': this.data.newIONo,
            'Brand Name': this.data.brandDesc,
            'StoreTypeasperBrand': this.data.storeTypeasperBrand,
            'Channel': this.data.channel,
            'Franchisee Name': this.data.franchiseeName,
            'Store opening Date': this.data.storeOpeningDate,
            'Status': this.data.status,
            'Store Closing Date': this.data.storeClosingDate,
            'Location': this.data.location,
            'City': this.data.city,
            'State': this.data.state,
            'Address': this.data.address,
            'Pin code': this.data.pinCode,
            'Located ': this.data.located,
            'Region': this.data.region,
            'Store Manager Name': this.data.storeManagerName,
            'Contact no': this.data.contactNo,
            'ARM email id': this.data.ARMEmailId,
            'RM email id': this.data.RMEmailId,
            'NROM email id': this.data.NROMEmailId,
            'RCM mail': this.data.RCMmail,
            'Correct store email id': this.data.correctStoreEmailId,
            'HO contact': this.data.HOContact,
            'RD email id': this.data.RDEmailId
        };

        // Submit the form  
        confirmAction(() => { 
            loading = true
            $wire.create(dataset)
            loading = false
        }, 'Are you sure you want to create Store?');
    }

}" class="modal fade" id="exampleModalCenterCreate" tabindex="1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Store Master</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                </button>
            </div>
            <form @submit.prevent="submitForm">
                <div class="modal-body">

                    <span style="color: red;">{{ $message }}</span>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="mgp_sap_code">
                                    MGP SAP code <span style="color: red;">*</span>:
                                </label>
                                <input type="text" placeholder="eg,.. 10xx1" class="form-control" x-model="data.MGPSapCode">
                                <span class="text-danger" x-text="errors.MGPSapCode"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="store_id">
                                    Store ID <span style="color: red;">*</span>:
                                </label>
                                <input type="number" placeholder="eg,.. 1002" class="form-control" x-model="data.storeID">
                                <span class="text-danger" x-show="errors.storeID" x-text="errors.storeID"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="retek_code">
                                    RETEK Code <span style="color: red;">*</span>:
                                </label>
                                <input type="number" placeholder="eg,.. 10021" class="form-control" x-model="data.retekCode">
                                <span class="text-danger" x-show="errors.retekCode" x-text="errors.retekCode"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="new_io_no">
                                    New IO No:
                                </label>
                                <input type="number" placeholder="eg,.. 10021" class="form-control" x-model="data.newIONo">
                                <span class="text-danger" x-text="errors.newIONo"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="brand_desc">
                                    Brand Description <span style="color: red;">*</span>:
                                </label>
                                <input type="text" placeholder="eg,.. Allen Solly" class="form-control" x-model="data.brandDesc">
                                <span class="text-danger" x-text="errors.brandDesc"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="StoreTypeasperBrand">
                                    StoreTypeasperBrand:
                                </label>
                                <input type="text" placeholder="eg,.. " class="form-control"
                                    x-model="data.storeTypeasperBrand">
                                <span class="text-danger" x-text="errors.storeTypeasperBrand"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="Channel">
                                    Channel:
                                </label>
                                <input type="text" placeholder="eg,.. " class="form-control" x-model="data.channel">
                                <span class="text-danger" x-text="errors.channel"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="Franchisee Name">
                                    Franchisee Name:
                                </label>
                                <input type="text" placeholder="eg,.. Allen Solly" class="form-control"
                                    x-model="data.franchiseeName">
                                <span class="text-danger" x-text="errors.franchiseeName"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="Store opening Date">
                                    Store opening Date:
                                </label>
                                <input type="date" placeholder="eg,.. " class="form-control"
                                    x-model="data.storeOpeningDate">
                                <span class="text-danger" x-text="errors.storeOpeningDate"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="Status">
                                    Status:
                                </label>
                                <input type="text" placeholder="eg,.. Closed/Converted" class="form-control" x-model="data.status">
                                <span class="text-danger" x-text="errors.status"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="Store Closing Date">
                                    Store Closing Date:
                                </label>
                                <input type="date" placeholder="eg,.. " class="form-control"
                                    x-model="data.storeClosingDate">
                                <span class="text-danger" x-text="errors.storeClosingDate"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="Location">
                                    Location:
                                </label>
                                <input type="text" placeholder="eg,.. 42, Parker Avenu, Miami, Florida" class="form-control" x-model="data.location">
                                <span class="text-danger" x-text="errors.location"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="City">
                                    City:
                                </label>
                                <input type="text" placeholder="eg,.. Miami" class="form-control" x-model="data.city">
                                <span class="text-danger" x-text="errors.city"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="State">
                                    State:
                                </label>
                                <input type="text" placeholder="eg,.. Florida" class="form-control" x-model="data.state">
                                <span class="text-danger" x-text="errors.state"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="Address">
                                    Address:
                                </label>
                                <input type="text" placeholder="eg,.. 42, Parker Avenu, Miami, Florida" class="form-control" x-model="data.address">
                                <span class="text-danger" x-text="errors.address"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="Pin Code">
                                    Pin Code:
                                </label>
                                <input type="number" placeholder="eg,.. 102100" class="form-control" x-model="data.pinCode">
                                <span class="text-danger" x-text="errors.pinCode"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="Located">
                                    Located:
                                </label>
                                <input type="text" placeholder="eg,.. Miami, Florida" class="form-control" x-model="data.located">
                                <span class="text-danger" x-text="errors.located"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="Region">
                                    Region:
                                </label>
                                <input type="text" placeholder="eg,.. Miami" class="form-control" x-model="data.region">
                                <span class="text-danger" x-text="errors.region"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="Store Manager Name">
                                    Store Manager Name:
                                </label>
                                <input type="text" placeholder="eg,.. Bernard Hackell" class="form-control"
                                    x-model="data.storeManagerName">
                                <span class="text-danger" x-text="errors.storeManagerName"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="Contact No">
                                    Contact No:
                                </label>
                                <input type="tel" placeholder="eg,.. 0422-043232xx0" class="form-control" x-model="data.contactNo">
                                <span class="text-danger" x-text="errors.contactNo"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="ARM EmailId">
                                    ARM EmailId:
                                </label>
                                <input type="email" placeholder="eg,..  billie@example.com" class="form-control" x-model="data.ARMEmailId">
                                <span class="text-danger" x-text="errors.ARMEmailId"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="RM EmailId">
                                    RM EmailId:
                                </label>
                                <input type="email" placeholder="eg,..  rm@example.com" class="form-control" x-model="data.RMEmailId">
                                <span class="text-danger" x-text="errors.RMEmailId"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="NROM EmailId">
                                    NROM EmailId:
                                </label>
                                <input type="email" placeholder="eg,..  nrom@example.com" class="form-control" x-model="data.NROMEmailId">
                                <span class="text-danger" x-text="errors.NROMEmailId"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="RCM mail">
                                    RCM mail:
                                </label>
                                <input type="email" placeholder="eg,..  bernard@hackwell.com" class="form-control" x-model="data.RCMmail">
                                <span class="text-danger" x-text="errors.RCMmail"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="correct Store Email Id">
                                    Correct Store Email Id:
                                </label>
                                <input type="email" placeholder="eg,..  info@abfrl-store.com" class="form-control"
                                    x-model="data.correctStoreEmailId">
                                <span class="text-danger" x-text="errors.correctStoreEmailId"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="HO Contact">
                                    HO Contact:
                                </label>
                                <input type="tel" placeholder="eg,.. 0422-04xxxx12" class="form-control" x-model="data.HOContact">
                                <span class="text-danger" x-text="errors.HOContact"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="RD EmailId">
                                    RD EmailId:
                                </label>
                                <input type="email" placeholder="eg,.. john@example.com" class="form-control" x-model="data.RDEmailId">
                                <span class="text-danger" x-text="errors.RDEmailId"></span>
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