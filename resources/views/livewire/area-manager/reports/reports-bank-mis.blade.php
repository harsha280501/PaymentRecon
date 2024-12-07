<div class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
    <section id="bankmis">
        <div class="row">
            <div class="col-lg-12 mb-2">
            </div>
        </div>

        <div class="row">

            <div class="col-lg-9">
                <ul class="nav nav-tabs justify-content-start" role="tablist">
                    <li class="nav-item">
                        <a wire:click="switchTab('hdfc')" class="nav-link @if($activeTab === 'hdfc') active @endif" data-bs-toggle="tab" data-bs-target="#hdfc" href="#" role="tab">
                            <img src="../assets/images/hdfc-logo.png" />HDFC
                            BANK
                        </a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="switchTab('axis')" class="nav-link @if($activeTab === 'axis') active @endif" data-bs-toggle="
                            tab" data-bs-target="#axis" href="#" role="tab">
                            <img src="../assets/images/axis-logo.png" />Axis Bank
                        </a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="switchTab('icici')" class="nav-link @if($activeTab === 'icici') active @endif" data-bs-toggle="tab" data-bs-target="#icici" href="#" role="tab">
                            <img src="../assets/images/icici-logo.png" />ICICI Bank
                        </a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="switchTab('sbi')" class="nav-link @if($activeTab === 'sbi') active @endif" data-bs-toggle="
                            tab" data-bs-target="#sbi" href="#" role="tab">
                            <img src="../assets/images/sbi-logo.png" /> SBI
                            Bank
                        </a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="switchTab('idfc')" class="nav-link @if($activeTab === 'idfc') active @endif" data-bs-toggle="
                            tab" data-bs-target="#idfc" href="#" role="tab">
                            <img src="../assets/images/idfc-logo.png" />
                            IDFC Bank
                        </a>
                    </li>

                    <li class="nav-item">
                        <a wire:click="switchTab('wallet')" class="nav-link @if($activeTab === 'wallet') active @endif" data-bs-toggle="
                            tab" data-bs-target="#idfc" href="#" role="tab">
                            <img style="width: 30px; object-fit: cover" src="../assets/images/wallet.png" />
                            Wallet
                        </a>
                    </li>
                    <li class="nav-item">
                        <a wire:click="switchTab('amexpos')" class="nav-link @if($activeTab === 'amexpos') active @endif" data-bs-toggle="
                            tab" data-bs-target="#idfc" href="#" role="tab">
                            <img style="width: 30px; object-fit: cover" src="../assets/images/amexpos.png" />
                            AmexPos
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 d-flex align-items-center justify-content-end">

                <select class="bg-brown me-2" style="height: 7vh; outline: none; border: none; border-radius: 4px; font-size: .7em; padding: .5em 1em .5em .5em" wire:model="bankType">
                    @foreach ($bankTypes as $type)
                    <option value="{{ $type }}">{{ strtoupper($type) }}</option>
                    @endforeach
                </select>

                <div class="btn-group mb-1" style="margin-right: 5px; width: fit-content">
                    <button type="button" class="dropdown-toggle d-flex btn btn-secondary" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                    <div class="dropdown-menu" style="width: 150px !important" aria-labelledby="dropdownMenuButton1">
                        <a style="color: #000; text-decoration: none; font-size: .9em; padding: .7em 1em .7em .3em; width: 100% !important" wire:click="exportExcel" href="#">Export XLS</a>
                    </div>
                </div>

                <!--btn2-->
                <div class="btn-group mb-1">
                </div>
            </div>
        </div>
        <!--Tab contents--->
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content text-center">
                    <div class="tab-pane active" id="icici" role="tabpanel">
                        <section id="recent">
                            <div class="row">
                                <div class="col-lg-12 bankMISMainTable" wire:loading.class='overflow-none' @if(count($mis) < 1) style="overflow: hidden" @else style="overflow-x: scroll !important" @endif>
                                    <table style="overflow-x: scroll !important" id="bankMISTable" class="table table-responsive table-info" style="overflow-x: scroll !important">
                                        <thead>
                                            @if ($bankType == 'cash')

                                            @if($activeTab == 'hdfc')
                                            <tr class="headers">
                                                <td data-headerName="depositDt">STORE ID</td>
                                                <td data-headerName="tranType">RETEK CODE</td>
                                                <td data-headerName="depositAmt">COL BANK</td>
                                                <td data-headerName="depositAmt">PICK UP LOCATION</td>
                                                <td data-headerName="tid">DEPOSIT DATE</td>
                                                <td data-headerName="mid">CREDIT DATE</td>
                                                <td data-headerName="mid">DEPOSIT SLIP NUMBER</td>
                                                <td data-headerName="mid">DEPOSIT SLIP AMOUNT</td>
                                            </tr>
                                            @endif

                                            @if($activeTab == 'axis')
                                            <tr class="headers">
                                                <td data-headerName="depositDt">STORE ID</td>
                                                <td data-headerName="tranType">RETEK Code</td>
                                                <td data-headerName="depositAmt">COL BANK</td>
                                                <td data-headerName="depositAmt">LOCATION NAME</td>
                                                <td data-headerName="tid">DEP DATE</td>
                                                <td data-headerName="mid">CR DATE</td>
                                                <td data-headerName="mid">SLIP NO.</td>
                                                <td data-headerName="mid">SLIP AMOUNT</td>

                                            </tr>
                                            @endif

                                            @if($activeTab == 'icici')
                                            <tr class="headers">
                                                <td data-headerName="depositDt">STORE ID</td>
                                                <td data-headerName="tranType">RETEK CODE</td>
                                                <td data-headerName="depositAmt">COL BANK</td>
                                                <td data-headerName="depositAmt">LOCATION NAME</td>
                                                <td data-headerName="tid">DEP DATE</td>
                                                <td data-headerName="mid">CR DATE</td>
                                                <td data-headerName="mid">SLIP NO.</td>
                                                <td data-headerName="mid">SLIP AMOUNT</td>
                                            </tr>
                                            @endif


                                            @if($activeTab == 'sbi')
                                            <tr class="headers">
                                                <td data-headerName="depositDt">STORE ID</td>
                                                <td data-headerName="tranType">RETEK CODE</td>
                                                <td data-headerName="depositAmt">COL BANK </td>
                                                <td data-headerName="depositAmt">LOCATION NAME</td>
                                                <td data-headerName="depositAmt">DEPOSIT DATE</td>
                                                <td data-headerName="tid">ACTUAL LIQUIDATION DATE</td>
                                                <td data-headerName="mid">DEPOSIT SLIP NO</td>
                                                <td data-headerName="mid">TOTAL PAID AMT</td>
                                            </tr>
                                            @endif


                                            @if($activeTab == 'idfc')
                                            <tr class="headers">
                                                <td data-headerName="depositDt">STORE ID</td>
                                                <td data-headerName="tranType">RETAK CODE</td>
                                                <td data-headerName="depositAmt">COL BANK</td>
                                                <td data-headerName="depositAmt">PICK UP LOCATION</td>
                                                <td data-headerName="tid">DEPOSIT DATE</td>
                                                <td data-headerName="mid">ARRANGEMENT CREDIT DATE</td>
                                                <td data-headerName="mid">DEPOSIT SLIP NUMBER</td>
                                                <td data-headerName="mid">DEPOSIT SLIP AMOUNT</td>
                                            </tr>
                                            @endif


                                            @elseif($bankType == 'card')
                                            @if($activeTab == 'hdfc')
                                            <tr class="headers">
                                                <td data-headerName="acctNo">STORE ID</td>
                                                <td data-headerName="acctNo">Retak CODE</td>
                                                <td data-headerName="tranType">COL BANK</td>
                                                <td data-headerName="mername">Account NO</td>
                                                <td data-headerName="depositAmt">MERCHANT CODE</td>
                                                <td data-headerName="depositAmt">TERMINAL NUMBER</td>
                                                <td data-headerName="depositAmt">TRANS DATE</td>
                                                <td data-headerName="depositAmt">SETTLE DATE</td>
                                                <td data-headerName="tid">Deposit Amount</td>
                                                <td data-headerName="tid">MSF</td>
                                                <td data-headerName="tid">GST</td>
                                                <td data-headerName="tid">Net Amount</td>
                                            </tr>
                                            @endif

                                            @if($activeTab == 'icici')
                                            <tr class="headers">
                                                <td data-headerName="acctNo">STORE ID</td>
                                                <td data-headerName="acctNo">Retak Code</td>
                                                <td data-headerName="depositDt">COL BANK</td>
                                                <td data-headerName="tranType">ACCOUNT NO</td>
                                                <td data-headerName="mername"> TRADE NAME</td>
                                                <td data-headerName="depositAmt"> TID</td>
                                                <td data-headerName="depositAmt">MID</td>
                                                <td data-headerName="depositAmt">TRANSACTION DATE</td>
                                                <td data-headerName="depositAmt">POST DATE</td>
                                                <td data-headerName="tid">TRANSACTION AMT</td>
                                                <td data-headerName="tid">COMM AMOUNT</td>
                                                <!-- <td data-headerName="tid">GST TOTAL</td> -->
                                                <td data-headerName="tid">NET AMT</td>
                                            </tr>
                                            @endif

                                            @if($activeTab == 'sbi')
                                            <tr class="headers">
                                                <td data-headerName="acctNo">STORE ID</td>
                                                <td data-headerName="acctNo">RETAK CODE</td>
                                                <td data-headerName="depositDt">COL BANK</td>
                                                <td data-headerName="tranType">ACCOUNT NO</td>
                                                <td data-headerName="mername">Account NR</td>
                                                <td data-headerName="depositAmt">TID</td>
                                                <td data-headerName="depositAmt">MID</td>
                                                <td data-headerName="depositAmt">TRANS DATE</td>
                                                <td data-headerName="depositAmt">STL DATE</td>
                                                <td data-headerName="tid">TXN AMOUNT</td>
                                                <td data-headerName="tid">MDR Amount</td>
                                                <td data-headerName="tid">GST</td>
                                                <td data-headerName="tid">NET AMOUNT</td>
                                            </tr>
                                            @endif

                                            @if($activeTab == 'amexpos')
                                            <tr class="headers">
                                                <td data-headerName="acctNo">Store ID</td>
                                                <td data-headerName="acctNo">RETAK CODE</td>
                                                <td data-headerName="depositDt">COL BANK</td>
                                                <td data-headerName="tranType">ACCOUNT NO</td>
                                                <td data-headerName="mername">MERCHAND CODE</td>
                                                <td data-headerName="mername">Terminal ID</td>
                                                <td data-headerName="depositAmt">Submitting merchant number</td>
                                                <td data-headerName="depositAmt">Transaction date</td>
                                                <td data-headerName="depositAmt">Settlement date</td>
                                                <td data-headerName="depositAmt">Charge amount</td>
                                                <td data-headerName="tid">MSF Commission</td>
                                                <td data-headerName="tid">GST TOtal</td>
                                                <td data-headerName="tid">Net Amount</td>
                                            </tr>
                                            @endif

                                            @elseif($bankType == 'upi')
                                            @if($activeTab == 'hdfc')
                                            <tr class="headers">
                                                <td data-headerName="acctNo">STORE ID</td>
                                                <td data-headerName="acctNo">RETAK CODE</td>
                                                <td data-headerName="depositDt">COL BANK</td>
                                                <td data-headerName="tranType">HDFC UPI A/c</td>
                                                <td data-headerName="mername">EXTERNAL MID</td>
                                                <td data-headerName="depositAmt"> EXTERNAL TID</td>
                                                <td data-headerName="depositAmt">UPI MERCHANT ID</td>
                                                <td data-headerName="depositAmt">TRANSACTION REQ DATE</td>
                                                <td data-headerName="depositAmt">SETTLEMENT DATE</td>
                                                <td data-headerName="tid">DEPOSIT AMOUNT</td>
                                                <td data-headerName="tid">MSF AMOUNT</td>
                                                <td data-headerName="tid">GST TOTAL</td>
                                                <td data-headerName="tid">NET AMOUNT</td>
                                            </tr>
                                            @endif

                                            @elseif($bankType == 'PHONEPE')
                                            <tr class="headers">
                                                <td data-headerName="acctNo">STORE ID</td>
                                                <td data-headerName="acctNo">RETAK CODE</td>
                                                <td data-headerName="depositDt">COL BANK</td>
                                                <td data-headerName="mername">TERMINAL ID</td>
                                                <td data-headerName="depositAmt">MID</td>
                                                <td data-headerName="depositAmt">TRANSACTION DATE</td>
                                                <td data-headerName="depositAmt">SETTLEMENT DATE</td>
                                                <td data-headerName="tid">DEPOSIT AMOUNT</td>
                                                <td data-headerName="tid">FEE</td>
                                                <td data-headerName="tid">GST TOTAL</td>
                                                <td data-headerName="tid">NET AMOUNT</td>
                                                <td data-headerName="tid">BANK REF</td>
                                            </tr>

                                            @elseif($bankType == 'paytm')
                                            <tr class="headers">
                                                <td data-headerName="acctNo">STORE ID</td>
                                                <td data-headerName="acctNo">RETAK CODE</td>
                                                <td data-headerName="depositDt">COL BANK</td>
                                                <td data-headerName="tranType">POS_ID/c</td>
                                                <td data-headerName="mername">MID</td>
                                                <td data-headerName="depositAmt">TRANSACTION DATE</td>
                                                <td data-headerName="depositAmt">SETTLEMENT DATE</td>
                                                <td data-headerName="tid">AMOUNT</td>
                                                <td data-headerName="tid">Commission</td>
                                                <td data-headerName="tid">GST</td>
                                                <td data-headerName="tid">NET AMOUNT</td>
                                                <td data-headerName="tid">UTR_No.</td>
                                            </tr>


                                            @endif
                                        </thead>
                                        <tbody wire:loading.class='none'>

                                            @if ($bankType == 'card')

                                            @if($activeTab == "hdfc")
                                            @foreach ($mis as $main)
                                            @php
                                            $data = (array) $main
                                            @endphp
                                            <tr>
                                                <td class="acctNo">
                                                     {{ $data["storeID"] }} 
                                                </td>
                                                <td class="acctNo">
                                                    {{ $data["Retak code"] }}
                                                </td>
                                                <td class="depositDt">{{ $data["colBank"] }}</td>
                                                <td class="depositDt">{{ $data["acctNo"] }}</td>
                                                <td class="tranType">{{ $data["merCode"] }}</td>
                                                <td class="depositAmt">{{ $data["tid"] }}</td>
                                                <td class="tid">{{ $data["depositDt"] }}</td>
                                                <td class="tid">{{ $data["crtDt"] }}</td>
                                                <td class="mid">{{ $data["depositAmount"] }}</td>
                                                <td class="mid">{{ $data["msfComm"] }}</td>
                                                <td class="mid">{{ $data["gstTotal"] }}</td>
                                                <td class="mid">{{ $data["netAmount"] }}</td>
                                            </tr>
                                            @endforeach
                                            @endif

                                            @if($activeTab == "icici")
                                            @foreach ($mis as $main)
                                            @php
                                            $data = (array) $main
                                            @endphp
                                            <tr>
                                                <td class="acctNo">
                                                    {{ $data["Store ID"] }}
                                                </td>
                                                <td class="acctNo">
                                                    {{ $data["Retak code"] }}
                                                </td>
                                                <td class="depositDt">{{ $data["colBank"] }}</td>
                                                <td class="depositDt">{{ $data["acctNo"] }}</td>
                                                <td class="tranType">{{ $data["merCode"] }}</td>
                                                <td class="depositAmt">{{ $data["tid"] }}</td>
                                                <td class="tranType">{{ $data["mid"] }}</td>
                                                <td class="tid">{{ $data["depositDt"] }}</td>
                                                <td class="tid">{{ $data["crtDt"] }}</td>
                                                <td class="mid">{{ $data["depositAmount"] }}</td>
                                                <td class="mid">{{ $data["msfComm"] }}</td>                                               
                                                <td class="mid">{{ $data["netAmount"] }}</td>
                                            </tr>
                                            @endforeach
                                            @endif

                                            @if($activeTab == "sbi")
                                            @foreach ($mis as $main)
                                            @php
                                            $data = (array) $main
                                            @endphp
                                            <tr>
                                                <td class="acctNo">
                                                    {{ $data["Store ID"] }}
                                                </td>
                                                <td class="acctNo">
                                                    {{ $data["Retak code"] }}
                                                </td>
                                                <td class="depositDt">{{ $data["colBank"] }}</td>
                                                <td class="depositDt">{{ $data["acctNo"] }}</td>
                                                <td class="tranType">{{ $data["merCode"] }}</td>
                                                <td class="tranType">{{ $data["mid"] }}</td>
                                                <td class="depositAmt">{{ $data["tid"] }}</td>
                                                <td class="tid">{{ $data["depositDt"] }}</td>
                                                <td class="tid">{{ $data["crtDt"] }}</td>
                                                <td class="mid">{{ $data["depositAmount"] }}</td>
                                                <td class="mid">{{ $data["msfComm"] }}</td>
                                                <td class="mid">{{ $data["gstTotal"] }}</td>
                                                <td class="mid">{{ $data["netAmount"] }}</td>
                                            </tr>
                                            @endforeach
                                            @endif

                                            @if($activeTab == "amexpos")
                                            @foreach ($mis as $main)
                                            @php
                                            $data = (array) $main
                                            @endphp
                                            <tr>
                                                <td class="acctNo">
                                                    <!-- {{ $data["SAPcode"] }} -->
                                                </td>
                                                <td class="acctNo">
                                                    <!-- {{ $data["Retak code"] }} -->
                                                </td>
                                                <td class="depositDt">{{ $data["colBank"] }}</td>
                                                <td class="depositDt">{{ $data["acctNo"] }}</td>
                                                <td class="tranType">{{ $data["merCode"] }}</td>
                                                <td class="depositAmt">{{ $data["tid"] }}</td>
                                                <td class="tranType">{{ $data["mid"] }}</td>
                                                <td class="tid">{{ $data["depositDt"] }}</td>
                                                <td class="tid">{{ $data["crtDt"] }}</td>
                                                <td class="mid">{{ $data["depositAmount"] }}</td>
                                                <td class="mid">{{ $data["msfComm"] }}</td>
                                                <td class="mid">{{ $data["gstTotal"] }}</td>
                                                <td class="mid">{{ $data["netAmount"] }}</td>
                                            </tr>
                                            @endforeach
                                            @endif


                                            @elseif ($bankType == 'upi')

                                            @if($activeTab == "hdfc")
                                            @foreach ($mis as $main)
                                            @php
                                            $data = (array) $main
                                            @endphp
                                            <tr>
                                                <td class="acctNo">
                                                    <!-- {{ $data["SAPcode"] }} -->
                                                </td>
                                                <td class="acctNo">
                                                    <!-- {{ $data["Retak code"] }} -->
                                                </td>
                                                <td class="depositDt">{{ $data["colBank"] }}</td>
                                                <td class="depositDt">{{ $data["acctNo"] }}</td>
                                                <td class="tranType">{{ $data["merCode"] }}</td>
                                                <td class="depositAmt">{{ $data["tid"] }}</td>
                                                <td class="tranType">{{ $data["mid"] }}</td>
                                                <td class="tid">{{ $data["depositDt"] }}</td>
                                                <td class="tid">{{ $data["crtDt"] }}</td>
                                                <td class="mid">{{ $data["depositAmount"] }}</td>
                                                <td class="mid">{{ $data["msfComm"] }}</td>
                                                <td class="mid">{{ $data["gstTotal"] }}</td>
                                                <td class="mid">{{ $data["netAmount"] }}</td>
                                            </tr>
                                            @endforeach
                                            @endif

                                            @elseif($bankType == 'cash')

                                            @if($activeTab == "hdfc")

                                            @foreach ($mis as $main)
                                            @php
                                            $data = (array) $main
                                            @endphp
                                            <tr>
                                                <td class="acctNo">{{ $data['Store ID']}}</td>
                                                <td class="tranType">{{ $data["Retak code"] }}</td>
                                                <td class="tranType">{{ $data["colBank"] }}</td>
                                                <td class="mid">{{ $data['locationName'] }}</td>
                                                <td class="depositAmt">{{ $data['depositDt'] }}</td>
                                                <td class="depositAmt">{{ $data['crDt'] }}</td>
                                                <td class="tid">{{ $data['depSlipNo'] }}</td>
                                                <td class="tid">{{ $data['depositAmount'] }}</td>
                                            </tr>
                                            @endforeach
                                            @endif

                                            @if($activeTab == "axis")

                                            @foreach ($mis as $main)
                                            @php
                                            $data = (array) $main
                                            @endphp
                                            <tr>
                                                <td class="acctNo">{{ $data['Store ID']}}</td>
                                                <td class="tranType">{{ $data["Retak code"] }}</td>
                                                <td class="tranType">{{ $data["colBank"] }}</td>
                                                <td class="mid">{{ $data['locationName'] }}</td>
                                                <td class="depositAmt">{{ $data['depositDt'] }}</td>
                                                <td class="depositAmt">{{ $data['crDt'] }}</td>
                                                <td class="tid">{{ $data['depSlipNo'] }}</td>
                                                <td class="tid">{{ $data['depositAmount'] }}</td>
                                            </tr>
                                            @endforeach
                                            @endif


                                            @if($activeTab == "icici")

                                            @foreach ($mis as $main)
                                            @php
                                            $data = (array) $main
                                            @endphp
                                            <tr>
                                                <td class="acctNo">{{ $data['Store ID']}}</td>
                                                <td class="tranType">{{ $data["Retak code"] }}</td>
                                                <td class="tranType">{{ $data["colBank"] }}</td>
                                                <td class="mid">{{ $data['locationName'] }}</td>
                                                <td class="depositAmt">{{ $data['depositDt'] }}</td>
                                                <td class="depositAmt">{{ $data['crDt'] }}</td>
                                                <td class="tid">{{ $data['depSlipNo'] }}</td>
                                                <td class="tid">{{ $data['depositAmount'] }}</td>
                                            </tr>
                                            @endforeach
                                            @endif

                                            @if($activeTab == "sbi")

                                            @foreach ($mis as $main)
                                            @php
                                            $data = (array) $main
                                            @endphp
                                            <tr>
                                                <td class="acctNo">{{ $data['Store ID']}}</td>
                                                <td class="tranType">{{ $data["Retak code"] }}</td>
                                                <td class="tranType">{{ $data["colBank"] }}</td>
                                                <td class="mid">{{ $data['locationName'] }}</td>
                                                <td class="depositAmt">{{ $data['depositDt'] }}</td>
                                                <td class="depositAmt">{{ $data['crDt'] }}</td>
                                                <td class="tid">{{ $data['depSlipNo'] }}</td>
                                                <td class="tid">{{ $data['depositAmount'] }}</td>
                                            </tr>
                                            @endforeach
                                            @endif

                                            @if($activeTab == "idfc")
                                            @foreach ($mis as $main)
                                            @php
                                            $data = (array) $main
                                            @endphp
                                            <tr>
                                                <td class="acctNo">{{ $data['Store ID']}}</td>
                                                <td class="tranType">{{ $data["Retak code"] }}</td>
                                                <td class="tranType">{{ $data["colBank"] }}</td>
                                                <td class="mid">{{ $data['locationName'] }}</td>
                                                <td class="depositAmt">{{ $data['depositDt'] }}</td>
                                                <td class="depositAmt">{{ $data['crDt'] }}</td>
                                                <td class="tid">{{ $data['depSlipNo'] }}</td>
                                                <td class="tid">{{ $data['depositAmount'] }}</td>
                                            </tr>
                                            @endforeach
                                            @endif

                                            @elseif($bankType == 'PHONEPE')

                                            @foreach ($mis as $main)

                                            @php
                                            $data = (array) $main
                                            @endphp

                                            <tr>
                                                <td class="acctNo">
                                                    <!-- {{ $data["SAPcode"] }} -->
                                                </td>
                                                <td class="acctNo">
                                                    <!-- {{ $data["Retak code"] }} -->
                                                </td>
                                                <td class="depositDt">{{ $data["colBank"] }}</td>
                                                <td class="depositAmt">{{ $data["tid"] }}</td>
                                                <td class="tranType">{{ $data["mid"] }}</td>
                                                <td class="tid">{{ $data["depositDt"] }}</td>
                                                <td class="tid">{{ $data["crDt"] }}</td>
                                                <td class="mid">{{ $data["depositAmount"] }}</td>
                                                <td class="mid">{{ $data["msfComm"] }}</td>
                                                <td class="mid">{{ $data["totalGST"] }}</td>
                                                <td class="mid">{{ $data["netAmount"] }}</td>
                                                <td class="mid">{{ $data["bankRef"] }}</td>
                                            </tr>
                                            @endforeach

                                            @elseif($bankType == 'paytm')

                                            @foreach ($mis as $main)

                                            @php
                                            $data = (array) $main
                                            @endphp

                                            <tr>
                                                <td class="acctNo">
                                                    {{ $data["Store ID"] }}
                                                </td>
                                                <td class="acctNo">
                                                    {{ $data["Retak code"] }}
                                                </td>
                                                <td class="depositDt">{{ $data["colBank"] }}</td>
                                                <td class="depositAmt">{{ $data["tid"] }}</td>
                                                <td class="tranType">{{ $data["mid"] }}</td>
                                                <td class="tid">{{ $data["depositDt"] }}</td>
                                                <td class="tid">{{ $data["crtDt"] }}</td>
                                                <td class="mid">{{ $data["depositAmount"] }}</td>
                                                <td class="mid">{{ $data["msfComm"] }}</td>
                                                <td class="mid">{{ $data["totalGST"] }}</td>
                                                <td class="mid">{{ $data["netAmount"] }}</td>
                                                <td class="mid">{{ $data["utrNo"] }}</td>
                                            </tr>
                                            @endforeach
                                            @else

                                            <span class="text-center small">This bank does not have the requested
                                                payment type</span>
                                            @endif

                                        </tbody>
                                        <br>
                                    </table>

                                    @if (count($mis) < 1) <p class="mt-3">
                                        No data available
                                        </p>
                                        @endif

                                        <div style="display: none; text-align:center; margin-top: 10px" wire:loading.class="mainLoading">
                                            <div class="spinner-border spinner-border-sm" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <span>Loading ...</span>
                                        </div>
                                </div>
                            </div>
                        </section>

                        <div wire:loading.class='none' class="mt-4">
                            {{ $mis->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
