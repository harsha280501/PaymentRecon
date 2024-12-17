<div class="row mb-2">
    <div class="col-lg-12">
        <ul class="nav nav-tabs justify-content-start" role="tablist">
            {{-- <li class="nav-item">
                <a @click="() => {
                        $wire.switchTab('store-missing')
                        reset()
                    }" class="nav-link @if($activeTab === 'store-missing') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#hdfc" style="font-size: .9em !important" href="#" role="tab">StoreID Retek code Missing
                </a>
            </li> --}}

            {{-- <li class="nav-item">
                <a @click="() => {
                        $wire.switchTab('bank-drop-missing')
                        reset()
                    }" class="nav-link @if($activeTab === 'bank-drop-missing') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                    Bankdrop ID Missing
                </a>
            </li> --}}

            <li class="nav-item">
                <a @click="() => {
                        $wire.switchTab('bankdrop-mismatch')
                        reset()
                    }" class="nav-link @if($activeTab === 'bankdrop-mismatch') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                    Bankdrop/Deposit Slip No. Mismatch
                </a>
            </li>
        </ul>
    </div>
    <div class="col-lg-3 d-flex align-items-center justify-content-end">
        <div class="btn-group mb-1">
        </div>
    </div>
</div>
