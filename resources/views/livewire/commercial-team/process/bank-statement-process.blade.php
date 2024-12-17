<section id="recent" class="process-page" x-data="{
    start: null,
    end: null,

    reset() {
        this.start = null;
        this.end = null;
    }
}">

    <div class="row mb-4">
        <div class="col-lg-9">
            <ul class="nav nav-tabs justify-content-start" role="tablist">
                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('cash')
                        reset()   
                    }" class="nav-link @if($activeTab === 'cash') active tab-active @endif" data-bs-toggle="tab"
                        href="#" role="tab" style="font-size: .8em !important">
                        CASH MIS TO BANK STATEMENT RECON
                    </a>
                </li>
                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('card')
                        reset()   
                    }" class="nav-link @if($activeTab === 'card') active tab-active @endif" data-bs-toggle="
                            tab" href="#" role="tab" style="font-size: .8em !important">
                        CARD MIS TO BANK STATEMENT RECON
                    </a>
                </li>
                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('wallet')
                        reset()   
                    }" class="nav-link @if($activeTab === 'wallet') active tab-active @endif" data-bs-toggle="
                            tab" href="#" role="tab" style="font-size: .8em !important">
                        WALLET MIS TO BANK STATEMENT RECON
                    </a>
                </li>
                <li class="nav-item">
                    <a @click="() => {
                        $wire.switchTab('upi')
                        reset()   
                    }" class="nav-link @if($activeTab === 'upi') active tab-active @endif" data-bs-toggle="
                            tab" href="#" role="tab" style="font-size: .8em !important">
                        UPI MIS TO BANK STATEMENT RECON
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-lg-3 d-flex align-items-center justify-content-end">
            <div class="btn-group mb-1">
            </div>
        </div>
    </div>

    <x-app.commercial-head.process.cash-recon.filters :filtering="$filtering" :activeTab="$activeTab"
        :cashStores="$cash_stores" :cardStores="$card_stores" :walletStores="$wallet_stores" :upiStores="$upi_stores"
        :cashCodes="$cash_codes" :walletCodes="$wallet_codes" :upiCodes="$upi_codes" :cardCodes="$card_codes"
        :months="$_months" />

    <div class="row">
        <div class="col-lg-12">

            <x-scrollable.scrollable :dataset="$dataset">
                <x-scrollable.scroll-head>

                    @if($activeTab == 'cash')

                    <tr>
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Credit Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                    class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                            </div>
                        </th>
                        <th>Retek Code</th>
                        <th>Brand</th>
                        <th>Slip No.</th>
                        <th>Bank</th>
                        <th>Ref no.</th>
                        <th>Collection Amount</th>
                        <th>Credit Amount</th>
                        <th>Difference Amount</th>
                        <th>Status</th>
                        <th>Recon Status</th>
                        <th>Submit Recon</th>
                    </tr>
                    @endif

                    @if($activeTab == 'card')

                    <tr>
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Credit Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                    class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                            </div>
                        </th>
                        <th>Retek Code</th>
                        <th>Brand</th>
                        {{-- <th>Card</th> --}}
                        <th>TID / MID</th>
                        <th>Sale Amount</th>
                        <th>Bank</th>
                        <th>Date</th>
                        {{-- <th>Ref. no.</th> --}}
                        <th>Collection Amount</th>
                        <th>Difference Amount</th>
                        <th>Status</th>
                        <th>Recon Status</th>

                        <th>Submit Recon</th>
                    </tr>

                    @endif


                    @if($activeTab == 'wallet')

                    <tr>
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Credit Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                    class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                            </div>
                        </th>
                        <th>Retek Code</th>
                        <th>Brand</th>
                        {{-- <th>Card</th> --}}
                        <th>TID / MID</th>
                        <th>Bank</th>
                        <th>Date</th>
                        {{-- <th>Ref. no.</th> --}}
                        <th>Collection Amount</th>
                        <th>Sale Amount</th>
                        <th>Difference Amount</th>
                        <th>Status</th>
                        <th>Recon Status</th>
                        <th>Submit Recon</th>
                    </tr>

                    @endif

                    @if($activeTab == 'upi')
                    <tr>
                        <th>
                            <div class="d-flex align-items-center gap-2">
                                <span>Credit Date</span>
                                <i style="opacity: .5; font-size: 1.8em" wire:click="orderBy()"
                                    class="fa-solid @if($orderBy == 'asc') fa-caret-up @else fa-caret-down @endif"></i>
                            </div>
                        </th>
                        <th>Retek Code</th>
                        <th>Brand</th>
                        <th>TID / MID</th>
                        <th>Sale Amount</th>
                        <th>Bank</th>
                        <th>Date</th>
                        <th>Collection Amount</th>
                        <th>Difference Amount</th>
                        <th>Status</th>
                        <th>Recon Status</th>
                        <th>Submit Recon</th>
                    </tr>
                    @endif


                </x-scrollable.scroll-head>

                <x-scrollable.scroll-body>

                    @if($activeTab == 'cash')

                    @foreach ($dataset as $data)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}</td>
                        <td>{{ $data->retekCode }}</td>
                        <td>{{ $data->brand }}</td>
                        <td>{{ $data->depostSlipNo }}</td>
                        <td>{{ $data->colBank }}</td>
                        <td>{{ $data->refNo }}</td>

                        <td>{{ number_format($data->depositAmount, 2) }}</td>
                        <td>{{ number_format($data->creditAmount) }}</td>
                        <td>{{ number_format($data->diffSaleDeposit, 2) }}</td>

                        <td style="font-weight: 700; color: @if($data->status === 'Matched') teal @else red @endif">
                            {{ $data->status }}
                        </td>
                        <td>{{ $data->reconStatus == 'disapprove' ? 'Rejected' : $data->reconStatus }}</td>
                        <td>
                            <a href="#" style="font-size: 1.1em"
                                data-bs-target="#exampleModalCenterSecondTab_{{ $data->cashMisBkStRecoUID }}"
                                data-bs-toggle="modal">View</a>
                        </td>
                    </tr>

                    <div class="modal fade" id="exampleModalCenterSecondTab_{{ $data->cashMisBkStRecoUID }}"
                        tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered " role="document" style="max-width:90%;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Cash to Bank Statement Reconciliation</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="forms-sample">
                                        <div class="row" style="margin-bottom: -20px">
                                            <h5>Reconciliation dashboard</h5>
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
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">
                                                        <h5>Location : </h5>
                                                    </label>
                                                    <label for="exampleInputUsername1">
                                                        <h5>{{ $data->Location }}</h5>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: -20px">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">
                                                        <h5>Pickup Bank : </h5>
                                                    </label>
                                                    <label for="exampleInputUsername1">
                                                        <h5>{{ $data->colBank }}</h5>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">
                                                        <h5>Reconciliation Date : </h5>
                                                    </label>
                                                    <label for="exampleInputUsername1">
                                                        <h5>{{ Carbon\Carbon::parse($data->processDt)->format('d-m-Y')
                                                            }}</h5>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                    <h5>Reconciliation Window </h5>
                                    <section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">
                                        @if($data->reconStatus == 'disapprove')
                                        <div class="row cash-pickup">
                                            <div class="col-lg-3">
                                                <h5>Expected Deposit Date</h5>
                                            </div>

                                            <div class="col-lg-2">
                                                <h5>Credit Amount</h5>
                                            </div>
                                            <div class="col-lg-2">
                                                <h5>Collection Amount</h5>
                                            </div>
                                            <div class="col-lg-2">
                                                <h5>Difference [Sale-Collection]</h5>
                                            </div>
                                            <div class="col-lg-3">
                                                <h5>Reason for Disapproval</h5>
                                            </div>
                                        </div>

                                        <div class="row cash-pickup-item">
                                            <div class="col-lg-3">
                                                {{ Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}
                                            </div>

                                            <div class="col-lg-2">
                                                {{ number_format($data->creditAmount, 2) }}
                                            </div>
                                            <div class="col-lg-2">
                                                {{ number_format($data->depositAmount, 2) }}
                                            </div>
                                            <div class="col-lg-2">
                                                {{ number_format($data->diffSaleDeposit, 2) }}
                                            </div>
                                            <div class="col-lg-3">
                                                {{ $data->approvalRemarks }}
                                            </div>
                                        </div>
                                        @else
                                        <div class="row cash-pickup">
                                            <div class="col-lg-3">
                                                <h5>Expected Deposit Date</h5>
                                            </div>

                                            <div class="col-lg-3">
                                                <h5>Credit Amount</h5>
                                            </div>
                                            <div class="col-lg-3">
                                                <h5>Collection Amount</h5>
                                            </div>
                                            <div class="col-lg-3">
                                                <h5>Difference [Sale-Collection]</h5>
                                            </div>

                                        </div>

                                        <div class="row cash-pickup-item">
                                            <div class="col-lg-3">
                                                {{ Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}
                                            </div>

                                            <div class="col-lg-3">
                                                {{ number_format($data->creditAmount, 2) }}
                                            </div>
                                            <div class="col-lg-3">
                                                {{ number_format($data->depositAmount, 2) }}
                                            </div>
                                            <div class="col-lg-3">
                                                {{ number_format($data->diffSaleDeposit, 2) }}
                                            </div>
                                        </div>
                                        @endif

                                    </section>
                                    <br>

                                    <h5>Manual Entry By Store for reconciliation</h5>
                                    <section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">

                                        <div class="row cash-pickup">
                                            <div class="col-lg-3">
                                                <h5>Item</h5>
                                            </div>
                                            <div class="col-lg-1 text-center">
                                                <h5>Bank Name</h5>
                                            </div>
                                            <div class="col-lg-1 text-center">
                                                <h5>Credit Date</h5>
                                            </div>

                                            <div class="col-lg-2 text-center">
                                                <h5>Ref. No.
                                                </h5>
                                            </div>

                                            <div class="col-lg-1 text-center">
                                                <h5>Amount</h5>
                                            </div>

                                            <div class="col-lg-1 text-center">
                                                <h5>Difference</h5>
                                            </div>

                                            <div class="col-lg-2">
                                                <h5>Remarks</h5>
                                            </div>

                                            <div class="col-lg-1 text-center">
                                                <h5>Supporting Documents</h5>
                                            </div>
                                        </div>

                                        @php
                                        $mainReconData = DB::table('MLF_Outward_CashMISBankStReco_ApprovalProcess')
                                        ->where('cashMisBkStRecoUID' ,$data->cashMisBkStRecoUID)
                                        ->get();
                                        @endphp

                                        @foreach ($mainReconData as $main)
                                        <div class="row mainUploadItems cash-pickup-item">
                                            <div class="col-lg-3">
                                                {{ $main->item }}
                                            </div>
                                            <div class="col-lg-1 text-center">
                                                {{ $main->bankName }}
                                            </div>
                                            <div class="col-lg-1 text-center">
                                                {{ Carbon\Carbon::parse($main->creditDate)->format('d-m-Y') }}
                                            </div>

                                            <div class="col-lg-2 text-center">
                                                {{ $main->slipnoORReferenceNo }}
                                            </div>
                                            <div class="col-lg-1 text-center">
                                                {{ number_format($main->amount, 2) }}
                                            </div>
                                            <div class="col-lg-1 text-center">
                                                {{ number_format($main->differenceAmount, 2) }}
                                            </div>
                                            <div class="col-lg-2">
                                                {{ $main->remarks }}
                                            </div>

                                            <div class="col-lg-1 pt-2 d-flex gap-3 justify-content-center">
                                                @if ($main->supportDocupload && $main->supportDocupload != 'undefined')
                                                <a download style="text-decoration: none"
                                                    href="{{ url('/') }}/storage/app/public/reconciliation/cash-reconciliation/cash-bank/{{ $main->supportDocupload }}">
                                                    <i class="fa-solid fa-download"></i>
                                                </a>
                                                @else
                                                <p class="text-center" style="margin-top: -10px">NO FILE</p>
                                                @endif

                                            </div>
                                        </div>
                                        @endforeach

                                        <div class="d-flex justify-content-end mt-4 mb-3 gap-3">
                                            <div class="form-group">
                                                <label for="">Sale Amount</label>
                                                <input disabled type="text" placeholder="Rs. 0.00" id="recon-amount"
                                                    value="{{ number_format($data->creditAmount, 2) }}"
                                                    class="form-control">
                                            </div>

                                            @php
                                            $depositAmount = DB::table('MLF_Outward_CashMISBankStReco_ApprovalProcess')
                                            ->where('cashMisBkStRecoUID' ,$data->cashMisBkStRecoUID)
                                            ->sum('differenceAmount');

                                            @endphp


                                            <div class="form-group">
                                                <label for="">Deposit Amount</label>
                                                <input disabled type="text" placeholder="Rs. 0.00"
                                                    id="recon-deposit-amount"
                                                    value="{{ number_format($data->depositAmount, 2) }}"
                                                    class="form-control">
                                            </div>


                                            <div class="form-group">
                                                <label for="">Adjustment Amount</label>
                                                <input disabled type="text" placeholder="Rs. 0.00"
                                                    id="recon-deposit-amount"
                                                    value="{{ number_format($data->adjAmount, 2) }}"
                                                    class="form-control">
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
                                                <textarea id="remarks" style="width: 400px; height: 15vh;" type="text"
                                                    placeholder="Enter the comments" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </section>

                                </div>
                                <div class="modal-footer">

                                    <div class="footer-loading-btn"
                                        style="display: none; text-align:left; margin: 0 1em; flex: 1; color: #000">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span>Loading ...</span>
                                    </div>

                                    <button x-data
                                        @click="(e) => cashApproval(e, 'exampleModalCenterSecondTab_{{ $data->cashMisBkStRecoUID }}')"
                                        style="" data-id="{{ $data->cashMisBkStRecoUID }}" type="button"
                                        id="modalSubmitButton" class="btn btn-success green">Save</button>


                                    <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    @endforeach

                    @endif

                    @if($activeTab == 'card')

                    @foreach ($dataset as $data)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}</td>
                        <td>{{ $data->retekCode }}</td>
                        <td>{{ $data->brand }}</td>
                        <td>{{ $data->tid }}</td>
                        <td>{{ number_format($data->creditAmount, 2) }}</td>
                        <td>{{ $data->colBank }}</td>
                        <td>{{ Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                        <td>{{ number_format($data->depositAmount) }}</td>
                        <td>{{ number_format($data->diffSaleDeposit, 2) }}</td>

                        <td style="font-weight: 700; color: @if($data->status === 'Matched') teal @else red @endif">
                            {{ $data->status }}
                        </td>
                        <td>{{ $data->reconStatus == 'disapprove' ? 'Rejected' : $data->reconStatus }}</td>

                        <td> <a href="#" style="font-size: 1.1em"
                                data-bs-target="#exampleModalCenterSecondTab_{{ $data->cardMisBankStRecoUID }}"
                                data-bs-toggle="modal">View</a></td>
                    </tr>


                    <div class="modal fade" id="exampleModalCenterSecondTab_{{ $data->cardMisBankStRecoUID }}"
                        tabindex="1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered " role="document" style="max-width:90%;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Card to Bank Statement Reconciliation</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="forms-sample">
                                        <div class="row" style="margin-bottom: -20px">
                                            <h5>Reconciliation dashboard</h5>
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
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">
                                                        <h5>Location : </h5>
                                                    </label>
                                                    <label for="exampleInputUsername1">
                                                        <h5>{{ $data->Location }}</h5>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom: -20px">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">
                                                        <h5>Pickup Bank : </h5>
                                                    </label>
                                                    <label for="exampleInputUsername1">
                                                        <h5>{{ $data->colBank }}</h5>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">
                                                        <h5>Reconciliation Date : </h5>
                                                    </label>
                                                    <label for="exampleInputUsername1">
                                                        <h5>{{ Carbon\Carbon::parse($data->processDt)->format('d-m-Y')
                                                            }}</h5>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </form>

                                    <h5>Reconciliation Window </h5>
                                    <section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">
                                        @if($data->reconStatus == 'disapprove')
                                        <div class="row cash-pickup">
                                            <div class="col-lg-3">
                                                <h5>Expected Deposit Date</h5>
                                            </div>

                                            <div class="col-lg-2">
                                                <h5>Credit Amount</h5>
                                            </div>
                                            <div class="col-lg-2">
                                                <h5>Collection Amount</h5>
                                            </div>
                                            <div class="col-lg-2">
                                                <h5>Difference [Sale-Collection]</h5>
                                            </div>
                                            <div class="col-lg-3">
                                                <h5>Reason for Disapproval</h5>
                                            </div>
                                        </div>

                                        <div class="row cash-pickup-item">
                                            <div class="col-lg-3">
                                                {{ Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}
                                            </div>

                                            <div class="col-lg-2">
                                                {{ number_format($data->creditAmount, 2) }}
                                            </div>

                                            <div class="col-lg-2">
                                                {{ number_format($data->depositAmount, 2) }}
                                            </div>
                                            <div class="col-lg-2">
                                                {{ number_format($data->diffSaleDeposit, 2) }}
                                            </div>

                                            <div class="col-lg-3">
                                                {{ $data->approvalRemarks }}
                                            </div>
                                        </div>
                                        @else
                                        <div class="row cash-pickup">
                                            <div class="col-lg-3">
                                                <h5>Expected Deposit Date</h5>
                                            </div>

                                            <div class="col-lg-3">
                                                <h5>Credit Amount</h5>
                                            </div>
                                            <div class="col-lg-3">
                                                <h5>Collection Amount</h5>
                                            </div>
                                            <div class="col-lg-3">
                                                <h5>Difference [Sale-Collection]</h5>
                                            </div>

                                        </div>

                                        <div class="row cash-pickup-item">
                                            <div class="col-lg-3">
                                                {{ Carbon\Carbon::parse($data->crDt)->format('d-m-Y') }}
                                            </div>

                                            <div class="col-lg-3">
                                                {{ number_format($data->creditAmount, 2) }}
                                            </div>

                                            <div class="col-lg-3">
                                                {{ number_format($data->depositAmount, 2) }}
                                            </div>
                                            <div class="col-lg-3">
                                                {{ number_format($data->diffSaleDeposit, 2) }}
                                            </div>
                                        </div>
                                        @endif

                                    </section>
                                    <br>

                                    <h5>Manual Entry By Store for reconciliation</h5>
                                    <section class="d-flex" style="flex-direction: column; padding: 0 .8em;" id="">

                                        <div class="row cash-pickup">
                                            <div class="col-lg-3">
                                                <h5>Item</h5>
                                            </div>
                                            <div class="col-lg-1 text-center">
                                                <h5>Bank Name</h5>
                                            </div>
                                            <div class="col-lg-1 text-center">
                                                <h5>Credit Date</h5>
                                            </div>

                                            <div class="col-lg-1 text-center">
                                                <h5>Ref. No.
                                                </h5>
                                            </div>

                                            <div class="col-lg-1 text-center">
                                                <h5>Amount</h5>
                                            </div>

                                            <div class="col-lg-2">
                                                <h5>Remarks</h5>
                                            </div>

                                            <div class="col-lg-2">
                                                <h5>Supporting Documents</h5>
                                            </div>
                                        </div>

                                        @php
                                        $mainReconData = DB::table('MLF_Outward_CardMISBankStReco_ApprovalProcess')
                                        ->where('cardMisBkStRecoUID' ,$data->cardMisBankStRecoUID)
                                        ->get();
                                        @endphp

                                        @foreach ($mainReconData as $main)
                                        <div class="row mainUploadItems cash-pickup-item">
                                            <div class="col-lg-3">
                                                {{ $main->item }}
                                            </div>
                                            <div class="col-lg-1 text-center">
                                                {{ $main->bankName }}
                                            </div>
                                            <div class="col-lg-1 text-center">
                                                {{ Carbon\Carbon::parse($main->creditDate)->format('d-m-Y') }}
                                            </div>

                                            <div class="col-lg-1 text-center">
                                                {{ $main->slipnoORReferenceNo }}
                                            </div>

                                            <div class="col-lg-1 text-center">
                                                {{ number_format($main->amount, 2) }}
                                            </div>

                                            <div class="col-lg-2">
                                                {{ $main->remarks }}
                                            </div>

                                            <div class="col-lg-2 pt-2 d-flex gap-3 justify-content-start">
                                                @if ($main->supportDocupload && $main->supportDocupload != 'undefined')
                                                <a download style="text-decoration: none"
                                                    href="{{ url('/') }}/storage/app/public/reconciliation/card-reconciliation/card-bank/{{ $main->supportDocupload }}">
                                                    <i class="fa-solid fa-download"></i> Download
                                                </a>
                                                @else
                                                <p style="margin-top: -10px" class="text-center">NO FILE</p>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach

                                        <div class="d-flex justify-content-end mt-4 mb-3 gap-3">
                                            <div class="form-group">
                                                <label for="">Sale Amount</label>
                                                <input disabled type="text" placeholder="Rs. 0.00" id="recon-amount"
                                                    value="{{ number_format($data->creditAmount, 2) }}"
                                                    class="form-control">
                                            </div>

                                            @php
                                            $depositAmount = DB::table('MLF_Outward_CardMISBankStReco_ApprovalProcess')
                                            ->where('cardMisBkStRecoUID' ,$data->cardMisBankStRecoUID)
                                            ->sum('differenceAmount');

                                            @endphp


                                            <div class="form-group">
                                                <label for="">Deposit Amount</label>
                                                <input disabled type="text" placeholder="Rs. 0.00"
                                                    id="recon-deposit-amount"
                                                    value="{{ number_format($data->depositAmount) }}"
                                                    class="form-control">
                                            </div>



                                            <div class="form-group">
                                                <label for="">Adjustment Amount</label>
                                                <input disabled type="text" placeholder="Rs. 0.00"
                                                    id="recon-deposit-amount"
                                                    value="{{ number_format($data->adjAmount, 2) }}"
                                                    class="form-control">
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
                                                <textarea id="remarks" style="width: 400px; height: 15vh;" type="text"
                                                    placeholder="Enter the comments" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </section>

                                </div>
                                <div class="modal-footer">

                                    <div class="footer-loading-btn"
                                        style="display: none; text-align:left; margin: 0 1em; flex: 1; color: #000">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span>Loading ...</span>
                                    </div>

                                    <button x-data
                                        @click="(e) => cardApproval(e, 'exampleModalCenterSecondTab_{{ $data->cardMisBankStRecoUID }}')"
                                        style="" data-id="{{ $data->cardMisBankStRecoUID }}" type="button"
                                        id="modalSubmitButton" class="btn btn-success green">Save</button>

                                    <button type="button" class="btn grey" data-bs-dismiss="modal">Cancel</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach

                    @endif

                    @if($activeTab == 'wallet')

                    @foreach ($dataset as $data)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($data->creditDt)->format('d-m-Y') }}</td>
                        <td>{{ $data->retekCode }}</td>
                        <td>{{ $data->brand }}</td>
                        <td>{{ $data->tid }}</td>
                        <td>{{ $data->colBank }}</td>
                        <td>{{ Carbon\Carbon::parse($data->depositDt)->format('d-m-Y') }}</td>
                        <td>{{ number_format($data->depositAmount) }}</td>
                        <td>{{ number_format($data->creditAmount, 2) }}</td>
                        <td>{{ number_format($data->diffSaleDeposit, 2) }}</td>
                        <td>{{ $data->status }}</td>
                        <td>{{ $data->reconStatus == 'disapprove' ? 'Rejected' : $data->reconStatus }}</td>
                        <td> <a href="#" style="font-size: 1.1em"
                                data-bs-target="#exampleModalCenterSecondTab_{{ $data->walletMisBankStRecoUID }}"
                                data-bs-toggle="modal">View</a></td>
                    </tr>
                    <x-app.commercial-head.process.wallet-recon.bank-popup-modal :data="$data" />

                    @endforeach

                    @endif

                    @if($activeTab == 'upi')

                    @foreach ($dataset as $data)
                    <x-app.commercial-head.process.upi-recon.upi-bank-table-dataset :data="$data" />
                    {{-- Modal --}}
                    <x-app.commercial-head.process.upi-recon.modal :data="$data" />
                    @endforeach

                    @endtab
                </x-scrollable.scroll-body>
            </x-scrollable.scrollable>
        </div>
    </div>

    <script>
        var $j = jQuery.noConflict();
        $j('.searchField').select2();


        document.addEventListener('livewire:load', function() {

            $j('#select01-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });

            $j('#select02-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });

            $j('#select03-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });

            $j('#select04-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('store', e.target.value);
            });

            $j('#select11-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });

            $j('#select12-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });

            $j('#select13-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });

            $j('#select14-dropdown').on('change', function(e) {
                @this.set('filtering', true);
                @this.set('code', e.target.value);
            });


        });

    </script>

</section>