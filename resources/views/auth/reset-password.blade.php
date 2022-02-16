@extends('layouts.app')

@section('style')
<style>
  
    .col-lg-8{
        margin-top:150px;
        margin-left:auto;
        margin-right:auto;
    }
    
    .ibox-content{
        background:#fff;
    }
    
    .col-sm-6{
        margin-bottom:50px;
    }
    
    h3{
        text-align:center;
    }

    .form-control:focus, .has-success .form-control, .has-success .form-control:focus, .single-line:focus {
        border-color: #4682b4;
    }
</style>
@endsection

@section('content')
<div class="page-wrapper" style='max-width:1170px;margin:auto;'>
    <div class="row">
        <div class="col-lg-8">
            <div class="ibox ">
                <div class="ibox-content">
                    <h2 class="font-bold">Промяна на паролата</h2>
                    <div class="row">
                        <div class="col-lg-12">
                            <form class="m-t" role="form" method="POST" action="{{ route('password.update') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="token" value="{{ $request->route('token') }} ">
                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input id="email" type="email" class="form-control" name="email" value="{{old('email',$request->email)}}" placeholder="Имейл" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input id="password" type="password" class="form-control" name="password" placeholder="Парола" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Потвърждение на паролата" required>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success block full-width m-b">Промени паролата</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
