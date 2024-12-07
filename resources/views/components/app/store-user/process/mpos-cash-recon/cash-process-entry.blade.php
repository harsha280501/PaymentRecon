<div class="mainFormValidaitionInputs">
    {{-- Random id --}}
    <div class="p-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            {{-- Primary Select --}}
            <template x-if="recon.item != 'Other'">
                <h5 type="text" class="text-dark" data-name="item" x-text="recon.item"></h5>
            </template>
            {{-- Other Select box --}}
            <template x-if="recon.item == 'Other'">
                <div class="d-flex justify-content-start gap-2 align-items-center">
                    <h5 type="text" class="text-dark" x-text="recon.item"></h5>
                    <input x-model="recon.name" placeholder="Eg.,: Cash Spend in Store" class="form-control" data-name="item" type="text">
                </div>
            </template>
            {{-- Remove Button --}}
            <template x-if="recons.length > 1">
                <button @click="remove(recon.id)" class="btn btn-outline-danger"><i class="fa-solid fa-close"></i></button>
            </template>
        </div>
        {{-- main body --}}
        <div class="d-flex justify-content-center align-items-center gap-3 mb-3 pt-4" style="border-top: 2px solid #00000023;">

            <div class="w-100">
                <label for="">Sale Date</label>
                <input x-model="recon.saleDate" type="date" max="{{ now()->format('Y-m-d') }}" data-name="saleDate" class="form-control" id="exampleInputConfirmPassword1" placeholder="Sale Date">
            </div>
            <div class="w-100">
                <label for="">Deposit Date</label>
                <input x-model="recon.depositDate" type="date" max="{{ now()->format('Y-m-d') }}" data-name="depositDate" class="form-control" id="exampleInputConfirmPassword1" placeholder="Sale Date">
            </div>
            <template x-if="'{{ $data->DiffAmount }}' < 0">
                <div class="w-100">
                    <label for="">Sale Amount</label>
                    <input x-model="recon.saleAmount" type="number" data-name="saleAmount" class="form-control" id="amount1" placeholder="Amount" />
                </div>
            </template>
            <template x-if="'{{ $data->DiffAmount }}' > 0">
                <div class="w-100">
                    <label for="">Deposit Amount</label>
                    <input x-model="recon.depositAmount" type="number" data-name="depositAmount" class="form-control" placeholder="Amount">
                </div>
            </template>

            <div class="w-100">
                <label for="">Slip Number</label>
                <input x-model="recon.slipNumber" type="text" data-name="slipNumber" class="form-control mt-1" id="exampleInputConfirmPassword1" placeholder="Slip No">
            </div>
        </div>

        <div class="d-flex justify-content-start align-items-center gap-3 mb-3 pb-4" style="border-bottom: 2px solid #00000023">

            <div style="width: 150px !important" x-data="{
                banks: ['HDFC', 'ICICI', 'SBI', 'AXIS', 'IDFC']
            }">
                <label for="">Bank Name</label>
                <div style="width: inherit !important" class="select my-1">
                    <select style="width: inherit !important" x-model="recon.bankName">
                        <option value="HDFC">SELECT A BANK</option>
                        <template x-for="bank in banks">
                            <option :value="bank" x-html="bank"></option>
                        </template>
                    </select>
                </div>
                {{-- <input type="text" data-name="bankName" class="form-control" id="exampleInputConfirmPassword1" placeholder="Bank Name"> --}}
            </div>
            <div class="w-100" style="flex: 1 !important">
                <label for="">Remarks</label>
                <input x-model="recon.remarks" type="text" data-name="remarks" class="form-control" id="exampleInputConfirmPassword1" placeholder="Remarks">
            </div>
            <div class="d-flex justify-content-end pt-4" style="flex-direction: column; ">
                <label for="">Support Docupload</label>
                <input x-on:change="recon['supportDocupload'] = Object.values($event.target.files)" type="file" data-passes-validation data-name="supportDocupload" class="form-control" id="exampleInputConfirmPassword1" placeholder="Slip No">
                <span class="small mt-1">Supported file type: <span class="text-black">png, jpg, pdf</span></span>
            </div>
        </div>
    </div>
</div>
