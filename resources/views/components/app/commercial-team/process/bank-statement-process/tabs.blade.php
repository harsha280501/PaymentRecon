<div class="row mb-4">
    <div class="col-lg-9">
        <ul class="nav nav-tabs justify-content-start" role="tablist">
            <li class="nav-item">
                <a @click="() => {
                    reset()
                    $wire.switchTab('cash')
                }" class="nav-link @if($activeTab === 'cash') active tab-active @endif" data-bs-toggle="tab" href="#" role="tab" style="font-size: .8em !important">CASH MIS TO BANK STATEMENT
                </a>
            </li>
            <li class="nav-item">
                <a @click="() => {
                    reset()
                    $wire.switchTab('card')
                }" class="nav-link @if($activeTab === 'card') active tab-active @endif" data-bs-toggle="
                        tab" href="#" role="tab" style="font-size: .8em !important">
                    CARD MIS TO BANK STATEMENT
                </a>
            </li>

            <li class="nav-item">
                <a @click="() => {
                    reset()
                    $wire.switchTab('upi')
                }" class="nav-link @if($activeTab === 'upi') active tab-active @endif" data-bs-toggle="
                        tab" href="#" role="tab" style="font-size: .8em !important">
                    UPI MIS TO BANK STATEMENT
                </a>
            </li>
            <li class="nav-item">
                <a @click="() => {
                    reset()
                    $wire.switchTab('wallet')
                }" class="nav-link @if($activeTab === 'wallet') active tab-active @endif" data-bs-toggle="
                        tab" href="#" role="tab" style="font-size: .8em !important">
                    WALLET MIS TO BANK STATEMENT
                </a>
            </li>
        </ul>
    </div>
    <div class="col-lg-3 d-flex align-items-center justify-content-end">
        <div class="btn-group mb-1">
        </div>
    </div>
</div>
