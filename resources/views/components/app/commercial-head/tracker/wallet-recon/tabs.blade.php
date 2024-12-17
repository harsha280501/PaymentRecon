<x-tabs.page>
    <li class="nav-item">
        <a wire:click="switchTab('store2wallet')" class="nav-link @if($activeTab === 'store2wallet') active tab-active @endif" data-bs-toggle="tab" data-bs-target="#hdfc" href="#" role="tab">Store To Wallet MIS
        </a>
    </li>
    <li class="nav-item">
        <a wire:click="switchTab('wallet2bank')" class="nav-link @if($activeTab === 'wallet2bank') active tab-active @endif" data-bs-toggle="
                tab" data-bs-target="#axis" role="tab" href="#">
            WALLET MIS to Bank Statement
        </a>
    </li>

    <li class="nav-item">
        <a wire:click="switchTab('processed')" class="nav-link @if($activeTab === 'processed') active tab-active @endif" data-bs-toggle="
                tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
            Wallet Reconciliation Process
        </a>
    </li>

    <li class="nav-item">
        <a wire:click="switchTab('wallet-bank-process')" class="nav-link @if($activeTab === 'wallet-bank-process') active tab-active @endif" data-bs-toggle="
                tab" data-bs-target="#axis" role="tab" style="font-size: .9em !important" href="#">
            Wallet to Bank Statement Reconciliation Process
        </a>
    </li>
</x-tabs.page>
