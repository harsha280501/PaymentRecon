<div class="row mb-4">
    <div class="col-lg-9">
        <ul class="nav nav-tabs justify-content-start" role="tablist">
            <li class="nav-item">
                <a wire:click="switchTab('store2cash')" class="nav-link @if($activeTab === 'store2cash') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#hdfc" role="tab" style="font-size: .8em !important" href="#">Store To CASH MIS
                </a>
            </li>
            <li class="nav-item">
                <a wire:click="switchTab('cash2bank')" class="nav-link @if($activeTab === 'cash2bank') active tab-active @endif" data-bs-toggle="
                tab" data-bs-target="#axis" role="tab" style="font-size: .8em !important" href="#">
                    CASH MIS to Bank Statement
                </a>
            </li>
            <li class="nav-item">
                <a wire:click="switchTab('processed')" class="nav-link @if($activeTab === 'processed') active tab-active @endif" data-bs-toggle="
                tab" data-bs-target="#axis" role="tab" style="font-size: .8em !important" href="#">
                    Cash Reconciliation Process
                </a>
            </li>

            <li class="nav-item">
                <a wire:click="switchTab('cash-bank-process')" class="nav-link @if($activeTab === 'cash-bank-process') active tab-active @endif" data-bs-toggle="
                tab" data-bs-target="#axis" role="tab" style="font-size: .8em !important" href="#">
                    Cash to Bank Statement Reconciliation Process
                </a>
            </li>
        </ul>
    </div>
    <div class="col-lg-3 d-flex align-items-center justify-content-end">
        <div class="btn-group mb-1">
        </div>
    </div>
</div>
