@extends('layouts.website')

@section('style')
<style>
    div.gallery {
        margin: 5px;
        border: 1px solid #ccc;
        float: left;
        width: 180px;
    }

    div.gallery:hover {
        border: 1px solid #777;
    }

    div.gallery img {
        width: 100%;
        height: auto;
    }

    div.desc {
        padding: 15px;
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="container">
    @include('shared.messages')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('website.hostesses_arr.show.show_profile')}}</h3>                    
                </div>

                    
                <div class="panel-body">                    
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class='active'><a class="nav-link active" data-toggle="tab" href="#tab-1">{{__('website.hostesses_arr.show.contacts')}}</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-2">{{__('website.hostesses_arr.show.personal_information')}}</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-3">{{__('website.hostesses_arr.show.profile')}}</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-4">{{__('website.hostesses_arr.show.images')}}</a></li>
                            <li><a class="nav-link" href="{{route('hostesses.edit',$user->id)}}">{{__('website.hostesses_arr.show.edit')}}</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <div class='row'>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.name')}}: </strong>
                                                {{__('website.titles_arr')[$hostess->sex].' '.$user->first_name.' '.$user->last_name }}
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.email')}}: </strong>
                                                {{ $user->email }}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.phone')}}: </strong>
                                                {{ $user->phone }}
                                            </div>
                                        </div>                                        
                                    </div>                                    
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <div class='row'>                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.preferred_areas')}}: </strong>
                                                @foreach(__('website.hostess_areas_arr') as $key=>$value)     
                                                {{in_array($key,$hostess->preferred_occupation) ? $value.', ' : '' }}
                                                @endforeach 
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.birth_date')}}: </strong>
                                                {{ date('d.m.Y',strtotime($hostess->birth_date)) }}
                                            </div>
                                        </div> 
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.country')}}: </strong>
                                                {{ $hostess->country }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.nationality')}}: </strong>
                                                {{ $hostess->nationality }}
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.region')}}: </strong>
                                                {{ $hostess->region->name }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.city')}}: </strong>
                                                {{ $hostess->city->zip.' '.$hostess->city->name }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.address')}}: </strong>
                                                {{ $hostess->address }}
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.type')}}: </strong>
                                                {{__('website.personal_types_arr')[$hostess->type] }}
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.height')}}: </strong>   
                                                {{$hostess->height}}
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.cloth_size')}}: </strong>   
                                                {{$hostess->cloth_size}}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.chest')}}: </strong>
                                                {{ $hostess->chest }}
                                            </div>
                                        </div> 
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.waist')}}: </strong>
                                                {{ $hostess->waist }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.hips')}}: </strong>
                                                {{ $hostess->hips }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.hair_color')}}: </strong>
                                                {{__('website.hair_colors_arr')[$hostess->hair_color] }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.eye_color')}}: </strong>
                                                {{__('website.eye_colors_arr')[$hostess->eye_color] }}
                                            </div>
                                        </div>                                         
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.shoe_size')}}: </strong>
                                                {{ $hostess->shoe_size }}
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.visible_tattoo')}}: </strong>
                                                {{ $hostess->tattoo==1 ? __('website.hostesses_arr.show.yes') : __('website.hostesses_arr.show.no') }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.visible_piercing')}}: </strong>
                                                {{ $hostess->piercing==1 ? __('website.hostesses_arr.show.yes') : __('website.hostesses_arr.show.no') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-3" class="tab-pane">
                                <div class='panel-body'>
                                    <div class='row'>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.occupation')}}: </strong>
                                                {{$hostess->occupation}}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.profession')}}: </strong>   
                                                {{$hostess->profession}}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.education')}}: </strong>   
                                                {{$hostess->education}}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.driver_licence')}}: </strong>
                                                {{ $hostess->driver_licence==1 ? __('website.hostesses_arr.show.yes') : __('website.hostesses_arr.show.no') }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.own_car')}}: </strong>
                                                {{ $hostess->own_car==1 ? __('website.hostesses_arr.show.yes') : __('website.hostesses_arr.show.no') }}
                                            </div>
                                        </div>


                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <h3>{{__('website.hostesses_arr.show.spoken_languages')}} </h3>
                                            <div class="form-group">
                                                {{__('website.hostesses_arr.show.german')}}: {{ __('website.language_levels_arr')[$hostess->de] }}<br/>
                                                {{__('website.hostesses_arr.show.english')}}: {{ __('website.language_levels_arr')[$hostess->en] }}<br/>
                                                {{__('website.hostesses_arr.show.spanish')}}: {{ __('website.language_levels_arr')[$hostess->sp] }}<br/>
                                                {{__('website.hostesses_arr.show.french')}}: {{ __('website.language_levels_arr')[$hostess->fr] }}<br/>
                                                @for($i=1;$i<4;$i++)                                                    
                                                    @if($hostess['other_language_'.$i]!=null)
                                                    {{__('website.languages_arr')[$hostess['other_language_'.$i]]}}: {{ __('website.language_levels_arr')[$hostess['other_language_'.$i.'_lvl']] }}<br/>
                                                    @endif                                                    
                                                @endfor
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.accommodation_places')}}: </strong>
                                                @foreach($main_cities as $main_city)     
                                                    {{in_array($main_city->id,$hostess->accommodation_places) ? $main_city->name.', ' : '' }}
                                                @endforeach
                                                {{$hostess->other_cities}}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.modeling')}}: </strong>
                                                {{ $hostess->modeling }}
                                            </div>
                                        </div> 

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.presentation')}}: </strong>
                                                {{ $hostess->presentation }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.gastronomy')}}: </strong>
                                                {{ $hostess->gastronomy }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.team_leader')}}: </strong>
                                                {{$hostess->team_leader}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.experience_abroad')}}: </strong>
                                                {{$hostess->experience_abroad}}
                                            </div>
                                        </div>                                         
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.musical_instrument')}}: </strong>
                                                {{ $hostess->musical_instrument }}
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.hostesses_arr.show.past_experience')}}: </strong>
                                                {{$hostess->past_experience}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-4" class="tab-pane">
                                <div class="panel-body">
                                    <div class='row'>
                                        <div class="gallery">
                                            <a target="_blank" href="{{url('/images/'.$hostess->portrait[0]->name)}}">
                                              <img src="{{url('/images/'.$hostess->portrait[0]->name)}}" alt="{{$hostess->portrait[0]->name}}">
                                            </a>
                                            <div class="desc">Portrait</div>
                                        </div>
                                        
                                        <div class="gallery">
                                            <a target="_blank" href="{{url('/images/'.$hostess->body_image[0]->name)}}">
                                              <img src="{{url('/images/'.$hostess->body_image[0]->name)}}" alt="{{$hostess->body_image[0]->name}}">
                                            </a>
                                            <div class="desc">Body image</div>
                                        </div>
                                        
                                        @foreach ($hostess->images as $image)                                        
                                        <div class="gallery">
                                            <a target="_blank" href="{{url('/images/'.$image->name)}}">
                                              <img src="{{url('/images/'.$image->name)}}" alt="{{$image->name}}">
                                            </a>
                                            <div class="desc">Image</div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="panel-footer"></div>
            </div>
        </div>
    </div>
</div>
@endsection
