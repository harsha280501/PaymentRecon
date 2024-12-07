<div class="row">
    @if($tenderStatus == 'cash' || $tenderStatus == 'all')
    <div class="mt-5 col-12 col-md-6 col-lg-6 col-xl-3">
        <x-app.commercial-head.dashboard.banks-heading heading="Tender Wise Cash Collection" img="{{asset('assets/images/cash.png')}}" />
        <x-app.commercial-head.dashboard.banks-table-headers>
            @if($tender->HDFCCash == '₹ 0.00' && $tender->ICICICash == '₹ 0.00' && $tender->SBICash == '₹ 0.00' &&
            $tender->IDFCCash == '₹ 0.00' && $tender->AXISCash == '₹ 0.00')
            <tr>
                <td colspan="2" class="text-center">Not available</td>
            </tr>
            @endif

            @if($tender->HDFCCash != '₹ 0.00')
            <tr>
                <td>
                    <img src="{{asset('assets/images/HDFC.png')}}" width="100%" /> <span class="hide-text">HDFC BANK</span>
                </td>
                <td>
                    <h3>
                        <span data-bs-toggle="tooltip" title="{{ $tender->HDFCCash }}">{{ $tender->FC_HDFCCash }}</span>
                    </h3>
                </td>
            </tr>
            @endif
            @if($tender->ICICICash != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/ICIC.png')}}" width="100%"><span class="hide-text"> ICICI BANK</span>
                </td>
                <td>
                    <h3>
                        <span data-bs-toggle="tooltip" title="{{ $tender->ICICICash }}">{{ !$tender->ICICICash ? ' 0.00' : ' '.$tender->FC_ICICICash
                            }}</span>
                    </h3>
                </td>
            </tr>
            @endif
            @if($tender->SBICash != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/sbi.png')}}" width="100%"><span class="hide-text"> SBI BANK</span>
                </td>

                <td>
                    <h3>
                        <span data-bs-toggle="tooltip" title="{{ $tender->SBICash }}">{{ !$tender->SBICash ? ' 0.00' : ' '.$tender->FC_SBICash
                            }}</span>
                    </h3>
                </td>
            </tr>
            @endif
            @if($tender->IDFCCash != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/idfc-logo.png')}}" width="100%"><span class="hide-text">IDFC Bank</span>
                </td>
                <td>
                    <h3>
                        <span data-bs-toggle="tooltip" title="{{ $tender->IDFCCash }}">{{ !$tender->IDFCCash ? ' 0.00' : ' '.$tender->FC_IDFCCash
                            }}</span>
                    </h3>
                </td>
            </tr>
            @endif

            @if($tender->AXISCash != '₹ 0.00')
            <tr>
                <td>
                    <img src="{{asset('assets/images/axis-logo.png')}}" width="100%"><span class="hide-text">Axis Bank</span>
                </td>
                <td>
                    <h3>
                        <span data-bs-toggle="tooltip" title="{{ $tender->AXISCash }}">{{ !$tender->AXISCash ? ' 0.00' : ' '.$tender->FC_AXISCash
                            }}</span>
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
                        <span data-bs-toggle="tooltip" title="{{ $tender->CashTotal }}">{{ !$tender->CashTotal ? ' 0.00': ' '.$tender->FC_CashTotal
                            }}</span>
                    </h3>
                </td>
            </tr>
            @endif
        </x-app.commercial-head.dashboard.banks-table-headers>
    </div>
    @endif

    @if($tenderStatus == 'card' || $tenderStatus == 'all')

    <div class="mt-5 col-12 col-md-6 col-lg-6 col-xl-3">
        <x-app.commercial-head.dashboard.banks-heading heading="Tender Wise Card Collection" img="{{asset('assets/images/card.png')}}" />
        <x-app.commercial-head.dashboard.banks-table-headers>

            @if($tender->HDFCCard == '₹ 0.00' && $tender->ICICICard == '₹ 0.00' && $tender->SBICard == '₹ 0.00' &&
            $tender->AMEXCard == '₹ 0.00')
            <tr>
                <td colspan="2" class="text-center">Not available</td>
            </tr>
            @endif

            @if($tender->HDFCCard != '₹ 0.00')
            <tr>
                <td>
                    <img src="{{asset('assets/images/HDFC.png')}}" width="100%"><span class="hide-text"> HDFC BANK</span>
                </td>
                <td>
                    <h3>
                        <span data-bs-toggle="tooltip" title="{{ $tender->HDFCCard }}">{{ !$tender->HDFCCard ? ' 0.00' : ' '.$tender->FC_HDFCCard
                            }}</span>
                    </h3>
                </td>
            </tr>
            @endif

            @if($tender->ICICICard != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/ICIC.png')}}" width="100%"><span class="hide-text">ICICI BANK</span>
                </td>
                <td>
                    <h3>
                        <span data-bs-toggle="tooltip" title="{{ $tender->ICICICard }}">{{ !$tender->ICICICard ? ' 0.00' : ' '.$tender->FC_ICICICard
                            }}</span>
                    </h3>
                </td>
            </tr>
            @endif
            @if($tender->SBICard != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/sbi.png')}}" width="100%"> <span class="hide-text">SBI BANK</span>
                </td>
                <td>
                    <h3>
                        <span data-bs-toggle="tooltip" title="{{ $tender->SBICard }}">{{ !$tender->SBICard ? ' 0.00' : ' '.$tender->FC_SBICard
                            }}</span>
                    </h3>
                </td>
            </tr>
            @endif
            @if($tender->AMEXCard != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/amex.png')}}" width="100%"><span class="hide-text">AMEXPOS Card</span>
                </td>
                <td>
                    <h3>
                        <span data-bs-toggle="tooltip" title="{{ $tender->AMEXCard }}">{{ !$tender->AMEXCard ? ' 0.00' : ' '.$tender->FC_AMEXCard
                            }}</span>
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
                        <span data-bs-toggle="tooltip" title="{{ $tender->CardTotal }}">{{ !$tender->CardTotal ? ' 0.00': ' '.$tender->FC_CardTotal
                            }}</span>
                    </h3>
                </td>
            </tr>
            @endif
        </x-app.commercial-head.dashboard.banks-table-headers>
    </div>
    @endif

    @if($tenderStatus == 'upi' || $tenderStatus == 'all')

    <div class="mt-5 col-12 col-md-6 col-lg-6 col-xl-3">
        <x-app.commercial-head.dashboard.banks-heading heading="Tender Wise UPI Collection" img="{{asset('assets/images/card.png')}}" />
        <x-app.commercial-head.dashboard.banks-table-headers>

            @if($tender->UPIH == '₹ 0.00')
            <tr>
                <td colspan="2" class="text-center">Not available</td>
            </tr>
            @endif

            @if($tender->UPIH != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/upi.png')}}" width="100%"> <span class="hide-text">HDFC UPI</span>
                </td>
                <td>
                    <h3>
                        <span data-bs-toggle="tooltip" title="{{ $tender->UPIH }}">{{ !$tender->UPIH ? ' 0.00' : ' '.$tender->FC_UPIH }}</span>
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
                        <span data-bs-toggle="tooltip" title="{{ $tender->UPIH }}">{{ !$tender->UPIH ? ' 0.00': ' '.$tender->FC_UPIH }}</span>
                    </h3>
                </td>
            </tr>
            @endif

        </x-app.commercial-head.dashboard.banks-table-headers>
    </div>
    @endif

    @if($tenderStatus == 'wallet' || $tenderStatus == 'all')

    <div class="mt-5 col-12 col-md-6 col-lg-6 col-xl-3">
        <x-app.commercial-head.dashboard.banks-heading heading="Tender Wise Wallet Collection" img="{{asset('assets/images/wallet.png')}}" />
        <x-app.commercial-head.dashboard.banks-table-headers>

            @if($tender->payTM == '₹ 0.00' && $tender->phonePay == '₹ 0.00')
            <tr>
                <td colspan="2" class="text-center">Not available</td>
            </tr>
            @endif

            @if($tender->payTM != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/paytm.png')}}" width="100%"><span class="hide-text">WALLET PAYTM</span>
                </td>
                <td>
                    <h3>
                        <span data-bs-toggle="tooltip" title="{{ $tender->payTM }}">{{ !$tender->payTM ? ' 0.00': ' '.$tender->FC_payTM }}</span>
                    </h3>
                </td>
            </tr>
            @endif
            @if($tender->phonePay != '₹ 0.00')

            <tr>
                <td>
                    <img src="{{asset('assets/images/phonepe.png')}}" width="100%"><span class="hide-text">WALLET PHONEPAY</span>
                </td>
                <td>
                    <h3>
                        <span data-bs-toggle="tooltip" title="{{ $tender->phonePay }}">{{ !$tender->phonePay ? ' 0.00': ' '.$tender->FC_phonePay
                            }}</span>
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
                        <span data-bs-toggle="tooltip" title="{{ $tender->WalletTotal }}">{{ !$tender->WalletTotal ? ' 0.00': '
                            '.$tender->FC_WalletTotal }}</span>
                    </h3>
                </td>
            </tr>
            @endif
        </x-app.commercial-head.dashboard.banks-table-headers>
    </div>
    @endif
</div>
