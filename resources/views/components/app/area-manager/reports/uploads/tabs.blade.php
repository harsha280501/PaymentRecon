<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs justify-content-start" role="tablist">
            {{-- HDFC --}}
            <li class="nav-item">
                <a wire:click="switchTab('hdfc-cash')" class="nav-link @if($activeTab === 'hdfc-cash') active @endif" data-bs-toggle="tab" data-bs-target="#hdfc" href="#" role="tab">
                    {{-- <img src="{{ asset('assets/images/hdfc-logo.png') }}" /> --}}
                    HDFC CASH
                </a>
            </li>
            <li class="nav-item">
                <a wire:click="switchTab('hdfc-card')" class="nav-link @if($activeTab === 'hdfc-card') active @endif" data-bs-toggle="tab" data-bs-target="#hdfc" href="#" role="tab">
                    {{-- <img src="{{ asset('assets/images/hdfc-logo.png') }}" /> --}}
                    HDFC CARD
                </a>
            </li>
            <li class="nav-item">
                <a wire:click="switchTab('hdfc-upi')" class="nav-link @if($activeTab === 'hdfc-upi') active @endif" data-bs-toggle="tab" data-bs-target="#hdfc" href="#" role="tab">
                    {{-- <img src="{{ asset('assets/images/hdfc-logo.png') }}" /> --}}
                    HDFC UPI
                </a>
            </li>

            {{-- Axis --}}
            <li class="nav-item">
                <a wire:click="switchTab('axis-cash')" class="nav-link @if($activeTab === 'axis-cash') active @endif" data-bs-toggle="
                    tab" data-bs-target="#axis" href="#" role="tab">
                    {{-- <img src="{{ asset('assets/images/axis-logo.png') }}" /> --}}
                    AXIS CASH
                </a>
            </li>

            {{-- ICICI --}}
            <li class="nav-item">
                <a wire:click="switchTab('icici-cash')" class="nav-link @if($activeTab === 'icici-cash') active @endif" data-bs-toggle="tab" data-bs-target="#icici" href="#" role="tab">
                    {{-- <img src="{{ asset('assets/images/icici-logo.png') }}" /> --}}
                    ICICI CASH
                </a>
            </li>
            <li class="nav-item">
                <a wire:click="switchTab('icici-card')" class="nav-link @if($activeTab === 'icici-card') active @endif" data-bs-toggle="tab" data-bs-target="#icici" href="#" role="tab">
                    {{-- <img src="{{ asset('assets/images/icici-logo.png') }}" /> --}}
                    ICICI CARD
                </a>
            </li>

            {{-- SBI --}}
            <li class="nav-item">
                <a wire:click="switchTab('sbi-cash')" class="nav-link @if($activeTab === 'sbi-cash') active @endif" data-bs-toggle="
                    tab" data-bs-target="#sbi" href="#" role="tab">
                    {{-- <img src="{{ asset('assets/images/sbi-logo.png') }}" /> --}}
                    SBI CASH
                </a>
            </li>
            <li class="nav-item">
                <a wire:click="switchTab('sbi-card')" class="nav-link @if($activeTab === 'sbi-card') active @endif" data-bs-toggle="
                    tab" data-bs-target="#sbi" href="#" role="tab">
                    {{-- <img src="{{ asset('assets/images/sbi-logo.png') }}" /> --}}
                    SBI CARD
                </a>
            </li>

            {{-- IDFC --}}
            <li class="nav-item">
                <a wire:click="switchTab('idfc-cash')" class="nav-link @if($activeTab === 'idfc-cash') active @endif" data-bs-toggle="
                    tab" data-bs-target="#idfc" href="#" role="tab">
                    {{-- <img src="{{ asset('assets/images/idfc-logo.png') }}" /> --}}
                    IDFC CASH
                </a>
            </li>

            {{-- WALLET --}}
            <li class="nav-item">
                <a wire:click="switchTab('payTm')" class="nav-link @if($activeTab === 'payTm') active @endif" data-bs-toggle="
                    tab" data-bs-target="#idfc" href="#" role="tab">
                    {{-- <img style="width: 30px; object-fit: cover" src="{{ asset('assets/images/wallet.png') }}" /> --}}
                    PAYTM
                </a>
            </li>
            <li class="nav-item">
                <a wire:click="switchTab('phonePe')" class="nav-link @if($activeTab === 'phonePe') active @endif" data-bs-toggle="
                    tab" data-bs-target="#idfc" href="#" role="tab">
                    {{-- <img style="width: 30px; object-fit: cover" src="{{ asset('assets/images/wallet.png') }}" /> --}}
                    PHONEPE
                </a>
            </li>

            {{-- Amex --}}
            <li class="nav-item">
                <a wire:click="switchTab('amexpos-card')" class="nav-link @if($activeTab === 'amexpos-card') active @endif" data-bs-toggle="
                    tab" data-bs-target="#idfc" href="#" role="tab">
                    {{-- <img style="width: 30px; object-fit: cover" src="{{ asset('assets/images/amexpos.png') }}" /> --}}
                    AMEXPOS CARD
                </a>
            </li>
        </ul>
    </div>
</div>
