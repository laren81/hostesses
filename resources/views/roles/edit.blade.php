@extends('layouts.app')


@section('style')
<style>

    input[type=checkbox] {
        display:none;
    }

    input[type=checkbox] + label
    {
        background-image: url('/css/images/x-mark.ico');
        height: 16px;
        width: 16px;
        display:inline-block;
        padding: 0 0 0 0px;
    }
    input[type=checkbox]:checked + label
    {
        background-image: url('/css/images/check-mark.ico');
        height: 16px;
        width: 16px;
        display:inline-block;
        padding: 0 0 0 0px;
    }
</style>
@endsection

@section('link')
<link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('texte.roles_arr.edit.edit_role')}}</h3>
                <div class="pull-right">
                    <a class="btn btn-primary back-btn" href="{{route('admin.roles.index')}}" >{{__('texte.roles_arr.edit.roles')}}</a>
                </div>
            </div>

            <div class="panel-body">
                <form id="role_update" method="POST" action="{{ route('admin.roles.update',$role->id) }}" class="form form-horizontal" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-2 col-form-label control-label">{{__('texte.roles_arr.edit.name')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name',$role->name)}}"/>
                            @if ($errors->has('name'))
                                <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>                        
                                       
                    <div class="form-group">
                        <div class="col-sm-12" style='text-align: center;'>
                            <button type="submit" class="btn btn-primary">{{__('texte.roles_arr.edit.change')}}</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="panel-footer"></div>
        </div>
    </div>
</div>


<script src="{{ asset('js/jquery.validate.js') }}"></script>
<script src="{{ asset('js/validation.js') }}"></script>

<script type="text/javascript" charset="utf-8">
function check_all(){
    $('.ckbox').prop('checked',true);
}
function uncheck_all(){
    $('.ckbox').prop('checked',false);
}

$('.create').on('click',function(){
   var checked = $(this).is(':checked');
   $('.ckbox.child_create[data_group="'+$(this).attr('data-id')+'"]').prop('checked', checked);
});

$('.read').on('click',function(){
   var checked = $(this).is(':checked');
   $('.ckbox.child_read[data_group="'+$(this).attr('data-id')+'"]').prop('checked', checked);
});

$('.edit').on('click',function(){
   var checked = $(this).is(':checked');
   $('.ckbox.child_edit[data_group="'+$(this).attr('data-id')+'"]').prop('checked', checked);
});

$('.delete').on('click',function(){
   var checked = $(this).is(':checked');
   $('.ckbox.child_delete[data_group="'+$(this).attr('data-id')+'"]').prop('checked', checked);
});
</script>
@endsection