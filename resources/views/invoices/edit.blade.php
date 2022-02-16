@extends('layouts.app')

@section('link')
<link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('texte.invoices_arr.edit.edit_invoice')}}</h3>
                <div class="pull-right">
                    <a class="btn btn-primary back-btn" href="{{route('admin.invoices.index')}}">{{__('texte.invoices_arr.edit.invoices')}}</a>
                </div>
            </div>

            <div class="panel-body">
                <form id="invoice_edit" method="POST" action="{{ route('admin.invoices.update',$invoice->id) }}" class="form form-horizontal">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    <div class="form-group row {{ $errors->has('client_id') ? ' has-error' : '' }}">
                        <label for="client" class="col-sm-2 col-form-label">{{__('texte.invoices_arr.edit.client')}}</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="client" name="client_id">
                                <option value="{{$invoice->client_id}}" selected>{{$invoice->client->company_name}}</option>
                            </select>
                            @if ($errors->has('client_id'))
                                <span class="help-block"><strong>{{ $errors->first('client_id') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row {{ $errors->has('event_id') ? ' has-error' : '' }}">
                        <label for="event" class="col-sm-2 col-form-label">{{__('texte.invoices_arr.edit.event')}}</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="event" name="event_id">
                                <option value="{{$invoice->event_id}}" selected>{{$invoice->event->name}}</option>
                            </select>
                            @if ($errors->has('event_id'))
                                <span class="help-block"><strong>{{ $errors->first('event_id') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row {{ $errors->has('date') ? ' has-error' : '' }}">
                        <label for="date" class="col-sm-2 col-form-label">{{__('texte.invoices_arr.edit.date')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="date" name="date" value="{{old('date',date('d.m.Y',strtotime($invoice->date)))}}"/>
                            @if ($errors->has('date'))
                                    <span class="help-block"><strong>{{ $errors->first('date') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>    
                    
                    <div class="form-group row {{ $errors->has('payment_date') ? ' has-error' : '' }}">
                        <label for="payment_date" class="col-sm-2 col-form-label">{{__('texte.invoices_arr.edit.payment_date')}}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="payment_date" name="payment_date" value="{{old('payment_date',date('d.m.Y',strtotime($invoice->payment_date)))}}"/>
                            @if ($errors->has('payment_date'))
                                    <span class="help-block"><strong>{{ $errors->first('payment_date') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div> 
                    
                    <div class="form-group row {{ $errors->has('payment_type') ? ' has-error' : '' }}">
                        <label for="payment_type" class="col-sm-2 col-form-label">{{__('texte.invoices_arr.edit.payment_type')}}</label>
                        <div class="col-sm-8" style="padding-top: 6px;">
                            <input type="radio" name="payment_type" value="1" id="radio1" {{old('payment_type',$invoice->payment_type)==1 ? 'checked' : ''}} checked>
                            <label for="radio1">{{__('texte.invoices_arr.edit.bank')}}</label>

                            <input type="radio" name="payment_type" value="2" id="radio2" {{old('payment_type',$invoice->payment_type)==2 ? 'checked' : ''}}>
                            <label for="radio2">{{__('texte.invoices_arr.edit.cash')}}</label>
                        
                            @if ($errors->has('payment_type'))
                                <span class="help-block"><strong>{{ $errors->first('payment_type') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row {{ $errors->has('note') ? ' has-error' : '' }}">
                        <label for="note" class="col-sm-2 col-form-label">{{__('texte.invoices_arr.edit.note')}}</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="note" name="note" placeholder="{{__('texte.invoices_arr.edit.note')}}">{{ old('note',$invoice->note) }}</textarea>
                            @if ($errors->has('note'))
                                <span class="help-block"><strong>{{ $errors->first('note') }}</strong></span>
                            @endif
                            <div class="errorBox"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="include_staff_wages" class="col-sm-2 col-form-label">{{__('texte.invoices_arr.edit.include_staff_wages')}}</label>
                        <div class="col-sm-8">
                            <input type="checkbox" id="include_staff_wages" name="include_staff_wages" value='1' {{old('include_staff_wages',$invoice->include_staff_wages)==1 ? "checked" : ""}}/>   
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="positions" class="col-sm-2 col-form-label">{{__('texte.invoices_arr.edit.positions')}}</label>
                        <div class="col-sm-8">
                            <table id="positions" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style='width:52%'>{{__('texte.invoices_arr.edit.description')}}</th>
                                        <th style='width:11%'>{{__('texte.invoices_arr.edit.days')}}</th>
                                        <th style='width:8%'>{{__('texte.invoices_arr.edit.staff_wages')}}</th>
                                        <th style='width:8%'>{{__('texte.invoices_arr.edit.booking_charge')}}</th>
                                        <th style='width:8%'>{{__('texte.invoices_arr.edit.additional_charge')}}</th>
                                        <th style='width:18%'>{{__('texte.invoices_arr.edit.value')}}</th>
                                        <th style='width:4%' data-sorter="false">{{__('texte.invoices_arr.edit.remove')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                                                 
                                </tbody>
                                <tfoot>                                    
                                    <tr id="sub_total_row">
                                        <th colspan="5" style="text-align:right">{{__('texte.invoices_arr.edit.sum')}}</th>
                                        <th colspan="2" id="value">0.00000</th>
                                    </tr>                                    
                                    <tr id="vat_row">
                                        <th colspan="5" style="text-align:right">{{__('texte.invoices_arr.edit.vat')}}</th>
                                        <th colspan="2" id="vat">0.00000</th>
                                    </tr>                                    
                                    <tr>
                                        <th colspan="5" style="text-align:right">{{__('texte.invoices_arr.edit.total')}}</th>
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
                            <button type="button" class="btn btn-success add_row">{{__('texte.invoices_arr.edit.add_row')}}</button>
                            <button type="submit" class="btn btn-primary">{{__('texte.invoices_arr.edit.update')}}</button>
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
    var rows = {!! json_encode($invoice->rows) !!}; 
    console.log(rows);
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
    });

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
</script>

<script src="{{ asset('js/invoice.js') }}"></script>
@endsection