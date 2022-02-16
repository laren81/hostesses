@extends('layouts.app')

@section('content')
<div class="container">
    @include('shared.messages')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('texte.invoices_arr.show.show_invoice')}}</h3>
                    <div class="pull-right">
                        <a class="btn btn-warning" href="{{route('admin.invoices.edit',$invoice->id)}}">{{__('texte.invoices_arr.show.change')}}</a>
                        <a class="btn btn-primary back-btn" href="{{route('admin.invoices.index')}}">{{__('texte.invoices_arr.show.invoices')}}</a>
                    </div>
                </div>
                    
                <div class="panel-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.invoices_arr.show.number')}}: </strong>
                            {{ $invoice->number }}
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.invoices_arr.show.client')}}: </strong>
                            {{ $invoice->client->company_name }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.invoices_arr.show.event')}}: </strong>
                            {{ $invoice->event->name }}
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.invoices_arr.show.date')}}: </strong>
                            {{ $invoice->date }}
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.invoices_arr.show.payment_date')}}: </strong>
                            {{ $invoice->payment_date }}
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.invoices_arr.show.amount')}}: </strong>
                            {{ $invoice->amount }}
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.invoices_arr.show.vat')}}: </strong>
                            {{ $invoice->vat }}
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.invoices_arr.show.total')}}: </strong>
                            {{ $invoice->total }}
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.invoices_arr.show.paid')}}: </strong>
                            {{ $invoice->paid }}
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.invoices_arr.show.status')}}: </strong>
                            {{ __('texte.invoice_statuses_arr')[$invoice->status]}}
                        </div>
                    </div> 
                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>{{__('texte.invoices_arr.show.staff_wages_included')}}: </strong>
                            {{ $invoice->include_staff_wages==1 ? __('texte.invoices_arr.show.yes') : __('texte.invoices_arr.show.no')}}
                        </div>
                    </div> 
                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                    @if(isset($invoice->rows) && count($invoice->rows)>0)
                    <h4>{{__('texte.invoices_arr.show.rows')}}</h4>
                    <div class="ibox float-e-margins">
                        <div class="ibox-content wide">
                            <div class="table-responsive">
                                <table id="document_rows" class="table table-bordered table-striped table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{__('texte.invoices_arr.show.service')}}</th>
                                            <th>{{__('texte.invoices_arr.show.quantity')}}</th>
                                            @if($invoice->include_staff_wages==1)
                                            <th>{{__('texte.invoices_arr.show.staff_wages')}}</th>
                                            @endif
                                            <th>{{__('texte.invoices_arr.show.booking_charge')}}</th>
                                            <th>{{__('texte.invoices_arr.show.additional_charge')}}</th>
                                            <th>{{__('texte.invoices_arr.show.value')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($invoice->rows as $row)
                                    <tr>
                                        <td>{{$row->service}}</td>
                                        <td>{{$row->quantity}}</td>
                                        @if($invoice->include_staff_wages==1)
                                        <td>{{$row->staff_wages}}</td>
                                        @endif
                                        <td>{{$row->booking_charge}}</td>
                                        <td>{{$row->additional_charge}}</td>
                                        <td>{{$row->value}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    </div>
                    
                    
                    
                    
                </div>                
                
                <div class="panel-footer"></div>
            </div>
        </div>
    </div>
</div>
@endsection
