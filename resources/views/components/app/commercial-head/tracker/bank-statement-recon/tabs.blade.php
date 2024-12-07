<div class="row mb-4">
    <div class="col-lg-9">
        <ul class="nav nav-tabs justify-content-start" role="tablist">
            <li class="nav-item">
                <a wire:click="switchTab('cash')" class="nav-link @if($activeTab === 'cash') active tab-active @endif" data-bs-toggle="
                tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                    CASH MIS to Bank Statement
                </a>
            </li>

            {{-- <li class="nav-item">
                <a wire:click="switchTab('card')" class="nav-link @if($activeTab === 'card') active tab-active @endif" data-bs-toggle="
                tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                    CARD MIS to Bank Statement
                </a>
            </li>

            <li class="nav-item">
                <a wire:click="switchTab('upi')" class="nav-link @if($activeTab === 'upi') active tab-active @endif" data-bs-toggle="
                tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                    UPI MIS to Bank Statement
                </a>
            </li>

            <li class="nav-item">
                <a wire:click="switchTab('wallet')" class="nav-link @if($activeTab === 'wallet') active tab-active @endif" data-bs-toggle="
                tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                    WALLET MIS to Bank Statement
                </a>
            </li> --}}
        </ul>
    </div>
    <div class="col-lg-3 d-flex align-items-center justify-content-end">
        <div class="btn-group mb-1">
        </div>
    </div>
</div>
