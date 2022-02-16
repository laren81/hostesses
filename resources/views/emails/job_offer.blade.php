<!DOCTYPE html>

<html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width; initial-scale=1.0">
         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        
        
        <style>
            body{
                font-family: 'Roboto',sans-serif !important;
                font-size: 14px;
                line-height: 1.42857143;
                color: #333;
                background-color: #fff;
            }
            .col-xs-12{
                width:100%;
                position: relative;
                min-height: 1px;
                padding-right: 15px;
                margin-left: 15px;
            }
            .col-sm-3 {
                width: 25%;
                float: left;
            }
            
            .row{
                width:100%;
                clear: both;
                display: table;
                margin-right: -15px;
                margin-left: -15px;
            }
            
            .panel {
                margin-bottom: 20px;
                background-color: #fff;
                border: 1px solid transparent;
                    border-top-color: transparent;
                    border-right-color: transparent;
                    border-bottom-color: transparent;
                    border-left-color: transparent;
                border-radius: 4px;
                -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
                box-shadow: 0 1px 1px rgba(0,0,0,.05);
            }
            
            .panel-default {
                border-color: #ddd;
            }
            
            .panel-body {
                padding: 15px;
            }
            
            .form-group {
                margin-bottom: 15px;
            }
            
            table {
                border-spacing: 0;
                border-collapse: collapse;
            }
            
            table {
                background-color: transparent;
            }
            
            .table {
                max-width: 100%;
                margin-bottom: 20px;
            }
            
            .table-bordered {
                border: 1px solid #ddd;
            }
            
            .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                padding: 8px;
                line-height: 1.42857143;
                vertical-align: top;
                border-top: 1px solid #ddd;
                border:1px solid #ddd;
            }
            th{
                text-align: left;
            }
            
            .table-striped > tbody > tr:nth-of-type(2n+1) {
                background-color: #f9f9f9;
            }
            
            footer{
                border-top: 1px solid #dddddd;
                padding: 40px 0px;
                display: block;
            }
            
            .container{
                clear: both;
                display: table;
                padding-right: 15px;
                padding-left: 15px;
                margin-right: auto;
                margin-left: auto;
                width:1170px;
            }
            
            .grid {
                display: grid;
            }
            .fot_col {
                margin-bottom: 25px;
            }
            
            .footer_title {
                text-transform: uppercase;
                font-weight: bold;
                margin-top:10px;
                margin-bottom: 25px;
                font-size: 18px;
            }
            
            .flex {
                display: flex;
            }
            p {
                margin: 0 0 10px;
            }
            
            
            .fa {
                display: inline-block;
                font: normal normal normal 14px/1 FontAwesome;
                    font-size: 14px;
                font-size: inherit;
                text-rendering: auto;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            
            .footert_contact {
                color: #4a4a4a;
                line-height: 38px;
            }
            
            
        </style>
    </head>

    <body>
        <center>
            <h2><a class="logo_link col-sm-3" href=""><img src="{{asset('images/logo.png')}}"></a></h2>
        </center>


        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                Dear {{$hostess->user->first_name}},
                                we have new job proposal that might be of interest for you. 
                            </div>
                        </div>     
                                
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Event: </strong>
                                {{ $event->name}}
                            </div>
                        </div> 
                            
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Time: </strong>
                                {{date('m.Y',strtotime($event->date_from)) === date('m.Y',strtotime($event->date_to)) ? (date('d',strtotime($event->date_from)).' - '.date('d.m.Y',strtotime($event->date_to))) : (date('Y',strtotime($event->date_from)) === date('Y',strtotime($event->date_to)) ? (date('d.m',strtotime($event->date_from)).' - '.date('d.m.Y',strtotime($event->date_to))) : (date('d.m.Y',strtotime($event->date_from)).' - '.date('d.m.Y',strtotime($event->date_to))))}}
                            </div>
                        </div> 
                        
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Region: </strong>
                                {{ $event->region->name}}
                            </div>
                        </div> 
                        
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>City: </strong>
                                {{ $event->city->name}}
                            </div>
                        </div>  
                                
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Location: </strong>
                                {{ $event->location}}
                            </div>
                        </div>                     
                        
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            @foreach($event->positions as $index=>$position)
                            <div class="tab-pane">
                                <div class="panel-body">
                                    <div class='row'>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.staff_type')}}: </strong>
                                                {{$position->staff_number.' '.__('texte.staff_types_arr')[$position->staff_type]}} - {{$position->staff_gender==1 ? __('texte.events_arr.show.female') : ($position->staff_gender==2 ? __('texte.events_arr.show.male') : __('texte.events_arr.show.gender_not_specified'))}}
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.period')}}: </strong>
                                                @if($position->date_from!=null && $position->date_to!=null)
                                                    @if(date('m.Y',strtotime($position->date_from)) === date('m.Y',strtotime($position->date_to)))
                                                        {{date('d',strtotime($position->date_from))}} - {{date('d.m.Y',strtotime($position->date_to))}}
                                                    @elseif(date('Y',strtotime($position->date_from)) === date('Y',strtotime($position->date_to)))
                                                        {{date('d.m',strtotime($position->date_from))}} - {{date('d.m.Y',strtotime($position->date_to))}}
                                                    @else
                                                        {{date('d.m.Y',strtotime($position->date_from))}} - {{date('d.m.Y',strtotime($position->date_to))}}
                                                    @endif
                                                @else
                                                    @if(date('m.Y',strtotime($event->date_from)) === date('m.Y',strtotime($event->date_to)))
                                                        {{date('d',strtotime($event->date_from))}} - {{date('d.m.Y',strtotime($event->date_to))}}
                                                    @elseif(date('Y',strtotime($event->date_from)) === date('Y',strtotime($event->date_to)))
                                                        {{date('d.m',strtotime($event->date_from))}} - {{date('d.m.Y',strtotime($event->date_to))}}
                                                    @else
                                                        {{date('d.m.Y',strtotime($event->date_from))}} - {{date('d.m.Y',strtotime($event->date_to))}}
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.time')}}: </strong>
                                                @if($position->time_from && $position->time_till)
                                                    {{ date('H:i',strtotime($position->time_from)).' - '.date('H:i',strtotime($position->time_till)) }}
                                                @else
                                                    {{ date('H:i',strtotime($event->time_from)).' - '.date('H:i',strtotime($event->time_till)) }}
                                                @endif
                                            </div>
                                        </div>

                                        @if($position->height_from!=null || $position->height_to!=null)
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.height')}}: </strong>
                                                {{ $position->height_from.' - '.$position->height_to }}
                                            </div>
                                        </div>
                                        @endif

                                        @if($position->size_from!=null || $position->size_to!=null)
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.size')}}: </strong>
                                                {{ $position->size_from.' - '.$position->size_to }}
                                            </div>
                                        </div>
                                        @endif

                                        @if($position->language_1!=null || $position->language_2!=null || $position->language_3!=null)
                                        <h4 style="margin-left:15px;">Languages required</h4>

                                            @if($position->language_1!=null)
                                            <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left:35px;">
                                                <div class="form-group">
                                                    <strong>{{$position->language_1=='de' ? __('texte.events_arr.show.german') : __('texte.events_arr.show.english')}}: </strong>
                                                    {{ __('texte.short_language_levels_arr')[$position->language_1_lvl]}}
                                                </div>
                                            </div>
                                            @endif

                                            @if($position->language_2!=null)
                                            <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left:35px;">
                                                <div class="form-group">
                                                    <strong>{{$position->language_2=='de' ? __('texte.events_arr.show.german') : __('texte.events_arr.show.english')}}: </strong>
                                                    {{ __('texte.short_language_levels_arr')[$position->language_2_lvl]}}
                                                </div>
                                            </div>
                                            @endif

                                            @if($position->language_3!=null)
                                            <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left:35px;">
                                                <div class="form-group">
                                                    <strong>{{__('texte.extended_languages_arr')[$position->language_3]}}: </strong>
                                                    {{ __('texte.short_language_levels_arr')[$position->language_3_lvl]}}
                                                </div>
                                            </div>
                                            @endif
                                        @endif

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.job_description')}}: </strong>
                                                {{ $position->job_description }}
                                            </div>
                                        </div>

                                        @if($position->outfit!=null)
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.outfit')}}: </strong>
                                                {{ $position->outfit }}
                                            </div>
                                        </div>
                                        @endif

                                        @if($position->other_comments!=null)
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.other_comments')}}: </strong>
                                                {{ $position->other_comments }}
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>  
                            </div>
                            @endforeach
                         </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                Please follow this <a href="#">link</a> for details and job proposal acceptance.
                            </div>
                        </div>
                    </div>
                </div>                                 
            </div>
        </div>
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 grid fot_col">
                        <a href=""><img class="float_left" src="{{asset('images/logo.png')}}"></a>
                    </div>
                    <div class="col-sm-3 grid fot_col">
                          <h4 class="footer_title">Contacts</h4>
                          <p class="flex"><i class="fa fa-map-marker paddright" aria-hidden="true"></i> </p>
                          <a class="footert_contact" href="tel:"><i class="fa fa-phone paddright" aria-hidden="true"></i> 123456</a>
                          <a class="footert_contact" href="mailto:"><i class="fa fa-envelope-o paddrightcontact" aria-hidden="true"></i> email@tesst.bg</a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>