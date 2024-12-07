<div>
    <div class="card" id="dash1">
        <h2 class="text-light font-weight-bold mb-3" style="color:#000;">Tender Wise Sales</h2>
        <div class="row g-6 mb-2">

            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card shadow border ">
                    <div class="card-body borderbottom">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">AMEXPOS CARD</span>

                                <span class="h3 font-bold mb-0 text-success">{{ ($tender->PAMX == '')? '₹0.00' : ($tender->PAMX) }}</span>
                            </div>

                            <div class="icon icon-shape bg-tenderwise text-white text-lg rounded-circle">
                                <img class="" src="{{asset('assets/images/amex.png')}}" width="100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card shadow border">
                    <div class="card-body borderbottom1">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: #000 !important">HDFC CARD</span>
                                <span class="h3 font-bold mb-0 text-success">{{ ($tender->PHDF == '')? '₹0.00' : ($tender->PHDF) }}</span>
                            </div>
                            <div class="icon icon-shape bg-tenderwise text-white text-lg rounded-circle">
                                <img class="" src="{{asset('assets/images/HDFC.png')}}" width="100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card shadow border">
                    <div class="card-body borderbottom2">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">ICICI CARD</span>
                                <span class="h3 font-bold mb-0 text-success"> {{ ($tender->PICI == '')? '₹0.00' : ($tender->PICI) }}</span>
                            </div>
                            <div class="icon icon-shape bg-tenderwise text-white text-lg rounded-circle">
                                <img class="" src="{{asset('assets/images/ICIC.png')}}" width="100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card shadow border">
                    <div class="card-body borderbottom3">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">SBI CARD</span>
                                <span class="h3 font-bold mb-0 text-success"> {{ ($tender->PSBI == '')? '₹0.00' : ($tender->PSBI) }}</span>
                            </div>
                            <div class="icon icon-shape bg-tenderwise text-white text-lg rounded-circle">
                                <img class="" src="{{asset('assets/images/sbi.png')}}" width="100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card" id="dash2">
        <div class="row g-6 mb-5">
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card shadow border ">
                    <div class="card-body borderbottom">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">Wallet (PhonePE,PayTM)</span>
                                <span class="h3 font-bold mb-0 text-success"> {{ ($tender->PUBI == '')? '₹0.00' : ($tender->PUBI) }}</span>
                            </div>
                            <div class="icon icon-shape bg-tenderwise text-white text-lg rounded-circle">
                                <img class="" src="{{asset('assets/images/union.png')}}" width="100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card shadow border">
                    <div class="card-body borderbottom1">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">INNOVITI CARD</span>
                                <span class="h3 font-bold mb-0 text-success"> {{ ($tender->UPIA == '')? '₹0.00' : ($tender->UPIA) }}</span>
                            </div>
                            <div class="icon icon-shape bg-tenderwise text-white text-lg rounded-circle">
                                <img class="" src="{{asset('assets/images/upi.png')}}" width="100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card shadow border">
                    <div class="card-body borderbottom2">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">HDFC UPI</span>
                                <span class="h3 font-bold mb-0 text-success"> {{ ($tender->UPIH == '')? '₹0.00' : ($tender->UPIH) }}</span>
                            </div>
                            <div class="icon icon-shape bg-tenderwise text-white text-lg rounded-circle">
                                <img class="" src="{{asset('assets/images/upi.png')}}" width="100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card shadow border">
                    <div class="card-body borderbottom3">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">CASH</span>
                                <span class="h3 font-bold mb-0 text-success"> {{ ($tender->Cash == '')?'₹0.00' : ($tender->Cash) }}</span>
                            </div>
                            <div class="icon icon-shape bg-tenderwise text-white text-lg rounded-circle">
                                <img class="" src="{{asset('assets/images/cash.png')}}" width="100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="text-align: right;"><a class="btn btn-success" href="{{ url('/') }}/amanager/sap">View More</a></div>
    </div>

</div>
