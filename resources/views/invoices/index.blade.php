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
                <h3 class="panel-title">{{__('texte.invoices_arr.index.invoices_list')}}</h3>
                </br>
                <div class="form-inline">
                    <div class="form-group">
                        <div class="input-group width-150">
                            <select class="form-control" id="client" name="client">
                                <option value="">--- {{__('texte.invoices_arr.index.client')}} ---</option>
                                @foreach($clients->sortBy('company_name') as $client)
                                <option value="{{$client->company_name}}">{{$client->company_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group width-150">
                            <select class="form-control" id="event" name="event">
                                <option value="">--- {{__('texte.invoices_arr.index.event')}} ---</option>
                                @foreach($events->sortBy('name') as $event)
                                <option value="{{$event->name}}">{{$event->name}}</option>
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
                            <div id="second_filters_div" style="display: inline-block; height:34px;margin-bottom:10px;font-size: 11px;"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-group width-150">
                            <select class="form-control" id="status" name="status">
                                <option value="">--- {{__('texte.invoices_arr.index.status')}} ---</option>
                                @foreach(__('texte.invoice_statuses_arr') as $status)
                                <option value="{{$status}}">{{$status}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button class='btn  btn-warning dark_bordered_warning' type='button' onclick="reset_filters();" title='{{__('texte.invoices_arr.index.reset_filters')}}' data-toggle='tooltip' style='margin-bottom:10px;'>{{__('texte.invoices_arr.index.reset_filters')}}</button>
                </div>
            </div>

            <div class="panel-body">
                <div class="ibox float-e-margins">

                    <div class="ibox-content wide">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{__('texte.invoices_arr.index.id')}}</th>
                                        <th>{{__('texte.invoices_arr.index.number')}}</th>
                                        <th>{{__('texte.invoices_arr.index.client')}}</th>
                                        <th>{{__('texte.invoices_arr.index.event')}}</th>
                                        <th>{{__('texte.invoices_arr.index.date')}}</th>
                                        <th>{{__('texte.invoices_arr.index.payment_date')}}</th>
                                        <th>{{__('texte.invoices_arr.index.total')}}</th>
                                        <th>{{__('texte.invoices_arr.index.paid')}}</th>
                                        <th>{{__('texte.invoices_arr.index.status')}}</th>
                                        <th data-sorter="false" style="text-align:right;padding-right:5px;">
                                            <a class="btn btn-w-m btn-primary" href="{{ route('admin.invoices.create') }}" title="{{__('texte.invoices_arr.index.add')}}" data-toggle="tooltip"><i class="glyphicon glyphicon-plus"></i></a>                                        
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="modal-delete" class="modal inmodal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content animated flipInY">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 id="modal-label" class="modal-title">{{__('texte.invoices_arr.index.delete_invoice')}}</h4>
                            </div>
                            <div class="modal-body">{{__('texte.invoices_arr.index.delete_invoice_confirm')}}</div>
                            <div class="modal-footer">
                                <button id="confirm_delete" type="button" class="btn btn-default" onclick="delete_role()">{{__('texte.invoices_arr.index.yes')}}</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"> {{__('texte.invoices_arr.index.no')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal inmodal" id="modal-set_payment" role="dialog" tabindex="-1" aria-labelledby="modal-label">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content animated flipInY">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 id="modal-label" class="modal-title">{{__('texte.invoices_arr.index.set_payment')}}</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="document_id" name="document_id" value=""/>

                                <h5></h5>
                                <div class="form-group row {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="paid" class="col-sm-1 col-form-label">{{__('texte.invoices_arr.index.amount')}}</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="paid" name="paid" value=""/>
                                    </div>
                                </div>
                                <span class="error_span" style="display:none;color:red">{{__('texte.invoices_arr.index.fill_amount')}}</span>
                            </div>
                            <div class="modal-footer">
                                <button id="confirm_set_payment" type="button" class="btn btn-default" onclick="set_payment()">{{__('texte.invoices_arr.index.change')}}</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"> {{__('texte.invoices_arr.index.cancel')}}</button>
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
    
    $('#client,#event,#status').select2();
     
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
                url: '/admin/get_invoices',
                type: 'POST'
            },
            "deferRender": true,
            columns: [
                { data: 'id', name: 'ID'},       
                { data: 'number', name: 'Number'},      
                { data: 'client', name: 'Client'}, 
                { data: 'event', name: 'Event'},
                { data: 'date', name: 'Date'},
                { data: 'payment_date', name: 'Payment date'},
                { data: 'total', name: 'Total'},
                { data: 'paid', name: 'Paid'},
                { data: 'status', name: 'Status',
                    render:function(data){
                        return data==0 ? 'New' : (data==1 ? 'Partly paid' : 'Paid');
                    }
                },
                { data: 'id', name: 'Actions',className: "right_alined",
                    "orderable" : false,
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol){
                        $(nTd).html("<a class='btn btn-info btn-circle' href='/admin/invoices/"+sData+"' title='Show' data-toggle='tooltip'><i class='glyphicon glyphicon-eye-open'></i></a> <a class='btn btn-warning btn-circle' href='/admin/invoices/"+sData+"/edit' title='Edit' data-toggle='tooltip'><i class='glyphicon glyphicon-pencil'></i></a> <a type='button' class='btn btn-success btn-circle set_payment_status' data-id='"+sData+"' data-paid='"+oData.paid+"' data-total='"+oData.total+"' title='Set payment status' data-target='#modal-set_payment' data-toggle='modal'><i class='glyphicon glyphicon-eur'></i></a> <a class='btn btn-primary btn-circle' href='/admin/invoices/"+sData+"/print' target='_blank' title='Print' data-toggle='tooltip'><i class='glyphicon glyphicon-print'></i></a> <a type='button' class='btn btn-danger btn-circle delete_button' data-id='"+sData+"' title='Delete' data-target='#modal-delete' data-toggle='modal'><i class='glyphicon glyphicon-trash'></i></a>");
                    }
                }            
            ],
            "oLanguage": {
                "sShow":"Показване",
                "sSearch": "Търсене",
                "sLengthMenu": "Показване на _MENU_  <span style='vertical-align:-moz-middle-with-baseline;margin-left:5px;'>Резултата на страница</span>",  
                "sInfo": "Показване на записи от _START_ до _END_ от общо _TOTAL_ записа",
                "sZeroRecords": "Не са намерени записи по зададените параметри",
                "sInfoEmpty": "Не са намерени записи по зададените параметри",
                "sInfoFiltered" : "- филтрирани от _MAX_ записа",
                "sLoadingRecords" : "Резултатите се зареждат, моля изчакайте...",
                "oPaginate": {
                                        "sNext": "Следваща",
                                        "sPrevious": "Предишна",
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
                column_number: 4,
                filter_type: "range_date",
                date_format: "dd.mm.yyyy",
                filter_delay: 500,
                filter_container_id: "first_filters_div",
                filter_default_label: ['Date from:','Date to:'],
                filter_reset_button_text: false
            },
            {
                column_number: 5,
                filter_type: "range_date",
                date_format: "dd.mm.yyyy",
                filter_delay: 500,
                filter_container_id: "second_filters_div",
                filter_default_label: ['Payment from:','Payment to:'],
                filter_reset_button_text: false
            },
        ]);
        
        $('#client').on('change', function(){
            table.columns(2).search(this.value).draw();
        });
        
        $('#event').on('change', function(){
            table.columns(3).search(this.value).draw();
        });
        
        $('#status').on('change', function(){
            table.columns(8).search(this.value).draw();
        });

    });
        
     
    
    $(document).on('input','#paid' ,function() {
        var valid = /^\d+\.?\d{0,5}$/.test(this.value),
        val = this.value;
    
        if(!valid){
            this.value = val.substring(0, val.length - 1);
        }
    });
    
    $(document).on('click', '.set_payment_status', function(){
        $('#modal-set_payment h5').text('Платени '+ $(this).attr('data-paid')+ ' лв от общо '+ $(this).attr('data-total')+ 'лв');
        $('#confirm_set_payment').attr('onclick','set_payment('+ $(this).attr('data-id')+ ')');
    });
    
    $(document).on('click','.delete_button',function(){
        $('#confirm_delete').attr('onclick','delete_invoice('+ $(this).data('id') + ')');
    });
    
    function delete_invoice(id){
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/admin/delete_invoice',
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
        
    function set_payment(id){
        var paid = $('#paid').val();
        
        if(paid!=''){
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/admin/set_invoice_paid_amount',
                        type: 'POST',
                data: { 'id' : id,
                        'paid' : paid},
                success: function(response){
                            $("button[data-dismiss=\"modal\"]").click();
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
        else{
            $('#paid').addClass('error');
            $('.error_span').show();
        }
    }
    
    function reset_filters(){
        $('.yadcf-filter-range-date').val('');
        $('#client,#event,#status').val('').trigger("change");        
    }
</script>
@endsection