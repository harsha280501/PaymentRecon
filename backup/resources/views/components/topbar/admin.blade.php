<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top active" id="mobile-header">

    <div class="row">
        <div class="navbar-menu-wrapper d-flex align-items-center">
            <div class="col-2">
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <!--span class="mdi mdi-menu"></span--><i class="fa fa-bars" aria-hidden="true"></i>
                </button>
            </div>

            <div class="col-8">
                <div class="search-field">
                    <form class="d-flex align-items-center h-100" action="#">
                        <div class="input-group">
                            <input type="text" class="form-control border-1" value="Welcome {{auth()->user()->name}}">
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-2">
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-account-circle ms-1" style="margin-left: .5em !important"></i>
                        </a>
                        <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
                            <div class="p-2">
                                <h5 class="dropdown-header text-uppercase ps-2 text-dark">Welcome {{auth()->user()->name}}</h5>
                                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="{{ url('/') }}/admin/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span>Log Out</span>
                                    <i class="mdi mdi-logout ms-1"></i>
                                </a>

                                <form id="logout-form" action="{{ url('/') }}/admin/logout" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="col-2">
                <ul class="navbar-nav navbar-nav-left">

                </ul>
            </div>
        </div>
    </div>
</nav>

{{-- <!-- partial:partials/_navbar.html desktop -->  --}}
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row" id="desktop-header">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">

        <a class="navbar-brand brand-logo" href="{{ url('/') }}"><img src="{{ asset('assets/images/logo.jpg') }}" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}"><img src="{{ asset('assets/images/logo.jpg') }}" alt="logo" /></a>

        <!--div class="float-right logo-text">
         <span style="font-size:14px;color:#fff">Payment Reconciliation Portal</span></div-->
    </div>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
    </button>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>
        <div class="search-field w-50">
            <form class="d-flex align-items-center h-100" action="#">
                <div class="input-group">
                    <input type="text" class="form-control border-1 dropdown-header text-uppercase ps-2 text-dark" value="Welcome {{auth()->user()->name}}"><i class="input-group-text mdi mdi-magnify" style="display: none"></i>
                </div>
            </form>
        </div>
        <ul class="navbar-nav navbar-nav-left">

        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <!-- BRAND -->
            {{-- <!-- <li class="nav-item  dropdown d-none d-md-block " id="reportDropdown">
                <a class="btn bg-brown nav-link dropdown-toggle" type="button" id="reportDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false" style="width:89%;padding-left:20px;padding-right:20px;font-size:12px;"> <i class="fa fa-group" aria-hidden="true"></i> <span class="brandLink">{{auth()->user()->brandName()}}</span></a>

            <div class="dropdown-menu navbar-dropdown brand" aria-labelledby="reportDropdown">
                <a class="dropdown-item" data-field="" href="#">All</a>
                @foreach ($brandAndStore['brandList'] as $brand)
                @if(auth()->user()->brandName()["Brand Name"] == $brand['Brand Name'])
                <a class="dropdown-item active" data-field="{{ $brand['Brand Name'] }}" href="#">{{auth()->user()->store()->brandName}}</a>
                @else
                <a class="dropdown-item" data-field="{{ $brand['Brand Name'] }}" href="#" onclick="changebrand(this);">{{ $brand['Brand Name'] }}</a>
                @endif
                @endforeach
            </div>
            </li> --> --}}
            <!-- STORES -->
            {{-- <!--  <li class="nav-item  dropdown d-none d-md-block " id="reportDropdown">
                <a class="btn bg-brown nav-link dropdown-toggle" type="button" id="reportDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false" style="width:89%;padding-left:20px;padding-right:20px;font-size:12px;"> <i class="fa fa-home" aria-hidden="true"></i> <span class="storeLink">{{auth()->user()->storeName()}}</span> </a>
            <div class="dropdown-menu navbar-dropdown store" aria-labelledby="reportDropdown">
                <a class="dropdown-item" data-field="" href="#">All</a>
                @foreach ($brandAndStore['storeList'] as $store)
                @if(auth()->user()->store->storeName() == $store['Location'])
                <a class="dropdown-item active" data-field="{{ $store['Location'] }}" href="#">{{auth()->user()->storeName()}}</a>
                @else
                <a class="dropdown-item" data-field="{{ $store['Location'] }}" href="#" onclick="changestore(this);">{{ $store['Location'] }}</a>
                @endif
                @endforeach
            </div>
            </li> --> --}}

            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">

                    <i class="mdi mdi-account-circle ms-1"></i>


                </a>
                <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">

                    <div class="p-2">
                        <h5 class="dropdown-header text-uppercase ps-2 text-dark">Welcome {{auth()->user()->name}}</h5>
                        <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="{{ url('/') }}/admin/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span>Log Out</span>
                            <i class="mdi mdi-logout ms-1"></i>
                        </a>

                        <form id="logout-form" action="{{ url('/') }}/admin/logout" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </div>
                </div>
            </li>

            <li class="nav-item dropdown" style="display: none;">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                    <i class="mdi mdi-bell-outline"></i>
                    <span class="count-symbol bg-danger"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                    <h6 class="p-3 mb-0 bg-primary text-white py-4">Notifications</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-success">
                                <i class="mdi mdi-calendar"></i>
                            </div>
                        </div>
                        <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                            <h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
                            <p class="text-gray ellipsis mb-0"> Just a reminder that you have an event today
                            </p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-warning">
                                <i class="mdi mdi-settings"></i>
                            </div>
                        </div>
                        <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                            <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
                            <p class="text-gray ellipsis mb-0"> Update dashboard </p>
                        </div>
                    </a>

                    <div class="dropdown-divider"></div>
                    <h6 class="p-3 mb-0 text-center">See all notifications</h6>
                </div>
            </li>
        </ul>

    </div>
