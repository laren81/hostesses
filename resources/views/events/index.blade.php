@extends('layouts.app')

@section('link')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery.dataTables.yadcf.css') }}" rel="stylesheet">
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/admin_filters.css') }}" rel="stylesheet">
@endsection


@section('content')
@include('shared.messages')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('texte.events_arr.index.events_list')}}</h3>
                </br>
                <div class="form-inline">
                    <div class="form-group">
                        <div class="input-group width-150">
                            <select class="form-control" id="client" name="client">
                                <option value="">--- {{__('texte.events_arr.index.client')}} ---</option>
                                @foreach($clients->sortBy('company_name') as $client)
                                <option value="{{$client->company_name}}">{{$client->company_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group width-150">
                            <select class="form-control" id="region" name="region">
                                <option value="">--- {{__('texte.events_arr.index.region')}} ---</option>
                                @foreach($regions as $region)
                                <option value="{{$region->name}}">{{$region->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group width-150">
                            <select class="form-control" id="city" name="city">
                                <option value="">--- {{__('texte.events_arr.index.city')}} ---</option>
                                @foreach($cities as $city)
                                <option value="{{$city->zip.' '.$city->name}}">{{$city->zip.' '.$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-group width-150">
                            <select class="form-control" id="urgent" name="urgent">
                                <option value="">--- {{__('texte.events_arr.index.urgent')}} ---</option>
                                <option value="{{__('texte.events_arr.index.yes')}}">{{__('texte.events_arr.index.yes')}}</option>
                                <option value="{{__('texte.events_arr.index.no')}}">{{__('texte.events_arr.index.no')}}</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-group width-150">
                            <select class="form-control" id="outside_event" name="outside_event">
                                <option value="">--- {{__('texte.events_arr.index.outside_event')}} ---</option>
                                <option value="{{__('texte.events_arr.index.yes')}}">{{__('texte.events_arr.index.yes')}}</option>
                                <option value="{{__('texte.events_arr.index.no')}}">{{__('texte.events_arr.index.no')}}</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-group width-150">
                            <select class="form-control" id="status" name="status">
                                <option value="">--- {{__('texte.events_arr.index.status')}} ---</option>
                                @foreach(__('website.admin_events_statuses_arr') as $status)
                                <option value="{{$status}}">{{$status}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-group">
                            <div id="first_filters_div" style="display: inline-block; height:34px;margin-bottom:10px;"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div id="second_filters_div" style="display: inline-block; height:34px;margin-bottom:10px;"></div>
                        </div>
                    </div>
                    <button class='btn  btn-warning dark_bordered_warning' type='button' onclick="reset_filters();" title='{{__('texte.events_arr.index.reset_filters')}}' data-toggle='tooltip' style='margin-bottom:10px;'>{{__('texte.events_arr.index.reset_filters')}}</button>
                </div>
            </div>

            <div class="panel-body">
                <div class="ibox float-e-margins">

                    <div class="ibox-content wide">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" width="100%" >
                                <thead>
                                    <tr>
                                        <th>{{__('texte.events_arr.index.id')}}</th>
                                        <th>{{__('texte.events_arr.index.client')}}</th>
                                        <th>{{__('texte.events_arr.index.name')}}</th>
                                        <th>{{__('texte.events_arr.index.region')}}</th>
                                        <th>{{__('texte.events_arr.index.city')}}</th>
                                        <th>{{__('texte.events_arr.index.location')}}</th>
                                        <th>{{__('texte.events_arr.index.period')}}</th>
                                        <th>{{__('texte.events_arr.index.urgent')}}</th> 
                                        <th>{{__('texte.events_arr.index.outside_event')}}</th> 
                                        <th>{{__('texte.events_arr.index.status')}}</th>                                        
                                        <th data-sorter="false" style="text-align:right;padding-right:5px;">
                                            <a class="btn btn-w-m btn-primary" href="{{ route('admin.events.create') }}" title="{{__('texte.events_arr.index.add')}}" data-toggle="tooltip"><i class="glyphicon glyphicon-plus"></i></a>                                        
                                        </th>
                                        <th hidden>{{__('texte.events_arr.index.date_from')}}</th>
                                        <th hidden>{{__('texte.events_arr.index.date_to')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
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
                                <h4 id="modal-label" class="modal-title">{{__('texte.events_arr.index.delete_event')}}</h4>
                            </div>
                            <div class="modal-body">{{__('texte.events_arr.index.delete_event_confirm')}}</div>
                            <div class="modal-footer">
                                <button id="confirm_delete" type="button" class="btn btn-default" onclick="delete_event()">{{__('texte.events_arr.index.yes')}}</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"> {{__('texte.events_arr.index.no')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="modal-confirm" class="modal inmodal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content animated flipInY">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 id="modal-label" class="modal-title">{{__('texte.events_arr.index.confirm_event')}}</h4>
                            </div>
                            <div class="modal-body">{{__('texte.events_arr.index.confirm_event_confirm')}}</div>
                            <div class="modal-footer">
                                <button id="confirm_event" type="button" class="btn btn-default" onclick="confirm_event()">{{__('texte.events_arr.index.yes')}}</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"> {{__('texte.events_arr.index.no')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="modal-invoices" class="modal inmodal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content animated flipInY">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 id="modal-label" class="modal-title">{{__('texte.events_arr.index.invoices')}}</h4>
                            </div>
                            <div class="modal-body">
                                <table id="inv_table" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{__('texte.events_arr.index.invoice')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal"> {{__('texte.events_arr.index.close')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer"></div>
        </div>
    </div>
</div>

<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.yadcf.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>

<script type="text/javascript" charset="utf-8">
    
    $('#client,#region,#city,#urgent,#status,#outside_event').select2();
    
    var event_statuses = {!! json_encode(__('texte.events_statuses_arr')) !!};

    $(document).ready(function(){
        table = $('.dataTables-example').DataTable({
            pageLength: 100,
            responsive: true,
            "server-side": true,
            dom: 'lTfgitp',
            "ajax": {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/admin/get_events',
                type: 'POST'
            },
            "deferRender": true,
            columns: [
                { data: 'id', name: 'id'},
                { data: 'client', name: 'Client'},
                { data: 'name', name: 'Name'},
                { data: 'region', name: 'Region'},
                { data: 'city', name: 'City',
                    render: function(data, type, row, meta){
                        return row.internal_location==1 ? (row.zip+' '+data) : row.external_city;
                    }
                },
                { data: 'location', name: 'Location'},
                { data: 'id' , name: 'Period',
                    render: function ( data, type, row, meta ) {
                        return row.date_from + ' - ' + row.date_to;
                    }
                },
                { data: 'urgent', name: 'Urgent',
                  render: function ( data, type, row, meta ) {
                        return data==1 ? 'Yes' : 'No';
                    } 
                },
                { data: 'internal_location', name: 'Urgent',
                  render: function ( data, type, row, meta ) {
                        return data==2 ? 'Yes' : 'No';
                    } 
                },
                { data: 'status', name: 'Status',
                  render: function ( data, type, row, meta ) {
                        return event_statuses[data];
                    } 
                },                      
                { data: 'id', name: 'Actions',className: "right_alined",
                    "orderable" : false,
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol){
                        var html = "<a class='btn btn-info btn-circle' href='/admin/events/"+sData+"' title='Покажи' data-toggle='tooltip'><i class='glyphicon glyphicon-eye-open'></i></a> <a class='btn btn-warning btn-circle' href='/admin/events/"+sData+"/edit' title='Промени' data-toggle='tooltip'><i class='glyphicon glyphicon-pencil'></i></a>";
                        
                        if(oData.status==0){
                            html += " <a type='button' href='/admin/events/"+sData+"/create_offer' class='btn btn-primary btn-circle confirm_button' data-id='"+sData+"' title='Make offer'><i class='glyphicon glyphicon-eur'></i></a>";
                        }
                        else if(oData.offer!=null){
                            html += " <a type='button' href='/admin/event_offers/"+oData.offer.id+"' class='btn btn-success btn-circle' data-id='"+sData+"' title='Show offer'><i class='glyphicon glyphicon-eur'></i></a>"; 
                            
                            if(oData.offer.accepted==1){
                                html+= " <a type='button' href='/admin/events/"+sData+"/jobs' class='btn btn-primary btn-circle' data-id='"+sData+"' title='Show event jobs'><i class='glyphicon glyphicon-cog'></i></a>"; 

                                if(oData.count_invoices!=0){
                                     html+= " <button type='button' class='btn btn-alt btn-circle btn-invoices' data-id='"+sData+"' title='Show event invoice'><i class='glyphicon glyphicon-usd'></i></button>"; 
                                }
                            }
                        }
                        
                        html += " <a type='button' class='btn btn-danger btn-circle delete_button' data-id='"+sData+"' title='Изтрий' data-target='#modal-delete' data-toggle='modal'><i class='glyphicon glyphicon-trash'></i></a>";
                        
                        $(nTd).html(html);
                    }
                },
                { data: 'date_from', name: 'Date from', visible:false}, 
                { data: 'date_to', name: 'Date to', visible:false} 
            ],
            "oLanguage": {
                "sSearch": "",
                "sLengthMenu": "_MENU_  <span style='vertical-align:-moz-middle-with-baseline;margin-left:5px;'>Резултата на страница</span>",  
                "sInfo": "Показване на записи от _START_ до _END_ от общо _TOTAL_ записа",
                "sZeroRecords": "Не са намерени записи по зададените параметри",
                "sInfoEmpty": "Не са намерени записи по зададените параметри",
                "sInfoFiltered" : "- филтрирани от _MAX_ записа",
                "sLoadingRecords" : "Резултатите се зареждат, моля изчакайте...",
                "oPaginate": {
                                        "sNext": "Следваща страница",
                                        "sPrevious": "Предишна страница",
                                  },

            },
            "initComplete":function(settings, json) {
                $("a").each(function(){
                    if($(this).attr('disabled')=='disabled'){
                        $(this).addClass('not-active');
                    }
                });  
            }
        });

        yadcf.init(table, [
            {
                column_number: 11,
                filter_type: "range_date",
                date_format: "dd.mm.yyyy",
                filter_delay: 500,
                filter_container_id: "first_filters_div",
                filter_default_label: ['Period from:','Period from:'],
                filter_reset_button_text: false
            },
            {
                column_number: 12,
                filter_type: "range_date",
                date_format: "dd.mm.yyyy",
                filter_delay: 500,
                filter_container_id: "second_filters_div",
                filter_default_label: ['Period to:','Period to:'],
                filter_reset_button_text: false
            },
        ]);

        $('#yadcf-filter--DataTables_Table_0-from-date-11').hide();
        $('#yadcf-filter--DataTables_Table_0-to-date-11').datepicker();

        $('#yadcf-filter--DataTables_Table_0-from-date-12').datepicker();
        $('#yadcf-filter--DataTables_Table_0-to-date-12').hide();
        yadcf.exFilterExternallyTriggered(table);
        
        $('#client').on('change', function(){
            table.columns(1).search(this.value).draw();
        });
        
        $('#region').on('change', function(){
            table.columns(3).search(this.value).draw();
        });
        
        $('#city').on('change', function(){
            table.columns(4).search(this.value).draw();
        });
        
        $('#urgent').on('change', function(){
            table.columns(7).search(this.value).draw();
        });
        
        $('#outside_event').on('change', function(){
            table.columns(8).search(this.value).draw();
        });
        
        $('#status').on('change', function(){
            table.columns(9).search(this.value).draw();
        });
    });
    
    $(document).on('click','.btn-invoices', function(){
        var id = $(this).attr('data-id');
        $('#inv_table tbody tr').remove();
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/admin/get_event_invoices',
                    type: 'POST',
            data: { 'id' : id},
            success: function(response){
                        for(var i in response){
                            var row = "<tr><td><a href='/admin/invoices/"+response[i].id+"' target='_blank'>"+(response[i].id+'/'+response[i].date+'/'+response[i].number)+"</td></tr>";
                            $('#inv_table tbody').append(row);
                        }
                        $('#modal-invoices').modal('show');
                    }
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
                    url: '/admin/delete_event',
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
    
    function reset_filters(){
        $('.yadcf-filter-range-date').val('');
        $('#client,#region,#city,#urgent,#status').val('').trigger("change");        
    }
</script>
@endsection