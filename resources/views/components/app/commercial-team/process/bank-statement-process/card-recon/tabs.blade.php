<div class="row mb-4">
    <div class="col-lg-9">
        <ul class="nav nav-tabs justify-content-start" role="tablist">
            {{-- <li class="nav-item">
                <a wire:click="switchTab('store2card')" class="nav-link @if($activeTab === 'store2card') active tab-active @endif" data-bs-toggle="tab" href="#" role="tab" style="font-size: .8em !important">STORE TO CARD MIS
                </a>
            </li> --}}
            <li class="nav-item">
                <a wire:click="switchTab('card2bank')" class="nav-link @if($activeTab === 'card2bank') active tab-active @endif" data-bs-toggle="
                        tab" href="#" role="tab" style="font-size: .8em !important">
                    CARD MIS TO BANK STATEMENT
                </a>
            </li>
        </ul>
    </div>
    <div class="col-lg-3 d-flex align-items-center justify-content-end">
        <div class="btn-group mb-1">
        </div>
    </div>
</div>
