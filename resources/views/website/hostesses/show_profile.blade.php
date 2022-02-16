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
    img {
	max-width: 100%;
	height: auto;
    }
    
    .col-lg-12,.col-md-12{
        padding:0px;
    }
</style>
@endsection

@section('link')
<link href="{{ asset('css/lightgallery-bundle.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    @include('shared.messages')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$hostess->user->first_name}}, Booking id {{$hostess->id}}</h3>                    
                </div>                    
                <div class="panel-body">  
                    
                    <div class="ibox-content wide">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <a href="{{url('/images/'.$hostess->portrait[0]->name)}}" data-lightbox="roadtrip" data-title="Booking (14562)">
                                <img src="{{url('/images/'.$hostess->portrait[0]->name)}}" alt="{{$hostess->portrait[0]->name}}">
                            </a>
                        </div>
                        
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom: 30px;">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>Name:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{$hostess->user->first_name.' '.$hostess->user->last_name}} </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>Age:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{date_diff(date_create($hostess->birth_date), date_create('now'))->y}}</div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>from:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{$hostess->city->name}} </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>Country:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{$hostess->country}} </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>Type:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{__('website.personal_types_arr')[$hostess->type] }}</div>
                                    </div>
                                </div>    
                            </div>    
                            
                            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom: 30px;">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>Eye:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{__('website.eye_colors_arr')[$hostess->eye_color] }} </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>Hair:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{__('website.hair_colors_arr')[$hostess->hair_color] }}</div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>Height:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{$hostess->height}} cm </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>Dress:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{$hostess->cloth_size}} </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>B/W/H:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{$hostess->chest}}/{{$hostess->waist}}/{{$hostess->hips}} </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>Shoe:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{$hostess->shoe_size}} </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-6 col-sm-12" style="margin-bottom: 30px;">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>German:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{ __('website.language_levels_arr')[$hostess->de] }} </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>English:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{ __('website.language_levels_arr')[$hostess->en] }} </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>Spanish:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{ __('website.language_levels_arr')[$hostess->sp] }} </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>French:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{ __('website.language_levels_arr')[$hostess->fr] }} </div>
                                    </div>

                                    @for($i=1;$i<4;$i++)                                                    
                                        @if($hostess['other_language_'.$i]!=null)
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="col-xs-6 col-lg-6"><strong>{{__('website.languages_arr')[$hostess['other_language_'.$i]]}}:</strong></div>
                                            <div class="col-xs-6 col-lg-6" style="padding:0px;">{{ __('website.language_levels_arr')[$hostess['other_language_'.$i.'_lvl']] }} </div>
                                        </div>
                                        @endif                                                    
                                    @endfor
                                </div>
                            </div>  
                            
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>Current activity:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{$hostess->occupation}} </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>Profession:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{$hostess->profession}} </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>Study:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{$hostess->education}} </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>Experience:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{$hostess->past_experience}} </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="col-xs-6 col-lg-6"><strong>available in:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">
                                            @foreach($main_cities as $main_city)     
                                            {{in_array($main_city->id,$hostess->accommodation_places) ? $main_city->name.', ' : '' }}
                                            @endforeach
                                            {{$hostess->other_cities}} 
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>Model references:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{$hostess->modeling}} </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="col-xs-6 col-lg-6"><strong>Catering:</strong></div>
                                        <div class="col-xs-6 col-lg-6" style="padding:0px;">{{$hostess->gastronomy}} </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        
                        <div class="col-md-12 text-left dark-text" style='margin-bottom:50px;'> 
                            <strong><br>Experiences at the fair &amp; promotional jobs:</strong>
                            <dd>{{$hostess->past_experience}}</dd>
                        </div>
                        
                        <div id="lightgallery">
                            @foreach ($hostess->all_images as $image)      
                                @if($image->type!='portrait')
                                    <a href="{{url('/images/'.$image->name)}}" data-lg-size="1600-2400">
                                        <img alt="{{$image->name}}" src="{{url('/images/thumbs/'.$image->name)}}" />
                                    </a>
                                @endif
                            @endforeach		
                        </div>
                    </div>
                </div>
                <div class="panel-footer"></div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/lightgallery.umd.js')}}"></script>
<script src="{{ asset('js/lg-thumbnail.min.js')}}"></script>
<script src="{{ asset('js/lg-zoom.min.js')}}"></script>


<script type="text/javascript">
    lightGallery(document.getElementById('lightgallery'), {
        plugins: [lgZoom, lgThumbnail],
        licenseKey: 'your_license_key',
        speed: 500
    });
</script>
@endsection
