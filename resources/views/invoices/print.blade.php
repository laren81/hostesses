<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} @yield('title')</title>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <!-- Styles -->
    <link href="{{ asset('css/print.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
        .right_aligned{
            text-align: right;
            padding-right:5px;
        }
        
        .left_aligned{
            text-align: left;
            padding-left:5px;
        }
        
        .right-dashed{
            border-right: 1px dashed #ddd !important;
        }
        
        .right-none{
            border-right:none;
        }
        
        .right-solid{
            border-right:1px solid #000 !important;
        }
        
        .left-dashed{
            border-left: 1px dashed #ddd !important;
        }
        
        .left-none{
            border-left:none;
        }
        
        .left-solid{
            border-left:1px solid #000 !important;
        }
        
        .bottom-dashed{
            border-bottom: 1px dashed #ddd !important;
        }
        
        .bottom-none{
            border-bottom:none;
        }
        
        .bottom-solid{
            border-bottom:1px solid #000 !important;
        }
        
        .top-dashed{
            border-top: 1px dashed #ddd !important;
        }
        
        .top-none{
            border-top:none;
        }
        
        .top-solid{
            border-top:1px solid #000 !important;
        }
        
        .table-dark > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
            border: 1px solid #000;
        }

    </style>
    

</head>
<body>
    <div id="wrapper">        
        <div id="page-wrapper" class="gray-bg">            
            <div class="container" style="margin-top:10px;">
                
                <table border="1" width="100%">
                    <tr>
                        <td colspan="2" width="38%" style="background-color:#c0c0c0;font-weight:bold;">{{__('texte.invoices_arr.print.receiver')}}</td>
                        <td colspan="3" rowspan="2" width="24%" class="bottom-dashed"><span style="display:block;padding:8px;font-size:30px;color:#808091;font-style:italic;">{{__('texte.invoices_arr.print.original')}}</span></td>
                        <td colspan="2" width="38%" style="background-color:#c0c0c0;font-weight:bold;">Supplier</td>
                    </tr>
                    <tr>
                        <td width="38%" colspan="2" rowspan="2" class="bottom-dashed"><span style="display:block;padding:8px;font-size:18px;">{{$invoice->client->company_name}}</span></td>
                        <td width="38%" colspan="4" rowspan="2" class="bottom-dashed"><span style="font-size:18px;">{{__('texte.invoices_arr.print.supplier_name')}}</span></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="left_aligned bottom-dashed right-none" width="14%" style="font-style: italic">{{__('texte.invoices_arr.print.invoice_nr')}}:</td>
                        <td class="right_aligned left-none bottom-dashed" width="10%" style="font-style: italic"><strong>{{$invoice->number}}</strong></td>
                    </tr>
                    <tr>
                        <td class="left_aligned bottom-dashed right-none" width="13%">{{__('texte.invoices_arr.print.address')}}:</td>
                        <td class="left_aligned left-none bottom-dashed" width="25%"><span style="display:block;"><strong>{{$invoice->client->street.' '.$invoice->client->house_number.', '.$invoice->client->city->zip.' '.$invoice->client->city->name}}</strong></span></td>
                        <td class="bottom-dashed" colspan="3"></td>
                        <td class="left_aligned bottom-dashed right-none" width="13%">{{__('texte.invoices_arr.print.address')}}:</td>
                        <td class="left_aligned left-none bottom-dashed" width="25%"><strong>{{__('texte.invoices_arr.print.supplier_address')}}</strong></td>
                    </tr>
                    <tr>
                        <td class="bottom-dashed right-none"></td>
                        <td class="bottom-dashed left-none right-none"></td>
                        <td colspan="2" class="left_aligned bottom-dashed right-none" width="14%" style="font-style: italic">{{__('texte.invoices_arr.print.date')}}</td>
                        <td class="right_aligned bottom-dashed left-none" width="10%" style="font-style: italic"><strong>{{date('d.m.Y',strtotime($invoice->date))}}</strong></td>
                        <td class="bottom-dashed right-none"></td>
                        <td class="bottom-dashed left-none"></td>
                    </tr>
                    <tr>
                        <td class="bottom-dashed right-none"></td>
                        <td class="bottom-dashed right-none"></td>
                        <td class="left_aligned bottom-solid right-none" rowspan="5" width="8%" style="font-style: italic"> {{__('texte.invoices_arr.print.place')}}: </td>
                        <td colspan="2" class="right_aligned left-none" rowspan="5" width="16%" style="font-style: italic"> {{__('texte.invoices_arr.print.supplier_place')}}</td>
                        <td class="bottom-dashed right-none"></td>
                        <td class="bottom-dashed right-none"></td>
                    </tr>
                    <tr>
                        <td class="left_aligned bottom-dashed right-none">{{__('texte.invoices_arr.print.vat_nr')}}:</td>       
                        <td class="left_aligned bottom-dashed left-none"><strong></strong></td> 
                        <td class="left_aligned bottom-dashed right-none">{{__('texte.invoices_arr.print.vat_nr')}}:</td>       
                        <td class="left_aligned bottom-dashed left-none"><strong>{{__('texte.invoices_arr.print.supplier_vat_nr')}}</strong></td>
                    </tr>
                    <tr>
                        <td class="left_aligned bottom-dashed right-none">{{__('texte.invoices_arr.print.pic')}}:</td>       
                        <td class="left_aligned bottom-dashed left-none"><strong>{{$invoice->client->user->first_name.' '.$invoice->client->user->last_name}}</strong></td>                         
                        <td class="left_aligned bottom-dashed right-none">{{__('texte.invoices_arr.print.pic')}}:</td>       
                        <td class="left_aligned bottom-dashed left-none"><strong>{{__('texte.invoices_arr.print.supplier_pic')}}</strong></td>
                    </tr>
                    <tr>
                        <td class="bottom-dashed left-none" colspan="2"><span style="display:block;padding:10px;"></span></td>                        
                        <td class="bottom-dashed left-none" colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="left_aligned right-none">{{__('texte.invoices_arr.print.phone')}}:</td>        
                        <td class="left_aligned left-none"><strong>{{$invoice->client->user->phone}}</strong></td>
                        <td class="left_aligned right-none">{{__('texte.invoices_arr.print.phone')}}:</td>        
                        <td class="left_aligned left-none"><strong> {{__('texte.invoices_arr.print.supplier_phone')}}</strong></td>
                    </tr>
                    
                    
                    <tr>
                        <td colspan="7">
                            <table class="table no-margin-bottom" width="100%">                                                   
                                <tr>
                                    <td colspan="7" rowspan="2" width="60%" style="font-size: 30px;border:none;">{{__('texte.invoices_arr.print.invoice')}}</td>                                    
                                </tr>                                
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <table class="table no-margin-bottom" width="100%"> 
                                <tr style="font-weight: bold;">
                                    <td class="bottom-solid right-solid" width="44%">{{__('texte.invoices_arr.print.service')}}</td>
                                    <td class="bottom-solid right-solid" width="6%">{{__('texte.invoices_arr.print.quantity')}}</td>
                                    <td class="bottom-solid right-solid" width="11%">{{__('texte.invoices_arr.print.staff_wages')}}</td>
                                    <td class="bottom-solid right-solid" width="11%">{{__('texte.invoices_arr.print.booking_charge')}}</td>
                                    <td class="bottom-solid right-solid" width="13%">{{__('texte.invoices_arr.print.additional_charge')}}</td>
                                    <td class="bottom-solid right-none" width="25%">{{__('texte.invoices_arr.print.value')}}</td>
                                </tr>                                
                                @foreach($invoice->rows as $index=>$row)
                                <tr>
                                    <td class="left_aligned right-solid">{{$row->service}}</td>
                                    <td class="right-solid">{{$row->quantity}}</td>
                                    <td class="right-solid">{{number_format($row->staff_wages,2)}} {{__('texte.invoices_arr.print.eur')}}</td>
                                    <td class="right-solid">{{number_format($row->booking_charge,2)}} {{__('texte.invoices_arr.print.eur')}}</td>
                                    <td class="right-solid">{{number_format($row->additional_charge,2)}} {{__('texte.invoices_arr.print.eur')}}</td>
                                    <td class="right_aligned">{{number_format($row->value,2)}} {{__('texte.invoices_arr.print.eur')}}</td>
                                </tr>                                
                                @endforeach
                                
                                @if($index<8)
                                    @for($i=$index;$i<7;$i++)
                                    <tr>
                                        <td class="right-solid"></td>
                                        <td class="right-solid"></td>
                                        <td class="right-solid"></td>
                                        <td class="right-solid"></td>
                                        <td class="right-solid"></td>
                                        <td></td>
                                    </tr>
                                    @endfor
                                @endif
                                <tr>
                                    <td class="left_aligned top-solid" colspan="3" rowspan="3"></td>
                                    <td class="left_aligned top-solid left-solid" colspan="2"><strong>{{__('texte.invoices_arr.print.total_net')}}</strong></td>
                                    <td class="right_aligned top-solid left-solid"><strong>{{number_format($invoice->amount,2)}} {{__('texte.invoices_arr.print.eur')}}</strong></td>
                                </tr>
                                <tr>                                    
                                    <td class="left_aligned top-solid left-solid" colspan="2"><strong>{{__('texte.invoices_arr.print.vat')}}</strong></td>
                                    <td class="right_aligned top-solid left-solid"><strong>{{number_format($invoice->vat,2)}} {{__('texte.invoices_arr.print.eur')}}</strong></td>
                                </tr>
                                <tr>                                    
                                    <td class="left_aligned top-solid left-solid" colspan="2"><strong>{{__('texte.invoices_arr.print.total_amount')}}</strong></td>
                                    <td class="right_aligned top-solid left-solid"><strong>{{number_format($invoice->total,2)}} {{__('texte.invoices_arr.print.eur')}}</strong></td>
                                </tr>
                                <tr>
                                    <td class="left_aligned top-solid left-solid bottom-dashed" colspan="6" style="font-style: italic;font-size:12px;">{{__('texte.invoices_arr.print.row_1',['total_amount' => number_format($invoice->total,2), 'date' => date('d.m.Y',strtotime($invoice->payment_date)), 'invoice_number' => $invoice->number])}}</td>
                                </tr>
                                <tr>
                                    <td class="left_aligned top-none left-solid" colspan="6" style="font-style: italic;font-size:12px;">{{__('texte.invoices_arr.print.row_2')}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    
                    <tr>
                        <td colspan="7">
                            <table class="no-margin-bottom" border="1" width="100%">
                                <tr>                                    
                                    <td class="left_aligned bottom-dashed right-none" width="10%">{{__('texte.invoices_arr.print.payment')}}:</td>
                                    <td class="left_aligned bottom-dashed left-none right-none" colspan="2" width="16%">{{__('texte.invoices_arr.print.bank_transfer')}}</td>
                                    <td class="left_aligned bottom-none left-none right-none" colspan="6"></td>
                                </tr>
                                <tr>                                    
                                    <td class="left_aligned bottom-dashed right-none" width="10%" style="font-size:10px">{{__('texte.invoices_arr.print.iban')}}:</td>
                                    <td class="left_aligned bottom-dashed left-none right-none" colspan="2" width="16%" style="font-size:10px;">{{__('texte.invoices_arr.print.supplier_iban')}}</td>
                                    <td class="left_aligned bottom-none left-none top-none right-none" colspan="6"></td>
                                </tr>
                                <tr>
                                    
                                    <td class="left_aligned bottom-dashed right-none" width="10%" style="font-size:10px">{{__('texte.invoices_arr.print.bank')}}:</td>
                                    <td class="left_aligned bottom-dashed left-none right-none" colspan="2" width="16%" style="font-size:10px">{{__('texte.invoices_arr.print.supplier_bank')}}</td>
                                    <td class="left_aligned bottom-none left-none top-none right-none" colspan="6"></td>
                                </tr>
                                <tr>
                                   
                                    <td class="left_aligned right-none" width="10%" style="font-size:10px">{{__('texte.invoices_arr.print.swift')}}:</td>
                                    <td class="left_aligned left-none right-none" colspan="2" width="16%" style="font-size:10px">{{__('texte.invoices_arr.print.supplier_swift')}}</td>
                                 
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
