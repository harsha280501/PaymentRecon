<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $config['title'] }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet"> -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <link rel="stylesheet" href="{{ asset('/assets/css/static/font-awesome-solid.min.css') }}">
     <link rel="stylesheet" href="{{ asset('/assets/css/static/font-awesome-all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/assets/css/login.css') }}">

    @include('layouts.base-layout')

    <script defer src="{{ asset('/assets/js/cdn.min.js') }}"></script>


    <script defer src="{{ asset('/assets/js/jquery.min.js') }}" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script defer src="{{ asset('/assets/js/select2.min.js') }}" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>

<body>

    @yield('content')

</body>

</html>
