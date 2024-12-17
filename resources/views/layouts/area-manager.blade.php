<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $config['title'] }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}?t={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}?t={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}?t={{ time() }}?t={{ time() }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}?t={{ time() }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}?t={{ time() }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?t={{ time() }}">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.12/sweetalert2.css" integrity="sha512-K0TEY7Pji02TnO4NY04f+IU66vsp8z3ecHoID7y0FSVRJHdlaLp/TkhS5WDL3OygMkVns4bz0/ah4j8M3GgguA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.12/sweetalert2.min.js" integrity="sha512-JbRQ4jMeFl9Iem8w6WYJDcWQYNCEHP/LpOA11LaqnbJgDV6Y8oNB9Fx5Ekc5O37SwhgnNJdmnasdwiEdvMjW2Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/solid.min.css" integrity="sha512-P9pgMgcSNlLb4Z2WAB2sH5KBKGnBfyJnq+bhcfLCFusrRc4XdXrhfDluBl/usq75NF5gTDIMcwI1GaG5gju+Mw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />



    {{-- <!-- End layout styles -->  --}}
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

    @include('layouts.base-layout')


    <script defer src="https://unpkg.com/alpinejs@3.2.4/dist/cdn.min.js"></script>
    {{-- Jquery  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/solid.min.css" integrity="sha512-P9pgMgcSNlLb4Z2WAB2sH5KBKGnBfyJnq+bhcfLCFusrRc4XdXrhfDluBl/usq75NF5gTDIMcwI1GaG5gju+Mw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="{{ asset('assets/css/store-user/app.css') }}?t={{ time() }}" />

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

        <x-topbar.area-manager :brandAndStore="$brandAndStore" />

        <div class="container-fluid page-body-wrapper">
            <div class="fix">
                <x-navigations.index :menus="$menus" />
            </div>

            <div class="main-panel active" style="margin-top:50px !important;">
                <div class="content-wrapper" style="margin-bottom: 90px">

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

        <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}?t={{ time() }}"></script>

        <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}?t={{ time() }}"></script>
        <script src="{{ asset('assets/vendors/jquery-circle-progress/js/circle-progress.min.js') }}?t={{ time() }}">
        </script>
        <script src="{{ asset('assets/js/jquery.cookie.js') }}?t={{ time() }}"></script>
        <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
        <script src="{{ asset('assets/js/hoverable-collapse.js') }}?t={{ time() }}"></script>

        <script src="{{ asset('assets/js/charts/index.js') }}?t={{ time() }}"></script>
        <script src="{{ asset('assets/js/misc.js') }}?t={{ time() }}"></script>

</body>

</html>
