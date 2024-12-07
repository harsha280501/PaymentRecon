<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $config['title'] }}</title>
    <!-- plugins:css -->
    <!-- plugins:css -->
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}?t={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}?t={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}?t={{ time() }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/commercial-head/app.css') }}?t={{ time() }}" />
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}?t={{ time() }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}?t={{ time() }}">

    <link rel="stylesheet" href="{{ asset('assets/css/static/select2.min.css') }}?t={{ time() }}" />




    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?t={{ time() }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

    <link rel="stylesheet" href="{{ asset('assets/css/static/sweet-alert.min.css') }}?t={{ time() }}" />

    <script src="{{ asset('assets/js/static/sweet-alert2.min.js') }}?t={{ time() }}"></script>
    <script defer src="{{ asset('assets/js/custom/bankMIS.js') }}?t={{ time() }}"></script>

    @include('layouts.base-layout')

    <script defer src="{{ asset('assets/js/alpine/alpine.js') }}?t={{ time() }}"></script>

    <link href="{{ asset('assets/css/commercial-team/app.css') }}?t={{ time() }}" />
    <script defer src="{{ asset('assets/js/custom/uploads.js') }}?t={{ time() }}"></script>
    <script defer src="{{ asset('assets/js/custom/bankStatementUpload.js') }}?t={{ time() }}"></script>
    <script src="{{ asset('assets/js/jquery/jquery.js') }}?t={{ time() }}"></script>
    <script src="{{ asset('assets/js/static/select2.min.js') }}?t={{ time() }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/static/font-awesome-solid.min.css') }}?t={{ time() }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/static/font-awesome-all.min.css') }}?t={{ time() }}" />

</head>

<body class="sidebar-icon-only">

    <div class="container-scroller">
        <div class="row p-0 m-0 proBanner d-none" id="proBanner">
            <div class="col-md-12 p-0 m-0">
                <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
                    <div class="ps-lg-1">

                    </div>
                    <div class="d-flex align-items-center justify-content-between">

                        <button id="bannerClose" class="btn border-0 p-0">
                            <i class="mdi mdi-close text-white me-0"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <x-topbar.commertial-team :brandAndStore="$brandAndStore" />

        <div class="container-fluid page-body-wrapper">

            <div class="fix">
                <x-navigations.index :menus="$menus" />
            </div>

            <div class="main-panel active">
                <div class="content-wrapper" style="margin-bottom: 90px;">
                    @yield('content')
                </div>
                <footer class="footer">
                    <div class="footer-inner-wraper">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between py-2">
                            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright ©
                                2023 <a href="#" target="_blank">ABFRL</a></span>

                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script>
            function lastyear() {
                document.getElementById("sales").style.display = "none";
                document.getElementById("sales1").style.display = "block";
                document.getElementById("topcust").style.display = "none";
                document.getElementById("topcust1").style.display = "block";
            }

            function thisyear() {
                document.getElementById("sales").style.display = "block";
                document.getElementById("sales1").style.display = "none";
                document.getElementById("topcust").style.display = "block";
                document.getElementById("topcust1").style.display = "none";
            }

        </script>
        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })

        </script>

        @yield('scripts')
        <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>

        <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/jquery-circle-progress/js/circle-progress.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
        <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
        <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>

        <script src="{{ asset('assets/js/misc.js') }}"></script>

</body>

</html>
