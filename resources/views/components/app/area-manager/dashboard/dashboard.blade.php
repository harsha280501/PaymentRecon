<section id="sales">
    <div class="row mb-3">
        <div class="col-lg-6 col-sm-4 grid-margin  grid-margin-lg-0">
            <div class="row">
                <div class="d-flex justify-content-between align-items-start" style="flex-wrap: wrap !important">


                    <!-- BRAND -->
                    <div class="d-sm-flex justify-content-xl-between align-items-center mb-2">
                        <div class="dropdown ms-0 ">
                            <select class="custom-select select2 form-control" id="search" data-live-search="true" data-bs-toggle="dropdown" style="height: 10px !important">
                                <option value="" class="dropdown-item">SELECT BRAND NAME</option>
                                <option value="" class="dropdown-item" data-field="">ALL</option>

                                @foreach($brandAndStore['brandList'] as $brand)

                                @php
                                $brand = (array) $brand
                                @endphp

                                {{-- {{ dd($brand['Brand Name']) }} --}}
                                @if(auth()->user()->store()['Brand Name'] == (array) $brand['Brand Name'])

                                <option value="{{ $brand['Brand Name'] }} ">{{auth()->user()->store()['Brand Name']}} </option>
                                @else
                                <option value="{{ $brand['Brand Name'] }} " onclick="changebrand(this);"> {{ $brand['Brand Name'] }} </option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- STORES -->
                    <div class="d-sm-flex justify-content-xl-between align-items-center mb-2">
                        <div class="dropdown ms-0  ">
                            <select class="custom-select select2 form-control" id="searchone" data-live-search="true">
                                <option value="" class="dropdown-item">SELECT STORE NAME</option>
                                <option value="" class="dropdown-item" data-field="">ALL</option>
                                 @foreach($brandAndStore['storeList'] as $store)

                                @if(auth()->user()->store()['Store Name'] == $store->Location)
                                <option value="{{ $store->Location }}"> {{auth()->user()->store()['Store Name']}} </option>
                                @else
                                <option value="{{ $store->Location }} " onclick="changebrand(this);"> {{ $store->Location }}</option>
                                @endif
                                @endforeach 
                            </select>
                        </div>
                    </div>



                </div>
            </div>
            <div class="card">
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="wrapper">
                                <div class="text-wrapper d-flex mb-2">
                                    <h1 class="mb-0 text-light" style="font-size:25px;"> <span class="legend-box"></span> MPOS</h1>

                                </div>
                                <h3 class="text-wrapper mb-5 text-dark font-weight-bold small">₹ 63,85,238.34</h3>

                            </div>
                            <div class="wrapper pt-3">
                                <div class="text-wrapper d-flex mb-2">
                                    <h1 class="mb-0 text-light" style="font-size:25px;"> <span class="legend-box red"></span> BANK MIS</h1>

                                </div>
                                <h3 class="text-wrapper mb-4 text-dark font-weight-bold small">₹ 65401.36</h3>

                            </div>
                        </div>

                        <div class="col-lg-6">

                            <div class="wrapper pt-3 mt-3" style="float:right">
                                <div class="text-wrapper d-flex mb-2">
                                    <h1 class="mb-0 text-light" style="font-size:25px;"> SAP</h1>

                                </div><br>
                                <h3 class="text-wrapper mb-4 font-weight-bold small" style="color:#63c518;">₹ 13,63,157,26.8</h3>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!--Sales chart-->

        <div class="col-lg-6 col-sm-8 grid-margin  grid-margin-lg-0 ">
            <div class="d-flex justify-content-between align-items-start ">

                <div class="d-flex justify-content-between align-items-start ">
                    <div class="dropdown ms-0 ml-md-4 mt-2 mt-lg-0">
                        <span class="dropdown-toggle d-flex align-items-center" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Yesterday</span>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1">
                            <a class="dropdown-item active" href="javascript:thisyear();">Yesterday</a>
                            <a class="dropdown-item active" href="#;">Last Fiscal Year</a>
                            <a class="dropdown-item" href="#">This Fiscal Year </a>
                            <a class="dropdown-item" href="#">This Week</a>
                            <a class="dropdown-item" href="#">Last Week</a>
                            <a class="dropdown-item" href="#">This Month</a>
                            <a class="dropdown-item" href="#">Last Month</a>
                        </div>
                    </div>
                </div>

                <h2 class="text-light font-weight-bold">STORE SALES </h2>

                <div class="d-sm-flex justify-content-xl-between align-items-center mb-2">
                    <div class="dropdown ms-0 ml-md-4 mt-2 mt-lg-0">
                        <span class="dropdown-toggle d-flex align-items-center" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Last 6 Months</span>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1">
                            <a class="dropdown-item" href="#">Last 15 Days</a>
                            <a class="dropdown-item" href="#">Last 1 Month</a>
                            <a class="dropdown-item active" href="#">Last 6 Months</a>

                            <a class="dropdown-item" href="#">Last 3 Months</a>

                            <a class="dropdown-item" href="#">This Fiscal Year</a>
                            <a class="dropdown-item" href="#">Last Fiscal Year</a>

                        </div>
                    </div>

                </div>
            </div>
            <div class="card" >
                <div class="card-body">
                    <img class="imgheight" src="../assets/images/sales.jpg" width="100%">
                </div>
            </div>
        </div>
    </div>
</section>




<script>
    var $j = jQuery.noConflict();
    $j('#search').select2();
    var $j = jQuery.noConflict();
    $j('#searchone').select2();


</script>

