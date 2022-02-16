@extends('layouts.app')

@section('link')
<link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('texte.invoices_arr.create.create_invoice')}}</h3>
                <div class="pull-right">
                    <a class="btn btn-primary back-btn" href="{{route('admin.roles.index')}}">{{__('texte.invoices_arr.create.back')}}</a>
                </div>
            </div>

            <div class="panel-body">
                <form id="invoice_create" method="POST" action="{{ route('admin.invoices.store') }}" class="form form-horizontal">
                    {{ csrf_field() }}
                    
                    <input type="hidden" name="event_offer_id" value="{{isset($event_offer) ? $event_offer->id : 0}}"/>

                    <div class="form-group row {{ $errors->has('client_id') ? ' has-error' : '' }}">
                        <label for="client" class="col-sm-2 col-form-label">{{__('texte.invoices_arr.create.client')}}</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="client" name="client_id" required>
                                @if(isset($event_offer))
                                    <option value="{{$event_offer->event->client_id}}" selected>{{$event_offer->event->client->company_name}}</option>
                                @else
                                    <option value="">Please select</option>
                                    @foreach($clients as $client)                                    
                                    <option value="{{$client->id}}" {{old('client_id')==$client->id ? "selected" : ""}}>{{$client->company_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('client_id'))
                                <span class="help-block"><strong>{{ $errors->first('client_id') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row {{ $errors->has('event_id') ? ' has-error' : '' }}">
                        <label for="event" class="col-sm-2 col-form-label">{{__('texte.invoices_arr.create.event')}}</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="event" name="event_id" required>
                                @if(isset($event_offer))
                                <option value="{{$event_offer->event_id}}" selected>{{$event_offer->event->name}}</option>
                                @else
                                    <option value="">Please select</option>
                                    @foreach($events as $event)                                    
                                    <option value="{{$event->id}}" data-client="{{$event->client_id}}" {{old('event_id')==$event->id ? "selected" : ""}}>{{$event->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('event_id'))
                                <span class="help-block"><strong>{{ $errors->first('event_id') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row {{ $errors->has('date') ? ' has-error' : '' }}">
                        <label for="date" class="col-sm-2 col-form-label">{{__('texte.invoices_arr.create.date')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="date" name="date" value="{{old('date')}}"/>
                            @if ($errors->has('date'))
                                    <span class="help-block"><strong>{{ $errors->first('date') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>    
                    
                    <div class="form-group row {{ $errors->has('payment_date') ? ' has-error' : '' }}">
                        <label for="payment_date" class="col-sm-2 col-form-label">{{__('texte.invoices_arr.create.payment_date')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="payment_date" name="payment_date" value="{{old('payment_date')}}"/>
                            @if ($errors->has('payment_date'))
                                    <span class="help-block"><strong>{{ $errors->first('payment_date') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div> 
                    
                    <div class="form-group row {{ $errors->has('payment_type') ? ' has-error' : '' }}">
                        <label for="payment_type" class="col-sm-2 col-form-label">{{__('texte.invoices_arr.create.payment_type')}}</label>
                        <div class="col-sm-8" style="padding-top: 6px;">
                            <input type="radio" name="payment_type" value="1" id="radio1" {{old('payment_type')==1 ? 'checked' : ''}} checked>
                            <label for="radio1">{{__('texte.invoices_arr.create.bank')}}</label>

                            <input type="radio" name="payment_type" value="2" id="radio2" {{old('payment_type')==2 ? 'checked' : ''}}>
                            <label for="radio2">{{__('texte.invoices_arr.create.cash')}}</label>
                        
                            @if ($errors->has('payment_type'))
                                <span class="help-block"><strong>{{ $errors->first('payment_type') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row {{ $errors->has('note') ? ' has-error' : '' }}">
                        <label for="note" class="col-sm-2 col-form-label">{{__('texte.invoices_arr.create.note')}}</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="note" name="note" placeholder="{{__('texte.invoices_arr.create.note')}}">{{ old('note') }}</textarea>
                            @if ($errors->has('note'))
                                <span class="help-block"><strong>{{ $errors->first('note') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="include_staff_wages" class="col-sm-2 col-form-label">{{__('texte.invoices_arr.create.include_staff_wages')}}</label>
                        <div class="col-sm-8">
                            <input type="checkbox" id="include_staff_wages" name="include_staff_wages" value='1' checked/>   
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="positions" class="col-sm-2 col-form-label">{{__('texte.invoices_arr.create.positions')}}</label>
                        <div class="col-sm-8">
                            <table id="positions" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style='width:52%'>{{__('texte.invoices_arr.create.description')}}</th>
                                        <th style='width:11%'>{{__('texte.invoices_arr.create.days')}}</th>
                                        <th style='width:8%'>{{__('texte.invoices_arr.create.staff_wages')}}</th>
                                        <th style='width:8%'>{{__('texte.invoices_arr.create.booking_charge')}}</th>
                                        <th style='width:8%'>{{__('texte.invoices_arr.create.additional_charge')}}</th>
                                        <th style='width:18%'>{{__('texte.invoices_arr.create.value')}}</th>
                                        <th style='width:4%' data-sorter="false">{{__('texte.invoices_arr.create.remove')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                                                 
                                </tbody>
                                <tfoot>                                    
                                    <tr id="sub_total_row">
                                        <th colspan="5" style="text-align:right">{{__('texte.invoices_arr.create.sum')}}</th>
                                        <th colspan="2" id="value">0.00000</th>
                                    </tr>                                    
                                    <tr id="vat_row">
                                        <th colspan="5" style="text-align:right">{{__('texte.invoices_arr.create.vat')}}</th>
                                        <th colspan="2" id="vat">0.00000</th>
                                    </tr>                                    
                                    <tr>
                                        <th colspan="5" style="text-align:right">{{__('texte.invoices_arr.create.total')}}</th>
                                        <th colspan="2" id="total">0.00000</th>
                                    </tr>
                                </tfoot>
                            </table>
                            @if ($errors)
                                <span class="help-block"><strong>{{ $errors->first() }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12" style='text-align: center;'>
                            <button type="button" class="btn btn-success add_row">{{__('texte.invoices_arr.create.add_row')}}</button>
                            <button type="submit" class="btn btn-primary">{{__('texte.invoices_arr.create.add')}}</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="panel-footer"></div>
        </div>
    </div>
</div>


<script src="{{ asset('js/jquery.validate.js') }}"></script>

<script src="{{ asset('js/validation.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/datepicker-de.js') }}"></script>

<script type="text/javascript" charset="utf-8">
    var rows = {!! isset($event_offer) ? json_encode($event_offer->rows->keyBy('id')) : json_encode(collect()) !!}; 
    var initial_events = {!! isset($events) ? $events : collect()!!};
     
    $(document).ready(function(){
        $('.add_row').on('click', function(){
           add_empty_row(); 
        });
    });

    $("#date").datepicker({           
        onSelect: function(dateText, inst){           
           $("#payment_date").datepicker("option","minDate",
           $("#date").datepicker("getDate"));
        }
    }).datepicker("setDate",'now');

    $("#payment_date").datepicker({"minDate" :  $("#date").datepicker("getDate")}).datepicker("setDate",'now');
    
    $('#include_staff_wages').on('change', function(){
        if($(this).prop("checked")==true){
            $('#positions td:nth-child(3)').each(function(){
                $(this).find('.staff_wages').val($(this).find('.staff_wages').attr('data-value')).attr('readonly',false).trigger("input");;
            });
        }
        else{
            $('#positions td:nth-child(3)').each(function(){
                $(this).find('.staff_wages').val('0.00').attr('readonly',true).trigger("input");;
            });
        }
    });
    
    $(document).on('input','.number' ,function() {
        $(this).val($(this).val().replace(/,/g, '.')); 
        
        var valid =/^\d+\.?\d{0,2}$/.test(this.value),
        val = this.value;

        if(!valid){
            this.value = val.substring(0, val.length - 1);
        }  
    });
    
    $(document).on('input','.quantity' ,function() {
        var valid = /^\d+$/.test(this.value),
        val = this.value;
    
        if(!valid){
            this.value = val.substring(0, val.length - 1);
        }
    });
    
    $('#client').on('change', function(){
        var client = $('#client').val();
        if(client!=""){
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/admin/get_client_events',
                        type: 'POST',
                        async: false,
                data: { 'client' : client},
                success: function(response){
                            var options='<option value="">Please select</option>';
                            $('#event').find('option').remove().end();
                            if(response.length>0){
                                for (var i in response){
                                       options += '<option value="' + response[i].id + '" data-client="'+response[i].client_id+'">' + response[i].name + '</option>';
                                }
                            }                            
                            $('#event').html(options);
                            $('#event').trigger("updated");
                        }
            });
        }
        else{
            var options='<option value="">Please select</option>';
            $('#object').find('option').remove().end();
            
            for (var i in initial_events){
                options += '<option value="' + initial_events[i].id + '" data-client="'+initial_events[i].client_id+'">' + initial_events[i].name + '</option>';
            }
            $('#event').html(options);
            $('#event').trigger("updated").change();
        }
    });
    
    $('#event').on('change', function(){
        if($(this).val()!=""){
            $('#client').val($(this).find('option:selected').attr('data-client'));
        }
    });
</script>

<script src="{{ asset('js/invoice.js') }}"></script>
@endsection