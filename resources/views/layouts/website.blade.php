<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hostesses</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/inspinia.css') }}" rel="stylesheet">
        <link href="{{ asset('css/website/main.css') }}" rel="stylesheet">
        <link href="{{ asset('css/design.css') }}" rel="stylesheet">
        <link href="{{ asset('css/website.css') }}" rel="stylesheet">
        
        <link href="{{ asset('css/website/responsive.css') }}" rel="stylesheet">


        <script src="{{ asset('/js/jquery.js') }}"  charset="utf-8"></script>
        <script src="{{ asset('/js/bootstrap.min.js') }}"  charset="utf-8"></script>

        <script src="{{ asset('/js/jquery.slimscroll.min.js') }}" charset="utf-8"></script>
        @yield('style')
        @yield('link')

    </head>
    <body style="line-height:25px;">
        <div class="row header-holder">
            <div class="col-md-12">
                
                @if(auth()->check())
                <div class="col-lg-4 col-md-4 col-sm-12 column column-left">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">Hello, {{auth()->user()->first_name}} {{auth()->user()->last_name}}</strong>  
                                <i class="glyphicon glyphicon-comment" style="color:red;display:{{auth()->user()->unreadThreads()>0 ? 'inline-block' : 'none'}};"></i>
                                <b class="caret"></b>                                
                            </span> 
                        </span> 
                    </a>
                    
                    <ul class="dropdown-menu animated fadeInLeft m-t-xs">
                        <li>
                            <a href="{{ route('users.show',auth()->user()->id) }}">
                                {{__('texte.layouts_arr.website.profile')}}
                            </a>
                        </li>
                        <li>
                            <a href="{{env('APP_URL')."/messenger"}}">
                                Messenger
                                <span id="nav_thread_count" class="badge badge-pill badge-danger badge-notify"></span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                {{__('texte.layouts_arr.website.exit')}}
                            </a>
                        </li>
                    </ul>
                </div>
                @else
                <div class="col-lg-4 col-md-4 col-sm-12 column column-left">
                    <a href="{{route('login')}}">Enter</a>
                </div>
                @endif
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                <div class="col-lg-4 col-md-4 col-sm-12 column column-center">
                    <a href="mailto:info@aspl.bg">E-mail: info@messehostessen.com.de</a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 column column-right">
                    <p>Lorem ipsum dolor sit amet</p>
                </div>                
            </div>
        </div>

        <div class="row navbar-holder">
            <nav class="navbar navbar-expand-md">
                <a class="navbar-anchor" href="{{config('app.url')}}">
                    <img class="logo" typeof="foaf:Image" src="{{asset('/images/logo.png')}}" alt="Logo"/>
                </a>
                <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="main-navigation">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{config('app.url')}}">Hostesses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Promotional Staff</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Booth Models</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Exhibitions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Contact us</a>
                        </li>
                        @if(auth()->check() && auth()->user()->role_id==1)
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.home')}}">Administration</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
        </div>

        @yield('content')

        <div class="clear-50"></div>

        <footer id='footer' class="page-footer">
            <div class="container">
                <div class="row" style="text-align: center">
                    <div class="col-xs-6 col-sm-3">
                        <h5 style="font-size: 1.2em;">
                            <a href="/english/exhibition-staff-booth-hostess/" title="Exhibition Services">Exhibition Services</a>   
                        </h5>
                        <br>
                        <ul>     
                            <li><a href="/hostess/exhibition-stand-hostesses-leipzig/" title="exhibition Leipzig">exhibition Leipzig</a></li>
                            <li><a href="/hostess/exhibition-stand-hostesses-duesseldorf/" title="exhibition Dusseldorf">exhibition Dusseldorf</a></li>
                            <li><a href="/hostess/exhibition-stand-hostesses-essen/" title="exhibition Essen">exhibition Essen</a></li>
                            <li><a href="/hostess/exhibition-stand-hostesses-cologne/" title="exhibition Cologne">exhibition Cologne</a></li>
                            <li><a href="/hostess/exhibition-stand-hostesses-berlin/" title="exhibition Berlin">exhibition Berlin</a></li>
                            <li><a href="/hostess/exhibition-stand-hostesses-dresden/" title="exhibition Dresden">exhibition Dresden</a></li>
                            <li><a href="/hostess/exhibition-stand-hostesses-hamburg/" title="exhibition Hamburg">exhibition Hamburg</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <h5 style="font-size: 1.2em;">
                          <a href="/english/booking-hostess/" title="Booking Hostesses">Booking Hostesses</a>     
                        </h5> 
                        <br>
                        <ul>     
                            <li><a href="/hostess/exhibition-stand-hostesses-hanover/" title="exhibition Hanover">exhibition Hanover</a></li>
                            <li><a href="/hostess/exhibition-stand-hostesses-frankfurt/" title="exhibition Frankfurt">exhibition Frankfurt</a></li>
                            <li><a href="/hostess/exhibition-stand-hostesses-stuttgart/" title="exhibition Stuttgart">exhibition Stuttgart</a></li>
                            <li><a href="/exhibition-stand-hostesses-nuernberg/" title="exhibition Nuernberg">exhibition Nuernberg</a></li>
                            <li><a href="/hostess/exhibition-stand-hostesses-munich/" title="exhibition Munich">exhibition Munich</a></li>
                            <li><a href="/hostess/tradeshow-hostesses-cologne/" title="trade show Cologne">trade show Cologne</a></li>
                            <li><a href="/hostess/tradeshow-hostesses-duesseldorf/" title="trade show Duesseldorf">trade show Duesseldorf</a></li>
                        </ul>
                    </div>

                    <div class="col-xs-6 col-sm-3">
                        <h5 style="font-size: 1.2em;">
                         <a href="/english/booth-models/" title="Booking Hostesses">Booking Booth Models</a>     
                        </h5> 
                        <br>
                        <ul>
                            <li><a href="/english/booth-models/cologne/hostesses/" title="Booth Models Cologne">Booth Models Cologne</a></li>
                            <li><a href="/english/booth-models/frankfurt/hostesses/" title="Booth Models Frankfurt">Booth Models Frankfurt</a></li>
                            <li><a href="/english/booth-models/munich/hostesses/" title="Booth Models Munich">Booth Models Munich</a></li>  
                            <li><a href="/english/booth-models/berlin/hostesses/" title="Booth Models Berlin">Booth Models Berlin</a></li>
                            <li><a href="/english/booth-models/nuremberg/hostesses/" title="Booth Models Nuremberg">Booth Models Nuremberg</a></li>
                            <li><a href="/english/booth-models/hamburg/hostesses/" title="Booth Models Hamburg">Booth Models Hamburg</a></li>
                            <li><a href="/english/booth-models/hannover/hostesses/" title="Booth Models Hannover">Booth Models Hannover</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <h5 style="font-size: 1.2em;">
                          <a href="/EN/promotional-agency/" title="Locations">Locations</a>   
                        </h5> 
                        <br>
                        <ul>
                            <li><a href="/hostess/agency-frankfurt/"> Frankfurt</a></li>
                            <li><a href="/hostess/agency-hanover/"> Hanover</a></li>
                            <li><a href="/hostess/agency-hamburg/"> Hamburg</a></li>
                            <li><a href="/hostess/agency-berlin/"> Berlin</a></li>
                            <li><a href="/hostess/agency-cologne/"> Cologne</a></li>
                            <li><a href="/hostess/agency-essen/"> Essen</a></li>
                            <li><a href="/hostess/agency-duesseldorf/"> Duesseldorf</a></li>
                            <li><a href="/hostess/agency-munich/"> Munich</a></li>
                        </ul>
                    </div>
                </div>
            </div>            
        </footer>
        <div id="copyright" class="col-sm-12" style="text-align:center">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom: 20px;">
                    <a href="{{config('app.url')}}">
                        <img class="logo" typeof="foaf:Image" src="{{asset('/images/logo.png')}}" alt="Logo"/>
                    </a>
                </div>
            </div>
            &copy;Всички права запазени
        </div>
    </body>
</html>