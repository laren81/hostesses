@extends('layouts.website')

@section('style')
<style>
  
</style>
@endsection

@section('content')
<div class="container">
    @include('shared.messages')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('website.events_arr.show.event')}} </h3>
                </div>
                    
                <div class="panel-body">                   
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class='active'><a class="nav-link active" data-toggle="tab" href="#tab-1">{{__('website.events_arr.show.event')}}</a></li>
                            @foreach($event->positions as $index=>$position)
                            <li><a class="nav-link" data-toggle="tab" href="#tab-{{$index+2}}">{{__('website.events_arr.show.position').' '.(count($event->positions)>1 ? $index+1 : '')}}</a></li>
                            @endforeach
                            <li><a class="nav-link" href="{{route('events.edit',$event->id)}}">{{__('website.events_arr.show.change')}}</a></li>
                            <li><a class="nav-link" href="{{route('events.index')}}">{{__('website.events_arr.show.events')}}</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <div class='row'>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.events_arr.show.name')}}: </strong>
                                                {{$event->name }}
                                            </div>
                                        </div>            

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.events_arr.show.region')}}: </strong>
                                                {{$event->region->name}}
                                            </div>
                                        </div>  

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.events_arr.show.city')}}: </strong>
                                                {{$event->city->name}}
                                            </div>
                                        </div>                             

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.events_arr.show.location')}}: </strong>
                                                {{ $event->location }}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.events_arr.show.period')}}: </strong>
                                                @if(date('m.Y',strtotime($event->date_from)) === date('m.Y',strtotime($event->date_to)))
                                                    {{date('d',strtotime($event->date_from))}} - {{date('d.m.Y',strtotime($event->date_to))}}
                                                @elseif(date('Y',strtotime($event->date_from)) === date('Y',strtotime($event->date_to)))
                                                    {{date('d.m',strtotime($event->date_from))}} - {{date('d.m.Y',strtotime($event->date_to))}}
                                                @else
                                                    {{date('d.m.Y',strtotime($event->date_from))}} - {{date('d.m.Y',strtotime($event->date_to))}}
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.events_arr.show.time')}}: </strong>
                                                {{ date('H:i',strtotime($event->time_from)).' - '.date('H:i',strtotime($event->time_till)) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @foreach($event->positions as $index=>$position)
                            <div role="tabpanel" id="tab-{{$index+2}}" class="tab-pane">
                                <div class="panel-body">
                                    <div class='row'>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.events_arr.show.staff_type')}}: </strong>
                                                {{$position->staff_number.' '.__('website.staff_types_arr')[$position->staff_type]}} - {{$position->staff_gender==1 ? __('website.events_arr.show.female') : ($position->staff_gender==2 ? __('website.events_arr.show.male') : __('website.events_arr.show.gender_not_specified'))}}
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.events_arr.show.period')}}: </strong>
                                                @if($position->date_from!=null && $position->date_to!=null)
                                                    @if(date('m.Y',strtotime($position->date_from)) === date('m.Y',strtotime($position->date_to)))
                                                        {{date('d',strtotime($position->date_from))}} - {{date('d.m.Y',strtotime($position->date_to))}}
                                                    @elseif(date('Y',strtotime($position->date_from)) === date('Y',strtotime($position->date_to)))
                                                        {{date('d.m',strtotime($position->date_from))}} - {{date('d.m.Y',strtotime($position->date_to))}}
                                                    @else
                                                        {{date('d.m.Y',strtotime($position->date_from))}} - {{date('d.m.Y',strtotime($position->date_to))}}
                                                    @endif
                                                @else
                                                    @if(date('m.Y',strtotime($event->date_from)) === date('m.Y',strtotime($event->date_to)))
                                                        {{date('d',strtotime($event->date_from))}} - {{date('d.m.Y',strtotime($event->date_to))}}
                                                    @elseif(date('Y',strtotime($event->date_from)) === date('Y',strtotime($event->date_to)))
                                                        {{date('d.m',strtotime($event->date_from))}} - {{date('d.m.Y',strtotime($event->date_to))}}
                                                    @else
                                                        {{date('d.m.Y',strtotime($event->date_from))}} - {{date('d.m.Y',strtotime($event->date_to))}}
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.events_arr.show.time')}}: </strong>
                                                @if($position->time_from && $position->time_till)
                                                    {{ date('H:i',strtotime($position->time_from)).' - '.date('H:i',strtotime($position->time_till)) }}
                                                @else
                                                    {{ date('H:i',strtotime($event->time_from)).' - '.date('H:i',strtotime($event->time_till)) }}
                                                @endif
                                            </div>
                                        </div>                                        

                                        @if($position->height_from!=null || $position->height_to!=null)
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.events_arr.show.height')}}: </strong>
                                                {{ $position->height_from.' - '.$position->height_to }}
                                            </div>
                                        </div>
                                        @endif

                                        @if($position->size_from!=null || $position->size_to!=null)
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.events_arr.show.size')}}: </strong>
                                                {{ $position->size_from.' - '.$position->size_to }}
                                            </div>
                                        </div>
                                        @endif

                                        @if($position->language_1!=null || $position->language_2!=null || $position->language_3!=null)
                                        <h4 style="margin-left:15px;">Languages required</h4>

                                            @if($position->language_1!=null)
                                            <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left:35px;">
                                                <div class="form-group">
                                                    <strong>{{$position->language_1=='de' ? __('website.events_arr.show.german') : __('website.events_arr.show.english')}}: </strong>
                                                    {{ __('website.short_language_levels_arr')[$position->language_1_lvl]}}
                                                </div>
                                            </div>
                                            @endif

                                            @if($position->language_2!=null)
                                            <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left:35px;">
                                                <div class="form-group">
                                                    <strong>{{$position->language_2=='de' ? __('website.events_arr.show.german') : __('website.events_arr.show.english')}}: </strong>
                                                    {{ __('website.short_language_levels_arr')[$position->language_2_lvl]}}
                                                </div>
                                            </div>
                                            @endif

                                            @if($position->language_3!=null)
                                            <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left:35px;">
                                                <div class="form-group">
                                                    <strong>{{__('website.extended_languages_arr')[$position->language_3]}}: </strong>
                                                    {{ __('website.short_language_levels_arr')[$position->language_3_lvl]}}
                                                </div>
                                            </div>
                                            @endif
                                        @endif

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.events_arr.show.job_description')}}: </strong>
                                                {{ $position->job_description }}
                                            </div>
                                        </div>

                                        @if($position->outfit!=null)
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.events_arr.show.outfit')}}: </strong>
                                                {{ $position->outfit }}
                                            </div>
                                        </div>
                                        @endif

                                        @if($position->other_comments!=null)
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.events_arr.show.other_comments')}}: </strong>
                                                {{ $position->other_comments }}
                                            </div>
                                        </div>
                                        @endif                                        
                                    </div>
                                </div>
                            </div>  
                            @endforeach            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.yadcf.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>

<script type="text/javascript" charset="utf-8">   
    

</script>
@endsection
