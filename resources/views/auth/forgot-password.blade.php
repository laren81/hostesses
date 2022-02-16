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
                    <h2 class="font-bold">Забравена парола</h2>
                    <p>Въведете имейл адрес и ще получите съобщение за промяна на паролата.</p>
                    <div class="row">
                        <div class="col-lg-12">
                            <form class="m-t" role="form" method="POST" action="{{ route('password.email') }}">
                              {{ csrf_field() }}
                              <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Имейл" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                              </div>
                              <div class="form-group">
                                <button type="submit" class="btn btn-success block full-width m-b">Изпрати</button>
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

