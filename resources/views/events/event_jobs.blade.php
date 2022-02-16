@extends('layouts.app')

@section('content')
<div class="container">
    @include('shared.messages')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('texte.events_arr.jobs.event_jobs')}}</h3>
                    <div class="pull-right">
                        <a class="btn btn-primary back-btn" href="{{route('admin.events.index')}}">{{__('texte.events_arr.jobs.events')}}</a>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('texte.events_arr.jobs.client')}}: </strong>
                                {{$event->client->company_name }}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('texte.events_arr.jobs.status')}}: </strong>
                                {{__('texte.events_statuses_arr')[$event->status]}}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('texte.events_arr.jobs.name')}}: </strong>
                                {{$event->name }}
                            </div>
                        </div>   

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('texte.events_arr.jobs.region')}}: </strong>
                                {{ $event->region->name}}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('texte.events_arr.jobs.location')}}: </strong>
                                {{ $event->location }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="panel-group" id="accordion">
                        @foreach($positions as $index=>$position)
                        <div class="form-inline panel panel-default">
                            <div class="panel-heading" id="heading{{$index}}" style="padding:20px 15px !important;">  
                                <h4 class="panel-title" style="display:inline-block;width:70%">Position {{$index+1}}</h4>
                                <div style='float:right;'>
                                    <a class="btn btn-success" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$index}}">Виж повече</a>
                                </div>                     
                            </div>
                             <div id="collapse{{$index}}" class="panel-collapse collapse">                                     
                                <div class="panel-body">
                                    <div class='row'>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.jobs.staff_type')}}: </strong>
                                                {{$position->staff_number.' '.__('texte.staff_types_arr')[$position->staff_type]}} - {{$position->staff_gender==1 ? __('texte.events_arr.jobs.female') : ($position->staff_gender==2 ? __('texte.events_arr.jobs.male') : __('texte.events_arr.jobs.gender_not_specified'))}}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.jobs.period')}}: </strong>
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
                                                <strong>{{__('texte.events_arr.jobs.time')}}: </strong>
                                                @if($position->time_from && $position->time_till)
                                                    {{ date('H:i',strtotime($position->time_from)).' - '.date('H:i',strtotime($position->time_till)) }}
                                                @else
                                                    {{ date('H:i',strtotime($event->time_from)).' - '.date('H:i',strtotime($event->time_till)) }}
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:10px;">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Hostess comment</th>
                                                    <th>Client comment</th>
                                                    <th>Admin comment</th>
                                                </tr> 
                                                @foreach($jobs->where('event_position_id',$position->id) as $job)
                                                <tr>
                                                    <td>{{$job->first_name.' '.$job->last_name}}</td>
                                                    <td>{{__('texte.job_statuses_arr')[$job->status]}}</td>
                                                    <td>{{$job->hostess_comment}}</td>
                                                    <td>{{$job->client_comment}}</td>
                                                    <td>{{$job->admin_comment}}</td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>  

                             </div>
                        </div> 
                        @endforeach
                    </div>                        
                </div>           
                
                <div class="panel-footer"></div>
            </div>
        </div>
    </div>
</div>
@endsection
