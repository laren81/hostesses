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
                    <h3 class="panel-title">{{__('website.events_arr.index.events')}}</h3>                    
                </div>

                    
                <div class="panel-body">
                    <div class="ibox ">
                        <div class="form-inline">
                            <div class="form-group">
                                <div class="input-group width-180">
                                    <select class="form-control" id="statuses" name="statuses">
                                        <option value="">--- {{__('website.events_arr.index.status')}} ---</option>
                                        @foreach(__('website.client_events_statuses_arr') as $status)
                                        <option value="{{$status}}">{{$status}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group width-180">
                                    <select class="form-control" id="regions" name="regions">
                                        <option value="">--- {{__('website.events_arr.index.region')}} ---</option>
                                        @foreach($regions as $region)
                                        <option value="{{$region->name}}">{{$region->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group width-180">
                                    <select class="form-control" id="cities" name="cities">
                                        <option value="">--- {{__('website.events_arr.index.city')}} ---</option>
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
                                        <th>{{__('website.events_arr.index.name')}}</th>
                                        <th>{{__('website.events_arr.index.region')}}</th>
                                        <th>{{__('website.events_arr.index.city')}}</th>
                                        <th>{{__('website.events_arr.index.location')}}</th>
                                        <th>{{__('website.events_arr.index.period')}}</th>
                                        <th>{{__('website.events_arr.index.status')}}</th>
                                        <th data-sorter="false" style="text-align:right;padding-right:5px;">
                                            <a class="btn btn-default" href="{{ route('events.create') }}" title="{{__('website.events_arr.index.add')}}" data-toggle="tooltip"><i class="glyphicon glyphicon-plus"></i></a>                                        
                                        </th>
                                        <th hidden>{{__('website.events_arr.index.date_from')}}</th>
                                        <th hidden>{{__('website.events_arr.index.date_to')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($events as $event)
                                    <tr>
                                        <td>{{$event->name}}</td>
                                        <td>{{$event->region_id!=0 ? $event->region->name : ''}}</td>
                                        <td>{{$event->region_id!=0 ? ($event->city->zip.' '.$event->city->name) : $event->external_city}}</td>
                                        <td>{{$event->location}}</td>
                                        <td>
                                            @if($event->date_from===$event->date_to)
                                                {{date('d.m.Y',strtotime($event->date_from))}}
                                            @elseif(date('m.Y',strtotime($event->date_from)) === date('m.Y',strtotime($event->date_to)))
                                                {{date('d',strtotime($event->date_from))}} - {{date('d.m.Y',strtotime($event->date_to))}}
                                            @elseif(date('Y',strtotime($event->date_from)) === date('Y',strtotime($event->date_to)))
                                                {{date('d.m',strtotime($event->date_from))}} - {{date('d.m.Y',strtotime($event->date_to))}}
                                            @else
                                                {{date('d.m.Y',strtotime($event->date_from))}} - {{date('d.m.Y',strtotime($event->date_to))}}
                                            @endif                                            
                                        </td>
                                        <td>{{__('website.client_events_statuses_arr')[$event->status]}}</td>
                                        <td style="text-align:right;padding-right:5px;"> 
                                            <a type="button" class="btn btn-default" href="{{route('events.show',$event->id)}}" title="{{__('website.events_arr.index.show')}}"><i class="glyphicon glyphicon-eye-open"></i></a> 
                                            @if($event->status==0)
                                            <a type="button" class="btn btn-default" href="{{route('events.edit',$event->id)}}" title="{{__('website.events_arr.index.edit')}}"><i class="glyphicon glyphicon-pencil"></i></a> 
                                            <button type="button" class="btn btn-default delete_button" data-id="{{$event->id}}" title="{{__('website.events_arr.index.delete')}}" data-target='#modal-delete' data-toggle='modal'><i class="glyphicon glyphicon-trash"></i></button>
                                            @else 
                                                @if($event->status>0 && $event->offer)
                                                <a type='button' href='{{route('event_offers.show',$event->offer->id)}}' class='btn btn-default' title='Show offer'><i class='glyphicon glyphicon-eur'></i></a>
                                                @endif
                                            @endif
                                            @if($event->status==5)
                                            <a type='button' href='{{route('ratings.create',$event->id)}}' class='btn btn-default' title='Rate personnel'><i class='glyphicon glyphicon-star'></i></a>
                                            @endif
                                        </td> 
                                        <td hidden>{{ date_format(new DateTime($event->date_from), 'd.m.Y')}}</td>
                                        <td hidden>{{ date_format(new DateTime($event->date_to), 'd.m.Y')}}</td>
                                    </tr>
                                    @endforeach                                    
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="modal-delete" class="modal inmodal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content animated flipInY">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 id="modal-label" class="modal-title">{{__('website.events_arr.index.delete_event')}}</h4>
                            </div>
                            <div class="modal-body">{{__('website.events_arr.index.delete_event_confirm')}}</div>
                            <div class="modal-footer">
                                <button id="confirm_delete" type="button" class="btn btn-default" onclick="delete_event()">{{__('website.events_arr.index.yes')}}</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"> {{__('website.events_arr.index.no')}}</button>
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
                column_number: 7,
                filter_type: "range_date",
                date_format: "dd.mm.yyyy",
                filter_delay: 500,
                filter_container_id: "first_filters_div",
                filter_default_label: ['Period from:','Period from:'],
                filter_reset_button_text: false
            },
            {
                column_number: 8,
                filter_type: "range_date",
                date_format: "dd.mm.yyyy",
                filter_delay: 500,
                filter_container_id: "second_filters_div",
                filter_default_label: ['Period to:','Period to:'],
                filter_reset_button_text: false
            },
        ]);
    
        $('#yadcf-filter--myTable-from-date-7').hide();
        $('#yadcf-filter--myTable-to-date-7').datepicker();

        $('#yadcf-filter--myTable-from-date-8').datepicker();
        $('#yadcf-filter--myTable-to-date-8').hide();
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
    
    $(document).on('click','.delete_button',function(){
        $('#confirm_delete').attr('onclick','delete_event('+ $(this).data('id') + ')');
    }); 
    
    function delete_event(id){
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/delete_event',
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
