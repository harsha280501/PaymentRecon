<div x-data="{
    data: {
        storeID: '',
        retekCode: '',
        colBank: '',
        salesDate: '',
        reconItem: '{{ $data->cardSalesRecoUID }}',
    },

    depositAmount: '{{ $data->depositAmount }}',
    adjAmount: '{{ $data->adjAmount ?? 0 }}',
    brand: '-',

    errors: {},
    loading: false,

    saleAmount: 0,


    validate() {
        this.errors = {}; // Reset errors object


        const storeIDPattern = /^\d{4}$/;   // 4 digits only
        const retekCodePattern = /^\d{5}$/; // 5 digits only
        const colBankOptions = ['HDFC Card', 'ICICI Card', 'SBI Card', 'Amex Card', 'HDFC UPI'];

        // Validate StoreID
        if (!storeIDPattern.test(this.data.storeID)) {
            this.errors.storeID = 'Store ID must be 4 digits.';
        }

        // Validate RetekCode
        if (!retekCodePattern.test(this.data.retekCode)) {
            this.errors.retekCode =  'Retek Code must be 5 digits.';
        }

        // Validate ColBank
        if (!colBankOptions.includes(this.data.colBank)) {
            this.errors.colBank =  'ColBank must be one of the following: HDFC Card, ICICI Card, SBI Card, or Amex Card, HDFC UPI.';
        }

        // Validate Sales Date
        if (!this.data.salesDate) {
            this.errors.salesDate =  'Sales Date is required.';
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


        // Submit the form  
        confirmAction(() => { 
            loading = true
            $wire.recon(this.data)
            loading = false
        }, 'Are you sure you want to update the reconciliation?');
    },





    async getSalesData() {
        
        if(!this.validate()) {
            return false;
        }

        const sales = JSON.parse(await $wire.getSalesAmount(this.data))

        this.saleAmount = sales.cardSale
        this.brand = sales.brand
        console.log(sales)
        return true;
    }




}" class="modal fade" id="sdkcskskdsfkxnskdldkzsdsdlksddlskoijfdskvm_{{ $data->cardSalesRecoUID }}" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore>
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Card Reconciliation</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                </button>
            </div>
            <form>
                <div class="modal-body">

                    <div class="px-3" style="border-radius: 5px">
                        <div class="px-3 py-1 mt-1" style="background: #f0f0f0; border-radius: 5px">

                            <div class="d-flex justify-content-between align-items-center mt-2" style="color: #000;">
                                <h5 type="text" class="text-dark" data-name="item">Reconciliation Item</h5>
                            </div>

                            <div class="d-flex justify-content-center align-items-start gap-3 mb-1 pt-3" style="border-top: 2px solid #00000023; flex-wrap: nowrap">

                                <div class="w-100">
                                    <label for="">Store ID</label>
                                    <p class="text-black" style="font-weight: 700">{{ $data->storeID }}</p>
                                </div>

                                <div class="w-100">
                                    <label for="">Retek Code</label>
                                    <p class="text-black" style="font-weight: 700">{{ $data->retekCode }}</p>
                                </div>

                                <div class="w-100">
                                    <label for="">Brand</label>
                                    <p class="text-black" style="font-weight: 700">{{ $data->brand }}</p>
                                </div>

                                <div class="w-100">
                                    <label for="">Collection Bank</label>
                                    <p class="text-black" style="font-weight: 700">{{ $data->collectionBank }}</p>
                                </div>

                                <div class="w-100">

                                </div>
                            </div>

                            <div class="d-flex justify-content-center align-items-start gap-3 mb-1 pt-3" style="flex-wrap: nowrap">

                                <div class="w-100">
                                    <label for="">Sale Date</label>
                                    <p class="text-black" style="font-weight: 700">{{
                                        Carbon\Carbon::parse($data->transactionDate)->format('d-m-Y') }}</p>
                                </div>

                                <div class="w-100">
                                    <label for="">Deposit Date</label>
                                    <p class="text-black" style="font-weight: 700">{{
                                        Carbon\Carbon::parse($data->depositDt)->format('d-m-Y')}}</p>
                                </div>

                                <div class="w-100">
                                    <label for="">Sale Amount</label>
                                    <p class="text-black" style="font-weight: 700">{{ $data->cardSale }}</p>
                                </div>

                                <div class="w-100">
                                    <label for="">Deposit Amount</label>
                                    <p class="text-black" style="font-weight: 700">{{ $data->depositAmount }}</p>
                                </div>

                                <div class="w-100">
                                    <label for="">Store Response Entry</label>
                                    <template x-if="data.storeID.trim() != '' || data.salesDate.trim() != '' || data.colBank.trim() != ''">
                                        <p class="text-black" style="font-weight: 700" x-text="-1 * depositAmount"></p>
                                    </template>
                                    <template x-if="data.storeID == '' && data.salesDate == '' && data.colBank == ''">
                                        -<p class="text-black" style="font-weight: 700" x-text="adjAmount"></p>
                                    </template>
                                </div>
                            </div>
                        </div>

                        @if($data->isUpdated == 0)

                        <template x-if="data.storeID.trim() != '' || data.salesDate.trim() != '' || data.colBank.trim() != ''">
                            <div class="px-3 py-1" style="background: #d6fdd591;  border-radius: 5px; margin-top: 1em">

                                <div class="d-flex justify-content-between align-items-center mt-2" style="color: #000;">
                                    <h5 type="text" class="text-dark" data-name="item">New Reconciliation Item</h5>
                                </div>

                                <div class="d-flex justify-content-center align-items-start gap-3 mb-1 pt-3" style="border-top: 2px solid #00000023; flex-wrap: nowrap">

                                    <div class="w-100">
                                        <label for="">Store ID</label>
                                        <p class="text-black" style="font-weight: 700" x-text="data.storeID"></p>
                                    </div>

                                    <div class="w-100">
                                        <label for="">Retek Code</label>
                                        <p class="text-black" style="font-weight: 700" x-text="data.retekCode"></p>
                                    </div>

                                    <div class="w-100">
                                        <label for="">Brand</label>
                                        <p class="text-black" style="font-weight: 700"  x-text="brand"></p>
                                    </div>

                                    <div class="w-100">
                                        <label for="">Collection Bank</label>
                                        <p class="text-black" style="font-weight: 700" x-text="data.colBank"></p>
                                    </div>
                                    <div class="w-100">

                                    </div>
                                </div>

                                <div class="d-flex justify-content-center align-items-start gap-3 mb-1 pt-3" style="flex-wrap: nowrap">
                                    <div class="w-100">
                                        <label for="">Sale Date</label>
                                        <p class="text-black" style="font-weight: 700" x-text="new Intl.DateTimeFormat('en-IN', { day: '2-digit', month: '2-digit', year: 'numeric' })
                                            .format(new Date(data.salesDate))
                                            .split('/')
                                            .join('-')">
                                        </p>
                                    </div>

                                    <div class="w-100">
                                        <label for="">Deposit Date</label>
                                        <p class="text-black" style="font-weight: 700">{{
                                            Carbon\Carbon::parse($data->depositDt)->format('d-m-Y')}}</p>
                                    </div>

                                    <div class="w-100"> 
                                        <label for="">Sale Amount</label>
                                        <p class="text-black" style="font-weight: 700" x-text="saleAmount"></p>
                                    </div>

                                    <div class="w-100">
                                        <label for="">Deposit Amount</label>
                                        <p class="text-black" style="font-weight: 700">0.00</p>
                                    </div>

                                    <div class="w-100">
                                        <label for="">Store Response Entry</label>
                                        <p class="text-black" style="font-weight: 700">{{ $data->depositAmount }}</p>
                                    </div>
                                </div>
                            </div>

                        </template>
                        <div class="px-3 py-1" style="background: #f9f9f9;  border-radius: 5px; margin-top: 1em">
                            <div class="d-flex justify-content-center align-items-start gap-3 mb-1 pt-2" style="flex-wrap: nowrap">

                                <div class="w-100">
                                    <div class="form-group">
                                        <label for="Store opening Date">
                                            New Sale Date <span style="color: red;">*</span>:
                                        </label>
                                        <input type="date" placeholder="eg,.. " class="form-control mt-1" x-model="data.salesDate" max="{{ Carbon\Carbon::parse($data->depositDt)->format('Y-m-d') }}">
                                        <span class="text-danger" x-text="errors.salesDate"></span>
                                    </div>
                                </div>
                                <div class="w-100">
                                    <div class="form-group selectFilter">
                                        <label for="store_id" style="margin-bottom: .8em;">
                                            New Store ID <span style="color: red;">*</span>:
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

                                        <span class="text-danger" x-show="errors.storeID" x-text="errors.storeID"></span>
                                    </div>
                                </div>
                                <div class="w-100">
                                    <div class="form-group">
                                        <label for="retek_code">
                                            New Retek Code <span style="color: red;">*</span>:
                                        </label>
                                        <input type="number" placeholder="eg,.. 10021" class="form-control mt-1" x-model="data.retekCode" disabled>
                                        <span class="text-danger" x-show="errors.retekCode" x-text="errors.retekCode"></span>
                                    </div>
                                </div>

                                <div class="w-100">
                                    <div class="form-group">
                                        <label for="Store opening Date">
                                            New Tender (Collection Bank) <span style="color: red;">*</span>:
                                        </label>
                                        <div wire:ignore>
                                            <select id="select_tender_bank" class="form-select mt-1" x-model="data.colBank">
                                                <option style="padding: 0.5em 1em;" selected value="" class="form-item">
                                                    SELECT A
                                                    BANK</option>

                                                <option style="padding: 0.5em 1em;" value="HDFC Card" class="form-item">
                                                    HDFC
                                                    Card</option>
                                                <option style="padding: 0.5em 1em;" value="ICICI Card" class="form-item">ICICI
                                                    Card</option>
                                                <option style="padding: 0.5em 1em;" value="SBI Card" class="form-item">
                                                    SBI Card
                                                </option>
                                                <option style="padding: 0.5em 1em;" value="Amex Card" class="form-item">
                                                    Amex
                                                    Card</option>
                                                <option style="padding: 0.5em 1em;" value="HDFC UPI" class="form-item">
                                                    HDFC UPI</option>
                                            </select>
                                        </div>
                                        <span class="text-danger" x-show="errors.colBank" x-text="errors.colBank"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

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

                        @if($data->isUpdated == 0)

                        <template x-if="data.storeID.trim() != '' && data.salesDate.trim() != '' && data.colBank.trim() != ''">
                            <button type="submit" class="btn btn-warning w-100 text-dark me-2 px-2" @click.prevent="getSalesData">Check Sales</button>
                        </template>

                        <template x-if="1 == 1">
                            <button type="submit" class="btn btn-danger w-100 text-dark" style="padding: 0;" @click.prevent="() => {
                                confirmAction(() => { 
                                    loading = true
                                    $wire.moveToUnallocated(['{{ $data->cardSalesRecoUID }}'])
                                    loading = false
                                }, 'Are you sure you want to move this item to unallocated?');

                            }">Move > Unallocated</button>
                        </template>

                        <template x-if="saleAmount > 0">
                            <button type="submit" class="btn btn-success green mx-2" @click.prevent="submitForm">Save</button>
                        </template>
                        @endif
                        <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
