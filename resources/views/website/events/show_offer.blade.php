@extends('layouts.website')

@section('link')
<link href="{{ asset('css/item_styles.css') }}" rel="stylesheet">
@endsection

@section('style')
<style>
    .ibox-content{
        padding:0;
    }
    
    .panel-heading a, .panel-heading button {
        position: relative;
        bottom: 10px;
        left: 0px;
        color: #676a6c;
    }    
    
    .application_img{
        
    }
</style>
@endsection

@section('content')
<div class="container">
    @include('shared.messages')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{__('website.events_arr.show_offer.event_offer')}}       
                        <a type="button" class="btn btn-default" href="{{route('events.index')}}" title="{{__('website.events_arr.show_offer.events')}}">{{__('website.events_arr.show_offer.events')}}</a> 
                        @if($offer->event->status==1 && $offer->accepted==0)
                        <button type="button" class="btn btn-default" data-target="#modal-confirm_offer" data-toggle='modal' title="{{__('website.events_arr.show_offer.accept_offer')}}">{{__('website.events_arr.show_offer.accept_offer')}}</button> 
                        @endif
                    </h3>
                </div>
                    
                
                <div class="panel-body">
                    <div class='row'>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('website.events_arr.show_offer.name')}}: </strong>
                                {{$offer->event->name }}
                            </div>
                        </div>   

                        @if($offer->event->internal_locaiton==1)
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('website.events_arr.show_offer.region')}}: </strong>
                                {{$offer->event->region->name}}
                            </div>
                        </div>
                        @endif

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('website.events_arr.show_offer.city')}}: </strong>
                                {{$offer->event->internal_locaiton==1 ? ($offer->event->city->zip.' '.$offer->event->city->name) : $offer->event->external_city}}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('website.events_arr.show_offer.location')}}: </strong>
                                {{ $offer->event->location }}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('website.events_arr.show_offer.period')}}: </strong>
                                @if(date('m.Y',strtotime($offer->event->date_from)) === date('m.Y',strtotime($offer->event->date_to)))
                                    {{date('d',strtotime($offer->event->date_from))}} - {{date('d.m.Y',strtotime($offer->event->date_to))}}
                                @elseif(date('Y',strtotime($offer->event->date_from)) === date('Y',strtotime($offer->event->date_to)))
                                    {{date('d.m',strtotime($offer->event->date_from))}} - {{date('d.m.Y',strtotime($offer->event->date_to))}}
                                @else
                                    {{date('d.m.Y',strtotime($offer->event->date_from))}} - {{date('d.m.Y',strtotime($offer->event->date_to))}}
                                @endif
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('website.events_arr.show_offer.time')}}: </strong>
                                {{ date('H:i',strtotime($offer->event->time_from)).' - '.date('H:i',strtotime($offer->event->time_till)) }}
                            </div>
                        </div>

                        @if(!empty($offer->note))
                        <div class="col-xs-12 col-sm-12 col-md-12">        
                            <div class="form-group">                            
                                <strong>{{__('website.events_arr.show_offer.note')}}</label></strong>
                                {{$offer->note}}
                            </div>
                        </div>
                        @endif

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content wide">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>{{__('website.events_arr.show_offer.position')}}</th>
                                                        <th>{{__('website.events_arr.show_offer.description')}}</th>
                                                        <th>{{__('website.events_arr.show_offer.days')}}</th>
                                                        <th>{{__('website.events_arr.show_offer.staff_wages')}}</th>
                                                        <th>{{__('website.events_arr.show_offer.booking_charge')}}</th>
                                                        <th>{{__('website.events_arr.show_offer.other_charges')}}</th>
                                                        <th>{{__('website.events_arr.show_offer.position_total')}}</th>   
                                                        <th>{{__('website.events_arr.show_offer.note')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($offer->rows as $index=>$row)
                                                        <tr>
                                                            <td>{{$index+1}}</td>
                                                            <td>{{$row->event_position->description()}}</td>
                                                            <td>{{$row->days}}</td>
                                                            <td>{{$row->staff_wages}}</td>
                                                            <td>{{$row->booking_charge}}</td>                                                            
                                                            <td>{{$row->additional_charge}}</td>
                                                            <td>{{number_format(($row->event_position->staff_number*$row->total),2,'.',' ')}}</td>
                                                            <td>{{$row->client_note}}</td>                                             
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan='6' style='text-align:right;'>{{__('website.events_arr.show_offer.total')}}</td>
                                                        <td>{{number_format($offer->total_amount,2,'.',' ')}}</td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>                                           
                                        </div>
                                    </div>
                                </div>
                                
                                @if($offer->accepted==1)
                                <div class="ibox float-e-margins" style="margin-top:50px;">
                                    <div class="ibox-content wide">                                        
                                        @foreach($positions as $index=>$position)
                                        
                                            @if(count($positions)>1)
                                                Applications for {{__('website.events_arr.show_offer.position')}} {{$index+1}}
                                            @else
                                                Applications
                                            @endif
                                            
                                        <div class="row">
                                            @foreach($position->jobs->where('status','>',0) as $job)
                                            <div class="col-xs-12 col-sm-3 col-lg-2 dark-text" style="width:auto;padding-right:9px;">	
                                                <div class="item">
                                                    <img class="application_img" src="{{url('/images/thumbs/'.$job->user->hostess->portrait[0]->name)}}" alt="{{$job->user->hostess->portrait[0]->name}}">
                                                    <div class="item-overlay">
                                                        @if(__('texte.job_statuses_images_arr')[$job->status]!=null)
                                                        <img src="{{url('/images/'.__('texte.job_statuses_images_arr')[$job->status].'.png')}}" style='width:50%'>
                                                        @endif
                                                    </div>	
                                                    <div class="item-content">
                                                        <div class="item-top-content">
                                                            <div class="item-top-content-inner">
                                                                <div class="item-product">
                                                                    <div class="item-top-title">
                                                                        <font size="2" color="fff"><strong>{{$job->user->hostess->user->first_name}}</strong></font> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>				

                                                        <div class="item-add-content">
                                                            <div class="item-add-content-inner">
                                                                <div class="section">
                                                                    <font size="3" color="ff5a5f"><strong>Booking ID {{$job->user_id}} </strong></font><br>
                                                                    Height {{$job->user->hostess->height}} cm<br>
                                                                    Size {{$job->user->hostess->cloth_size}}<br>
                                                                    Breast/Waist/Hip:<br> {{$job->user->hostess->chest}}/{{$job->user->hostess->waist}}/{{$job->user->hostess->hips}} 
                                                                </div>
                                                            </div>
                                                        </div>									
                                                    </div>
                                                </div>	                 
                                                <p>Booking ID {{$job->user_id}}</p>                                                
                                                <p><strong>{!! !empty($job->extra_charge) ? 'Extra '.number_format($job->extra_charge,2). 'EUR/daily' : '<br/>' !!}</strong></p>
                                                
                                                <p><a class="btn btn-default" style="width:90%; margin-bottom: 15px;" href="{{route('hostesses.show',$job->user->hostess->id)}}" target="_blank" title="Show Hostess"><i class="glyphicon glyphicon-triangle-right" aria-hidden="true"></i>View Details</a></p>
                                                <p>
                                                    <button type="button" class="btn btn-default accept_application" style="width:40%; margin-bottom: 15px;" title="Confirm application" data-toggle="modal" data-target="#modal-review_application" data-id="{{$job->id}}" {{$job->status!=1 ? "disabled" : ""}}><i class="glyphicon glyphicon-ok" style="color:green;"></i></button>
                                                    <button type="button" class="btn btn-default reject_application" style="width:40%; margin-bottom: 15px;" title="Reject application" data-toggle="modal" data-target="#modal-review_application" data-id="{{$job->id}}" {{$job->status!=1 ? "disabled" : ""}}><i class="glyphicon glyphicon-ban-circle" style="color:#ca1717"></i></button>
                                                </p>
                                                <hr>
                                            </div>
                                            @endforeach
                                        </div>                                        
                                        @endforeach
                                    </div>
                                </div>
                                @else
                                <div class="ibox float-e-margins" style="margin-top:50px;">
                                    <div class="ibox-content wide">
                                        There are booth models listed in our agency for your inquiry in {{$offer->event->internal_locaiton==1 ? ($offer->event->city->zip.' '.$offer->event->city->name) : $offer->event->external_city}}. If you are interest in our first offer, we will check the availibilty of our staff. 
                                        
                                        @foreach($offer->event->positions as $index=>$position)
                                        <div class="row">
                                            @if(count($offer->event->positions)>1)
                                            <h3>{{__('website.events_arr.show_offer.position')}} {{$index+1}}</h3>
                                            @endif
                                            @foreach($position->hostesses() as $hostess)
                                            <div class="col-xs-12 col-sm-3 col-lg-2 dark-text" style="width:auto;padding-right:9px;">	
                                                <div class="item">
                                                    <img src="{{url('/images/thumbs/'.$hostess->portrait[0]->name)}}" alt="{{$hostess->portrait[0]->name}}">
                                                    <div class="item-overlay"></div>	
                                                    <div class="item-content">
                                                        <div class="item-top-content">
                                                            <div class="item-top-content-inner">
                                                                <div class="item-product">
                                                                    <div class="item-top-title">
                                                                        <font size="2" color="fff"><strong>{{$hostess->user->first_name}}</strong></font> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>				

                                                        <div class="item-add-content">
                                                            <div class="item-add-content-inner">
                                                                <div class="section">
                                                                    <font size="3" color="ff5a5f"><strong>Booking ID {{$hostess->user_id}}</strong></font><br>
                                                                    Height {{$hostess->height}} cm<br>
                                                                    Size {{$hostess->cloth_size}}<br>
                                                                    Breast/Waist/Hip:<br> {{$hostess->chest}}/{{$hostess->waist}}/{{$hostess->hips}} 
                                                                </div>
                                                            </div>
                                                        </div>									
                                                    </div>
                                                </div>	                 
                                                <p>Booking ID {{$hostess->user_id}}</p>
                                                <p><a class="btn btn-default" style="width:90%; margin-bottom: 15px;" href="{{route('hostesses.show',$hostess->id)}}" target="_blank" title="Show Hostess"><i class="glyphicon glyphicon-triangle-right" aria-hidden="true"></i>View Details</a></p>
                                                <hr>
                                            </div>
                                            @endforeach
                                        </div>                                        
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>                            
                        </div>
                        <div id="modal-confirm_offer" class="modal inmodal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content animated flipInY">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 id="modal-label" class="modal-title">{{__('website.events_arr.show_offer.accept_offer')}}</h4>
                                    </div>
                                    <div class="modal-body">{{__('website.events_arr.show_offer.confirm_accept_offer')}}</div>
                                    <div class="modal-footer">
                                        <button id="confirm_event" type="button" class="btn btn-default" onclick="accept_offer({{$offer->id}})">{{__('website.events_arr.show_offer.yes')}}</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal"> {{__('website.events_arr.show_offer.no')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="modal-review_application" class="modal inmodal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content animated flipInY">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 id="modal-label" class="modal-title"></h4>
                                    </div>
                                    <div class="modal-body"></div>
                                    <div class="modal-footer">
                                        <button id="review_application_btn" type="button" class="btn btn-default" onclick="">{{__('website.events_arr.show_offer.yes')}}</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal"> {{__('website.events_arr.show_offer.no')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
<script type='text/javascript'>
    
    $(document).on('click', '.accept_application, .reject_application', function(){
        var id = $(this).attr('data-id'); 
        if($(this).hasClass('accept_application')){
            var status = 2;
        }
        else{
            var status = 4;
        }

        $('#modal-review_application').find('.modal-title').html(status=='2' ? 'Accept application' : 'Reject application'); 
        $('#modal-review_application').find('.modal-body').html('Are you sure you want to '+(status==2 ? 'accept' : 'reject')+' this application ?'); 
        $('#review_application_btn').attr('onclick','review_application('+id+','+status+')');
    });
    
    function review_application(id,status){
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/review_application',
                    type: 'POST',
            data: { 'id' : id,
                    'status' : status},
            success: function(response){
                        if(response.warning){
                            alert(response.warning);
                        }
                        else{
                            alert(response.success);
                            location.reload();
                        }
                    }
        });    
    }
    
    function accept_offer(id){
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/accept_offer',
                    type: 'POST',
            data: { 'id' : id},
            success: function(response){
                        if(response.warning){
                            alert(response.warning);
                        }
                        else{
                            alert(response.success);
                            location.reload();
                        }
                    }
        });    
    }
</script>
@endsection
