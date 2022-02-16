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

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('texte.roles_arr.create.create_role')}}</h3>
                <div class="pull-right">
                    <a class="btn btn-primary back-btn" href="{{route('admin.roles.index')}}">{{__('texte.roles_arr.create.roles')}}</a>
                </div>
            </div>

            <div class="panel-body">
                <form id="role_create" method="POST" action="{{ route('admin.roles.store') }}" class="form form-horizontal">
                    {{ csrf_field() }}

                    <div class="form-group row {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-2 col-form-label">{{__('texte.roles_arr.create.name')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}"/>
                            @if ($errors->has('name'))
                                    <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>     

                    <div class="form-group">
                        <div class="col-sm-12" style='text-align: center;'>
                            <button type="submit" class="btn btn-primary">{{__('texte.roles_arr.create.add')}}</button>
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
@endsection