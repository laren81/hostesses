@extends('layouts.website')

@section('style')
<style>
  
    .col-lg-8{
        
        margin:150px auto 0px;
    }
    
    .ibox-content{
        background:#fff;
    }
    
    .col-sm-6{
        margin-bottom:50px;
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
                        <div class="col-sm-6 b-r"><h3 class="m-t-none m-b">Вход</h3>
                            <p>Влезте в сайта</p>
                            <form class="m-t" role="form" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <input type="hidden" class="form-control" id="device_id" name="device_id" value="{{ old('device_id') }}">
                                
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">    
                                    <label>Имейл</label> 
                                    <input type="email" class="form-control" placeholder="Имейл" name="email" value="{{ old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label>Парола</label> 
                                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div>                                    
                                    <button class="btn btn-sm btn-success float-right m-t-n-xs" type="submit"><strong>Влизане</strong></button>
                                    <label class=""> <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;"></ins></div> Запомни ме </label>
                                </div>
                                <div>
                                    <a href="{{ route('password.request') }}" style="margin-right:10px;"><small>Забравена парола ?</small></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function(){ 
                invokeCSCode();						
        }, 500);
    });




    function invokeCSCode() {
        try {
            invokeCSharpAction();
        }
        catch (err) {
            console.log(err);
        }
    }
</script>
@endsection
