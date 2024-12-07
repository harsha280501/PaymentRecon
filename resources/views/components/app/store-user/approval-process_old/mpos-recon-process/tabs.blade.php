<div class="row mb-4">
    <div class="col-lg-9">
        <ul class="nav nav-tabs justify-content-start" role="tablist">
            {{-- <li class="nav-item">
                <a wire:click="switchTab('cash')" class="nav-link @if($activeTab === 'cash') active tab-active @endif" data-bs-toggle="
                tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                    MPOS CASH TENDER TO BANK DROP RECONCILITION Process
                </a>
            </li> --}}
            {{-- <li class="nav-item">
                <a wire:click="switchTab('cashmis')" class="nav-link @if($activeTab === 'cashmis') active tab-active @endif" data-bs-toggle="
                tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
                    BANK DROP TO CASH MIS RECONCILIATION Process
                </a>
            </li> --}}

            <li class="nav-item">
                <a wire:click="switchTab('main')" class="nav-link @if($activeTab === 'main') active tab-active @endif" data-bs-toggle="
                tab" data-bs-target="#axis" role="tab" style="font-size: .8em !important" href="#">
                    CASH - TENDER TO BANKDROP TO BANKMIS
                </a>
            </li>
        </ul>
    </div>
    <div class="col-lg-3 d-flex align-items-center justify-content-end">
        <div class="btn-group mb-1">
        </div>
    </div>
</div>
