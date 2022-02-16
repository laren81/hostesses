@extends('layouts.app')

@section('link')
<link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery.timepicker.css') }}" rel="stylesheet">
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
                <h3 class="panel-title">{{__('texte.users_arr.edit_client.edit_client')}} {{$client->company_name}}</h3>
            </div>

            <div class="panel-body">
                <form id="edit_client" method="POST" action="{{route('admin.clients.update',$client->id)}}" class="form form-horizontal">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    
                    <input type="hidden" name="user_id" value="{{$user->id}}"/>

                    <div class="tabs-container">                     
                        <ul class="nav nav-tabs" role="tablist">
                            <li class='active'><a class="nav-link active" data-toggle="tab" href="#tab-1">Contacts</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-2">Company details</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <div class='row'>
                                        <div class="form-group">                            
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('title') ? ' has-error' : '' }}">
                                                <label for="title" class="control-label">{{__('texte.users_arr.edit_client.title')}}</label>
                                                <select class="form-control" id="title" name="title" required>
                                                    <option value="">{{__('texte.users_arr.edit_client.select')}}</option>
                                                    @foreach(__('website.titles_arr') as $key=>$value)
                                                    <option value="{{$key}}" {{old('title',$client->title)==$key ? "selected" : ""}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('title'))
                                                    <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                                                    
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                                <label for="first_name" class="control-label">{{__('texte.users_arr.edit_client.first_name')}}</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{old('first_name',$user->first_name)}}" required/>
                                                @if ($errors->has('first_name'))
                                                        <span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                                <label for="last_name" class="control-label">{{__('texte.users_arr.edit_client.last_name')}}</label>
                                                <input type="text" class="form-control" id="name" name="last_name" value="{{old('last_name',$user->last_name)}}" required/>
                                                @if ($errors->has('last_name'))
                                                        <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>                                            
                                        </div>

                                        <div class="form-group">                           
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('email') ? ' has-error' : '' }}">
                                                <label for="email" class="control-label">{{__('texte.users_arr.edit_client.email')}}</label>
                                                <input type="text" class="form-control" id="email" name="email" value="{{old('email',$user->email)}}" required/>
                                                @if ($errors->has('email'))
                                                        <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                          
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('phone') ? ' has-error' : '' }}">
                                                <label for="phone" class="control-label">{{__('texte.users_arr.edit_client.phone')}}</label>
                                                <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone',$user->phone)}}" required/>
                                                @if ($errors->has('phone'))
                                                        <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>    
                                        <div class="form-group col-xs-12 col-md-3 {{ $errors->has('active') ? ' has-error' : '' }}">                                            
                                            <label for="active" class="control-label">
                                                <input type="checkbox" id="active" name="active" value="1" {{ $user->active==1 ? "checked" : ""}} /> {{__('texte.users_arr.edit_client.active')}} 
                                            </label>
                                            @if ($errors->has('active'))
                                                <span class="help-block"><strong>{{ $errors->first('active') }}</strong></span>
                                            @endif
                                            <div class="errorBox"></div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <div class='row'> 
                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('company_name') ? ' has-error' : '' }}">
                                                <label for="company_name" class="control-label">{{__('texte.users_arr.edit_client.company_name')}}</label>
                                                <input type="text" class="form-control" id="company_name" name="company_name" value="{{old('company_name',$client->company_name)}}" required/>
                                                @if ($errors->has('company_name'))
                                                        <span class="help-block"><strong>{{ $errors->first('company_name') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('website') ? ' has-error' : '' }}">
                                                <label for="website" class="control-label">{{__('texte.users_arr.edit_client.website')}}</label>
                                                <input type="text" class="form-control" id="website" name="website" value="{{old('website',$client->website)}}"/>
                                                @if ($errors->has('website'))
                                                        <span class="help-block"><strong>{{ $errors->first('website') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">                                                                                        
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('region_id') ? ' has-error' : '' }}">
                                                <label class="control-label" for="region">{{__('texte.users_arr.edit_client.region')}}</label>
                                                <select class="form-control" id="region" name="region_id" required>
                                                    <option value=""></option>
                                                    @foreach($regions as $region)
                                                    <option value="{{$region->id}}" {{old('region_id',$client->region_id)==$region->id ? "selected" : ""}}>{{$region->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('region_id'))
                                                    <span class="help-block"><strong>{{ $errors->first('region_id') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('city_id') ? ' has-error' : '' }}">
                                                <label for="city_id" class="control-label">{{__('texte.users_arr.edit_client.zip_city')}}</label>
                                                <div class="ui-widget">                         
                                                    <input type="text" class="autocomplete form-control" id="city" name="city" value="{{old('city',($client->city->zip.' '.$client->city->name))}}">
                                                    <input type="hidden" class="form-control" id="city_id" name="city_id" value="{{old('city_id',$client->city_id)}}" required/>
                                                </div>                        
                                                @if ($errors->has('city_id'))
                                                        <span class="help-block"><strong>{{ $errors->first('city_id') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>                                          
                                        </div>
                                        
                                        <div class="form-group">                            
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('street') ? ' has-error' : '' }}">
                                                <label for="street" class="control-label">{{__('texte.users_arr.edit_client.street')}}</label>
                                                <input type="text" class="form-control" id="street" name="street" value="{{old('street',$client->street)}}" required/>
                                                @if ($errors->has('street'))
                                                    <span class="help-block"><strong>{{ $errors->first('street') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('house_number') ? ' has-error' : '' }}">
                                                <label class="control-label" for="house_number">{{__('texte.users_arr.edit_client.house_number')}}</label>
                                                <input type="text" class="form-control" id="house_number" name="house_number" value="{{old('house_number',$client->house_number)}}" required>
                                                @if ($errors->has('house_number'))
                                                    <span class="help-block"><strong>{{ $errors->first('house_number') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group">
                                            <div class="col-sm-12" style='text-align: center;'>
                                                <button type="submit" class="btn btn-default">{{__('texte.users_arr.edit_client.submit')}}</button>
                                            </div>
                                        </div>
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
<script src="{{ asset('js/jquery.timepicker.min.js') }}"></script>
<script src="{{ asset('js/filter_cities.js') }}"></script>

<script type="text/javascript" charset="utf-8">
    $('#title,#region').select2();
</script>
@endsection