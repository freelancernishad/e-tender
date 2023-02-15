<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('dashboard_asset/css/bootstrap.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard_asset/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">


</head>

<body>

    <div id="wrapper">



        <router-view></router-view>

        @section('container')
        @show()
    </div>

<script src="{{ asset('js/app.js?ver=1.0.0') }}"></script>




</body>

</html>
