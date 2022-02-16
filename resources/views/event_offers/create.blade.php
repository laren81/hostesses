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
                <h3 class="panel-title">{{__('texte.event_offers_arr.create.create_offer')}}</h3>
                <div class="pull-right">
                    <a class="btn btn-primary back-btn" href="{{route('admin.events.index')}}">{{__('texte.event_offers_arr.create.events')}}</a>
                </div>
            </div>    

            <div class="panel-body">
                <div class='row'>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.event_offers_arr.create.client')}}: </strong>
                            {{$event->client->company_name }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.event_offers_arr.create.status')}}: </strong>
                            {{__('texte.events_statuses_arr')[$event->status]}}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.event_offers_arr.create.name')}}: </strong>
                            {{$event->name }}
                        </div>
                    </div>   

                    @if($event->internal_location==1)
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.event_offers_arr.create.region')}}: </strong>
                            {{ $event->region->name}}
                        </div>
                    </div>
                    @endif
                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.event_offers_arr.create.city')}}: </strong>
                            {{ $event->internal_location==1 ? ($event->city->zip.' '.$event->city->name) : $event->external_city}}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.event_offers_arr.create.location')}}: </strong>
                            {{ $event->location }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.event_offers_arr.create.period')}}: </strong>
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
                            <strong>{{__('texte.event_offers_arr.create.time')}}: </strong>
                            {{ date('H:i',strtotime($event->time_from)).' - '.date('H:i',strtotime($event->time_till)) }}
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <form id="event_offer_create" method="POST" action="{{ route('admin.event_offers.store') }}" class="form form-horizontal">
                            {{ csrf_field() }}
                            <input type='hidden' name='event_id' value='{{$event->id}}'/>
                            
                            <div class="form-group">                            
                                <div class="control-group col-xs-12 col-md-12">
                                    <label class="control-label">{{__('texte.event_offers_arr.create.note')}}</label>
                                    <textarea class="form-control" name='note' rows='5'>{{abs(strtotime($event->date_from.' '.$event->time_from) - strtotime($event->created_at))/(60*60)<72 ? __('texte.event_offers_arr.create.subject_to_staff_demands') : ''}}</textarea>
                                    <div class="errorBox"></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content wide">
                                        <div class="table-responsive">
                                            <table id='event_positions' class="table table-striped table-bordered table-hover dataTables-example" width="100%" >
                                                <thead>
                                                    <tr>
                                                        <th>{{__('texte.event_offers_arr.create.staff_type')}}</th>
                                                        <th>{{__('texte.event_offers_arr.create.staff_number')}}</th>
                                                        <th>{{__('texte.event_offers_arr.create.staff_gender')}}</th>
                                                        <th>{{__('texte.event_offers_arr.create.dates')}}</th>                                                        
                                                        <th>{{__('texte.event_offers_arr.create.time')}}</th>
                                                        <th>{{__('texte.event_offers_arr.create.staff_wages')}}</th>
                                                        <th>{{__('texte.event_offers_arr.create.days')}}</th>
                                                        <th>{{__('texte.event_offers_arr.create.booking_charge')}}</th>
                                                        <th>{{__('texte.event_offers_arr.create.other_charges')}}</th>
                                                        <th>{{__('texte.event_offers_arr.create.position_total')}}</th>   
                                                        <th>{{__('texte.event_offers_arr.create.client_note')}}</th>
                                                        <th>{{__('texte.event_offers_arr.create.admin_note')}}</th>
                                                        <th>{{__('texte.event_offers_arr.create.details')}}</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($positions as $index=>$position)
                                                    <tr data-id='{{$position->id}}'>
                                                        <td>
                                                            <input type='hidden' name='position_id[]' value='{{$position->id}}'/>                                                            
                                                            {{__('texte.staff_types_arr')[$position->staff_type]}}
                                                        </td>
                                                        <td><input type='text' class='form-control number staff_number' name='staff_number[]' value='{{$position->staff_number}}' readonly required/></td>
                                                        <td>{{$position->staff_gender==1 ? __('texte.event_offers_arr.create.female') : ($position->staff_gender==2 ? __('texte.event_offers_arr.create.male') : __('texte.event_offers_arr.create.gender_not_specified'))}}</td>
                                                        <td>
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
                                                        </td>
                                                        <td>
                                                            @if($position->time_from && $position->time_till)
                                                                {{ date('H:i',strtotime($position->time_from)).' - '.date('H:i',strtotime($position->time_till)) }}
                                                            @else
                                                                {{ date('H:i',strtotime($event->time_from)).' - '.date('H:i',strtotime($event->time_till)) }}
                                                            @endif
                                                        </td>                                                        
                                                        <td><input type='text' class='form-control number wages' name='staff_wages[]' value='{{$position->staff_wages}}' readonly required/></td>
                                                        <td>
                                                            <input type='text' class='form-control number days' name='days[]' value='{{$position->days()}}' readonly required/>
                                                        </td>
                                                        <td>
                                                            <input type='text' class='form-control number booking_charge {{$errors->has('booking_charge.'.$index) ? 'error' : ''}}' name='booking_charge[{{$index}}]' value='{{old('booking_charge.'.$index,$position->booking_charge)}}' required/>
                                                            <div class="errorBox"></div>
                                                            @if($errors->has('booking_charge.'.$index))
                                                                <span class="help-block" style='color:#cc5965;'><strong>{{ $errors->first('booking_charge.'.$index) }}</strong></span>
                                                            @endif
                                                        </td>                                                            
                                                        <td>
                                                            <input type='text' class='form-control number additional_charge' name='additional_charge[]' value='{{old('additional_charge.'.$index)}}'/>                                                            
                                                        </td>
                                                        <td><input type='text' class='form-control position_amount' name='position_amount[]' value='{{old('position_amount.'.$index)}}' readonly required/></td>
                                                        <td><input type='text' class='form-control client_note' name='client_note[]' value='{{old('client_note.'.$index)}}'/></td>    
                                                        <td><input type='text' class='form-control admin_note' name='admin_note[]' value='{{old('admin_note.'.$index)}}' /></td> 
                                                        <td>
                                                            <a type='button' class='btn btn-success btn-circle' title='{{__('texte.event_offers_arr.create.details')}}' data-target='#modal-show_details-{{$position->id}}' data-toggle='modal'><i class='glyphicon glyphicon-eye-open'></i></a>
                                                            <div id="modal-show_details-{{$position->id}}" class="modal inmodal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content animated flipInY">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                            <h4 id="modal-label" class="modal-title">{{__('texte.event_offers_arr.create.position_details')}}</h4>
                                                                        </div>
                                                                        <div class="modal-body" style="overflow-y:auto;">
                                                                            @if($position->height_from!=null || $position->height_to!=null)
                                                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                <div class="form-group">
                                                                                    <strong>{{__('texte.event_offers_arr.create.height')}}: </strong>
                                                                                    {{ $position->height_from.' - '.$position->height_to }}
                                                                                </div>
                                                                            </div>
                                                                            @endif

                                                                            @if($position->size_from!=null || $position->size_to!=null)
                                                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                <div class="form-group">
                                                                                    <strong>{{__('texte.event_offers_arr.create.size')}}: </strong>
                                                                                    {{ $position->size_from.' - '.$position->size_to }}
                                                                                </div>
                                                                            </div>
                                                                            @endif

                                                                            @if($position->language_1!=null || $position->language_2!=null || $position->language_3!=null)
                                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                    <div class="form-group">
                                                                                        <h4>Languages required</h4>
                                                                                    </div>
                                                                                </div>
                                                                                @if($position->language_1!=null)
                                                                                <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left:35px;">
                                                                                    <div class="form-group">
                                                                                        <strong>{{$position->language_1=='de' ? __('texte.event_offers_arr.create.german') : __('texte.event_offers_arr.create.english')}}: </strong>
                                                                                        {{ __('texte.short_language_levels_arr')[$position->language_1_lvl]}}
                                                                                    </div>
                                                                                </div>
                                                                                @endif

                                                                                @if($position->language_2!=null)
                                                                                <div class="col-xs-12 col-sm-12 col-md-12" style="padding-left:35px;">
                                                                                    <div class="form-group">
                                                                                        <strong>{{$position->language_2=='de' ? __('texte.event_offers_arr.create.german') : __('texte.event_offers_arr.create.english')}}: </strong>
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
                                                                                    <strong>{{__('texte.event_offers_arr.create.job_description')}}: </strong>
                                                                                    {{ $position->job_description }}
                                                                                </div>
                                                                            </div>

                                                                            @if($position->outfit!=null)
                                                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                <div class="form-group">
                                                                                    <strong>{{__('texte.event_offers_arr.create.outfit')}}: </strong>
                                                                                    {{ $position->outfit }}
                                                                                </div>
                                                                            </div>
                                                                            @endif

                                                                            @if($position->other_comments!=null)
                                                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                <div class="form-group">
                                                                                    <strong>{{__('texte.event_offers_arr.create.other_comments')}}: </strong>
                                                                                    {{ $position->other_comments }}
                                                                                </div>
                                                                            </div>
                                                                            @endif
                                                                        </div>                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan='9' style='text-align:right;'>{{__('texte.event_offers_arr.create.total')}}</td>
                                                        <td><input type='text' class='form-control total_amount' name='total_amount' value='' readonly/></td>
                                                        <td colspan='3'></td>
                                                    </tr>
                                                </tfoot>
                                            </table>                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                                
                            <div class="form-group">
                                <div class="col-sm-12" style='text-align: center;'>
                                    <button type="submit" class="btn btn-primary">{{__('texte.event_offers_arr.create.create')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel-footer"></div>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery.validate.js') }}"></script>
<script src="{{ asset('js/validation.js') }}"></script>
<script>

    $(document).ready(function(){
        sum();
        $('#blank_offer').on('click', function(){
            
        });
    });

    $(document).on('input','.number' ,function() {
        $(this).val($(this).val().replace(/,/g, '.')); 
        
        var valid =/^\d+\.?\d{0,5}$/.test(this.value),
        val = this.value;

        if(!valid){
            this.value = val.substring(0, val.length - 1);
        }  
        sum();
    });
    
    function sum(){
        var total_amount = 0;
        
        $('#event_positions>tbody>tr').each(function(){
            var staff_number = $(this).find('.staff_number').val();
            var days = $(this).find('.days').val();
            var wages = $(this).find('.wages').val();
            var booking_charge = $(this).find('.booking_charge').val()!=='' ? $(this).find('.booking_charge').val() : 0;
            var additional_charge = $(this).find('.additional_charge').val()!=='' ? $(this).find('.additional_charge').val() : 0;
            
            var calculated_sum = staff_number*days*(parseFloat(wages) + parseFloat(booking_charge) + parseFloat(additional_charge)); 
            total_amount+= parseFloat(calculated_sum);
           
            $(this).find('.position_amount').val(parseFloat(calculated_sum).toFixed(2));            
        });
        
        $('.total_amount').val(parseFloat(total_amount).toFixed(2));
    }

</script>
@endsection
