<div class="row mb-4">
    <div class="col-lg-9">
        <ul class="nav nav-tabs justify-content-start" role="tablist">
            <li class="nav-item">
                <a wire:click="switchTab('card')" class="nav-link @if($activeTab === 'card') active tab-active @endif" data-bs-toggle="
                tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                    CARD RECONCILITION Process
                </a>
            </li>

            <li class="nav-item">
                <a wire:click="switchTab('wallet')" class="nav-link @if($activeTab === 'wallet') active tab-active @endif" data-bs-toggle="
                tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                    WALLET RECONCILIATION Process
                </a>
            </li>
        </ul>
    </div>
    <div class="col-lg-3 d-flex align-items-center justify-content-end">
        <div class="btn-group mb-1">
        </div>
    </div>
</div>
