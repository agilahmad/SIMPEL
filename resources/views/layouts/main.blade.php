<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="theme_ocean">
    <!--! The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags !-->
    <!--! BEGIN: Apps Title-->
    <title>CSIRT - Pelaporan</title>
    <!--! END:  Apps Title-->
    <!--! BEGIN: Favicon-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/select2-theme.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme.min.css') }}">
    @stack('css')
    <!--! END: Custom CSS-->
    <!--! HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries !-->
    <!--! WARNING: Respond.js doesn"t work if you view the page via file: !-->
    <!--[if lt IE 9]>
   <script src="https:oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
   <script src="https:oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
@include('layouts.sidebar')
@include('layouts.topbar')
@yield('content')

<script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/tagify.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/tagify-data.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/quill.min.js') }}"></script>
{{-- <script src="{{ asset('assets/vendors/js/select2.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/vendors/js/select2-active.min.js') }}"></script> --}}
<script src="{{ asset('assets/js/common-init.min.js') }}"></script>
{{-- <script src="{{ asset('assets/vendors/js/apexcharts.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/vendors/js/jquery.time-to.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/analytics-init.min.js') }}"></script> --}}
<script src="{{ asset('assets/js/theme-customizer-init.min.js') }}"></script>
<!--! END: Theme Customizer !-->
@stack('js')
<!--! END: Theme Customizer !-->
</body>

</html>
