@extends('layouts.website')

@section('link')
<link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery.timepicker.css') }}" rel="stylesheet">
@endsection

@section('style')
<style>
    .staff_position{
        padding:2px;
        background:#f3f3f4;
        margin-bottom:10px;
    }
    
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
                <h3 class="panel-title">{{__('website.clients_arr.create_profile.client_profile')}}</h3>
            </div>
            
            <div class="panel-body">
                <form id="create_client_profile" method="POST" action="{{route('users.store_client_profile',auth()->user()->id)}}" class="form form-horizontal">
                    {{ csrf_field() }}

                    <div class='row'>
                        <div class="form-group">   
                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="control-label">{{__('website.clients_arr.create_profile.title')}}</label>
                                <select class="form-control" id="title" name="title" required>
                                    <option value=""></option>
                                    @foreach(__('website.titles_arr') as $key=>$value)
                                    <option value="{{$key}}" {{old('title')==$key ? "selected" : ""}}>{{$value}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('title'))
                                    <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
                                @endif
                                <div class="errorBox"></div>
                            </div>
                            
                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('company_name') ? ' has-error' : '' }}">
                                <label for="company_name" class="control-label">{{__('website.clients_arr.create_profile.company_name')}}</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" value="{{old('company_name')}}" required/>
                                @if ($errors->has('company_name'))
                                        <span class="help-block"><strong>{{ $errors->first('company_name') }}</strong></span>
                                @endif
                                <div class="errorBox"></div>
                            </div>
                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('website') ? ' has-error' : '' }}">
                                <label for="website" class="control-label">{{__('website.clients_arr.create_profile.website')}}</label>
                                <input type="text" class="form-control" id="website" name="website" value="{{old('website')}}"/>
                                @if ($errors->has('website'))
                                        <span class="help-block"><strong>{{ $errors->first('website') }}</strong></span>
                                @endif
                                <div class="errorBox"></div>
                            </div>
                        </div>

                        <div class="form-group">                             
                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('region_id') ? ' has-error' : '' }}">
                                <label class="control-label" for="region">{{__('website.clients_arr.create_profile.region')}}</label>
                                <select class="form-control" id="region" name="region_id" required>
                                    <option value=""></option>
                                    @foreach($regions as $region)
                                    <option value="{{$region->id}}" {{old('region_id')==$region->id ? "required" : ""}}>{{$region->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('region_id'))
                                    <span class="help-block"><strong>{{ $errors->first('region_id') }}</strong></span>
                                @endif
                                <div class="errorBox"></div>
                            </div>
                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('city_id') ? ' has-error' : '' }}">
                                <label for="city_id" class="control-label">{{__('website.clients_arr.create_profile.zip_city')}}</label>
                                <div class="ui-widget">                         
                                    <input type="text" class="autocomplete form-control" id="city" name="city" value="{{old('city')}}">
                                    <input type="hidden" class="form-control" id="city_id" name="city_id" value="{{old('city_id')}}" required/>
                                </div>                        
                                @if ($errors->has('city_id'))
                                        <span class="help-block"><strong>{{ $errors->first('city_id') }}</strong></span>
                                @endif
                                <div class="errorBox"></div>
                            </div>                            
                        </div>
                        <div class="form-group">    
                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('street') ? ' has-error' : '' }}">
                                <label for="street" class="control-label">{{__('website.clients_arr.create_profile.street')}}</label>
                                <input type="text" class="form-control" id="street" name="street" value="{{old('street')}}" required/>
                                @if ($errors->has('street'))
                                    <span class="help-block"><strong>{{ $errors->first('street') }}</strong></span>
                                @endif
                                <div class="errorBox"></div>
                            </div>
                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('house_number') ? ' has-error' : '' }}">
                                <label class="control-label" for="house_number">{{__('website.clients_arr.create_profile.house_number')}}</label>
                                <input type="text" class="form-control" id="house_number" name="house_number" value="{{old('house_number')}}" required>
                                @if ($errors->has('house_number'))
                                    <span class="help-block"><strong>{{ $errors->first('house_number') }}</strong></span>
                                @endif
                                <div class="errorBox"></div>
                            </div>
                        </div>  
                        <div class="form-group">
                            <div class="control-group col-xs-12 col-md-12{{ $errors->has('terms_agreed') ? ' has-error' : '' }}">
                                <div>
                                    <input type="radio" name="terms_agreed" value="1" class="styled" id="terms_agreed">
                                    <label for="terms_agreed"></label>

                                    <strong>{{__('website.clients_arr.create_profile.accept')}}</strong> {{__('website.clients_arr.create_profile.our')}} <a href="/nutzungsbedingungen/hostessen.html" target="_blank" class="alert-link">{{__('website.clients_arr.create_profile.terms_of_use')}}</a> &amp; <a href="/datenschutz/" target="_blank" class="alert-link">{{__('website.clients_arr.create_profile.data_protection')}}</a>.
                                </div>
                                @if ($errors->has('terms_agreed'))
                                    <span class="help-block"><strong>{{ $errors->first('terms_agreed') }}</strong></span>
                                @endif
                                <div class="errorBox"></div>
                            </div>
                        </div> 
                        <div class="form-group">
                            <div class="col-sm-12" style='text-align: center;'>
                                <button type="submit" class="btn btn-default">{{__('website.clients_arr.create_profile.submit')}}</button>
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
<script src="{{ asset('js/jquery.timepicker.min.js') }}"></script>
<script src="{{ asset('js/filter_cities.js') }}"></script>

<script type="text/javascript" charset="utf-8">
    $('#title,#region').select2();
</script>
@endsection