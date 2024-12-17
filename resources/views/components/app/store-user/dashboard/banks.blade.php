{{-- <div class="d-flex gap-4 gap-lg-2 flex-column flex-md-row w-100 flex-wrap" id="dashboard-main"> --}}
<div class="row">

    @if($tenderStatus == 'cash' || $tenderStatus == 'all')
    <div class="mt-5 col-12 col-md-6 col-lg-6 col-xl-3">
        <x-app.store-user.dashboard.banks-heading heading="Tender Wise Cash Collection" img="{{asset('assets/images/cash.png')}}" />
        <x-app.store-user.dashboard.banks-table-headers>
            @if($tender->HDFCCash == '₹ 0.00' && $tender->ICICICash == '₹ 0.00' && $tender->SBICash == '₹ 0.00' && $tender->IDFCCash == '₹ 0.00' && $tender->AXISCash == '₹ 0.00')
            <tr>
                <td colspan="2" class="text-center">Not available</td>
            </tr>
            @endif

            @if($tender->HDFCCash != '₹ 0.00')
            <tr>
                <td>
                    <img src="{{asset('assets/images/HDFC.png')}}" width="100%" /><span class="hide-text"> HDFC BANK</span>
                </td>
                <td>
                    <h3>
                        <span title="{{ $tender->HDFCCash }}">{{ !$tender->HDFCCash ? ' 0.00' : ' '.$tender->HDFCCash }}</span>
                    </h3>
                </td>
            </tr>
            @endif
            @if($tender->ICICICash != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/ICIC.png')}}" width="100%"> <span class="hide-text"> ICICI BANK</span>
                </td>
                <td>
                    <h3>
                        <span title="{{ $tender->ICICICash }}">{{ !$tender->ICICICash ? ' 0.00' : ' '.$tender->ICICICash }}</span>
                    </h3>
                </td>
            </tr>
            @endif
            @if($tender->SBICash != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/sbi.png')}}" width="100%"><span class="hide-text"> STATE BANK OF INDIA</span>
                </td>

                <td>
                    <h3>
                        <span title="{{ $tender->SBICash }}">{{ !$tender->SBICash ? ' 0.00' : ' '.$tender->SBICash }}</span>
                    </h3>
                </td>
            </tr>
            @endif
            @if($tender->IDFCCash != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/idfc-logo.png')}}" width="100%"><span class="hide-text">IDFC Bank</span></td>
                <td>
                    <h3>
                        <span title="{{ $tender->IDFCCash }}">{{ !$tender->IDFCCash ? ' 0.00' : ' '.$tender->IDFCCash }}</span>
                    </h3>
                </td>
            </tr>
            @endif

            @if($tender->AXISCash != '₹ 0.00')
            <tr>
                <td>
                    <img src="{{asset('assets/images/axis-logo.png')}}" width="100%"><span class="hide-text">Axis Bank</span></td>
                <td>
                    <h3>
                        <span title="{{ $tender->AXISCash }}">{{ !$tender->AXISCash ? ' 0.00' : ' '.$tender->AXISCash }}</span>
                    </h3>
                </td>
            </tr>
            @endif
            @if($tender->CashTotal != '₹ 0.00')
            <tr class='total'>
                <td>
                    TOTAL</td>
                <td>
                    <h3>
                        <span title="{{ $tender->CashTotal }}">{{ !$tender->CashTotal ? ' 0.00': ' '.$tender->CashTotal }}</span>
                    </h3>
                </td>
            </tr>
            @endif
        </x-app.store-user.dashboard.banks-table-headers>
    </div>
    @endif

    @if($tenderStatus == 'card' || $tenderStatus == 'all')

    <div class="mt-5 col-12 col-md-6 col-lg-6 col-xl-3">
        <x-app.store-user.dashboard.banks-heading heading="Tender Wise Card Collection" img="{{asset('assets/images/card.png')}}" />
        <x-app.store-user.dashboard.banks-table-headers>

            @if($tender->HDFCCard == '₹ 0.00' && $tender->ICICICard == '₹ 0.00' && $tender->SBICard == '₹ 0.00' && $tender->AMEXCard == '₹ 0.00')
            <tr>
                <td colspan="2" class="text-center">Not available</td>
            </tr>
            @endif

            @if($tender->HDFCCard != '₹ 0.00')
            <tr>
                <td>
                    <img src="{{asset('assets/images/HDFC.png')}}" width="100%"><span class="hide-text"> HDFC BANK</span></td>
                <td>
                    <h3>
                        <span title="{{ $tender->HDFCCard }}">{{ !$tender->HDFCCard ? ' 0.00' : ' '.$tender->HDFCCard }}</span>
                    </h3>
                </td>
            </tr>
            @endif

            @if($tender->ICICICard != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/ICIC.png')}}" width="100%"> <span class="hide-text">ICICI BANK</span></td>
                <td>
                    <h3>
                        <span title="{{ $tender->ICICICard }}">{{ !$tender->ICICICard ? ' 0.00' : ' '.$tender->ICICICard }}</span>
                    </h3>
                </td>
            </tr>
            @endif
            @if($tender->SBICard != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/sbi.png')}}" width="100%"><span class="hide-text"> SBI BANK</span></td>
                <td>
                    <h3>
                        <span title="{{ $tender->SBICard }}">{{ !$tender->SBICard ? ' 0.00' : ' '.$tender->SBICard }}</span>
                    </h3>
                </td>
            </tr>
            @endif
            @if($tender->AMEXCard != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/amex.png')}}" width="100%"><span class="hide-text">AMEXPOS Card</span></td>
                <td>
                    <h3>
                        <span title="{{ $tender->AMEXCard }}">{{ !$tender->AMEXCard ? ' 0.00' : ' '.$tender->AMEXCard }}</span>
                    </h3>
                </td>
            </tr>
            @endif
            @if($tender->CardTotal != '₹ 0.00')

            <tr class='total'>
                <td>
                    TOTAL</td>
                <td>
                    <h3>
                        <span title="{{ $tender->CardTotal }}">{{ !$tender->CardTotal ? ' 0.00': ' '.$tender->CardTotal }}</span>
                    </h3>
                </td>
            </tr>
            @endif
        </x-app.store-user.dashboard.banks-table-headers>
    </div>
    @endif

    @if($tenderStatus == 'upi' || $tenderStatus == 'all')

    <div class="mt-5 col-12 col-md-6 col-lg-6 col-xl-3">
        <x-app.store-user.dashboard.banks-heading heading="Tender Wise UPI Collection" img="{{asset('assets/images/card.png')}}" />
        <x-app.store-user.dashboard.banks-table-headers>

            @if($tender->UPIH == '₹ 0.00')
            <tr>
                <td colspan="2" class="text-center">Not available</td>
            </tr>
            @endif

            @if($tender->UPIH != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/upi.png')}}" width="100%"> <span class="hide-text">HDFC UPI</span></td>
                <td>
                    <h3>
                        <span title="{{ $tender->UPIH }}">{{ !$tender->UPIH ? ' 0.00' : ' '.$tender->UPIH }}</span>
                    </h3>
                </td>
            </tr>
            @endif

            @if($tender->UPIH != '₹ 0.00')

            <tr class='total'>
                <td>
                    TOTAL</td>
                <td>
                    <h3>
                        <span title="{{ $tender->UPIH }}">{{ !$tender->UPIH ? ' 0.00': ' '.$tender->UPIH }}</span>
                    </h3>
                </td>
            </tr>
            @endif

        </x-app.store-user.dashboard.banks-table-headers>
    </div>
    @endif

    @if($tenderStatus == 'wallet' || $tenderStatus == 'all')

    <div class="mt-5 col-12 col-md-6 col-lg-6 col-xl-3">
        <x-app.store-user.dashboard.banks-heading heading="Tender Wise Wallet Collection" img="{{asset('assets/images/wallet.png')}}" />
        <x-app.store-user.dashboard.banks-table-headers>

            @if($tender->payTM == '₹ 0.00' && $tender->phonePay == '₹ 0.00')
            <tr>
                <td colspan="2" class="text-center">Not available</td>
            </tr>
            @endif

            @if($tender->payTM != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/paytm.png')}}" width="100%"><span class="hide-text">WALLET PAYTM</span></td>
                <td>
                    <h3>
                        <span title="{{ $tender->payTM }}">{{ !$tender->payTM ? ' 0.00': ' '.$tender->payTM }}</span>
                    </h3>
                </td>
            </tr>
            @endif
            @if($tender->phonePay != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/phonepe.png')}}" width="100%"><span class="hide-text">WALLET PHONEPAY</span></td>
                <td>
                    <h3>
                        <span title="{{ $tender->phonePay }}">{{ !$tender->phonePay ? ' 0.00': ' '.$tender->phonePay }}</span>
                    </h3>
                </td>
            </tr>
            @endif
            @if($tender->WalletTotal != '₹ 0.00')

            <tr class='total'>
                <td>
                    TOTAL</td>
                <td>
                    <h3>
                        <span title="{{ $tender->WalletTotal }}">{{ !$tender->WalletTotal ? ' 0.00': ' '.$tender->WalletTotal }}</span>
                    </h3>
                </td>
            </tr>
            @endif
        </x-app.store-user.dashboard.banks-table-headers>
    </div>
    @endif
</div>
