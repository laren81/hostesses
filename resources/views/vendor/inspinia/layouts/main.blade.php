<!DOCTYPE html>
<html lang="@yield('lang', config('app.locale', 'en'))">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Atnic">

  <title>@yield('title', config('app.name', 'INSPINIA'))</title>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Styles -->
  @section('styles')
  <link href="{{ asset('css/inspinia.css') }}" rel="stylesheet">
  <link href="{{ asset('css/design.css') }}" rel="stylesheet">
  @show

    <script src="{{ asset('/js/jquery.js') }}"  charset="utf-8"></script> 
    <script src="{{ asset('/js/bootstrap.min.js') }}"  charset="utf-8"></script>
    <script src="{{ asset('/js/manifest.js') }}" charset="utf-8"></script>
    <script src="{{ asset('/js/vendor.js') }}" charset="utf-8"></script>
    <script src="{{ asset('/js/jquery.metisMenu.js') }}" charset="utf-8"></script>
    <script src="{{ asset('/js/jquery.slimscroll.min.js') }}" charset="utf-8"></script>
    

    <script src="{{ asset('/js/inspinia.js') }}" charset="utf-8"></script>
  @stack('head')
</head>

<body class="{{ config('inspinia.skin', '') }} {{ config('inspinia.sidebar', '') }} {{ config('inspinia.nav', '') }}">
  <div id="wrapper">
    @include('vendor.inspinia.layouts.sidebar.main')
    @include('vendor.inspinia.layouts.main-panel.main')
  </div>

  
	@show
	@stack('body')
</body>

</html>
