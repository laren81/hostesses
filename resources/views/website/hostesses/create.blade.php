@extends('layouts.website')

@section('link')
<link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
@endsection

@section('style')
<style>
    .ui-autocomplete{
        overflow-y:auto;
        height:400px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('website.hostesses_arr.create.hostess_job_application_form')}}</h3>
            </div>
            
            <div class="panel-body">
                <form id="create_hostess" method="POST" action="{{route('users.store_hostess')}}" class="form form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class='active'><a class="nav-link active" data-toggle="tab" href="#tab-1">{{__('website.hostesses_arr.create.contacts')}}</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-2">{{__('website.hostesses_arr.create.personal_information')}}</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-3">{{__('website.hostesses_arr.create.profile')}}</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-4">{{__('website.hostesses_arr.create.experience')}}</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-5">{{__('website.hostesses_arr.create.images')}}</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-6">{{__('website.hostesses_arr.create.confirmation')}}</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <div class='row'>
                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                                <label class="control-label" for="first_name">{{__('website.hostesses_arr.create.first_name')}}</label>
                                                <input type="text" class="form-control" name="first_name" value="{{old('first_name')}}" required>
                                                @if ($errors->has('first_name'))
                                                    <span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                                <label class="control-label" for="last_name"> {{__('website.hostesses_arr.create.last_name')}}</label>
                                                <input type="text" class="form-control" name="last_name" value="{{old('last_name')}}">
                                                @if ($errors->has('last_name'))
                                                    <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('email') ? ' has-error' : '' }}">
                                                <label class="control-label" for="email">{{__('website.hostesses_arr.create.email')}}</label>
                                                <input type="text" class="form-control" name="email" value="{{old('email')}}">
                                                @if ($errors->has('email'))
                                                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>

                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('phone') ? ' has-error' : '' }}">
                                                <label class="control-label" for="phone">{{__('website.hostesses_arr.create.mobile')}}</label>
                                                <input type="text" class="form-control" name="phone" value="{{old('phone')}}">
                                                @if ($errors->has('phone'))
                                                    <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div> 
                                        </div>
                                    </div>                                            
                                </div>
                            </div>
                            
                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <div class='row'>
                                        <br/>
                                                       
                                        <h3>{{__('website.hostesses_arr.create.preferred_areas')}}</h3>  
                                        
                                        <div class="form-group">                                            
                                            <div class="control-group col-xs-12 col-md-12{{ $errors->has('preferred_occupation') ? ' has-error' : '' }}">
                                                @foreach(__('website.hostess_areas_arr') as $key=>$value)
                                                <label style='margin-right:2%;'> 
                                                    <input type="checkbox" name="preferred_occupation[]" value="{{$key}}" id="preferred_occupation" {{old('preferred_occupation') && in_array($key,old('preferred_occupation')) ? 'checked' : ''}}> {{$value}} 
                                                </label>
                                                @endforeach
                                                @if ($errors->has('preferred_occupation'))
                                                    <span class="help-block"><strong>{{ $errors->first('preferred_occupation') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>    
                                        
                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('sex') ? ' has-error' : '' }}">
                                                <label for="title" class="control-label">{{__('website.hostesses_arr.create.sex')}}</label>
                                                <div>
                                                    <input type="radio" name="sex" value="1" id="radio1" {{old('sex')==='1' ? 'checked' : ''}}>
                                                    <label for="radio1">{{__('website.hostesses_arr.create.female')}}</label>

                                                    <input type="radio" name="sex" value="2" id="radio2" {{old('sex')==='2' ? 'checked' : ''}}>
                                                    <label for="radio2">{{__('website.hostesses_arr.create.male')}}</label>
                                                </div>
                                                @if ($errors->has('sex'))
                                                    <span class="help-block"><strong>{{ $errors->first('sex') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('birth_date') ? ' has-error' : '' }}">
                                                <label class="control-label" for="birth_date">{{__('website.hostesses_arr.create.birth_date')}}</label>
                                                <input type="text" class="form-control" id="birth_date" name="birth_date" value="{{old('birth_date')}}"/> 
                                                @if ($errors->has('birth_date'))
                                                    <span class="help-block"><strong>{{ $errors->first('birth_date') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div> 
                                                             
                                            
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('country') ? ' has-error' : '' }}">
                                                <label class="control-label" for="country">{{__('website.hostesses_arr.create.country')}}</label>
                                                <input type="text" class="form-control" name="country" value="{{old('country')}}">
                                                @if ($errors->has('country'))
                                                    <span class="help-block"><strong>{{ $errors->first('country') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('nationality') ? ' has-error' : '' }}">
                                                <label class="control-label" for="nationality"> {{__('website.hostesses_arr.create.nationality')}}</label>
                                                <input type="text" class="form-control" name="nationality" value="{{old('nationality')}}">
                                                @if ($errors->has('nationality'))
                                                    <span class="help-block"><strong>{{ $errors->first('nationality') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">                                              
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('region_id') ? ' has-error' : '' }}">
                                                <label class="control-label" for="region_id">{{__('website.hostesses_arr.create.region')}}</label>
                                                <select class="form-control" id="region" name="region_id" required>
                                                    <option value=""></option>
                                                    @foreach($regions as $region)
                                                    <option value="{{$region->id}}" {{old('region_id')==$region->id ? "selected" : ""}}>{{$region->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('region_id'))
                                                    <span class="help-block"><strong>{{ $errors->first('region_id') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('city_id') ? ' has-error' : '' }}">
                                                <label for="city_id" class="control-label">{{__('website.hostesses_arr.create.zip_city')}}</label>
                                                <div class="ui-widget">                         
                                                    <input type="text" class="autocomplete form-control" id="city" name="city" value="{{old('city')}}">
                                                    <input type="hidden" class="form-control" id="city_id" name="city_id" value="{{old('city_id')}}" required/>
                                                </div>                        
                                                @if ($errors->has('city_id'))
                                                        <span class="help-block"><strong>{{ $errors->first('city_id') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('address') ? ' has-error' : '' }}">
                                                <label class="control-label" for="address">{{__('website.hostesses_arr.create.address')}}</label>
                                                <input type="text" class="form-control" id="address" name="address" value="{{old('address')}}" required>
                                                @if ($errors->has('address'))
                                                    <span class="help-block"><strong>{{ $errors->first('address') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('type') ? ' has-error' : '' }}">
                                                <label class="control-label" for="type">{{__('website.hostesses_arr.create.type')}}</label>
                                                <select class="form-control" name="type" required> 
                                                    <option value=''>Type</option>
                                                    @foreach(__('website.personal_types_arr') as $key=>$value)
                                                    <option value='{{$key}}' {{old('type')==$key ? "selected" : ""}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('type'))
                                                    <span class="help-block"><strong>{{ $errors->first('type') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>

                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('height') ? ' has-error' : '' }}">
                                                <label class="control-label" for="height">{{__('website.hostesses_arr.create.height')}}</label>
                                                <select class="form-control" name="height" type="text">
                                                    <option></option>
                                                    @for($i=159;$i<=210;$i++)
                                                    <option value="{{$i}}" {{old('height')==$i ? "selected" : ""}}>{{$i}}</option>
                                                    @endfor
                                                </select>
                                                @if ($errors->has('height'))
                                                    <span class="help-block"><strong>{{ $errors->first('height') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div> 
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('cloth_size') ? ' has-error' : '' }}">
                                                <label class="control-label" for="cloth_size">{{__('website.hostesses_arr.create.cloth_size')}}</label>
                                                <select class="form-control" name="cloth_size" type="text">
                                                    <option></option>
                                                    @for($i=32;$i<=56;$i+=2)
                                                    <option value="{{$i}}" {{old('cloth_size')==$i ? "selected" : ""}}>{{$i}}</option>
                                                    @endfor
                                                </select>
                                                @if ($errors->has('cloth_size'))
                                                    <span class="help-block"><strong>{{ $errors->first('cloth_size') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div> 							
                                        </div>

                                        <div class="form-group">                            
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('chest') ? ' has-error' : '' }}">
                                                <label class="control-label" for="chest">{{__('website.hostesses_arr.create.chest')}}</label>
                                                <select class="form-control" name="chest" type="text"> 
                                                    <option></option>
                                                    @for($i=70;$i<=132;$i++)
                                                    <option value="{{$i}}" {{old('chest',90)==$i ? "selected" : ""}}>{{$i}}</option>
                                                    @endfor                                                    
                                                </select>
                                                @if ($errors->has('chest'))
                                                    <span class="help-block"><strong>{{ $errors->first('chest') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('waist') ? ' has-error' : '' }}">
                                                <label class="control-label" for="waist">{{__('website.hostesses_arr.create.waist')}}</label>
                                                <select class="form-control" name="waist" type="text">
                                                    <option></option>
                                                    @for($i=50;$i<=115;$i++)
                                                    <option value="{{$i}}" {{old('waist',60)==$i ? "selected" : ""}}>{{$i}}</option>
                                                    @endfor                                                      
                                                </select>
                                                @if ($errors->has('waist'))
                                                    <span class="help-block"><strong>{{ $errors->first('waist') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('hips') ? ' has-error' : '' }}">
                                                <label class="control-label" for="hips">{{__('website.hostesses_arr.create.hips')}}</label>
                                                <select class="form-control" id="hips" name="hips" type="text">
                                                    <option></option>
                                                    @for($i=70;$i<=140;$i++)
                                                    <option value="{{$i}}" {{old('hips',90)==$i ? "selected" : ""}}>{{$i}}</option>
                                                    @endfor
                                                </select>
                                                @if ($errors->has('hips'))
                                                    <span class="help-block"><strong>{{ $errors->first('hips') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div> 							
                                        </div> 

                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('hair_color') ? ' has-error' : '' }}">
                                                <label class="control-label" for="hair_color">{{__('website.hostesses_arr.create.hair_color')}}</label>
                                                <select class="form-control" name="hair_color" type="text"> 
                                                    <option></option>
                                                    @foreach(__('website.hair_colors_arr') as $key=>$value)
                                                    <option value="{{$key}}" {{old('hair_color')==$key ? "selected" : ""}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('hair_color'))
                                                    <span class="help-block"><strong>{{ $errors->first('hair_color') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>

                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('eye_color') ? ' has-error' : '' }}">
                                                <label class="control-label" for="eye_color">{{__('website.hostesses_arr.create.eye_color')}}</label>
                                                <select class="form-control" name="eye_color" type="text">
                                                    <option></option>
                                                    @foreach(__('website.eye_colors_arr') as $key=>$value)
                                                    <option value="{{$key}}" {{old('eye_color')==$key ? "selected" : ""}}>{{$value}}</option>
                                                    @endforeach                                                    
                                                </select>
                                                @if ($errors->has('eye_color'))
                                                    <span class="help-block"><strong>{{ $errors->first('eye_color') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>  

                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('shoe_size') ? ' has-error' : '' }}">
                                                <label class="control-label" for="shoe_size">{{__('website.hostesses_arr.create.shoe_size')}}</label>
                                                <select class="form-control" name="shoe_size" type="text">
                                                    <option></option>
                                                    @for($i=35;$i<=50;$i++)
                                                    <option value="{{$i}}" {{old('shoe_size')==$i ? "selected" : ""}}>{{$i}}</option>
                                                    @endfor 
                                                </select>
                                                @if ($errors->has('shoe_size'))
                                                    <span class="help-block"><strong>{{ $errors->first('shoe_size') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div> 							
                                        </div>   

                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('tattoo') ? ' has-error' : '' }}">      
                                                <label class="control-label text-left" for="tattoo">{{__('website.hostesses_arr.create.visible_tattoo')}}</label>
                                                <div>                                    
                                                    <input type="radio" name="tattoo" value="1" id="radio3" {{old('tattoo')==='1' ? 'checked' : ''}}>
                                                    <label for="radio3">{{__('website.hostesses_arr.create.yes')}}</label>

                                                    <input type="radio" name="tattoo" value="0" id="radio4" {{old('tattoo')==='0' ? 'checked' : ''}}>
                                                    <label for="radio4">{{__('website.hostesses_arr.create.no')}}</label> 
                                                </div>
                                                @if ($errors->has('tattoo'))
                                                    <span class="help-block"><strong>{{ $errors->first('tattoo') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>

                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('piercing') ? ' has-error' : '' }}">      
                                                <label class="control-label" for="piercing">{{__('website.hostesses_arr.create.visible_piercing')}}</label>                                
                                                <div>
                                                    <input type="radio" name="piercing" value="1" id="radio5" {{old('piercing')==='1' ? 'checked' : ''}}>
                                                    <label for="radio5">{{__('website.hostesses_arr.create.yes')}}</label>

                                                    <input type="radio" name="piercing" value="0" id="radio6" {{old('piercing')==='0' ? 'checked' : ''}}>
                                                    <label for="radio6">{{__('website.hostesses_arr.create.no')}}</label>
                                                </div>    
                                                @if ($errors->has('piercing'))
                                                    <span class="help-block"><strong>{{ $errors->first('piercing') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                    <div class='row'>
                                        <h3>{{__('website.hostesses_arr.create.profile')}}</h3>

                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('occupation') ? ' has-error' : '' }}">
                                                <label class="control-label" for="occupation">{{__('website.hostesses_arr.create.occupation')}}</label>
                                                <input type="text" class="form-control" name="occupation" value="{{old('occupation')}}">
                                                @if ($errors->has('tattoo'))
                                                    <span class="help-block"><strong>{{ $errors->first('occupation') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>

                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('profession') ? ' has-error' : '' }}">
                                                <label class="control-label" for="profession">{{__('website.hostesses_arr.create.profession')}}</label>
                                                <input type="text" class="form-control" name="profession" value="{{old('profession')}}">
                                                @if ($errors->has('profession'))
                                                    <span class="help-block"><strong>{{ $errors->first('profession') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>

                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('education') ? ' has-error' : '' }}">                                
                                                <label class="control-label" for="education">{{__('website.hostesses_arr.create.education')}}</label>
                                                <input type="text" class="form-control" name="education" value="{{old('education')}}">
                                                @if ($errors->has('education'))
                                                    <span class="help-block"><strong>{{ $errors->first('education') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>                                  
                                            </div> 
                                        </div>

                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('driver_licence') ? ' has-error' : '' }}">      
                                                <label class="control-label text-left" for="driver_licence">{{__('website.hostesses_arr.create.driver_licence')}}</label>
                                                <div>                                    
                                                    <input type="radio" name="driver_licence" value="1" id="radio7" {{old('driver_licence')==='1' ? 'checked' : ''}}>
                                                    <label for="radio7">{{__('website.hostesses_arr.create.yes')}}</label>

                                                    <input type="radio" name="driver_licence" value="0" id="radio8" {{old('driver_licence')==='0' ? 'checked' : ''}}>
                                                    <label for="radio8">{{__('website.hostesses_arr.create.no')}}</label>                                    
                                                </div>
                                                @if ($errors->has('driver_licence'))
                                                    <span class="help-block"><strong>{{ $errors->first('driver_licence') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div> 
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('own_car') ? ' has-error' : '' }}">      
                                                <label class="control-label" for="own_car">{{__('website.hostesses_arr.create.own_car')}}</label>
                                                <div>                                    
                                                    <input type="radio" name="own_car" value="1" id="radio9" {{old('own_car')==='1' ? 'checked' : ''}}>
                                                    <label for="radio9">{{__('website.hostesses_arr.create.yes')}}</label>

                                                    <input type="radio" name="own_car" value="0" id="radio10" {{old('old_car')==='0' ? 'checked' : ''}}>
                                                    <label for="radio10">{{__('website.hostesses_arr.create.no')}}</label>                                    
                                                </div>
                                                @if ($errors->has('own_car'))
                                                    <span class="help-block"><strong>{{ $errors->first('own_car') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('trade_licence') ? ' has-error' : '' }}">      
                                                <label class="control-label" for="trade_licence">{{__('website.hostesses_arr.create.trade_licence')}}</label>
                                                <div>
                                                    <input type="radio" name="trade_licence" value="1" id="radio11" {{old('trade_licence')==='1' ? 'checked' : ''}}>
                                                    <label for="radio11">{{__('website.hostesses_arr.create.yes')}}</label>

                                                    <input type="radio" name="trade_licence" value="0" id="radio12" {{old('trade_licence')==='0' ? 'checked' : ''}}>
                                                    <label for="radio12">{{__('website.hostesses_arr.create.no')}}</label>                                    
                                                </div> 
                                                @if ($errors->has('trade_licence'))
                                                    <span class="help-block"><strong>{{ $errors->first('trade_licence') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('health_certificate') ? ' has-error' : '' }}">     
                                                <label class="control-label" for="health_certificate">{{__('website.hostesses_arr.create.health_certificate')}}</label>
                                                <div>                                    
                                                    <input type="radio" name="health_certificate" value="1" id="radio13" {{old('health_certificate')==='1' ? 'checked' : ''}}>
                                                    <label for="radio13">{{__('website.hostesses_arr.create.yes')}}</label>

                                                    <input type="radio" name="health_certificate" value="0" id="radio14" {{old('health_certificate')==='0' ? 'checked' : ''}}>
                                                    <label for="radio14">{{__('website.hostesses_arr.create.no')}}</label>                                    
                                                </div>
                                                @if ($errors->has('health_certificate'))
                                                    <span class="help-block"><strong>{{ $errors->first('health_certificate') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>
                                        <br/>
                                        <h3>{{__('website.hostesses_arr.create.spoken_languages')}}</h3>

                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('de') ? ' has-error' : '' }}">
                                                <label class="control-label" for="de">{{__('website.hostesses_arr.create.german')}}</label>
                                                <select class="form-control" name="de" type="text"> 
                                                    <option></option>
                                                    @foreach(__('website.language_levels_arr') as $key=>$value)
                                                    <option value="{{$key}}" {{old('de')==$key ? "selected" : ""}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('de'))
                                                    <span class="help-block"><strong>{{ $errors->first('de') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>

                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('en') ? ' has-error' : '' }}">
                                                <label class="control-label" for="en">{{__('website.hostesses_arr.create.english')}}</label>
                                                <select class="form-control" name="en" type="text">
                                                    <option></option>
                                                    @foreach(__('website.language_levels_arr') as $key=>$value)
                                                    <option value="{{$key}}" {{old('en')==$key ? "selected" : ""}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('en'))
                                                    <span class="help-block"><strong>{{ $errors->first('en') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div> 

                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('sp') ? ' has-error' : '' }}">
                                                <label class="control-label" for="sp">{{__('website.hostesses_arr.create.spanish')}}</label>
                                                <select class="form-control" name="sp" type="text">
                                                    <option></option>
                                                    @foreach(__('website.language_levels_arr') as $key=>$value)
                                                    <option value="{{$key}}" {{old('sp')==$key ? "selected" : ""}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('sp'))
                                                    <span class="help-block"><strong>{{ $errors->first('sp') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>

                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('fr') ? ' has-error' : '' }}">
                                                <label class="control-label" for="fr">{{__('website.hostesses_arr.create.french')}}</label>
                                                <select class="form-control" name="fr" type="text">
                                                    <option></option>
                                                    @foreach(__('website.language_levels_arr') as $key=>$value)
                                                    <option value="{{$key}}" {{old('fr')==$key ? "selected" : ""}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('fr'))
                                                    <span class="help-block"><strong>{{ $errors->first('fr') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('other_language_1') ? ' has-error' : '' }}">
                                                <label class="control-label" for="other_language_1">{{__('website.hostesses_arr.create.other_language')}}</label>
                                                <select class="form-control" name="other_language_1" type="text">
                                                    <option value=""></option>
                                                    @foreach(__('website.languages_arr') as $key=>$value)
                                                    <option value="{{$key}}" {{old('other_language_1')==$key ? "selected" : ""}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('other_language_1'))
                                                    <span class="help-block"><strong>{{ $errors->first('other_language_1') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('other_language_1_lvl') ? ' has-error' : '' }}">
                                                <label class="control-label" for="other_language_1_lvl"> {{__('website.hostesses_arr.create.level')}}</label>
                                                <select class="form-control" name="other_language_1_lvl" type="text">
                                                    <option></option>
                                                    @foreach(__('website.short_language_levels_arr') as $key=>$value)
                                                    <option value="{{$key}}" {{old('other_language_1_lvl')==$key ? "selected" : ""}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('other_language_1_lvl'))
                                                    <span class="help-block"><strong>{{ $errors->first('other_language_1_lvl') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('other_language_2') ? ' has-error' : '' }}">
                                                <label class="control-label" for="other_language_2">{{__('website.hostesses_arr.create.other_language')}}</label>
                                                <select class="form-control" name="other_language_2" type="text">
                                                    <option value=""></option>
                                                    @foreach(__('website.languages_arr') as $key=>$value)
                                                    <option value="{{$key}}" {{old('other_language_2')==$key ? "selected" : ""}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('other_language_2'))
                                                    <span class="help-block"><strong>{{ $errors->first('other_language_2') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('other_language_2_lvl') ? ' has-error' : '' }}">
                                                <label class="control-label" for="other_language_2_lvl"> {{__('website.hostesses_arr.create.level')}}</label>
                                                <select class="form-control" name="other_language_2_lvl" type="text">
                                                    <option></option>
                                                    @foreach(__('website.short_language_levels_arr') as $key=>$value)
                                                    <option value="{{$key}}" {{old('other_language_2_lvl')==$key ? "selected" : ""}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('other_language_2_lvl'))
                                                    <span class="help-block"><strong>{{ $errors->first('other_language_2_lvl') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('other_language_3') ? ' has-error' : '' }}">
                                                <label class="control-label" for="other_language_3">{{__('website.hostesses_arr.create.other_language')}}</label>
                                                <select class="form-control" name="other_language_3" type="text">
                                                    <option value=""></option>
                                                    @foreach(__('website.languages_arr') as $key=>$value)
                                                    <option value="{{$key}}" {{old('other_language_3')==$key ? "selected" : ""}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('other_language_3'))
                                                    <span class="help-block"><strong>{{ $errors->first('other_language_3') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('other_language_3_lvl') ? ' has-error' : '' }}">
                                                <label class="control-label" for="other_language_3_lvl"> {{__('website.hostesses_arr.create.level')}}</label>
                                                <select class="form-control" name="other_language_3_lvl" type="text">
                                                    <option></option>
                                                    @foreach(__('website.short_language_levels_arr') as $key=>$value)
                                                    <option value="{{$key}}" {{old('other_language_3_lvl')==$key ? "selected" : ""}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('other_language_3_lvl'))
                                                    <span class="help-block"><strong>{{ $errors->first('other_language_3_lvl') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>

                                        <br/>
                                        <h3>{{__('website.hostesses_arr.create.accommodation_places')}}</h3>                       
                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-12{{ $errors->has('accommodation_places') ? ' has-error' : '' }}">
                                                @foreach($main_cities as $main_city)
                                                <label style='margin-right:2%;min-width:135px;'> 
                                                    <input type="checkbox" name="accommodation_places[]" value="{{$main_city->id}}" id="accommodation_place_{{$main_city->id}}" {{old('accommodation_places') && in_array($main_city->id,old('accommodation_places')) ? 'checked' : ''}}> {{$main_city->name}}
                                                </label>
                                                @endforeach
                                                @if ($errors->has('accommodation_places'))
                                                    <span class="help-block"><strong>{{ $errors->first('accommodation_places') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('other_cities') ? ' has-error' : '' }}">
                                               <label class="control-label" for="other_cities">{{__('website.hostesses_arr.create.other_cities')}}</label>
                                               <input type="text" class="form-control" name="other_cities" value='{{old('other_cities')}}'>
                                            </div>
                                            @if ($errors->has('other_cities'))
                                                <span class="help-block"><strong>{{ $errors->first('other_cities') }}</strong></span>
                                            @endif
                                            <div class="errorBox"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-4" class="tab-pane">
                                <div class="panel-body">
                                    <div class='row'>
                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('modeling') ? ' has-error' : '' }}">
                                                <label class="control-label" for="modeling">{{__('website.hostesses_arr.create.modeling')}}</label>
                                                <input type="text" class="form-control" name="modeling" value='{{old('modeling')}}'>
                                                @if ($errors->has('modeling'))
                                                    <span class="help-block"><strong>{{ $errors->first('modeling') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>

                                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('presentation') ? ' has-error' : '' }}">
                                                <label class="control-label" for="presentation">{{__('website.hostesses_arr.create.presentation')}}</label>
                                                <input type="text" class="form-control" name="presentation" value='{{old('presentation')}}'>
                                                @if ($errors->has('presentation'))
                                                    <span class="help-block"><strong>{{ $errors->first('presentation') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div> 

                                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('gastronomy') ? ' has-error' : '' }}">                                
                                                <label class="control-label" for="gastronomy">{{__('website.hostesses_arr.create.gastronomy')}}</label>
                                                <input type="text" class="form-control" name="gastronomy" value='{{old('gastronomy')}}'>
                                                @if ($errors->has('gastronomy'))
                                                    <span class="help-block"><strong>{{ $errors->first('gastronomy') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>                             
                                        </div>

                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('team_leader') ? ' has-error' : '' }}">
                                                <label class="control-label" for="team_leader">{{__('website.hostesses_arr.create.team_leader')}}</label>
                                                <input type="text" class="form-control" name="team_leader" value='{{old('team_leader')}}'>
                                                @if ($errors->has('team_leader'))
                                                    <span class="help-block"><strong>{{ $errors->first('team_leader') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('experience_abroad') ? ' has-error' : '' }}">
                                                <label class="control-label" for="experience_abroad">{{__('website.hostesses_arr.create.experience_abroad')}}</label>
                                                <input type="text" class="form-control" name="experience_abroad" value='{{old('experience_abroad')}}'>
                                                @if ($errors->has('experience_abroad'))
                                                    <span class="help-block"><strong>{{ $errors->first('experience_abroad') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>                                            
                                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('musical_instrument') ? ' has-error' : '' }}">
                                                <label class="control-label" for="musical_instrument">{{__('website.hostesses_arr.create.musical_instrument')}}</label>
                                                <input type="text" class="form-control" name="musical_instrument" value='{{old('musical_instrument')}}'>
                                                @if ($errors->has('musical_instrument'))
                                                    <span class="help-block"><strong>{{ $errors->first('musical_instrument') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>                           
                                        </div>
                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-12{{ $errors->has('past_experience') ? ' has-error' : '' }}">
                                                <label class="control-label" for="past_experience">{{__('website.hostesses_arr.create.past_experience')}}</label>
                                                <textarea class="form-control" type="text" name="past_experience" rows="6">{{old('past_experience')}}</textarea>
                                                @if ($errors->has('past_experience'))
                                                <span class="help-block"><strong>{{ $errors->first('past_experience') }}</strong></span>
                                                @endif
                                            <div class="errorBox"></div> 
                                            </div>                                                       
                                        </div>
                                    </div>                                                       
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-5" class="tab-pane">
                                <div class="panel-body">
                                    <div class='row'>
                                        <div class="form-group">
                                            <div class="col-xs-12 text-left">
                                                <br><br>
                                                <b ><h3><font size="2" color="ff5a5f">*</font> {{__('website.hostesses_arr.create.upload_pictures')}}</h3></b>
                                                <br>
                                                <p>{!!__('website.hostesses_arr.create.upload_pictures_text_1')!!}</p> 
                                                <img src="{{asset('images/website/Portrait.jpg')}}" alt="{{__('website.hostesses_arr.create.hostesses_home')}}" title="{{__('website.hostesses_arr.create.hostesses_home')}}" width="195" height="283" border="1">
                                                <img src="{{asset('images/website/Ganzkoerperbild.jpg')}}" alt="{{__('website.hostesses_arr.create.hostesses_home')}}" title="{{__('website.hostesses_arr.create.hostesses_home')}}e" width="195" height="283" border="1">
                                                <img src="{{asset('images/website/amerikanisches-Portrait.jpg')}}" alt="{{__('website.hostesses_arr.create.hostesses_home')}}" title="{{__('website.hostesses_arr.create.hostesses_home')}}" width="195" height="283" border="1">
                                                <br>
                                                {!!__('website.hostesses_arr.create.upload_pictures_text_2')!!}

                                                <br><br>

                                                <div class="image_div">
                                                    <div class="img-row-edit">
                                                        <img class="element_image portrait" src="{{asset('images/website/Portrait.jpg')}}" alt="Portrait"/>
                                                    </div>
                                                    <div class="img-row">
                                                        <div class="margin--bottom-5">
                                                            <div class="custom-file">
                                                                <label class="btn m-btn--icon-only">
                                                                    <input class="custom-file-input" type="file" name="portrait" value="">
                                                                    <i class="glyphicon glyphicon-upload"></i>
                                                                </label>
                                                                <a type="button" href="javascript:;" class="remove_portrait">
                                                                    <i class="glyphicon glyphicon-trash"></i>
                                                                </a>                                                
                                                            </div>
                                                            @if ($errors->has('portrait'))
                                                                <span class="help-block"><strong>{{ $errors->first('portrait') }}</strong></span>
                                                            @endif
                                                            <div class="errorBox"></div>
                                                        </div>                                                                
                                                    </div>
                                                    <div class="clear-both"></div>
                                                </div>

                                                <br/>
                                                <div class="image_div">
                                                    <div class="img-row-edit">
                                                        <img class="element_image body-image" src="{{asset('images/website/Ganzkoerperbild.jpg')}}" alt="Ganzkoerperbild"/>
                                                    </div>
                                                    <div class="img-row">
                                                        <div class="margin--bottom-5">
                                                            <div class="custom-file">
                                                                <label class="btn m-btn--icon-only">
                                                                    <input class="custom-file-input" type="file" name="body_image" required>
                                                                    <i class="glyphicon glyphicon-upload"></i>
                                                                </label>
                                                                <a type="button" href="javascript:;" class="remove_body_image">
                                                                    <i class="glyphicon glyphicon-trash"></i>
                                                                </a>                                                
                                                            </div>
                                                            @if ($errors->has('body_image'))
                                                                <span class="help-block"><strong>{{ $errors->first('body_image') }}</strong></span>
                                                            @endif
                                                            <div class="errorBox"></div>
                                                        </div>                                                                
                                                    </div>
                                                    <div class="clear-both"></div>
                                                </div>

                                                <br/>
                                                <div class="image_div images_div">
                                                    <div class="img-row-edit">
                                                        <img class="element_image" src="{{asset('images/website/amerikanisches-Portrait.jpg')}}" alt="amerikanisches Portrait"/>
                                                    </div>
                                                    <div class="img-row">
                                                        <div class="margin--bottom-5">
                                                            <div class="custom-file">
                                                                <label class="btn m-btn--icon-only">
                                                                    <input class="custom-file-input" type="file" name="images[]">
                                                                    <i class="glyphicon glyphicon-upload"></i>
                                                                </label>
                                                                <a type="button" href="javascript:;" class="remove_image">
                                                                    <i class="glyphicon glyphicon-trash"></i>
                                                                </a>                                                
                                                            </div>  
                                                            @if ($errors->has('images.*'))
                                                                <span class="help-block"><strong>{{ $errors->first('images.*') }}</strong></span>
                                                            @endif
                                                            <div class="errorBox"></div>
                                                        </div>                                                                
                                                    </div>
                                                    <div class="clear-both"></div>
                                                </div>           
                                                <div class="add_element_image">
                                                    <a href="javascript:;" class="btn btn-primary btn-default add_image">{{__('website.hostesses_arr.create.add_image')}}</a>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                                
                            <div role="tabpanel" id="tab-6" class="tab-pane">
                                <div class="panel-body">
                                    <div class='row'>
                                        <b ><h3><font size="2" color="ff5a5f">*</font>  {{__('website.hostesses_arr.create.public_model_file')}}</h3></b>
                                        <div class="form-group">                            
                                            <div class="control-group col-xs-12 col-md-9{{ $errors->has('public_consent') ? ' has-error' : '' }}">
                                                <p>{!!__('website.hostesses_arr.create.text3')!!}</p>
                                                <div>                                        
                                                    <input type="radio" name="public_consent" value="1" class="styled">
                                                    <label for="public_consent">{{__('website.hostesses_arr.create.public_yes')}}</label>
                                                </div>
                                                <div>    
                                                    <input type="radio" name="public_consent" value="0" class="styled">
                                                    <label for="public_consent">{{__('website.hostesses_arr.create.public_no')}}</label>                                        
                                                </div>
                                                @if ($errors->has('public_consent'))
                                                    <span class="help-block"><strong>{{ $errors->first('public_consent') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-9{{ $errors->has('terms_agreed') ? ' has-error' : '' }}">
                                                <div>
                                                    <input type="radio" name="terms_agreed" value="1" class="styled" id="terms_agreed">
                                                    <label for="terms_agreed"></label>

                                                    <strong>{{__('website.hostesses_arr.create.accept')}}</strong> {{__('website.hostesses_arr.create.our')}} <a href="/nutzungsbedingungen/hostessen.html" target="_blank" class="alert-link">{{__('website.hostesses_arr.create.terms_of_use')}}</a> &amp; <a href="/datenschutz/" target="_blank" class="alert-link">{{__('website.hostesses_arr.create.data_protection')}}</a>.
                                                </div>
                                                @if ($errors->has('terms_agreed'))
                                                    <span class="help-block"><strong>{{ $errors->first('terms_agreed') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div> 
                                        <button type="submit">{{__('website.hostesses_arr.create.submit_formular')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="panel-footer"></div>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/datepicker-de.js') }}"></script>
<script src="{{ asset('js/jquery.validate.js') }}"></script>
<script src="{{ asset('js/validation.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/filter_cities.js') }}"></script>

<script type="text/javascript" charset="utf-8">
    $('#type,#region').select2();
    
    $('#birth_date').datepicker({
        changeMonth: true, 
        changeYear: true, 
        dateFormat: "dd.mm.yy",
        yearRange: "-30:+00" 
    });
    
    $('.add_image').on('click',function(){
        var new_element = $('.image_div').last().clone();
        new_element.find('.element_image').attr('src',"{{asset('images/website/amerikanisches-Portrait.jpg')}}");
        new_element.find('.errorBox').html('');
        $('.add_element_image').before(new_element);
    });
    
    function readURL(element,input){
         if(input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              element.closest('.image_div').find('.element_image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

     $(document).on('change',".custom-file-input",function() {
        var element = $(this);
        $(this).closest('.margin--bottom-5').find('.errorBox').html('');
        $('.submit').attr('disabled',false);
        if($(this).val()!=''){
            if(this.files[0].size>5242880){
                $(this).closest('.margin--bottom-5').find('.errorBox').append('<label class="error size_error">Снимката трябва да бъде до 5МБ</label><br/>');
                $('.submit').attr('disabled',true);
            }
            else{
                $(this).closest('.margin--bottom-5').find('.errorBox').find('.size_error').remove();
            }
            
            if($.inArray(this.value.split('.').pop(),['jpg','jpeg','png','bmp','gif','svg'])==-1){
                
                var current_element = $(this).closest('.image_div').find('.element_image');

                if(current_element.hasClass('portrait')){
                    current_element.attr('src',"{{asset('images/website/Portrait.jpg')}}");
                }
                else if(current_element.hasClass('body-image')){
                    current_element.attr('src',"{{asset('images/website/Ganzkoerperbild.jpg')}}");
                }
                else{
                    current_element.attr('src',"{{asset('images/website/amerikanisches-Portrait.jpg')}}");
                }
                
                $(this).closest('.image_div').find('.custom-file-input').val('').change();
                $(this).closest('.margin--bottom-5').find('.errorBox').append('<label class="error extension_error">Файлът трябва да е с разширение jpg, jpeg ,png ,bmp ,gif или svg.</label>');
                $('.submit').attr('disabled',true);
            }
            else{
                $(this).closest('.margin--bottom-5').find('.errorBox').find('.extension_error').remove();
            }
        }
         readURL(element,this);
    });
    
    $(document).on('click','.remove_portrait',function(){        
        $(this).closest('.image_div').find('.element_image').attr('src',"{{asset('images/website/Portrait.jpg')}}");
        $(this).closest('.image_div').find('.custom-file-input').val('').change();
    });
    
    $(document).on('click','.remove_body_image',function(){        
            $(this).closest('.image_div').find('.element_image').attr('src',"{{asset('images/website/Ganzkoerperbild.jpg')}}");
            $(this).closest('.image_div').find('.custom-file-input').val('').change();
    });
     
    $(document).on('click','.remove_image',function(){
        if($('.images_div').length>1){
            $(this).closest('.images_div').remove();
            if(!$('.error').length){
                $('.submit').attr('disabled',false);
            }
        }
        else{
            $(this).closest('.image_div').find('.element_image').attr('src',"{{asset('images/website/amerikanisches-Portrait.jpg')}}");
            $(this).closest('.image_div').find('.custom-file-input').val('').change();
        }
    }); 
</script>
@endsection