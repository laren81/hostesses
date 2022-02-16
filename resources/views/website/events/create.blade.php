@extends('layouts.website')

@section('link')
<link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery.timepicker.css') }}" rel="stylesheet">
@endsection

@section('style')
<style>
    #tab-2 .row{
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
                <h3 class="panel-title">{{__('website.events_arr.create.event_form')}}</h3>
            </div>
            <div class="panel-body">
                <form id="event_create" method="POST" action="{{route('events.store')}}" class="form form-horizontal">
                    {{ csrf_field() }}

                    <input type="hidden" name="client_id" value="{{$client->id}}"/>
                    
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class='active'><a class="nav-link active" data-toggle="tab" href="#tab-1">{{__('website.events_arr.create.general_information')}}</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-2">{{__('website.events_arr.create.required_staff')}}</a></li>
                        </ul>
                        
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <div class='row'>                       
                                        <div class="form-group">                            
                                            <div class="control-group col-xs-12 col-md-12{{ $errors->has('name') ? ' has-error' : '' }}">
                                                <label for="name" class="control-label">{{__('website.events_arr.create.event_name')}}</label>
                                                <input type="text" class="form-control" id="event_name" name="name" value="{{old('name')}}" required/>
                                                @if ($errors->has('name'))
                                                        <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">  
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('internal_location') ? ' has-error' : '' }}">
                                                <label for="title" class="control-label">{{__('website.events_arr.create.internal_location')}}</label>
                                                <div>
                                                    <input type="radio" name="internal_location" value="1" id="radio1" {{old('internal_location')==='1' ? 'checked' : ''}} checked>
                                                    <label for="radio1">{{__('website.events_arr.create.yes')}}</label>

                                                    <input type="radio" name="internal_location" value="2" id="radio2" {{old('internal_location')==='2' ? 'checked' : ''}}>
                                                    <label for="radio2">{{__('website.events_arr.create.no')}}</label>
                                                </div>
                                                @if ($errors->has('internal_location'))
                                                    <span class="help-block"><strong>{{ $errors->first('internal_location') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('region_id') ? ' has-error' : '' }}">
                                                <label for="region_id" class="control-label">{{__('website.events_arr.create.region')}}</label>
                                                <select class="form-control" id='region' name='region_id' required>
                                                    <option value=''></option>
                                                    @foreach($regions as $region)
                                                    <option value='{{$region->id}}' {{old('region_id')==$region->id ? "selected" : ""}}>{{$region->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('region_id'))
                                                    <span class="help-block"><strong>{{ $errors->first('region_id') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('city_id') ? ' has-error' : '' }}">
                                                <label for="city_id" class="control-label">{{__('website.events_arr.create.zip_city')}}</label>
                                                <div class="ui-widget">                         
                                                    <input type="text" class="autocomplete form-control" id="city" name="city" value="{{old('city')}}">
                                                    <input type="hidden" class="form-control" id="city_id" name="city_id" value="{{old('city_id')}}" required/>
                                                </div>                        
                                                @if ($errors->has('city_id'))
                                                        <span class="help-block"><strong>{{ $errors->first('city_id') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            
                                            <div class="control-group col-xs-12 col-md-6{{ $errors->has('external_city') ? ' has-error' : '' }}">
                                                <label for="external_city" class="control-label">{{__('website.events_arr.create.external_city')}}</label>
                                                <input type="text" class="form-control" id="external_city" name="external_city" value="{{old('external_city')}}" required/>
                                                @if ($errors->has('external_city'))
                                                        <span class="help-block"><strong>{{ $errors->first('external_city') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>

                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('location') ? ' has-error' : '' }}">
                                                <label for="location" class="control-label">{{__('website.events_arr.create.event_location')}}</label>
                                                <input type="text" class="form-control" id="event_location" name="location" value="{{old('location')}}" required/>
                                                @if ($errors->has('location'))
                                                        <span class="help-block"><strong>{{ $errors->first('location') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">                            
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('date_from') ? ' has-error' : '' }}">
                                                <label for="date_from" class="control-label">{{__('website.events_arr.create.date_from')}}</label>
                                                <input type="text" class="form-control" id="date_from" name="date_from" value="{{old('date_from')}}" required/>
                                                @if ($errors->has('date_from'))
                                                    <span class="help-block"><strong>{{ $errors->first('date_from') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('date_to') ? ' has-error' : '' }}">
                                                <label for="date_to" class="control-label">{{__('website.events_arr.create.date_to')}}</label>
                                                <input type="text" class="form-control" id="date_to" name="date_to" value="{{old('date_to')}}" required/>
                                                @if ($errors->has('date_to'))
                                                    <span class="help-block"><strong>{{ $errors->first('date_to') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('time_from') ? ' has-error' : '' }}">
                                                <label for="time_from" class="control-label">{{__('website.events_arr.create.time_from')}}</label>
                                                <input type="text" class="form-control" id="time_from" name="time_from" value="{{old('time_from')}}" required/>
                                                @if ($errors->has('time_from'))
                                                    <span class="help-block"><strong>{{ $errors->first('time_from') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('time_till') ? ' has-error' : '' }}">
                                                <label for="time_till" class="control-label">{{__('website.events_arr.create.time_till')}}</label>
                                                <input type="text" class="form-control" id="time_till" name="time_till" value="{{old('time_till')}}" required/>
                                                @if ($errors->has('time_till'))
                                                    <span class="help-block"><strong>{{ $errors->first('time_till') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <div id="position_1" class='row staff_position'>
                                        <div class="form-group">                            
                                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('positions.1.staff_type') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.staff_type')}}</label>
                                                <select class="form-control staff_type" name="positions[1][staff_type]" required>
                                                    <option value=""></option>
                                                    @foreach(__('website.staff_types_arr') as $key=>$value)
                                                    <option value="{{$key}}" {{old('positions.1.staff_type')==$key ? "selected" : ""}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('positions.1.staff_type'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.staff_type') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>

                                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('positions.1.staff_number') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.number')}}</label>
                                                <input type="text" class="form-control staff_number" name="positions[1][staff_number]" value="{{old('positions.1.staff_number')}}" required/>
                                                @if ($errors->has('positions.1.staff_number'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.staff_number') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            
                                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('positions.1.staff_gender') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.gender')}}</label>
                                                <select class="form-control staff_gender" name="positions[1][staff_gender]" required>
                                                    <option value=""></option>                                                    
                                                    <option value="1" {{old('positions.1.staff_gender')===1 ? 'selected' : ''}}>{{__('website.events_arr.create.female')}}</option>
                                                    <option value="2" {{old('positions.1.staff_gender')===2 ? 'selected' : ''}}>{{__('website.events_arr.create.male')}}</option>
                                                    <option value="0" {{old('positions.1.staff_gender')===0 ? 'selected' : ''}}>{{__('website.events_arr.create.no_matter')}}</option>
                                                </select>
                                                @if ($errors->has('positions.1.staff_gender'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.staff_gender') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>                                            
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('positions.1.date_from') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.date_from')}}</label>
                                                <input type="text" class="form-control date_from" id="date_from_1" name="positions[1][date_from]" value="{{old('positions.1.date_from')}}"/>
                                                @if ($errors->has('positions.1.date_from'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.date_from') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('positions.1.date_to') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.date_to')}}</label>
                                                <input type="text" class="form-control date_to" id="date_to_1" name="positions[1][date_to]" value="{{old('positions.1.date_to')}}"/>
                                                @if ($errors->has('positions.1.date_to'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.date_to') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('positions.1.time_from') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.time_from')}}</label>
                                                <input type="text" class="form-control time_from" name="positions[1][time_from]" value="{{old('positions.1.time_from')}}"/>
                                                @if ($errors->has('positions.1.time_from'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.time_from') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('positions.1.time_till') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.time_till')}}</label>
                                                <input type="text" class="form-control time_till" name="positions[1][time_till]" value="{{old('positions.1.time_till')}}"/>
                                                @if ($errors->has('positions.1.time_till'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.time_till') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <h4 style="margin-left:17px;">{{__('website.events_arr.create.fill_only')}}</h4>
                                        </div>

                                        <div class="form-group">                            
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('positions.1.height_from') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.height')}} {{__('website.events_arr.create.from')}}</label>
                                                <select class="form-control height_from" name="positions[1][height_from]">
                                                    <option value=''></option>
                                                    @for($i=160;$i<200;$i+=2)
                                                    <option value='{{$i}}' {{old('positions.1.height_from')==$i ? 'selected' : ''}}>{{$i}}</option>
                                                    @endfor
                                                </select>
                                                @if ($errors->has('positions.1.height_from'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.height_from') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('positions.1.height_to') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.height')}} {{__('website.events_arr.create.to')}}</label>
                                                <select class="form-control height_to" name="positions[1][height_to]">
                                                    <option value=''></option>
                                                    @for($i=160;$i<=200;$i+=2)
                                                        <option value='{{$i}}' {{old('positions.1.height_to')==$i ? 'selected' : ''}}>{{$i}}</option>
                                                    @endfor
                                                </select>
                                                @if ($errors->has('positions.1.height_to'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.height_to') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>

                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('positions.1.size_from') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.size')}} {{__('website.events_arr.create.from')}}</label>
                                                <select class="form-control size_from" name="positions[1][size_from]">
                                                    <option value=''></option>
                                                    @for($i=32;$i<=58;$i+=2)
                                                        <option value='{{$i}}' {{old('positions.1.size_from')==$i ? 'selected' : ''}}>{{$i}}</option>
                                                    @endfor
                                                </select>
                                                @if ($errors->has('positions.1.size_from'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.size_from') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            
                                            <div class="control-group col-xs-12 col-md-3{{ $errors->has('positions.1.size_to') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.size')}} {{__('website.events_arr.create.to')}}</label>
                                                <select class="form-control size_to" name="positions[1][size_to]">
                                                    <option value=''></option>
                                                    @for($i=32;$i<=58;$i+=2)
                                                        <option value='{{$i}}' {{old('positions.1.size_to')==$i ? 'selected' : ''}}>{{$i}}</option>
                                                    @endfor
                                                </select>
                                                @if ($errors->has('positions.1.size_to'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.size_to') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">                            
                                            <div class="control-group col-xs-12 col-md-2{{ $errors->has('positions.1.language_1') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.language')}}(1)</label>
                                                <select class="form-control language_1" name="positions[1][language_1]">
                                                    <option value=''></option>
                                                    <option value='de' {{old('positions.1.language_1')=='de' ? 'selected' : ''}}>{{__('website.events_arr.create.german')}}</option>
                                                    <option value='en' {{old('positions.1.language_1')=='en' ? 'selected' : ''}}>{{__('website.events_arr.create.english')}}</option>
                                                </select>
                                                @if ($errors->has('positions.1.language_1'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.language_1') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-2{{ $errors->has('positions.1.language_1_lvl') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.language_level')}}</label>
                                                <select class="form-control language_1_lvl" name="positions[1][language_1_lvl]" type="text" number>
                                                    <option></option>
                                                    @foreach(__('website.short_language_levels_arr') as $key=>$value)
                                                        @if($key!=1)
                                                        <option value="{{$key}}" {{old('positions.1.language_1_lvl')==$key ? "selected" : ""}}>{{$value}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('positions.1.language_1_lvl'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.language_1_lvl') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>

                                            <div class="control-group col-xs-12 col-md-2{{ $errors->has('positions.1.language_2') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.language')}}(2)</label>
                                                <select class="form-control language_2" name="positions[1][language_2]">
                                                    <option value=''></option>
                                                    <option value='de' {{old('positions.1.language_2')=='de' ? 'selected' : ''}}>{{__('website.events_arr.create.german')}}</option>
                                                    <option value='en' {{old('positions.1.language_2')=='en' ? 'selected' : ''}}>{{__('website.events_arr.create.english')}}</option>
                                                </select>
                                                @if ($errors->has('positions.1.language_2'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.language_2') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-2{{ $errors->has('positions.1.language_2_lvl') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.language_level')}}</label>
                                                <select class="form-control language_2_lvl" name="positions[1][language_2_lvl]" type="text">
                                                    <option></option>
                                                    @foreach(__('website.short_language_levels_arr') as $key=>$value)
                                                        @if($key!=1)
                                                        <option value="{{$key}}" {{old('positions.1.language_2_lvl')==$key ? "selected" : ""}}>{{$value}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('positions.1.language_2_lvl'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.language_2_lvl') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>

                                            <div class="control-group col-xs-12 col-md-2{{ $errors->has('positions.1.language_3') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.language')}}(3)</label>
                                                <select class="form-control language_3" name="positions[1][language_3]">
                                                    <option value=''></option>
                                                    @foreach(__('website.extended_languages_arr') as $key=>$value)
                                                    <option value='{{$key}}' {{old('positions.1.language_3')==$key ? 'selected' : ''}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('positions.1.language_3'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.language_3') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                            <div class="control-group col-xs-12 col-md-2{{ $errors->has('positions.1.language_3_lvl') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.language_level')}}</label>
                                                <select class="form-control language_3_lvl" name="positions[1][language_3_lvl]" type="text">
                                                    <option></option>
                                                    @foreach(__('website.short_language_levels_arr') as $key=>$value)
                                                        @if($key!=1)
                                                        <option value="{{$key}}" {{old('positions.1.language_3_lvl')==$key ? "selected" : ""}}>{{$value}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('positions.1.language_3_lvl'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.language_3_lvl') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">                            
                                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('positions.1.job_description') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.job_description')}}</label>
                                                <textarea class="form-control job_description" name='positions[1][job_description]' placeholder='{{__('website.events_arr.create.job_description_text')}}' rows='5' required>{{old('positions.1.job_description')}}</textarea>
                                                @if ($errors->has('positions.1.job_description'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.job_description') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>

                                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('positions.1.outfit') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.outfit')}}</label>
                                                <textarea class="form-control outfit" name='positions[1][outfit]' placeholder='{{__('website.events_arr.create.outfit_text')}}' rows='5'>{{old('positions.1.outfit')}}</textarea>
                                                @if ($errors->has('positions.1.outfit'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.outfit') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>

                                            <div class="control-group col-xs-12 col-md-4{{ $errors->has('positions.1.other_comments') ? ' has-error' : '' }}">
                                                <label class="control-label">{{__('website.events_arr.create.other_comments')}}</label>
                                                <textarea class="form-control other_comments" name='positions[1][other_comments]' placeholder='{{__('website.events_arr.create.other_comments_text')}}' rows='5'>{{old('positions.1.other_comments')}}</textarea>
                                                @if ($errors->has('positions.1.other_comments'))
                                                    <span class="help-block"><strong>{{ $errors->first('positions.1.other_comments') }}</strong></span>
                                                @endif
                                                <div class="errorBox"></div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12" style='text-align: center;'>
                                        <button type="button" class="btn btn-success add_position">{{__('website.events_arr.create.add_position')}}</button>   
                                        <button type="button" class="btn btn-danger remove_position">{{__('website.events_arr.create.remove_position')}}</button>
                                        <button type="submit" class="btn btn-default">{{__('website.events_arr.create.create')}}</button>
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
    $('#region,.staff_type,.staff_gender,.height_from,.height_to,.size_from,.size_to,.language_1,.language_1_lvl,.language_2,.language_2_lvl,.language_3,.language_3_lvl').select2();
    
    $(document).ready(function(){
        $("#date_from").datepicker({   
            onSelect: function(dateText, inst){
               $("#date_to").datepicker("option","minDate",
               $("#date_from").datepicker("getDate"));
            }
        });

        $("#date_to").datepicker({"minDate" :  $("#date_from").datepicker("getDate")});
        
        $('#time_from').timepicker({'timeFormat': 'H:i'}).val();
        $('#time_till').timepicker({'timeFormat': 'H:i', 'show2400':true}).val();
        
        $("#date_from_1").datepicker({   
            onSelect: function(dateText, inst){
               $("#date_to_1").datepicker("option","minDate",
               $("#date_from_1").datepicker("getDate"));
            }
        });

        $("#date_to_1").datepicker({"minDate" :  $("#date_from_1").datepicker("getDate")});
        
        $('#position_1').find('.time_from').timepicker({'timeFormat': 'H:i'}).val();
        $('#position_1').find('.time_till').timepicker({'timeFormat': 'H:i', 'show2400':true}).val();
    });
     
    $('.add_position').on('click', function(){
       var element = $('.staff_position').last();
        
       var last_id = $(element).attr('id').replace("position_","");     
        
        $(element).find('select').each(function(){
            $(this).select2('destroy');  
        });
        
        $(element).find(".hasDatepicker").datepicker("destroy");
        
        var new_element = $(element).clone();

        new_element.attr('id','position_'+(parseFloat(last_id)+1));

        new_element.find('.control-group').each(function(){
           $(this).html($(this).html().replace('positions['+last_id+']','positions['+(parseFloat(last_id)+1)+']'));
        });
        
        new_element.find('.form-control').each(function(){
           $(this).val('');
        });
        
        $(new_element).find('#date_from_'+last_id).attr('id','date_from_'+(parseFloat(last_id)+1));
        $(new_element).find('#date_to_'+last_id).attr('id','date_to_'+(parseFloat(last_id)+1));
       
        $(element).closest('.panel-body').append(new_element);
     
        $(element).find('select').select2();
        
        $(element).find(".date_from").datepicker({   
            onSelect: function(dateText, inst){
               $(element).find(".date_to").datepicker("option","minDate",
               $(element).find(".date_from").datepicker("getDate"));
            }
        });

        $(element).find(".date_to").datepicker({"minDate" :  $(element).find(".date_from").datepicker("getDate")});
        
        $(new_element).find('select').select2();
        
        $(new_element).find('.staff_type').rules("add", {
            required: true
        });
        
        $(new_element).find('.staff_number').rules("add", {
            required: true
        });
        
        $(new_element).find('.staff_gender').rules("add", {
            required: true
        });
        
        $(new_element).find('.job_description').rules("add", {
            required: true
        });
        
        $(new_element).find('.language_1_lvl').rules("add", {
            required: {
                depends: function(element) {
                    return $(this).closest('.form-group').find('.language_1').val()!=='';
                }
            }
        });
        
        $(new_element).find('.language_2_lvl').rules("add", {
            required: {
                depends: function(element) {
                    return $(this).closest('.form-group').find('.language_2').prev().val()!=='';
                }
            }
        });
        
        $(new_element).find('.language_3_lvl').rules("add", {
            required: {
                depends: function(element) {
                    return $('.language_3').prev().val()!=='';
                }
            }
        });
        
        $(new_element).find(".date_from").datepicker({   
            onSelect: function(dateText, inst){
               $(new_element).find(".date_to").datepicker("option","minDate",
               $(new_element).find(".date_from").datepicker("getDate"));
            }
        });

        $(new_element).find(".date_to").datepicker({"minDate" :  $(new_element).find(".date_from").datepicker("getDate")});
        
        $(new_element).find('.time_from').timepicker({'timeFormat': 'H:i'}).val();
        $(new_element).find('.time_till').timepicker({'timeFormat': 'H:i', 'show2400':true}).val();           
    });
    
    $('.remove_position').on('click', function(){
        if($('.staff_position').length>1){
            $('.staff_position').last().remove();
        }
    });
    
    $('input[type="radio"]').on('click', function(){
        if($('#radio1').is(':checked')){
            $('#external_city').closest('.control-group').hide();
            $('#region').closest('.control-group').show();
            $('#city_id').closest('.control-group').show();
        }
        else{
            $('#external_city').closest('.control-group').show();
            $('#region').closest('.control-group').hide();
            $('#city_id').closest('.control-group').hide();
        }
    });
    
    $('input[type="radio"]:checked').click();
</script>
@endsection