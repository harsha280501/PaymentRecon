<div class="row mb-4">
    <div class="col-lg-9">
        <ul class="nav nav-tabs justify-content-start" role="tablist">
            <li class="nav-item">
                <a @click="() => {
                    $wire.switchTab('card')
                    reset()
                }" class="nav-link @if($activeTab === 'card') active tab-active @endif" data-bs-toggle="tab" href="#" role="tab" style="font-size: .8em !important">CARD RECONCILIATION
                </a>
            </li>
            <li class="nav-item">
                <a @click="() => {
                    $wire.switchTab('wallet')
                    reset()
                }" class="nav-link @if($activeTab === 'wallet') active tab-active @endif" data-bs-toggle="tab" href="#" role="tab" style="font-size: .8em !important">WALLET RECONCILIATION
                </a>
            </li>
        </ul>
    </div>
    <div class="col-lg-3 d-flex align-items-center justify-content-end">
        <div class="btn-group mb-1">
        </div>
    </div>
</div>
