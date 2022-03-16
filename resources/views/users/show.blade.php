@extends('layouts.app')

@section('style')
<style>
span.stars, span.stars span {
    display: block;
    background: url(stars.png) 0 -16px repeat-x;
    width: auto;
    height: 16px;
}

span.stars span {
    background-position: 0 0;
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
                    <h3 class="panel-title">{{__('texte.users_arr.show.show_user')}}</h3>
                    <div class="pull-right">
                        <a class="btn btn-warning" href="{{route('admin.users.edit',$user->id)}}">{{__('texte.users_arr.show.change')}}</a>
                        <a class="btn btn-primary back-btn" href="{{route('admin.users.index')}}">{{__('texte.users_arr.show.users')}}</a>
                    </div>
                </div>

                    
                <div class="panel-body">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class='active'><a class="nav-link active" data-toggle="tab" href="#tab-1">{{__('texte.users_arr.show.basic_information')}}</a></li>
                            @if($user->role_id!=1 && $user->profile_completed==1)
                            <li><a class="nav-link" data-toggle="tab" href="#tab-2">{{__('texte.users_arr.show.additional_information')}}</a></li>
                            @endif
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <div class='row'>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.first_name')}}: </strong>
                                                {{ $user->first_name }}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.last_name')}}: </strong>
                                                {{ $user->last_name }}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.role')}}: </strong>
                                                {{ $user->role->name }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.email')}}: </strong>
                                                {{ $user->email }}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.phone')}}: </strong>
                                                {{ $user->phone }}
                                            </div>
                                        </div> 

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.active')}}: </strong>
                                                {{ $user->active==1 ? __('texte.users_arr.show.yes') : __('texte.users_arr.show.no') }}
                                            </div>
                                        </div>
                                        
                                        @if($user->role_id==2)
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.rating')}}: </strong>
                                                <div style='display:flex;'>
                                                    <span class="stars" data-rating="{{$user->rating()}}" data-num-stars="5" style='color:orange'></span>
                                                    <p>({{count($user->ratings)}})</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if($user->role_id!=1 && $user->profile_completed==1)
                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    @if($user->role_id==2)
                                    <div class='row'>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.preferred_areas')}}: </strong>
                                                @foreach(__('website.hostess_areas_arr') as $key=>$value)     
                                                {{in_array($key,$user_details->preferred_occupation) ? $value.', ' : '' }}
                                                @endforeach 
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.birth_date')}}: </strong>
                                                {{ date('d.m.Y',strtotime($user_details->birth_date)) }}
                                            </div>
                                        </div> 
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.country')}}: </strong>
                                                {{ $user_details->country }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.nationality')}}: </strong>
                                                {{ $user_details->nationality }}
                                            </div>
                                        </div>                                                                               
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.zip')}}: </strong>
                                                {{ $user_details->zip }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.region')}}: </strong>
                                                {{ $user_details->region->name }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.city')}}: </strong>
                                                {{ $user_details->city->name }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.address')}}: </strong>
                                                {{ $user_details->address }}
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.type')}}: </strong>
                                                {{__('website.personal_types_arr')[$user_details->type] }}
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.height')}}: </strong>   
                                                {{$user_details->height}}
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.cloth_size')}}: </strong>   
                                                {{$user_details->cloth_size}}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.chest')}}: </strong>
                                                {{ $user_details->chest }}
                                            </div>
                                        </div> 
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.waist')}}: </strong>
                                                {{ $user_details->waist }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.hips')}}: </strong>
                                                {{ $user_details->hips }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.hair_color')}}: </strong>
                                                {{__('website.hair_colors_arr')[$user_details->hair_color] }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.eye_color')}}: </strong>
                                                {{__('website.eye_colors_arr')[$user_details->eye_color] }}
                                            </div>
                                        </div>                                         
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.shoe_size')}}: </strong>
                                                {{ $user_details->shoe_size }}
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.visible_tattoo')}}: </strong>
                                                {{ $user_details->tattoo==1 ? __('texte.users_arr.show.yes') : __('texte.users_arr.show.no') }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.visible_piercing')}}: </strong>
                                                {{ $user_details->piercing==1 ? __('texte.users_arr.show.yes') : __('texte.users_arr.show.no') }}
                                            </div>
                                        </div>
                                    
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.occupation')}}: </strong>
                                                {{$user_details->occupation}}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.profession')}}: </strong>   
                                                {{$user_details->profession}}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.education')}}: </strong>   
                                                {{$user_details->education}}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.driver_licence')}}: </strong>
                                                {{ $user_details->driver_licence==1 ? __('texte.users_arr.show.yes') : __('texte.users_arr.show.no') }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.own_car')}}: </strong>
                                                {{ $user_details->own_car==1 ? __('texte.users_arr.show.yes') : __('texte.users_arr.show.no') }}
                                            </div>
                                        </div>


                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <h3>{{__('texte.users_arr.show.spoken_languages')}} </h3>
                                            <div class="form-group">
                                                {{__('texte.users_arr.show.german')}}: {{ __('website.language_levels_arr')[$user_details->de] }}<br/>
                                                {{__('texte.users_arr.show.english')}}: {{ __('website.language_levels_arr')[$user_details->en] }}<br/>
                                                {{__('texte.users_arr.show.spanish')}}: {{ __('website.language_levels_arr')[$user_details->sp] }}<br/>
                                                {{__('texte.users_arr.show.french')}}: {{ __('website.language_levels_arr')[$user_details->fr] }}<br/>
                                                @for($i=1;$i<4;$i++)                                                    
                                                    @if($user_details['other_language_'.$i]!=null)
                                                    {{__('website.languages_arr')[$user_details['other_language_'.$i]]}}: {{ __('website.language_levels_arr')[$user_details['other_language_'.$i.'_lvl']] }}<br/>
                                                    @endif                                                    
                                                @endfor
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.accommodation_places')}}: </strong>
                                                @foreach($main_cities as $main_city)     
                                                {{in_array($main_city->id,$user_details->accommodation_places) ? $main_city->name.', ' : '' }}
                                                @endforeach
                                                {{$user_details->other_cities}}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.modeling')}}: </strong>
                                                {{ $user_details->modeling }}
                                            </div>
                                        </div> 

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.presentation')}}: </strong>
                                                {{ $user_details->presentation }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.gastronomy')}}: </strong>
                                                {{ $user_details->gastronomy }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.team_leader')}}: </strong>
                                                {{$user_details->team_leader}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.experience_abroad')}}: </strong>
                                                {{$user_details->experience_abroad}}
                                            </div>
                                        </div>                                         
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.musical_instrument')}}: </strong>
                                                {{ $user_details->musical_instrument }}
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.past_experience')}}: </strong>
                                                {{$user_details->past_experience}}
                                            </div>
                                        </div>
                                    
                                        <div class="gallery">
                                            <a target="_blank" href="{{url('/images/'.$user_details->portrait[0]->name)}}">
                                              <img src="{{url('/images/thumbs/'.$user_details->portrait[0]->name)}}" alt="{{$user_details->portrait[0]->name}}">
                                            </a>
                                            <div class="desc">Portrait</div>
                                        </div>
                                        
                                        <div class="gallery">
                                            <a target="_blank" href="{{url('/images/'.$user_details->body_image[0]->name)}}">
                                              <img src="{{url('/images/thumbs/'.$user_details->body_image[0]->name)}}" alt="{{$user_details->body_image[0]->name}}">
                                            </a>
                                            <div class="desc">Body image</div>
                                        </div>
                                        
                                        @foreach ($user_details->images as $image)                                        
                                        <div class="gallery">
                                            <a target="_blank" href="{{url('/images/'.$image->name)}}">
                                              <img src="{{url('/images/thumbs/'.$image->name)}}" alt="{{$image->name}}">
                                            </a>
                                            <div class="desc">Image</div>
                                        </div>
                                        @endforeach
                                    </div>    
                                    @elseif($user->role_id==3)
                                    <div class='row'>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.company_name')}}: </strong>
                                                {{ $user_details->company_name }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.zip')}}: </strong>
                                                {{ $user_details->zip }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.region')}}: </strong>
                                                {{ $user_details->region->name }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.city')}}: </strong>
                                                {{ $user_details->city->name }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.address')}}: </strong>
                                                {{ $user_details->street }} {{ $user->house_number }}
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.users_arr.show.website')}}: </strong>
                                                {{ $user_details->website }}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>                    
                </div>
                <div class="panel-footer"></div>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript'>
$(document).ready(function(){
    $('.stars').stars();
});

$.fn.stars = function() {
    return $(this).each(function() {
        var rating = $(this).data("rating");
        var fullStar = new Array(Math.floor(rating + 1)).join('<i class="fa fa-star"></i>');
        var halfStar = ((rating%1) !== 0) ? '<i class="fa fa-star-half-o"></i>': '';
        var noStar = new Array(Math.floor($(this).data("numStars") + 1 - rating)).join('<i class="fa fa-star"></i>');
        $(this).html(fullStar + halfStar );
    });
}
</script>
@endsection
