@extends('layouts.website')

@section('content')
@include('shared.messages')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-title"><h5>Dashboard1</h5>
              <div class="ibox-tools"> <span class="label label-warning-light pull-right">Welcome</span></div>
            </div>

            <div class="ibox-content">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if(!auth()->check())
                <a type="button" class="btn btn-primary" href='{{route('users.create_hostess')}}'>Looking for job</a>
                
                <a type="button" class="btn btn-success" href='{{route('users.create_client')}}'>Looking for staff</a>                
                @else       
                    @if(auth()->user()->role_id==3)
                    <a type="button" class="btn btn-success" href='{{route('events.index')}}'>My events</a>
                    @elseif(auth()->user()->role_id==2)
                    <a type="button" class="btn btn-success" href='{{route('jobs.index')}}'>My jobs</a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
