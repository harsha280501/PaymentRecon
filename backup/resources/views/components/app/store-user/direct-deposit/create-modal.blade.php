<div x-data="directDepositForm()">
    <!-- Bootstrap modal -->
    <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
        x-transition:leave="transition ease-in duration-300" class="modal fade" id="create-model-for-direct-deposit"
        tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Direct Deposit</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Bootstrap form -->
                    <form x-on:submit.prevent="save" class="row g-3 needs-validation" novalidate
                        enctype="multipart/form-data">
                        <!-- Deposit Slip No -->
                        <div class="col-md-4">
                            <label for="depositSlipNo" class="form-label">Deposit Slip No<span
                                    class="text-danger">*</span></label>
                            <input x-model="depositSlipNo" type="text" class="form-control"
                                placeholder="Enter Deposit Slip No" id="depositSlipNo" required>
                            <span x-text="errors.depositSlipNo" class="text-danger d-block"></span>
                        </div>

                        <!-- Amount -->
                        <div class="col-md-4">
                            <label for="amount" class="form-label">Amount<span class="text-danger">*</span></label>
                            <input x-model="amount" type="number" class="form-control" placeholder="Enter Amount"
                                id="amount" required>
                            <span x-text="errors.amount" class="text-danger d-block"></span>
                        </div>

                        <!-- Date -->
                        <div class="col-md-4">
                            <label for="date" class="form-label">Deposit Date<span class="text-danger">*</span></label>
                            <input x-model="date" type="date" class="form-control" placeholder="Enter Date"
                                id="date" required>
                            <span x-text="errors.date" class="text-danger d-block"></span>
                        </div>

                        <!-- Bank -->
                        <div class="col-md-4">
                            <label for="bank" class="form-label">Bank<span class="text-danger">*</span></label>
                            <select x-model="bank" class="form-select">
                                <option value="" selected>Select a Bank</option>
                                <option value="HDFC">HDFC</option>
                                <option value="ICICI">ICICI</option>
                                <option value="SBI">SBI</option>
                                <option value="AMEX CARD">AMEX CARD</option>
                            </select>
                            <span x-text="errors.bank" class="text-danger d-block"></span>
                        </div>

                        <!-- Account No -->
                        <div class="col-md-4">
                            <label for="accountNo" class="form-label">Account No<span
                                    class="text-danger">*</span></label>
                            <input x-model="accountNo" type="text" class="form-control"
                                placeholder="Enter Account No" id="accountNo" required>
                            <span x-text="errors.accountNo" class="text-danger d-block"></span>
                        </div>

                        <!-- Bank Branch -->
                        <div class="col-md-4">
                            <label for="bankBranch" class="form-label">Bank Branch<span
                                    class="text-danger">*</span></label>
                            <input x-model="bankBranch" type="text" class="form-control"
                                placeholder="Enter Bank Branch" id="bankBranch" required>
                            <span x-text="errors.bankBranch" class="text-danger d-block"></span>
                        </div>

                        <!-- Location -->
                        <div class="col-md-4">
                            <label for="location" class="form-label">Location<span class="text-danger">*</span></label>
                            <input x-model="location" type="text" class="form-control" placeholder="Enter Location"
                                id="location" required>
                            <span x-text="errors.location" class="text-danger d-block"></span>
                        </div>

                        <!-- City -->
                        <div class="col-md-4">
                            <label for="city" class="form-label">City<span class="text-danger">*</span></label>
                            <input x-model="city" type="text" class="form-control" placeholder="Enter City"
                                id="city" required>
                            <span x-text="errors.city" class="text-danger d-block"></span>
                        </div>

                        <!-- State -->
                        <div class="col-md-4">
                            <label for="state" class="form-label">State<span class="text-danger">*</span></label>
                            <input x-model="state" type="text" class="form-control" placeholder="Enter State"
                                id="state" required>
                            <span x-text="errors.state" class="text-danger d-block"></span>
                        </div>

                         <!-- RTGS/NEFT No -->
                         <div class="col-md-4" x-show="bankDeposit !== 'Cash Deposit'" x-transition>
                            <label for="RTGS_NEFT_No" class="form-label">RTGS/NEFT No <span
                                    class="text-danger">*</span></label>
                            <input x-model="RTGS_NEFT_No" type="text" class="form-control"
                                placeholder="RTGS/NEFT No" id="RTGS_NEFT_No" required>
                            <span x-text="errors.RTGS_NEFT_No" class="text-danger d-block"></span>
                        </div>

                        

                        <!-- Cash Deposit By -->
                        <div class="col-md-4">
                            <label for="cashDepositBy" class="form-label">Cash Deposit By<span
                                    class="text-danger">*</span></label>
                            <input x-model="cashDepositBy" type="text" class="form-control"
                                placeholder="Enter Cash Deposit By" id="cashDepositBy" required>
                            <span x-text="errors.cashDepositBy" class="text-danger d-block"></span>
                        </div>

                        <!-- Bank Deposit Selection -->
                        <div class="col-4">
                            <label for="bankDeposit" class="form-label">Bank Deposit <span
                                    class="text-danger">*</span></label>
                            <select x-model="bankDeposit" class="form-select">
                                <option value="" selected>Select Bank Deposit</option>
                                <option value="RTGS/NEFT">RTGS/NEFT</option>
                                <option value="Cash Deposit">Cash Deposit</option>
                            </select>
                            <span x-text="errors.bankDeposit" class="text-danger d-block"></span>
                        </div>

                       <!-- Sales Date From -->
                       <div class="col-md-4">
                            <label for="salesDateFrom" class="form-label">Sales Date<span
                                    class="text-danger">*</span></label>
                            <input x-model="salesDateFrom" type="date" class="form-control"
                                placeholder="Enter Sales Date From" id="salesDateFrom" required>
                            <span x-text="errors.salesDateFrom" class="text-danger d-block"></span>
                        </div>

                          <!-- Sales Tender Selection -->
                          <div class="col-4">
                            <label for="salesTender" class="form-label">Sales Tender<span
                                    class="text-danger">*</span></label>
                            <select x-model="salesTender" class="form-select">
                                <option value="" selected>Select Sales Tender</option>
                                <option value="Cash">Cash</option>
                                <option value="HDFC Card">HDFC Card</option>
                                <option value="ICICI Card">ICICI Card</option>
                                <option value="SBI Card">SBI Card </option>
                                <option value="AMEX Card">AMEX Card</option>
                                <option value="HDFC UPI">HDFC UPI </option>
                                <option value="WALLET PAYTM">WALLET PAYTM</option>
                                <option value="WALLET PHONEPE">WALLET PHONEPE</option>
                            </select>
                            <span x-text="errors.bankDeposit" class="text-danger d-block"></span>
                        </div>

                        <!-- Deposit Slip Proof -->
                        <div class="col-md-4">
                            <label for="depositSlipProof" class="form-label">Deposit Slip Proof (Max file size
                                10MB)<span class="text-danger">*</span></label>
                            <input x-on:change="(e) => depositSlipProof = e.target.files[0]" type="file"
                                class="form-control" placeholder="Enter Deposit Slip Proof" id="depositSlipProof"
                                required>
                            <label class="form-label">Accepted File Types PNG, JPG, PDF, CSV, XLSX</label>
                            <span x-text="errors.depositSlipProof" class="text-danger d-block"></span>
                        </div>

                        <!-- Reason -->
                        <div class="col-md-4">
                            <label for="reason" class="form-label">Reason for Direct Deposit<span
                                    class="text-danger">*</span></label>
                            <textarea x-model="reason" class="form-control" placeholder="Enter Reason" id="reason" rows="3" required></textarea>
                            <span x-text="errors.reason" class="text-danger d-block"></span>
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="w-100" style="display: flex; justify-content: flex-end; gap: 1em">
                            <button type="submit" class="btn btn-success btn-sm"
                                :style="{
                                    width: 'fit-content',
                                    opacity: loading ? 0.5 : 1,
                                    pointerEvents: loading ? 'none' : 'all'
                                }"
                                @click="$wire.filtering = false">Submit</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><span>Cancel</span></button>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <div x-show="loading"
                        style="display: block; text-align:left; margin: 0 1em; flex: 1; color: #000">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span>Loading ...</span>
                    </div>
                    <div class="p-2"></div>
                </div>
            </div>
        </div>
    </div>
</div>
