@extends('layouts.app')

@section('content')
<div class="container">
    @include('shared.messages')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('texte.events_arr.show.show_event')}}</h3>
                    <div class="pull-right">
                        <a class="btn btn-warning" href="{{route('admin.events.edit',$event->id)}}">{{__('texte.events_arr.show.change')}}</a>
                        <a class="btn btn-primary back-btn" href="{{route('admin.events.index')}}">{{__('texte.events_arr.show.events')}}</a>
                    </div>
                </div>

                    
                <div class="panel-body">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class='active'><a class="nav-link active" data-toggle="tab" href="#tab-1">{{__('texte.events_arr.show.event')}}</a></li>
                            @foreach($event->positions as $index=>$position)
                            <li><a class="nav-link" data-toggle="tab" href="#tab-{{$index+2}}">{{__('texte.events_arr.show.position').' '.(count($event->positions)>1 ? $index+1 : '')}}</a></li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <div class='row'>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.client')}}: </strong>
                                                {{$event->client->company_name }}
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.urgent')}}: </strong>
                                                {{$event->urgent==1 ? __('texte.events_arr.show.yes') : __('texte.events_arr.show.no')}}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.status')}}: </strong>
                                                {{__('texte.events_statuses_arr')[$event->status]}}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.name')}}: </strong>
                                                {{$event->name }}
                                            </div>
                                        </div>   
                                        
                                        @if($event->internal_location==1)
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.region')}}: </strong>
                                                {{ $event->region->name}}
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.city')}}: </strong>
                                                {{ $event->internal_location==1 ? ($event->city->zip.' '.$event->city->name) : $event->external_city}}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.location')}}: </strong>
                                                {{ $event->location }}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.period')}}: </strong>
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
                                                <strong>{{__('texte.events_arr.show.time')}}: </strong>
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
                                                <strong>{{__('texte.events_arr.show.staff_type')}}: </strong>
                                                {{$position->staff_number.' '.__('texte.staff_types_arr')[$position->staff_type]}} - {{$position->staff_gender==1 ? __('texte.events_arr.show.female') : ($position->staff_gender==2 ? __('texte.events_arr.show.male') : __('texte.events_arr.show.gender_not_specified'))}}
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.period')}}: </strong>
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
                                                <strong>{{__('texte.events_arr.show.time')}}: </strong>
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
                                                <strong>{{__('texte.events_arr.show.height')}}: </strong>
                                                {{ $position->height_from.' - '.$position->height_to }}
                                            </div>
                                        </div>
                                        @endif

                                        @if($position->size_from!=null || $position->size_to!=null)
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.size')}}: </strong>
                                                {{ $position->size_from.' - '.$position->size_to }}
                                            </div>
                                        </div>
                                        @endif

                                        @if($position->language_1!=null || $position->language_2!=null || $position->language_3!=null)
                                        <h4 style="margin-left:15px;">Languages required</h4>

                                            @if($position->language_1!=null)
                                            <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left:35px;">
                                                <div class="form-group">
                                                    <strong>{{$position->language_1=='de' ? __('texte.events_arr.show.german') : __('texte.events_arr.show.english')}}: </strong>
                                                    {{ __('texte.short_language_levels_arr')[$position->language_1_lvl]}}
                                                </div>
                                            </div>
                                            @endif

                                            @if($position->language_2!=null)
                                            <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left:35px;">
                                                <div class="form-group">
                                                    <strong>{{$position->language_2=='de' ? __('texte.events_arr.show.german') : __('texte.events_arr.show.english')}}: </strong>
                                                    {{ __('texte.short_language_levels_arr')[$position->language_2_lvl]}}
                                                </div>
                                            </div>
                                            @endif

                                            @if($position->language_3!=null)
                                            <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left:35px;">
                                                <div class="form-group">
                                                    <strong>{{__('texte.extended_languages_arr')[$position->language_3]}}: </strong>
                                                    {{ __('texte.short_language_levels_arr')[$position->language_3_lvl]}}
                                                </div>
                                            </div>
                                            @endif
                                        @endif

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.job_description')}}: </strong>
                                                {{ $position->job_description }}
                                            </div>
                                        </div>

                                        @if($position->outfit!=null)
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.outfit')}}: </strong>
                                                {{ $position->outfit }}
                                            </div>
                                        </div>
                                        @endif

                                        @if($position->other_comments!=null)
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('texte.events_arr.show.other_comments')}}: </strong>
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
                <div class="panel-footer"></div>
            </div>
        </div>
    </div>
</div>
@endsection
