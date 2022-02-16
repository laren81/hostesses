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
                    <div class="row">
                        <div class="col-sm-12 b-r">
                            <h3 class="m-t-none m-b">Регистрация</h3>
                            <form class="m-t" role="form"  method="POST" action="{{ route('register') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                  <input type="text" class="form-control" placeholder="Име" name="name" value="{{ old('name') }}" required autofocus>
                                  @if ($errors->has('name'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('name') }}</strong>
                                      </span>
                                  @endif
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                  <input type="email" class="form-control" placeholder="Електронна поща" name="email" value="{{ old('email') }}" required>
                                  @if ($errors->has('email'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('email') }}</strong>
                                      </span>
                                  @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                  <input type="password" class="form-control" placeholder="Парола" name="password" required>
                                  @if ($errors->has('password'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('password') }}</strong>
                                      </span>
                                  @endif
                                </div>
                                <div class="form-group">
                                  <input type="password" class="form-control" placeholder="Потвъри паролата" name="password_confirmation" required>
                                </div>

                                <button type="submit" class="btn btn-success block full-width m-b">Регистрирай ме</button>

                                <p class="text-muted text-center"><small>Вече имате регистрация?</small></p>
                                <a class="btn btn-sm btn-white btn-block" href="{{ route('login') }}">Вход</a>
                                
                                <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js?render=6Lde5ekZAAAAAPmooomYxN70m74fJ2iKhPte6YWf"></script>
<script>
    grecaptcha.ready(function () {
        grecaptcha.execute('6Lde5ekZAAAAAPmooomYxN70m74fJ2iKhPte6YWf', { action: 'contact' }).then(function (token) {
            var recaptchaResponse = document.getElementById('recaptchaResponse');
            recaptchaResponse.value = token;
        });
    });
</script>
@endsection
