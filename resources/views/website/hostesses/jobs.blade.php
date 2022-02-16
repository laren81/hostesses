@extends('layouts.website')

@section('link')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery.dataTables.yadcf.css') }}" rel="stylesheet">
@endsection

@section('style')
<style>
    .yadcf-filter-range-date-seperator{
        display:none;
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
                    <h3 class="panel-title">{{__('website.hostesses_arr.jobs.jobs')}}</h3>                    
                </div>

                    
                <div class="panel-body">
                    <div class="ibox ">
                        <div class="form-inline">
                            <div class="form-group">
                                <div class="input-group width-180">
                                    <select class="form-control" id="statuses" name="statuses">
                                        <option value="">--- {{__('website.hostesses_arr.jobs.status')}} ---</option>
                                        @foreach(__('texte.hostess_job_statuses_arr') as $status)
                                        <option value="{{$status}}">{{$status}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group width-180">
                                    <select class="form-control" id="regions" name="regions">
                                        <option value="">--- {{__('website.hostesses_arr.jobs.region')}} ---</option>
                                        @foreach($regions as $region)
                                        <option value="{{$region->name}}">{{$region->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group width-180">
                                    <select class="form-control" id="cities" name="cities">
                                        <option value="">--- {{__('website.hostesses_arr.jobs.city')}} ---</option>
                                        @foreach($cities as $city)
                                        <option value="{{$city->zip.' '.$city->name}}">{{$city->zip.' '.$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div id="first_filters_div" style="display: inline-block; height:38px;"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div id="second_filters_div" style="display: inline-block; height:38px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="ibox-content wide">
                            <table id="myTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{__('website.hostesses_arr.jobs.client')}}</th>
                                        <th>{{__('website.hostesses_arr.jobs.event')}}</th>
                                        <th>{{__('website.hostesses_arr.jobs.city')}}</th>
                                        <th>{{__('website.hostesses_arr.jobs.location')}}</th>
                                        <th>{{__('website.hostesses_arr.jobs.period')}}</th>
                                        <th>{{__('website.hostesses_arr.jobs.hours')}}</th>
                                        <th>{{__('website.hostesses_arr.jobs.wages')}}</th>
                                        <th>{{__('website.hostesses_arr.jobs.status')}}</th>
                                        <th>{{__('website.hostesses_arr.jobs.actions')}}</th>
                                        <th hidden>{{__('website.hostesses_arr.jobs.date_from')}}</th>
                                        <th hidden>{{__('website.hostesses_arr.jobs.date_to')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobs as $job)
                                    <tr>
                                        <td>{{$job->event_position->event->client->company_name}}</td>
                                        <td>{{$job->event_position->event->name}}</td>
                                        <td>{{$job->event_position->event->city->zip.' '.$job->event_position->event->city->name}}</td>
                                        <td>{{$job->event_position->event->location}}</td>
                                        <td>
                                            @if($job->date_from!=null && $job->date_to!=null)
                                                @if(date('m.Y',strtotime($job->date_from)) === date('m.Y',strtotime($job->date_to)))
                                                    {{date('d',strtotime($job->date_from))}} - {{date('d.m.y',strtotime($job->date_to))}}
                                                @elseif(date('Y',strtotime($job->date_from)) === date('Y',strtotime($job->date_to)))
                                                    {{date('d.m',strtotime($job->date_from))}} - {{date('d.m.y',strtotime($job->date_to))}}
                                                @else
                                                    {{date('d.m.y',strtotime($job->date_from))}} - {{date('d.m.y',strtotime($job->date_to))}}
                                                @endif
                                            @else
                                                @if(date('m.Y',strtotime($job->event_position->event->date_from)) === date('m.Y',strtotime($job->event_position->event->date_to)))
                                                    {{date('d',strtotime($job->event_position->event->date_from))}} - {{date('d.m.y',strtotime($job->event_position->event->date_to))}}
                                                @elseif(date('Y',strtotime($job->event_position->event->date_from)) === date('Y',strtotime($job->event_position->event->date_to)))
                                                    {{date('d.m',strtotime($job->event_position->event->date_from))}} - {{date('d.m.y',strtotime($job->event_position->event->date_to))}}
                                                @else
                                                    {{date('d.m.y',strtotime($job->event_position->event->date_from))}} - {{date('d.m.y',strtotime($job->event_position->event->date_to))}}
                                                @endif
                                            @endif                                            
                                        </td>
                                        <td>
                                            @if($job->time_from && $job->time_till)
                                                {{ date('H:i',strtotime($job->time_from)).' - '.date('H:i',strtotime($job->time_till)) }}
                                            @else
                                                {{ date('H:i',strtotime($job->event_position->event->time_from)).' - '.date('H:i',strtotime($job->event_position->event->time_till)) }}
                                            @endif
                                        </td>
                                        <td>{{number_format($job->staff_wages,2)}}</td>
                                        <td>{{__('texte.hostess_job_statuses_arr')[$job->status]}}</td>
                                        <td>
                                            <a type='button' class='btn btn-default' data-target='#modal-show_details-{{$job->event_position->id}}' data-toggle='modal'>Details</a>
                                            <div id="modal-show_details-{{$job->event_position->id}}" class="modal inmodal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content animated flipInY">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 id="modal-label" class="modal-title">{{__('texte.event_offers_arr.create.position_details')}}</h4>
                                                        </div>
                                                        <div class="modal-body" style="overflow-y:auto;">
                                                            @if($job->event_position->height_from!=null || $job->event_position->height_to!=null)
                                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <strong>{{__('texte.event_offers_arr.create.height')}}: </strong>
                                                                    {{ $job->event_position->height_from.' - '.$job->event_position->height_to }}
                                                                </div>
                                                            </div>
                                                            @endif

                                                            @if($job->event_position->size_from!=null || $job->event_position->size_to!=null)
                                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <strong>{{__('texte.event_offers_arr.create.size')}}: </strong>
                                                                    {{ $job->event_position->size_from.' - '.$job->event_position->size_to }}
                                                                </div>
                                                            </div>
                                                            @endif

                                                            @if($job->event_position->language_1!=null || $job->event_position->language_2!=null || $job->event_position->language_3!=null)
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <h4>Languages required</h4>
                                                                    </div>
                                                                </div>
                                                                @if($job->event_position->language_1!=null)
                                                                <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left:35px;">
                                                                    <div class="form-group">
                                                                        <strong>{{$job->event_position->language_1=='de' ? __('texte.event_offers_arr.create.german') : __('texte.event_offers_arr.create.english')}}: </strong>
                                                                        {{ __('texte.short_language_levels_arr')[$job->event_position->language_1_lvl]}}
                                                                    </div>
                                                                </div>
                                                                @endif

                                                                @if($job->event_position->language_2!=null)
                                                                <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left:35px;">
                                                                    <div class="form-group">
                                                                        <strong>{{$job->event_position->language_2=='de' ? __('texte.event_offers_arr.create.german') : __('texte.event_offers_arr.create.english')}}: </strong>
                                                                        {{ __('texte.short_language_levels_arr')[$job->event_position->language_2_lvl]}}
                                                                    </div>
                                                                </div>
                                                                @endif

                                                                @if($job->event_position->language_3!=null)
                                                                <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left:35px;">
                                                                    <div class="form-group">
                                                                        <strong>{{__('texte.extended_languages_arr')[$job->event_position->language_3]}}: </strong>
                                                                        {{ __('texte.short_language_levels_arr')[$job->event_position->language_3_lvl]}}
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            @endif

                                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <strong>{{__('texte.event_offers_arr.create.job_description')}}: </strong>
                                                                    {{ $job->event_position->job_description }}
                                                                </div>
                                                            </div>

                                                            @if($job->event_position->outfit!=null)
                                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <strong>{{__('texte.event_offers_arr.create.outfit')}}: </strong>
                                                                    {{ $job->event_position->outfit }}
                                                                </div>
                                                            </div>
                                                            @endif

                                                            @if($job->event_position->other_comments!=null)
                                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <strong>{{__('texte.event_offers_arr.create.other_comments')}}: </strong>
                                                                    {{ $job->event_position->other_comments }}
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>                                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            @if($job->status==0)
                                            <a type='button' class='btn btn-default reply-btn' data-target='#modal-reply' data-id='{{$job->id}}' data-urgent='{{$job->event_position->event->urgent}}' data-wages='{{number_format($job->staff_wages,2)}}' data-toggle='modal'>Reply</a>
                                            @endif
                                        </td>
                                        <td hidden>
                                            {{date('d.m.Y',strtotime($job->date_from!=null ? $job->date_from : $job->event_position->event->date_from))}}
                                        </td>
                                        <td hidden>
                                            {{date('d.m.Y',strtotime($job->date_to!=null ? $job->date_to : $job->event_position->event->date_to))}}
                                        </td>
                                    </tr>
                                    @endforeach                                    
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="modal-reply" class="modal inmodal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content animated flipInY">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 id="modal-label" class="modal-title">Job</h4>
                            </div>
                            <div class="modal-body" style='overflow: auto;'>   
                                
                                <div class="form-group">
                                    <div class="control-group col-xs-12 col-sm-12 col-md-12">                                    
                                        <label id="staff_wages_lbl" class="control-label">Wages per day: </label>                                        
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="control-group col-xs-12 col-sm-12 col-md-12">                                    
                                        <label for="additonal_charge" class="control-label">Additional charge: </label>
                                        <input type='text' class='form-control number' id='additional_charge' name='additional_charge' value='0' />
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <div class="control-group col-xs-12 col-sm-12 col-md-12">                                    
                                        <label for="note" class="control-label">Note: </label>
                                        <textarea class='form-control' id='note' name='note' value=''></textarea>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-12 col-md-12" style="padding-top: 6px;">                                    
                                        <input type="radio" name="status" value="1" checked/>
                                        <label for="radio1">Interested</label>

                                        <input type="radio" name="status" value="3"/>
                                        <label for="radio2">Not interested</label>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button id="reply_job_proposal" type="button" class="btn btn-default" onclick="reply_job_proposal()">Reply</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"> Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.yadcf.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>

<script type="text/javascript" charset="utf-8">   
    
    $('#statuses,#regions,#cities').select2();
    
    $(document).ready(function(){
        table = $('#myTable').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '',
            "targets": 'no-sort',
            "bSort": false,
            "order": [],
            "oLanguage": {
                "sShow":"Displaying",
                "sSearch": "Search",
                "sLengthMenu": "Displaying _MENU_  <span style='vertical-align:-moz-middle-with-baseline;margin-left:5px;'>results per page</span>",  
                "sInfo": "Displaying records from _START_ to _END_ from total _TOTAL_ records",
                "sZeroRecords": "No records found",
                "sInfoEmpty": "No records found",
                "sInfoFiltered" : "- filtered from _MAX_ records",
                "sLoadingRecords" : "Loading records, please wait...",
                "oPaginate": {
                    "sNext": "Next",
                    "sPrevious": "Previous",
                }
            }
        });

        yadcf.init(table, [
            {
                column_number: 9,
                filter_type: "range_date",
                date_format: "dd.mm.yyyy",
                filter_delay: 500,
                filter_container_id: "first_filters_div",
                filter_default_label: ['Period from:','Period from:'],
                filter_reset_button_text: false
            },
            {
                column_number: 10,
                filter_type: "range_date",
                date_format: "dd.mm.yyyy",
                filter_delay: 500,
                filter_container_id: "second_filters_div",
                filter_default_label: ['Period to:','Period to:'],
                filter_reset_button_text: false
            },
        ]);
    
        $('#yadcf-filter--myTable-from-date-9').hide();
        $('#yadcf-filter--myTable-to-date-9').datepicker();

        $('#yadcf-filter--myTable-from-date-10').datepicker();
        $('#yadcf-filter--myTable-to-date-10').hide();
        yadcf.exFilterExternallyTriggered(table);
        
        $('#statuses').on('change', function(){
            table.column(5).search(this.value).draw();
        });
        
        $('#regions').on('change', function(){
            table.column(1).search(this.value).draw();
        });
        
        $('#cities').on('change', function(){
            table.column(2).search(this.value).draw();
        });
    });
    
    $(document).on('click','.reply-btn',function(){
        var element = $(this);
        $('#staff_wages_lbl').html('Wages per day:' + $(element).attr('data-wages') + ' EUR');
        $('#additional_charge').val(0)
        if($(element).attr('data-urgent')==1){
            $('#additional_charge').closest('.form-group').show();
        }
        else{
           $('#additional_charge').closest('.form-group').hide(); 
        }
        $('#note').val('');
        $('#reply_job_proposal').attr('onclick','reply_job_proposal('+ $(this).data('id') + ')');
    }); 
    
    function reply_job_proposal(id){
        var additional_charge = $('#additional_charge').val();
        var note = $('#note').val();
        var status = $('input[name="status"]:checked').val();

        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/reply_job_proposal',
                    type: 'POST',
            data: { 'id' : id,
                    'additional_charge' : additional_charge,
                    'note' : note,
                    'status' : status
                },
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
