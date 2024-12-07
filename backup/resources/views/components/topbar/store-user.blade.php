<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top active" id="mobile-header">

    <div class="row">
        <div class="navbar-menu-wrapper d-flex align-items-center">
            <div class="col-2">
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
            </div>

            <div class="col-8">
                <div class="search-field">
                    <form class="d-flex align-items-center h-100" action="#">
                        <div class="input-group">
                            <input type="text" class="form-control border-1" value="{{auth()->user()->store()['Brand Name']}}">
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
                                {{-- <h5 class="dropdown-header text-uppercase ps-2 text-dark">Welcome {{auth()->user()->store()['Brand Name']}}</h5> --}}


                                <div class="dropdown-item py-1 mt-2 d-flex align-items-center justify-content-between" style="gap: .5em">
                                    <label for="exampleInputUsername1">
                                        <h5>Retek Code :</h5>
                                    </label>
                                    <label for="exampleInputUsername1">
                                        <h5 class="text-primary">{{auth()->user()->store()['SAP']}}</h5>
                                    </label>
                                </div>
                                <div class="dropdown-item py-1 mt-2 d-flex align-items-center justify-content-between" style="gap: .5em">
                                    <label for="exampleInputUsername1">
                                        <h5>Store ID :</h5>
                                    </label>
                                    <label for="exampleInputUsername1">
                                        <h5 class="text-primary">{{auth()->user()->store()['Store ID']}}</h5>
                                    </label>
                                </div>
                                <div class="dropdown-item py-1 mt-2 d-flex align-items-center justify-content-between" style="gap: .5em">
                                    <label for="exampleInputUsername1">
                                        <h5>Franchisee Name :</h5>
                                    </label>
                                    <label for="exampleInputUsername1">
                                        <h5 class="text-primary">{{auth()->user()->store()['Franchisee Name']}}</h5>
                                    </label>
                                </div>
                                <div class="dropdown-item py-1 mt-2 d-flex align-items-center justify-content-between" style="gap: .5em">
                                    <label for="exampleInputUsername1">
                                        <h5>Store Type :</h5>
                                    </label>
                                    <label for="exampleInputUsername1">
                                        <h5 class="text-primary">{{auth()->user()->store()['Store Type']}}</h5>
                                    </label>
                                </div>

                                <div class="dropdown-item py-1 mt-2 d-flex align-items-center justify-content-between" style="gap: .5em; flex-wrap: wrap">
                                    <label for="exampleInputUsername1">
                                        <h5 style="width: fit-content;">Location:</h5>
                                    </label>
                                    <div style="margin-left: 10px; width: 100%; text-overflow: ellipsis">
                                        <h5 class="text-primary" style="text-overflow: ellipsis; overflow: hidden; display: block; white-space: nowrap;">
                                            {{auth()->user()->name}}
                                        </h5>
                                    </div>
                                </div>

                                <a class="dropdown-item mt-3 py-1 d-flex align-items-center justify-content-between" href="{{ url('/') }}/suser/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span>Log Out</span>
                                    <i class="mdi mdi-logout ms-1"></i>
                                </a>

                                <form id="logout-form" action="{{ url('/') }}/suser/logout" method="POST" style="display: none;">
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
    </div>

    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
    </button>

    <div class="navbar-menu-wrapper d-flex align-items-stretch" style="height: fit-content">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>
        <div class="search-field ">
            <form class="d-flex align-items-center h-100" action="#">
                <div class="input-group" style="width: 400px !important">
                    <input type="text" class="form-control border-1 dropdown-header text-uppercase ps-2 text-dark" value="{{auth()->user()->store()['Brand Name']}} "><i class="input-group-text mdi mdi-magnify" style="display: none"></i>
                </div>
            </form>
        </div>
        <div class="d-flex flex-column w-100 px-3">
            <div style="width: inherit; margin-top: .8em" class="row">
                <div class="d-flex gap-1 px-2 col-4" style="justify-self: start">
                    <h5 class="fs-md">Retek Code : </h5>
                    <h5 class="text-primary fs-md">{{auth()->user()->store()['SAP']}} </h5>
                </div>
                <div class="d-flex gap-1 px-2 col-4">
                    <h5 class="fs-md">Store ID : </h5>
                    <h5 class="text-primary fs-md">{{auth()->user()->store()['Store ID']}} </h5>
                </div>
                <div class="d-flex gap-1 px-2 col-4 col-lg-4">
                    <h5>Store Type :</h5>
                    <h5 class="text-primary fs-md">{{auth()->user()->store()['Store Type']}} </h5>
                </div>

            </div>
            <div style=" width: inherit;" class="row pb-2">
                {{-- style="max-width: 400px; overflow-y: hidden !important;" --}}
                <div class="d-flex gap-1 px-2 col-6">
                    <h5 class="fs-md" style="width: fit-content;">Location: </h5>
                    <h5 class="text-primary fs-md" style=" overflow: hidden;">{{auth()->user()->name}}</h5>
                </div>
                <div class="d-flex gap-1 px-2 col-6">
                    <h5>Franchisee Name:</h5>
                    <h5 class="text-primary fs-md">{{auth()->user()->store()['Franchisee Name']}}</h5>
                </div>
            </div>
        </div>
        <ul class="navbar-nav navbar-nav-left">
        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-account-circle ms-1"></i>
                </a>
                <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">

                    <div class="p-2">
                        <h5 class="dropdown-header text-uppercase ps-2 text-dark">Welcome to the Collection Management & Reconciliation Portal</h5>
                        <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="{{ url('/') }}/suser/changepwd">Change Password </a>
                        <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="{{ url('/') }}/suser/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span>Log Out</span>
                            <i class="mdi mdi-logout ms-1"></i>
                        </a>
                        <form id="logout-form" action="{{ url('/') }}/suser/logout" method="POST" style="display: none;">
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
                            <p class="text-gray ellipsis mb-0">Just a reminder that you have an event today
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


</script>
