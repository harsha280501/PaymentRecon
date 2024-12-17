<div class="mt-3">
    <div class="card" id="dash1">
        <h2 class="text-light font-weight-bold mb-3" style="color:#000;">Tender Wise Sales</h2>
        <div class="row g-6 mb-2">

            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card shadow border ">
                    <div class="card-body borderbottom">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">AMEXPOS CARD (Cr)</span>

                                <span data-bs-toggle="tooltip" title="{{  ($tender->PAMXData == '')? '₹0.00' : ($tender->PAMXData) }}" class="h3 font-bold mb-0 text-success">{{ ($tender->RPAMX == '')? '₹0.00' : '₹ '.($tender->RPAMX) }}</span>
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
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: #000 !important">HDFC CARD (Cr)</span>
                                <span data-bs-toggle="tooltip" title="{{  ($tender->PHDFData == '')? '₹0.00' : ($tender->PHDFData) }}" class="h3 font-bold mb-0 text-success">{{ ($tender->RPHDF == '')? '₹0.00' : '₹ '.($tender->RPHDF) }}</span>
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
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">ICICI CARD (Cr)</span>
                                <span data-bs-toggle="tooltip" title="{{  ($tender->PICIData == '')? '₹0.00' : ($tender->PICIData) }}" class="h3 font-bold mb-0 text-success"> {{ ($tender->RPICI == '')? '₹0.00' : '₹ '.($tender->RPICI) }}</span>
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
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">SBI CARD (Cr)</span>
                                <span data-bs-toggle="tooltip" title="{{  ($tender->PSBIData == '')? '₹0.00' : ($tender->PSBIData) }}" class="h3 font-bold mb-0 text-success"> {{ ($tender->RPSBI == '')? '₹0.00' : '₹ '.($tender->RPSBI) }}</span>
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
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">Wallet(PhonePE,PayTM) (Cr)</span>
                                <span data-bs-toggle="tooltip" title="{{  ($tender->PUBIData == '')? '₹0.00' : ($tender->PUBIData) }}" class="h3 font-bold mb-0 text-success"> {{ ($tender->RPUBI == '')? '₹0.00' : '₹ '.($tender->RPUBI) }}</span>
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
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">INNOVITI CARD (Cr)</span>
                                <span data-bs-toggle="tooltip" title="{{  ($tender->UPIAData == '')? '₹0.00' : ($tender->UPIAData) }}" class="h3 font-bold mb-0 text-success"> {{ ($tender->RUPIA == '')? '₹0.00' : '₹ '.($tender->RUPIA) }}</span>
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
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">HDFC UPI (Cr)</span>
                                <span data-bs-toggle="tooltip" title="{{  ($tender->UPIHData == '')? '₹0.00' : ($tender->UPIHData) }}" class="h3 font-bold mb-0 text-success"> {{ ($tender->RUPIH == '')? '₹0.00' : '₹ '.($tender->RUPIH) }}</span>
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
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2" style="color: black !important">CASH (Cr)</span>
                                <span data-bs-toggle="tooltip" title="{{  ($tender->CashData == '')? '₹0.00' : ($tender->CashData) }}" class="h3 font-bold mb-0 text-success"> {{ ($tender->RCash == '')?'₹0.00' : '₹ '.($tender->RCash) }}</span>
                            </div>
                            <div class="icon icon-shape bg-tenderwise text-white text-lg rounded-circle">
                                <img class="" src="{{asset('assets/images/cash.png')}}" width="100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
