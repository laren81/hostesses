<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} @yield('title')</title>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">


    <!-- Styles -->
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/inspinia.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('css/design.css') }}" rel="stylesheet">
    @yield('link')
    @yield('style')

	<!-- Scripts -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>

        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/jquery.metisMenu.js') }}"></script>
        <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script> 
        <script src="{{ asset('js/inspinia.js') }}"></script>
</head>
<body class='md-skin fixed-nav fixed-sidebar no-skin-config pace-done'>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    @if(Auth::check())
                    <li class="nav-header">
                        <div class="dropdown profile-element"> 
                            <span>
                                <img alt="image" class="img-circle" src="{{asset('images/blank-profile.png')}}" />
                            </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs">
                                        <strong class="font-bold">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</strong>
                                        <b class="caret"></b>
                                    </span> 
                                </span> 
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li>
                                    <a href="{{ route('admin.users.show',auth()->user()->id) }}">
                                        {{__('texte.layouts_arr.app.profile')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{env('APP_URL')."/messenger"}}">
                                        {{__('texte.layouts_arr.app.messenger')}}
                                        <span id="nav_thread_count" class="badge badge-pill badge-danger badge-notify"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        {{__('texte.layouts_arr.app.exit')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="{{areActiveRoutes(['admin.users.index','admin.users.create','admin.users.show','admin.users.edit','admin.roles.index','admin.roles.create','admin.roles.show','admin.roles.edit','admin.prices.index']) ? 'active' : ''}}">
                        <a href="#">{{__('texte.layouts_arr.app.administration')}} <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="{{isActiveRoute('admin.users.index') ? 'active' : ''}}"><a href="{{ route('admin.users.index') }}"> {{__('texte.layouts_arr.app.users')}}</a></li>
                            <li class="{{isActiveRoute('admin.roles.index') ? 'active' : ''}}"><a href="{{ route('admin.roles.index') }}"> {{__('texte.layouts_arr.app.roles')}}</a></li>
                            <li class="{{isActiveRoute('admin.prices.index') ? 'active' : ''}}"><a href="{{route('admin.prices.index')}}"> {{__('texte.layouts_arr.app.prices')}}</a></li>
                        </ul>
                    </li>     
                    <li class="{{isActiveRoute('admin.events.index') ? 'active' : ''}}">
                        <a href="{{route('admin.events.index')}}"> {{__('texte.layouts_arr.app.events')}}</a>
                    </li>
                    <li class="{{isActiveRoute('admin.event_offers.index') ? 'active' : ''}}">
                        <a href="{{route('admin.event_offers.index')}}"> {{__('texte.layouts_arr.app.event_offers')}}</a>
                    </li>
                    <li class="{{isActiveRoute('admin.invoices.index') ? 'active' : ''}}">
                        <a href="{{route('admin.invoices.index')}}"> {{__('texte.layouts_arr.app.invoices')}}</a>
                    </li>                    
                    @endif                  
                    
                </ul>
            </div>
        </nav>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-fixed-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="{{ url('/') }}">
                                {{ config('app.name', 'Склад') }}
                            </a>
                        </li>
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}"> {{__('texte.layouts_arr.app.enter')}}</a></li>
                        @else
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                {{__('texte.layouts_arr.app.exit')}}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                        @endif
                    </ul>

                </nav>
            </div>
            @yield('content')
            <div class="footer">
                <div class="pull-right">
                    <a href="https://intersoft.bg/изработка-на-сайт" target="_blank">изработка на сайт</a>  InterSOFT
                </div>
                <div>
                    &copy;Всички права запазени
                </div>
            </div>
        </div>        
    </div>     
</body>
</html>
<script type="text/javascript">
    
    $('.sidebar-collapse').slimScroll({
        height: '100%',     
    });    
    
    $(document).ready(function(){
        $('a[disabled="disabled"]').addClass('not-active');
    });
    

</script>
