<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin LTE</title>
    @vite(['resources/scss/main.scss', 'resources/js/app.js'])
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('AdminLTE-2.4.18/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('AdminLTE-2.4.18/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE-2.4.18/bower_components/Ionicons/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE-2.4.18/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE-2.4.18/plugins/iCheck/all.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE-2.4.18/bower_components/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE-2.4.18/dist/css/skins/skin-blue.min.css')}}">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <x-header></x-header>
    @auth()
        <x-sidebar></x-sidebar>
    @endauth

    <div class="content-wrapper">
        <section class="content container-fluid">
            <!-- Display alert messages -->
            @if(session('success'))
                <x-alert type="success" message="{{session('success')}}" timeout="3000" />
            @endif
            @if(session('error'))
                <x-alert type="error" message="{{session('error')}}" timeout="3000" />
            @endif
            {{ $slot }}
        </section>
    </div>
    @auth()
        <x-footer />
    @endauth

</div>

<!-- jQuery 3 -->
<script src="{{asset('AdminLTE-2.4.18/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('AdminLTE-2.4.18/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('AdminLTE-2.4.18/dist/js/adminlte.min.js')}}"></script>

{{ $script ?? ''}}
</body>
</html>
