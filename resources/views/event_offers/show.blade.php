@extends('layouts.app')

@section('content')

@section('style')
<style>
    tr .number{
        width:70px
    }    
</style>
@endsection

@include('shared.messages')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('texte.event_offers_arr.show.show_offer')}}</h3>
                <div class="pull-right">
                    <a class="btn btn-warning" href="{{route('admin.event_offers.edit',$offer->id)}}">{{__('texte.event_offers_arr.show.change')}}</a>
                    <a class="btn btn-primary" href="{{route('admin.events.index')}}">{{__('texte.event_offers_arr.show.events')}}</a>
                    <a class="btn btn-success" href="{{route('admin.event_offers.index')}}">{{__('texte.event_offers_arr.show.event_offers')}}</a>
                </div>
            </div>    

            <div class="panel-body">
                <div class='row'>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.event_offers_arr.show.client')}}: </strong>
                            {{$offer->event->client->company_name }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.event_offers_arr.show.name')}}: </strong>
                            {{$offer->event->name }}
                        </div>
                    </div>   

                    @if($offer->event->internal_location==1)
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.event_offers_arr.show.region')}}: </strong>
                            {{ $offer->event->region->name}}
                        </div>
                    </div>
                    @endif
                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.event_offers_arr.show.city')}}: </strong>
                            {{ $offer->event->internal_location==1 ? ($offer->event->city->zip.' '.$offer->event->city->name) : $offer->event->external_city}}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.event_offers_arr.show.location')}}: </strong>
                            {{ $offer->event->location }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.event_offers_arr.show.period')}}: </strong>
                            @if(date('m.Y',strtotime($offer->event->date_from)) === date('m.Y',strtotime($offer->event->date_to)))
                                {{date('d',strtotime($offer->event->date_from))}} - {{date('d.m.Y',strtotime($offer->event->date_to))}}
                            @elseif(date('Y',strtotime($offer->event->date_from)) === date('Y',strtotime($offer->event->date_to)))
                                {{date('d.m',strtotime($offer->event->date_from))}} - {{date('d.m.Y',strtotime($offer->event->date_to))}}
                            @else
                                {{date('d.m.Y',strtotime($offer->event->date_from))}} - {{date('d.m.Y',strtotime($offer->event->date_to))}}
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.event_offers_arr.show.time')}}: </strong>
                            {{ date('H:i',strtotime($offer->event->time_from)).' - '.date('H:i',strtotime($offer->event->time_till)) }}
                        </div>
                    </div>
                    
                    @if(!empty($offer->note))
                    <div class="col-xs-12 col-sm-12 col-md-12">        
                        <div class="form-group">                            
                            <strong>Note:</label></strong>
                            {{$offer->note}}
                        </div>
                    </div>
                    @endif
                       
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content wide">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>{{__('texte.event_offers_arr.show.staff_type')}}</th>
                                                    <th>{{__('texte.event_offers_arr.show.staff_number')}}</th>
                                                    <th>{{__('texte.event_offers_arr.show.staff_gender')}}</th>
                                                    <th>{{__('texte.event_offers_arr.show.days')}}</th>
                                                    <th>{{__('texte.event_offers_arr.show.staff_wages')}}</th>
                                                    <th>{{__('texte.event_offers_arr.show.booking_charge')}}</th>
                                                    <th>{{__('texte.event_offers_arr.show.other_charges')}}</th>
                                                    <th>{{__('texte.event_offers_arr.show.position_total')}}</th>   
                                                    <th>{{__('texte.event_offers_arr.show.note')}}</th>
                                                    <th>{{__('texte.event_offers_arr.show.admin_note')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($offer->rows as $index=>$row)
                                                    <tr>
                                                        <td>{{__('texte.staff_types_arr')[$row->event_position->staff_type]}}</td>
                                                        <td>{{$row->event_position->staff_number}}</td>
                                                        <td>{{$row->event_position->staff_gender==1 ? __('texte.event_offers_arr.show.female') : ($row->event_position->staff_gender==2 ? __('texte.event_offers_arr.show.male') : __('texte.event_offers_arr.show.gender_not_specified'))}}</td>
                                                        <td>{{$row->days}}</td>
                                                        <td>{{$row->staff_wages}}</td>
                                                        <td>{{$row->booking_charge}}</td>                                                            
                                                        <td>{{$row->additional_charge}}</td>
                                                        <td>{{number_format(($row->event_position->staff_number*$row->total),2,'.',' ')}}</td>
                                                        <td>{{$row->client_note}}</td>  
                                                        <td>{{$row->admin_note}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan='7' style='text-align:right;'>{{__('texte.event_offers_arr.show.total')}}</td>
                                                    <td>{{number_format($offer->total_amount,2,'.',' ')}}</td>
                                                    <td colspan="2"></td>
                                                </tr>
                                            </tfoot>
                                        </table>                                           
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
@endsection
