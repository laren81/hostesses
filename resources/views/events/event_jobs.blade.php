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
                        @if($event->region_id!=0)
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('texte.events_arr.jobs.region')}}: </strong>
                                {{ $event->region->name}}
                            </div>
                        </div>
                        @endif
                        
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>{{__('texte.events_arr.jobs.city')}}: </strong>
                                {{ $event->city_id!=0 ? $event->city->name : $event->external_city}}
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
                                    <a class="btn btn-success" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$index}}">{{__('texte.events_arr.jobs.details')}}</a>
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
                                                    <th>{{__('texte.events_arr.jobs.name')}}</th>
                                                    <th>{{__('texte.events_arr.jobs.status')}}</th>
                                                    <th>{{__('texte.events_arr.jobs.hostess_comment')}}</th>
                                                    <th>{{__('texte.events_arr.jobs.client_comment')}}</th>
                                                    <th>{{__('texte.events_arr.jobs.admin_comment')}}</th>
                                                    <th>{{__('texte.events_arr.jobs.actions')}}</th>
                                                </tr> 
                                                @foreach($jobs->where('event_position_id',$position->id) as $job)
                                                <tr>
                                                    <td>{{$job->first_name.' '.$job->last_name}}</td>
                                                    <td>{{__('texte.job_statuses_arr')[$job->status]}}</td>
                                                    <td>{{$job->hostess_comment}}</td>
                                                    <td>{{$job->client_comment}}</td>
                                                    <td>{{$job->admin_comment}}</td>
                                                    <td><a type='button' class='btn btn-warning btn-circle job_status' data-id='{{$job->id}}' data-status="{{$job->status}}" title='Change status' ><i class='glyphicon glyphicon-pencil'></i></a></td>
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
        <div id="modal-change_status" class="modal inmodal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content animated flipInY">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 id="modal-label" class="modal-title">Change job status</h4>
                    </div>
                    <div class="modal-body" style='display:flex;'>                        
                        <div class="control-group col-xs-12 col-md-12">
                            <label for="job_status" class="col-sm-2 col-form-label">{{__('texte.events_arr.jobs.status')}}</label>
                            <select class="form-control" id="job_status" name="job_status" required>
                                @foreach(__('texte.job_statuses_arr') as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>    
                        
                        <div class="control-group col-xs-12 col-md-12">
                            <label for="admin_comment" class="col-sm-2 col-form-label">{{__('texte.events_arr.jobs.note')}}</label>
                            <input type="text" class="form-control" id="admin_comment" name="admin_comment"/>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button id="confirm_change" type="button" class="btn btn-default" onclick="change_job_status()">{{__('texte.events_arr.jobs.yes')}}</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"> {{__('texte.events_arr.jobs.no')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

$('.job_status').on('click', function(){
    var id = $(this).attr('data-id');
    var status = $(this).attr('data-status');
    
    $('#job_status').val(status);
    
    $('#confirm_change').attr('onclick','change_job_status('+ id + ')');
    
    $('#modal-change_status').modal('show');
});

function change_job_status(id){
    var status = $('#job_status').val();
    var comment = $('#admin_comment').val();
    
    $.ajax({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/admin/change_job_status',
                type: 'POST',
        data: { 'id' : id,
                'status' : status,
                'comment' : comment},
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
