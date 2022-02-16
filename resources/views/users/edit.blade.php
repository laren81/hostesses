@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('texte.users_arr.edit.edit_user')}}</h3>
                <div class="pull-right">
                    <a class="btn btn-primary back-btn" href="{{route('admin.users.index')}}">{{__('texte.users_arr.edit.users')}}</a>
                </div>
            </div>

            <div class="panel-body">
                <form id="user_edit" method="POST" action="{{ route('admin.users.update',$user->id) }}" class="form form-horizontal" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    <input type="hidden" name='role_id' value='{{$user->role_id}}'/>
                    
                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="first_name" class="col-sm-2 col-form-label control-label">{{__('texte.users_arr.edit.first_name')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{old('first_name',$user->first_name)}}"/>
                            @if ($errors->has('first_name'))
                                    <span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="last_name" class="col-sm-2 col-form-label control-label">{{__('texte.users_arr.edit.last_name')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{old('last_name',$user->last_name)}}"/>
                            @if ($errors->has('last_name'))
                                    <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-sm-2 col-form-label control-label">{{__('texte.users_arr.edit.email')}}</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email',$user->email) }}" required/>
                            @if ($errors->has('email'))
                                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone" class="col-sm-2 col-form-label control-label">{{__('texte.users_arr.edit.phone')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone',$user->phone) }}" />
                            @if ($errors->has('phone'))
                                    <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row {{ $errors->has('active') ? ' has-error' : '' }}">
                        <div class="col-sm-8 col-sm-offset-2">
                            <label for="active" class="col-form-label">
                                <input type="checkbox" id="active" name="active" value="1" {{ $user->active==1 ? "checked" : ""}} /> {{__('texte.users_arr.edit.active')}} 
                            </label>
                            @if ($errors->has('active'))
                                <span class="help-block"><strong>{{ $errors->first('active') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-12" style='text-align: center;'>
                            <button type="submit" class="btn btn-primary">{{__('texte.users_arr.edit.change')}}</button>
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