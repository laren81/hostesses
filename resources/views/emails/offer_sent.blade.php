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
                                Dear {{__('texte.titles_arr')[$offer->event->client->title]}} {{$offer->event->client->user->first_name.' '.$offer->event->client->user->last_name}},
                                in respect of your enquiry for {{$offer->event->name}} from 
                                {{date('m.Y',strtotime($offer->event->date_from)) === date('m.Y',strtotime($offer->event->date_to)) ? (date('d',strtotime($offer->event->date_from)).' - '.date('d.m.Y',strtotime($offer->event->date_to))) : (date('Y',strtotime($offer->event->date_from)) === date('Y',strtotime($offer->event->date_to)) ? (date('d.m',strtotime($offer->event->date_from)).' - '.date('d.m.Y',strtotime($offer->event->date_to))) : (date('d.m.Y',strtotime($offer->event->date_from)).' - '.date('d.m.Y',strtotime($offer->event->date_to))))}}
                                in  {{ $offer->event->city->name}}, please find herebelow our quote Nr.{{ $offer->id}}
                            </div>
                        </div>                        
                        
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <p>Quote</p>
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Staff type</th>
                                        <th>Staff number</th>
                                        <th>Staff gender</th>
                                        <th>Days</th>
                                        <th>Staff wages</th>
                                        <th>Booking charge</th>
                                        <th>Other charges</th>
                                        <th>Position total</th>   
                                        <th>Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($offer->rows as $index=>$row)
                                        <tr>
                                            <td>{{__('texte.staff_types_arr')[$row->event_position->staff_type]}}</td>
                                            <td>{{$row->event_position->staff_number}}</td>
                                            <td>{{$row->event_position->staff_gender==1 ? __('texte.events_arr.show.female') : ($row->event_position->staff_gender==2 ? __('texte.events_arr.show.male') : __('texte.events_arr.show.gender_not_specified'))}}</td>
                                            <td>{{$row->days}}</td>
                                            <td>{{$row->staff_wages}}</td>
                                            <td>{{$row->booking_charge}}</td>                                                            
                                            <td>{{$row->additional_charge}}</td>
                                            <td>{{$row->event_position->staff_number*$row->days*($row->staff_wages + $row->booking_charge + $row->additional_charge)}}</td>
                                            <td>{{$row->client_note}}</td>                                             
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan='7' style='text-align:right;'>Total</td>
                                        <td><input type='text' class='form-control total_amount' name='total_amount' value='{{$offer->total_amount}}' readonly/></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                         </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                Please follow this <a href="#">link</a> for details and staff matching your requirements.
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