</nav>
<script type="text/javascript">
    var baseUrl = BASEURL;
    var csrf = CSRFTOKEN;
    var formData = new FormData();
    /* var selector = '.store a';

        $(selector).on('click', function(){

        var formData = new FormData();

      $.ajax({
        type: "POST",
        url: baseUrl + "/",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {

        },
        error: function (jqXHR, exception) {

        },
      });

        $(selector).removeClass('active');
        $(this).addClass('active');
        var textval=$(".store a.active").attr("data-field");
        $('.storeLink').html(textval);

    });


        var selector1 = '.brand a';
        $(selector1).on('click', function(){
        $(selector1).removeClass('active');
        var formData = new FormData();
        $(this).addClass('active');
        var textval=$(".brand a.active").attr("data-field");
        $('.brandLink').html(textval);

        $.ajax({
        type: "POST",
        url: baseUrl + "/",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
        },
        error: function (jqXHR, exception) {

        },
      });

    }); */

    function changebrand(event) {
        var selector1 = document.querySelectorAll(".brand a");
        $(selector1).removeClass('active');
        $(event).addClass('active');
        var textval = $(".brand a.active").attr("data-field");
        $('.brandLink').html(textval);
        $.ajax({
            type: "POST"
            , url: baseUrl + "/"
            , headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            , }
            , data: formData
            , processData: false
            , contentType: false
            , success: function(response) {}
            , error: function(jqXHR, exception) {

            }
        , });
    }

    function changestore(event) {
        var selector1 = document.querySelectorAll(".store a");
        $(selector1).removeClass('active');
        $(event).addClass('active');
        var textval = $(".store a.active").attr("data-field");
        $('.storeLink').html(textval);
        $.ajax({
            type: "POST"
            , url: baseUrl + "/"
            , headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            , }
            , data: formData
            , processData: false
            , contentType: false
            , success: function(response) {}
            , error: function(jqXHR, exception) {

            }
        , });
    }

</script>
