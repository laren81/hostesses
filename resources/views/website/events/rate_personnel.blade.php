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
    
    .rating {
        display: inline-block;
        position: relative;
        height: 50px;
        line-height: 50px;
        font-size: 50px;
      }

      .rating label {
        position: absolute;
        top: 0;
        left: 15px;
        height: 100%;
        cursor: pointer;
      }

      .rating label:last-child {
        position: static;
      }

      .rating label:nth-child(1) {
        z-index: 5;
      }

      .rating label:nth-child(2) {
        z-index: 4;
      }

      .rating label:nth-child(3) {
        z-index: 3;
      }

      .rating label:nth-child(4) {
        z-index: 2;
      }

      .rating label:nth-child(5) {
        z-index: 1;
      }

      .rating label input {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
      }

      .rating label .icon {
        float: left;
        color: transparent;
      }

      .rating label:last-child .icon {
        color: #000;
      }

      .rating:not(:hover) label input:checked ~ .icon,
      .rating:hover label:hover input ~ .icon {
        color: #09f;
      }

      .rating label input:focus:not(:checked) ~ .icon:last-child {
        color: #000;
        text-shadow: 0 0 5px #09f;
      }
      
      .rated_label{
          color: #09f;
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
                        @if($event->status==1 && $offer->accepted==0)
                        <button type="button" class="btn btn-default" data-target="#modal-confirm_offer" data-toggle='modal' title="{{__('website.events_arr.show_offer.accept_offer')}}">{{__('website.events_arr.show_offer.accept_offer')}}</button> 
                        @endif
                    </h3>
                </div>
                    
                
                <div class="panel-body">
                    <div class='row'>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('website.events_arr.show_offer.name')}}: </strong>
                                {{$event->name }}
                            </div>
                        </div>   

                        @if($event->internal_locaiton==1)
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('website.events_arr.show_offer.region')}}: </strong>
                                {{$event->region->name}}
                            </div>
                        </div>
                        @endif

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('website.events_arr.show_offer.city')}}: </strong>
                                {{$event->internal_location==1 ? ($event->city->zip.' '.$event->city->name) : $event->external_city}}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('website.events_arr.show_offer.location')}}: </strong>
                                {{ $event->location }}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('website.events_arr.show_offer.period')}}: </strong>
                                @if(date('m.Y',strtotime($event->date_from)) === date('m.Y',strtotime($event->date_to)))
                                    {{date('d',strtotime($event->date_from))}} - {{date('d.m.Y',strtotime($event->date_to))}}
                                @elseif(date('Y',strtotime($event->date_from)) === date('Y',strtotime($event->date_to)))
                                    {{date('d.m',strtotime($event->date_from))}} - {{date('d.m.Y',strtotime($event->date_to))}}
                                @else
                                    {{date('d.m.Y',strtotime($event->date_from))}} - {{date('d.m.Y',strtotime($event->date_to))}}
                                @endif
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('website.events_arr.show_offer.time')}}: </strong>
                                {{ date('H:i',strtotime($event->time_from)).' - '.date('H:i',strtotime($event->time_till)) }}
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
                                                    @foreach($event->offer->rows as $index=>$row)
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
                                                        <td>{{number_format($event->offer->total_amount,2,'.',' ')}}</td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>                                           
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="ibox float-e-margins" style="margin-top:50px;">
                                    <div class="ibox-content wide">                                        
                                        @foreach($positions as $index=>$position)
                                        
                                        Personnel
                                        
                                        <div class="row">
                                            @foreach($position->jobs->where('status',2) as $job)
                                            <div class="col-xs-12 col-sm-3 col-lg-2 dark-text" style="width:auto;padding-right:9px;">	
                                                <div class="item">
                                                    <img class="application_img" src="{{url('/images/thumbs/'.$job->user->hostess->portrait[0]->name)}}" alt="{{$job->user->hostess->portrait[0]->name}}">
                                                    	
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
                                                <p style="text-align:center;">
                                                    @if($job->rating)
                                                     <label style="margin-bottom:25px;" title="{{$job->rating->comment}}">
                                                        @for($i=1;$i<=$job->rating->stars;$i++)
                                                            <span class="icon rated_label">★</span>
                                                        @endfor
                                                     </label>
                                                    <br/>
                                                    @else
                                                    <button type="button" class="btn btn-default rate_hostess" style="width:90%; margin-bottom: 15px;" title="Rate hostess" data-toggle="modal" data-target="#modal-rate_hostess" data-id="{{$job->id}}" data-user="{{$job->user_id}}"><i class="glyphicon glyphicon-star"></i></button>
                                                    @endif
                                                </p>
                                                <hr>
                                            </div>
                                            @endforeach
                                        </div>                                        
                                        @endforeach
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        
                        
                        <div id="modal-rate_hostess" class="modal inmodal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content animated flipInY">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 id="modal-label" class="modal-title">Rate hostess</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="rate_hostess" method="POST" action="{{route('ratings.store')}}" class="form form-horizontal">
                                            {{ csrf_field() }}
                                            <input type='hidden' id="job_id" name='job_id' value=''/>
                                            <input type='hidden' id="user_id" name='user_id' value=''/>
                                            
                                            <div class="form-group rating">                            
                                                <div class="control-group col-xs-12 col-md-12">
                                                    <label>
                                                        <input type="radio" name="stars" value="1" />
                                                        <span class="icon">★</span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="stars" value="2" />
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="stars" value="3" />
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>   
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="stars" value="4" />
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="stars" value="5" />
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                        <span class="icon">★</span>
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">                            
                                                <div class="control-group col-xs-12 col-md-12">
                                                    <label for="comment" class="control-label">Comment</label>
                                                    <textarea class="form-control" name="comment" value="{{old('comment')}}" required></textarea>
                                                    @if ($errors->has('comment'))
                                                        <span class="help-block"><strong>{{ $errors->first('comment') }}</strong></span>
                                                    @endif
                                                    <div class="errorBox"></div>
                                                </div>
                                            </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button id="review_application_btn" type="submit" class="btn btn-default">Rate</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                    </div>
                                    </form>
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
    
    $('.rate_hostess').on('click', function(){
       $('#job_id').val($(this).attr('data-id'));
       $('#user_id').val($(this).attr('data-user'));
    });
</script>
@endsection
