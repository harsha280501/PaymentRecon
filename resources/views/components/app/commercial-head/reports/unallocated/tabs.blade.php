<div class="col-lg-12">
    <ul class="nav nav-tabs justify-content-start" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if ($activeTab === 'cash') active tab-active @endif"
                style="font-size: .9em !important" href="{{ url('/') }}/chead/reports/un-allocated?tab=cash"
                role="tab">Cash
                Transactions
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @if ($activeTab === 'card') active tab-active @endif" role="tab"
                style="font-size: .9em !important" href="{{ url('/') }}/chead/reports/un-allocated?tab=card">
                Card Transactions
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @if ($activeTab === 'upi') active tab-active @endif" role="tab"
                style="font-size: .9em !important" href="{{ url('/') }}/chead/reports/un-allocated?tab=upi">
                Upi Transactions
            </a>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link @if ($activeTab === 'upi') active tab-active @endif"
                wire:click="$set('activeTab', 'upi')" style="font-size: .9em !important" role="tab">
                UPI Transactions
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link @if ($activeTab === 'wallet') active tab-active @endif"
                style="font-size: .9em !important" href="{{ url('/') }}/chead/reports/un-allocated?tab=wallet">
                Wallet Transactions
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab === 'cash-direct-deposit') active tab-active @endif"
                style="font-size: .9em !important"
                href="{{ url('/') }}/chead/reports/un-allocated?tab=cash-direct-deposit">
                Cash Direct Deposit Reco
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab === 'rtgs-neft-reco') active tab-active @endif"
                style="font-size: .9em !important"
                href="{{ url('/') }}/chead/reports/un-allocated?tab=rtgs-neft-reco">
                RTGS/NEFT Deposit Reco
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($activeTab === 'mismatch-store-recon') active tab-active @endif"
                style="font-size: .9em !important"
                href="{{ url('/') }}/chead/reports/un-allocated?tab=mismatch-store-recon">
                MISMATCH STORE RECON
            </a>
        </li>
    </ul>
</div>
