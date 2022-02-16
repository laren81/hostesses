@extends('layouts.app')

@section('content')
@include('shared.messages')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('texte.users_arr.create.create_user')}}</h3>
                <div class="pull-right">
                    <a class="btn btn-primary back-btn" href="{{route('admin.users.index')}}">{{__('texte.users_arr.create.users')}}</a>
                </div>
            </div>

            <div class="panel-body">
                <form id="user_create" method="POST" action="{{ route('admin.users.store') }}" class="form form-horizontal">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="first_name" class="col-sm-2 col-form-label control-label">{{__('texte.users_arr.create.first_name')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{old('first_name')}}"/>
                            @if ($errors->has('first_name'))
                                    <span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="last_name" class="col-sm-2 col-form-label control-label">{{__('texte.users_arr.create.last_name')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{old('last_name')}}"/>
                            @if ($errors->has('last_name'))
                                    <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                        <label for="role" class="col-sm-2 col-form-label control-label">{{__('texte.users_arr.create.role')}}</label>
                        <div class="col-sm-8">                                
                            <select class="form-control" id="role" name="role_id">
                                <option value="">{{__('texte.users_arr.create.role')}}</option>
                                @foreach($roles as $role)
                                <option value="{{$role->id}}" {{old('role_id')==$role->id ? "selected" : ""}}>{{$role->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('role_id'))
                                    <span class="help-block"><strong>{{ $errors->first('role_id') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-sm-2 col-form-label control-label">{{__('texte.users_arr.create.email')}}</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required/>
                            @if ($errors->has('email'))
                                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone" class="col-sm-2 col-form-label control-label">{{__('texte.users_arr.create.phone')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" />
                            @if ($errors->has('phone'))
                                    <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>

                    <!--
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-sm-2 col-form-label control-label">Парола</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password" name="password" pattern=".{6,}" required/>
                            @if ($errors->has('password'))
                                <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm" class="col-sm-2 col-form-label control-label">Потвърждение на паролата</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required/>
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>
                    -->

                    <div class="form-group">
                        <div class="col-sm-12" style='text-align: center;'>
                            <button type="submit" class="btn btn-primary">{{__('texte.users_arr.create.add')}}</button>
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

<script src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript" charset="utf-8">
$('#role').select2();
</script>
@endsection