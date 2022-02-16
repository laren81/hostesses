@extends('layouts.app')

@section('content')
<div class="container">
    @include('shared.messages')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('texte.roles_arr.show.show_role')}}</h3>
                    <div class="pull-right">
                        <a class="btn btn-warning" href="{{route('admin.roles.edit',$role->id)}}">{{__('texte.roles_arr.show.change')}}</a>
                        <a class="btn btn-primary back-btn" href="{{route('admin.roles.index')}}">{{__('texte.roles_arr.show.roles')}}</a>
                    </div>
                </div>
                    
                <div class="panel-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.roles_arr.show.name')}}: </strong>
                            {{ $role->name }}
                        </div>
                    </div>                                      
                </div>                
                
                <div class="panel-footer"></div>
            </div>
        </div>
    </div>
</div>
@endsection
