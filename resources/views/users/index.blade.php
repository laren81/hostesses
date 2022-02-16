@extends('layouts.app')

@section('link')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endsection

@section('content')
@include('shared.messages')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('texte.users_arr.index.users_list')}}</h3>
                </br>
                <div class="form-inline">
                    <div class="form-group">
                        <div class="input-group width-150">
                            <select class="form-control" id="role" name="role">
                                <option value="">--- {{__('texte.users_arr.index.role')}} ---</option>
                                @foreach($roles->sortBy('name') as $role)
                                <option value="{{$role->name}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group width-150">
                            <select class="form-control" id="active" name="active">
                                <option value="">--- {{__('texte.users_arr.index.active_m')}} ---</option>
                                <option value="{{__('texte.users_arr.index.yes')}}">{{__('texte.users_arr.index.yes')}}</option>
                                <option value="{{__('texte.users_arr.index.no')}}">{{__('texte.users_arr.index.no')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="ibox float-e-margins">

                    <div class="ibox-content wide">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" width="100%" >
                                <thead>
                                    <tr>
                                        <th>{{__('texte.users_arr.index.id')}}</th>
                                        <th>{{__('texte.users_arr.index.first_name')}}</th>
                                        <th>{{__('texte.users_arr.index.last_name')}}</th>
                                        <th>{{__('texte.users_arr.index.roles')}}</th>
                                        <th>{{__('texte.users_arr.index.email')}}</th>
                                        <th>{{__('texte.users_arr.index.phone')}}</th>
                                        <th>{{__('texte.users_arr.index.active_m')}}</th>
                                        <th data-sorter="false" style="text-align:right;padding-right:5px;">
                                            <a class="btn btn-w-m btn-primary" href="{{ route('admin.users.create') }}" title="{{__('texte.users_arr.index.add')}}" data-toggle="tooltip"><i class="glyphicon glyphicon-plus"></i></a>                                        
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
                                <h4 id="modal-label" class="modal-title">{{__('texte.users_arr.index.delete_user')}}</h4>
                            </div>
                            <div class="modal-body">{{__('texte.users_arr.index.delete_user_confirm')}}</div>
                            <div class="modal-footer">
                                <button id="confirm_delete" type="button" class="btn btn-default" onclick="delete_user()">{{__('texte.users_arr.index.yes')}}</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"> {{__('texte.users_arr.index.no')}}</button>
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
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/chosen.js') }}"></script>

<script type="text/javascript" charset="utf-8">
    
    $('#active,#role').select2();

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
                url: '/admin/get_users',
                type: 'POST'
            },
            "deferRender": true,
            columns: [
                { data: 'id', name: 'id'},
                { data: 'first_name', name: 'Име'},
                { data: 'last_name', name: 'Фамилия'},
                { data: 'role_name', name: 'Роля'},
                { data: 'email', name: 'И-мейл',
                  "defaultContent": "" },
                { data: 'phone', name: 'Телефон',
                  "defaultContent": "" },
                { data: 'active' , name: 'Активен',
                    render: function ( data, type, row, meta ) {
                        return data===1 ? 'Да' : 'Не';
                    }
                },                        
                { data: 'id', name: 'Действия',className: "right_alined",
                    "orderable" : false,
                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol){
                        $(nTd).html("<a class='btn btn-info btn-circle' href='/admin/users/"+sData+"' title='Покажи' data-toggle='tooltip'><i class='glyphicon glyphicon-eye-open'></i></a> <a class='btn btn-warning btn-circle' href='/admin/users/"+sData+"/edit' title='Промени' data-toggle='tooltip'><i class='glyphicon glyphicon-pencil'></i></a> <a type='button' class='btn btn-danger btn-circle delete_button' data-id='"+sData+"' title='Изтрий' data-target='#modal-delete' data-toggle='modal'><i class='glyphicon glyphicon-trash'></i></a>");
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

        
        $('#role').on('change', function(){
            table.columns(3).search(this.value).draw();
        });
    
        $('#active').on('change', function(){
            table.column(6).search(this.value).draw();
        });

    });
        
    $(document).on('click','.delete_button',function(){
        $('#confirm_delete').attr('onclick','delete_user('+ $(this).data('id') + ')');
    }); 
    
    function delete_user(id){
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/admin/delete_user',
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