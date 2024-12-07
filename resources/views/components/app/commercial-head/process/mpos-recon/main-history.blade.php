<section class="d-flex " style="flex-direction: column; padding: 0 .8em;" id="">

    <div class="row cash-pickup">
        <div class="col-lg-2">
            <h5>Item</h5>
        </div>

        <div class="col-lg-2 text-center">
            <h5>Approval Date</h5>
        </div>

        <div class="col-lg-2 text-center">
            <h5>Approval Status</h5>
        </div>

        <div class="col-lg-2 text-center">
            <h5>Amount</h5>
        </div>

        <div class="col-lg-2">
            <h5>Remarks</h5>
        </div>

        <div class="col-lg-2">
            <h5 class="text-center">Supporting Documents</h5>
        </div>
    </div>

    @php
    $mainReconData = \App\Models\Process\MPOS\MPOSCashTenderBankDropCashMISRecoApproval::where('CashTenderBkDrpUID' ,$data->CashTenderBkDrpUID)->
    where('isActive',1)
    ->get();
    @endphp

    @foreach ($mainReconData as $main)
    <div x-data="{
        isOpen: false,
    }" class="row mainUploadItems cash-pickup-item">
        <div class="col-lg-2">
            {{ $main->item }}
        </div>
        <div class="col-lg-2 text-center my-auto">
            {{ !$main->approvalDate ? '' : Carbon\Carbon::parse($main->approvalDate, 'UTC')->tz('Asia/Kolkata')->format('d-m-Y h:i A') }}
        </div>

        <div class="col-lg-2 text-center my-auto">
            {{ ucfirst($main->approveStatus == 'disapprove' ? "Rejected" : $main->approveStatus) }}
        </div>

        <div class="col-lg-2 text-center">
            {{ number_format($main->amount, 2) }}
        </div>

        <div class="col-lg-2">
            <p>{{ $main->remarks }}</p>
        </div>

        <div class="col-lg-2">
            <x-viewer.widget document="{{ url('/') }}/storage/app/public/reconciliation/mpos-reconciliation/store-mpos-bankmis/{{ $main->supportDocupload }}" />
        </div>

    </div>
    @endforeach

    <div class="d-flex justify-content-center align-items-start mt-4 mb-3 gap-3">
        <div class="form-group">
            <label for="">Sale Amount</label>
            <input disabled type="text" placeholder="Rs. 0.00" id="recon-amount" value="{{ $data->tenderAmountF }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Deposit Amount</label>
            <input disabled type="text" placeholder="Rs. 0.00" id="recon-deposit-amount" value="{{ $data->depositAmountF }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Difference</label>
            <input disabled type="text" placeholder="Rs. 0.00" id="recon-deposit-amount" value="{{ $data->calculatedDifference }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Approval Status</label>
            <select id="approvalStatus" class="form-control" style="width: 300px">
                <option selected value="">Select Approval Status</option>
                <option value="Approved">Approve</option>
                <option value="Rejected">Reject</option>
            </select>
        </div>

        <div class="form-group">
            <label for="">Remarks</label>
            <textarea id="remarks" style="width: 400px; height: 15vh;" type="text" placeholder="Enter the comments" class="form-control"></textarea>
        </div>
    </div>
</section>
