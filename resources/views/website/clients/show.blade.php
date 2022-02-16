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
                    <h3 class="panel-title">{{__('website.clients_arr.show.show_profile')}}</h3>                    
                </div>

                    
                <div class="panel-body">                    
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class='active'><a class="nav-link active" data-toggle="tab" href="#tab-1">{{__('website.clients_arr.show.contacts')}}</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-2">{{__('website.clients_arr.show.company_information')}}</a></li>
                            <li><a class="nav-link" href="{{route('clients.edit',$user->id)}}">{{__('website.clients_arr.show.edit')}}</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <div class='row'>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.clients_arr.show.name')}}: </strong>
                                                {{__('website.titles_arr')[$client->title].' '.$user->first_name.' '.$user->last_name }}
                                            </div>
                                        </div>                                        
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.clients_arr.show.email')}}: </strong>
                                                {{ $user->email }}
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.clients_arr.show.phone')}}: </strong>
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
                                                <strong>{{__('website.clients_arr.show.company_name')}}: </strong>
                                                {{ $client->company_name }}
                                            </div>
                                        </div>                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.clients_arr.show.region')}}: </strong>
                                                {{ $client->region->name }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.clients_arr.show.city')}}: </strong>
                                                {{ $client->city->zip.' '.$client->city->name }}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.clients_arr.show.address')}}: </strong>
                                                {{ $client->street }} {{ $client->house_number }}
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>{{__('website.clients_arr.show.website')}}: </strong>
                                                {{ $client->website }}
                                            </div>
                                        </div>
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
