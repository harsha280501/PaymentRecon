<div class="col-xl-4 col-12 mt-3">
    <x-app.admin.dashboard.banks-heading heading="Tender Wise Cash Collection" img="{{asset('assets/images/cash.png')}}" />

    <x-app.admin.dashboard.banks-table-headers>
        @if(!$tender->HDFCCash && !$tender->ICICICash && !$tender->SBICash && !$tender->IDFCCash && !$tender->AxisCash)
        <tr>
            <td colspan="2" class="text-center">No Data available</td>
        </tr>
        @endif

        @if($tender->HDFCCash)
        <tr>
            <td>
                <img src="{{asset('assets/images/HDFC.png')}}" width="100%" /> HDFC BANK</td>
            <td>
                <h3>{{ !$tender->HDFCCash ? '₹ 0.00' : $tender->HDFCCash }}</h3>
            </td>
        </tr>
        @endif
        @if($tender->ICICICash)

        <tr>
            <td>
                <img src="{{asset('assets/images/ICIC.png')}}" width="100%"> ICICI BANK</td>
            <td>
                <h3>{{ !$tender->ICICICash ? '₹ 0.00' : $tender->ICICICash }}</h3>
            </td>
        </tr>
        @endif
        @if($tender->SBICash)

        <tr>
            <td>
                <img src="{{asset('assets/images/sbi.png')}}" width="100%"> STATE BANK OF INDIA</td>

            <td>
                <h3>{{ !$tender->SBICash ? '₹ 0.00' : $tender->SBICash }}</h3>
            </td>
        </tr>
        @endif
        @if($tender->IDFCCash)

        <tr>
            <td>
                <img src="{{asset('assets/images/idfc-logo.png')}}" width="100%">IDFC Bank</td>
            <td>
                <h3>{{ !$tender->IDFCCash ? '₹ 0.00' : $tender->IDFCCash }}</h3>
            </td>
        </tr>
        @endif

        @if($tender->AxisCash)
        <tr>
            <td>
                <img src="{{asset('assets/images/axis-logo.png')}}" width="100%">Axis Bank</td>
            <td>
                <h3>{{ !$tender->AxisCash ? '₹ 0.00' : $tender->AxisCash }}</h3>
            </td>
        </tr>
        @endif

    </x-app.admin.dashboard.banks-table-headers>
</div>

<div class="col-xl-4 col-12 mt-3">
    <x-app.admin.dashboard.banks-heading heading="Tender Wise Card/UPI Collection" img="{{asset('assets/images/card.png')}}" />
    <x-app.admin.dashboard.banks-table-headers>

        @if(!$tender->HDFCCard && !$tender->HDFCUPI && !$tender->ICICICard && !$tender->SBICard && !$tender->AMEXCard)
        <tr>
            <td colspan="2" class="text-center">No Data available</td>
        </tr>
        @endif

        @if($tender->HDFCCard)
        <tr>
            <td>
                <img src="{{asset('assets/images/HDFC.png')}}" width="100%"> HDFC BANK (CARD)</td>
            <td>
                <h3>{{ !$tender->HDFCCard ? '₹ 0.00' : $tender->HDFCCard }}</h3>
            </td>
        </tr>
        @endif
        @if($tender->HDFCUPI)

        <tr>
            <td>
                <img src="{{asset('assets/images/upi.png')}}" width="100%"> HDFC UPI</td>
            <td>
                <h3>{{ !$tender->HDFCUPI ? '₹ 0.00' : $tender->HDFCUPI }}</h3>
            </td>
        </tr>
        @endif
        @if($tender->ICICICard)

        <tr>
            <td>
                <img src="{{asset('assets/images/ICIC.png')}}" width="100%"> ICICI BANK</td>
            <td>
                <h3>{{ !$tender->ICICICard ? '₹ 0.00' : $tender->ICICICard }}</h3>
            </td>
        </tr>
        @endif
        @if($tender->SBICard)

        <tr>
            <td>
                <img src="{{asset('assets/images/sbi.png')}}" width="100%"> STATE BANK OF INDIA</td>
            <td>
                <h3>{{ !$tender->SBICard ? '₹ 0.00' : $tender->SBICard }}</h3>
            </td>
        </tr>
        @endif
        @if($tender->AMEXCard)

        <tr>
            <td>
                <img src="{{asset('assets/images/amex.png')}}" width="100%">AMEXPOS Card</td>
            <td>
                <h3>{{ !$tender->AMEXCard ? '₹ 0.00' : $tender->AMEXCard }}</h3>
            </td>
        </tr>
        @endif

    </x-app.admin.dashboard.banks-table-headers>
</div>

<div class="col-xl-4 col-12 mt-3">
    <x-app.admin.dashboard.banks-heading heading="Tender Wise Wallet Collection" img="{{asset('assets/images/wallet.png')}}" />
    <x-app.admin.dashboard.banks-table-headers>

        @if(!$tender->payTM && !$tender->phonePay)
        <tr>
            <td colspan="2" class="text-center">No Data available</td>
        </tr>
        @endif

        @if($tender->payTM)

        <tr>
            <td>
                <img src="{{asset('assets/images/union.png')}}" width="100%">WALLET PAYTM</td>
            <td>
                <h3>{{ !$tender->payTM ? '₹ 0.00': $tender->payTM }}</h3>
            </td>
        </tr>
        @endif
        @if($tender->phonePay)

        <tr>
            <td>
                <img src="{{asset('assets/images/union.png')}}" width="100%">WALLET PHONEPAY</td>
            <td>
                <h3>{{ !$tender->phonePay ? '₹ 0.00': $tender->phonePay }}</h3>
            </td>
        </tr>
        @endif

    </x-app.admin.dashboard.banks-table-headers>
</div>
