@extends('layouts.app')

@section('link')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
@include('shared.messages')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('texte.roles_arr.index.roles_list')}}</h3>
                </br>
            </div>

            <div class="panel-body">
                <div class="ibox float-e-margins">

                    <div class="ibox-content wide">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                    <tr>
                                        <th>{{__('texte.roles_arr.index.id')}}</th>
                                        <th>{{__('texte.roles_arr.index.name')}}</th>
                                        <th data-sorter="false" style="text-align:right;padding-right:5px;">
                                            <a class="btn btn-w-m btn-primary" href="{{ route('admin.roles.create') }}" title="{{__('texte.roles_arr.index.add')}}" data-toggle="tooltip"><i class="glyphicon glyphicon-plus"></i></a>                                        
                                        </th>
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
                                <h4 id="modal-label" class="modal-title">{{__('texte.roles_arr.index.delete_role')}}</h4>
                            </div>
                            <div class="modal-body">{{__('texte.roles_arr.index.delete_role_confirm')}}</div>
                            <div class="modal-footer">
                                <button id="confirm_delete" type="button" class="btn btn-default" onclick="delete_role()">{{__('texte.roles_arr.index.yes')}}</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"> {{__('texte.roles_arr.index.no')}}</button>
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
<script type="text/javascript" charset="utf-8">
    
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
                url: '/admin/get_roles',
                type: 'POST'
            },
            "deferRender": true,
            columns: [
                { data: 'id', name: 'id'},       
                { data: 'name', name: 'Име',
                  "defaultContent": "" },                    
                { data: 'id', name: 'Действия',className: "right_alined",
                    "orderable" : false,
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol){
                        $(nTd).html("<a class='btn btn-info btn-circle' href='/admin/roles/"+sData+"' title='Покажи' data-toggle='tooltip'><i class='glyphicon glyphicon-eye-open'></i></a> <a class='btn btn-warning btn-circle' href='/admin/roles/"+sData+"/edit' title='Промени' data-toggle='tooltip'><i class='glyphicon glyphicon-pencil'></i></a> <a type='button' class='btn btn-danger btn-circle delete_button' data-id='"+sData+"' title='Изтрий' data-target='#modal-delete' data-toggle='modal'><i class='glyphicon glyphicon-trash'></i></a>");
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


        $('#role').on('change', function(){
            table.column(1).search(this.value).draw();
        });

    });
        
    $(document).on('click','.delete_button',function(){
        $('#confirm_delete').attr('onclick','delete_role('+ $(this).data('id') + ')');
    }); 
    
    function delete_role(id){
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/admin/delete_role',
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