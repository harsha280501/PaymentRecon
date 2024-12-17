<section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">

    <div class="row cash-pickup">
        <div class="col-lg-3">
            <h5>Item</h5>
        </div>
        <div class="col-lg-2">
            <h5>Sale Amount</h5>
        </div>
        <div class="col-lg-2">
            <h5>Difference Amount</h5>
        </div>
        <div class="col-lg-3">
            <h5>Remarks</h5>
        </div>
        <div class="col-lg-2">
            <h5>Supporting Document</h5>
        </div>
    </div>

    @php
    $mainReconData = DB::table('MLF_Outward_WalletMISBankStReco_ApprovalProcess')
    ->where('walletMisBkStRecoUID' ,$data->walletMisBankStRecoUID)
    ->orderBy('bankStWalletApprovalprocessUID', 'desc')
    ->get();
    @endphp

    @foreach ($mainReconData as $main)
    <div class="row mainUploadItems cash-pickup-item">
        <div class="col-lg-3">
            {{ $main->item }}
        </div>
        <div class="col-lg-2">
            {{ number_format($main->amount, 2) }}
        </div>
        <div class="col-lg-2">
            {{ number_format($main->differenceAmount, 2) }}
        </div>
        <div class="col-lg-3">
            {{ $main->remarks }}
        </div>



        <div style="width: fit-content;">
            <x-viewer.widget document="{{ url('/') }}/storage/app/public/reconciliation/wallet-reconciliation/wallet-bank/{{ $main->supportDocupload }}" />
        </div>
    </div>
    @endforeach

    <div class="d-flex justify-content-end mt-4 mb-3 gap-3">
        <div class="form-group">
            <label for="">Sale Amount</label>
            <input disabled type="text" placeholder="Rs. 0.00" id="recon-amount" value="{{ number_format($data->creditAmount, 2) }}" class="form-control">
        </div>

        @php
        $depositAmount = DB::table('MLF_Outward_WalletMISBankStReco_ApprovalProcess')
        ->where('walletMisBkStRecoUID' , $data->walletMisBankStRecoUID)
        ->sum('amount');

        @endphp


        <div class="form-group">
            <label for="">Deposit Amount</label>
            <input disabled type="text" placeholder="Rs. 0.00" id="recon-deposit-amount" value="{{ number_format($data->depositAmount, 2) }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Store Respons Entry</label>
            <input disabled type="text" placeholder="Rs. 0.00" id="recon-deposit-amount" value="{{ number_format($data->adjAmount, 2) }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Approval Status</label>
            <select id="approvalStatus" class="form-control" style="width: 300px">
                <option selected value="">Select Approval Status</option>
                <option value="approve">Approve</option>
                <option value="disapprove">Reject</option>
            </select>
        </div>

        <div class="form-group">
            <label for="">Remarks</label>
            <textarea id="remarks" style="width: 400px; height: 15vh;" type="text" placeholder="Enter your comments" class="form-control"></textarea>
        </div>
    </div>
</section>
