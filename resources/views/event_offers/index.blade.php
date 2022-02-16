@extends('layouts.app')

@section('link')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery.dataTables.yadcf.css') }}" rel="stylesheet">
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/admin_filters.css') }}" rel="stylesheet">
@endsection

@section('style')
<style>
    .break_lines{
        white-space: break-spaces;
    }
</style>
@endsection

@section('content')
@include('shared.messages')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('texte.event_offers_arr.index.event_offers_list')}}</h3>
                </br>
                <div class="form-inline">
                    <div class="form-group">
                        <div class="input-group width-150">
                            <select class="form-control" id="client" name="client">
                                <option value="">--- {{__('texte.event_offers_arr.index.client')}} ---</option>
                                @foreach($clients->sortBy('company_name') as $client)
                                <option value="{{$client->company_name}}">{{$client->company_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                                        
                    <div class="form-group">
                        <div class="input-group width-150">
                            <select class="form-control" id="status" name="status">
                                <option value="">--- {{__('texte.event_offers_arr.index.status')}} ---</option>
                                @foreach(__('website.admin_events_statuses_arr') as $status)
                                <option value="{{$status}}">{{$status}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button class='btn  btn-warning dark_bordered_warning' type='button' onclick="reset_filters();" title='{{__('texte.event_offers_arr.index.reset_filters')}}' data-toggle='tooltip' style='margin-bottom:10px;'>{{__('texte.event_offers_arr.index.reset_filters')}}</button>
                </div>
            </div>

            <div class="panel-body">
                <div class="ibox float-e-margins">

                    <div class="ibox-content wide">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" width="100%" >
                                <thead>
                                    <tr>
                                        <th>{{__('texte.event_offers_arr.index.id')}}</th>                                        
                                        <th>{{__('texte.event_offers_arr.index.client')}}</th>
                                        <th>{{__('texte.event_offers_arr.index.event')}}</th>
                                        <th>{{__('texte.event_offers_arr.index.event_status')}}</th>
                                        <th>{{__('texte.event_offers_arr.index.total_amount')}}</th>
                                        <th>{{__('texte.event_offers_arr.index.note')}}</th>
                                        <th>{{__('texte.event_offers_arr.index.accepted')}}</th>
                                        <th data-sorter="false" style="text-align:right;padding-right:5px;">{{__('texte.event_offers_arr.index.actions')}}</th>
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
    
    $('#client,#region,#city,#status').select2();
    
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
                url: '/admin/get_event_offers',
                type: 'POST'
            },
            "deferRender": true,
            columns: [
                { data: 'id', name: 'id'},
                { data: 'client', name: 'Client'},
                { data: 'name', name: 'Event'},
                { data: 'status', name: 'Status',
                    render: function ( data, type, row, meta ) {
                        return event_statuses[data];
                    } 
                },
                { data: 'total_amount', name: 'Amount'},
                { className: "break_lines",data: 'note', name: 'Note'},
                { data: 'accepted' , name: 'Accepted',
                    render: function ( data, type, row, meta ) {
                        return data==1 ? 'Yes' : 'No';
                    }
                },                                     
                { data: 'id', name: 'Actions',className: "right_alined",
                    "orderable" : false,
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol){
                        var html = "<a type='button' href='/admin/event_offers/"+sData+"' class='btn btn-info btn-circle' title='Show offer'><i class='glyphicon glyphicon-eye-open'></i></a> <a class='btn btn-success btn-circle' href='/admin/events/"+oData.event_id+"' title='Show event' data-toggle='tooltip'><i class='glyphicon glyphicon-glass'></i></a>";
                        
                        if(oData.accepted==1){
                            if(oData.invoice!=null){
                                html += " <a type='button' href='/admin/invoices/"+oData.invoice.id+"' class='btn btn-primary btn-circle' title='Show invoice'><i class='glyphicon glyphicon-eur'></i></a>"; 
                            }
                            else{
                                html += " <a type='button' href='/admin/invoices/"+sData+"/create/' class='btn btn-danger btn-circle' title='Create invoice'><i class='glyphicon glyphicon-eur'></i></a>"; 
                            }
                        }
                        $(nTd).html(html);
                    }
                }
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
        
        $('#client').on('change', function(){
            table.columns(1).search(this.value).draw();
        });
        
        $('#status').on('change', function(){
            table.columns(3).search(this.value).draw();
        });
    });
      
    function reset_filters(){
        $('.yadcf-filter-range-date').val('');
        $('#client,#region,#city,#status').val('').trigger("change");        
    }
</script>
@endsection