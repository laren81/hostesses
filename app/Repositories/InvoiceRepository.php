<?php

namespace App\Repositories;

use App\Models\Invoice;
use App\Models\InvoiceRow;

use App\Repositories\Interfaces\InvoiceRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use DateTime;
use DB;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function findInvoice($id){
        return Invoice::find($id);
    }
    
    public function getInvoice($id) {
        return Invoice::with('client')->with('event')->with('rows')->where('id',$id)->get()->first();
    }
    
    public function getInvoices(){
        $invoices = Invoice::leftJoin('clients','clients.id','=','invoices.client_id')->leftjoin('events','events.id','=','invoices.event_id')->select(['invoices.*',DB::raw('date_format(invoices.date,"%d.%m.%Y") as date'),DB::raw('date_format(invoices.payment_date,"%d.%m.%Y") as payment_date'),'clients.company_name as client','events.name as event'])->get();
        return $invoices;
    }
    
    public function storeInvoice($request) {

        $function_result = '';
        
        $input = $request->all();

        $input['date'] = isset($input['date']) ? date_format(new DateTime($input['date']), 'Y-m-d') : null;
        $input['payment_date'] = isset($input['payment_date']) ? date_format(new DateTime($input['payment_date']), 'Y-m-d') : null;
        $input['include_staff_wages'] = isset($input['include_staff_wages']) ? $input['include_staff_wages'] : 0;
        $input['stocks'] = $input['stocks'] ?? [];
       
        foreach ($input['stocks'] as $key => &$current_stock)
        {
            $rules['stocks.'.$key.'.service'] = 'required|string';
            $rules['stocks.'.$key.'.quantity'] = 'required|numeric|min:1';
            $rules['stocks.'.$key.'.staff_wages'] = 'required|numeric';
            $rules['stocks.'.$key.'.booking_charge'] = 'required|numeric';
            $rules['stocks.'.$key.'.additional_charge'] = 'required|numeric';
            $rules['stocks.'.$key.'.value'] = 'required|numeric';
        }

        $rules = $rules ?? [
            'stocks.0.service' => 'required|numeric',
            'stocks.0.quantity' => 'required|numeric|min:1',
            'stocks.0.staff_wages' => 'required|numeric',
            'stocks.0.booking_charge' => 'required|numeric',
            'stocks.0.additional_charge' => 'required|numeric',
            'stocks.0.value' => 'required|numeric',
        ];
        
        $rules['client_id'] = 'required|numeric';
        $rules['event_id'] = 'required|numeric';
        $rules['date'] = 'required|date|before:tomorrow';
        $rules['payment_date'] = 'required|date|after:yesterday';
        $rules['grounds'] = 'required_if:have_vat,0';
                    
        $messages= ['stocks.0.product.required' => 'Не е избран продукт.',
                    'stocks.*.quantity.required' => 'Не е избрано количество.',
                    'stocks.*.quantity.min' => 'Невалидно количество.',
                    'stocks.*.price.required' => 'Не е избрана цена.',
                    'stocks.*.price.min' => 'Невалидна цена.',
                    'stocks.*.discount.required' => 'Не е избрана отстъпка.',
                    'stocks.*.discount.min' => 'Невалидна отстъпка.',
                    'grounds.required_if' => 'Полето "Основание" е задължително, когато фактурата е без ДДС'];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails())
        {            
            $errors = $validator->errors();
           
            if(isset($input['date'])){
                $input['date'] = (new DateTime($input['date']))->format('d.m.Y');
            }
            if(isset($input['payment_date'])){
                $input['payment_date'] = (new DateTime($input['payment_date']))->format('d.m.Y');
            }

            foreach ($input['stocks'] as $key => &$current_stock)
            {
                if ($errors->has('stocks.'.$key.'.quantity')){
                    $current_stock['error_quantity'] = $errors->first('stocks.'.$key.'.quantity');
                }
            }
            
            return $errors;
        }        
        
        DB::transaction(function() use(&$input,&$function_result)
        {
            try{               
                $number = Invoice::withTrashed()->max(Db::raw('convert(number,unsigned integer)'))+1;
                $input['number'] = isset($input['number']) ? $input['number'] : ($number!=1 ? $number : 1000001); 
                
                //Създава се нов документ с данните въведени в полетата
                $invoice = Invoice::create($input);

                //Създаване на редовете на документа 
                foreach ($input['stocks'] as &$current_stock){                    
                    InvoiceRow::create([
                                        
                                        'invoice_id' => $invoice->id,
                                        'service' => $current_stock['service'],
                                        'quantity' => $current_stock['quantity'],
                                        'staff_wages' => $current_stock['staff_wages'],
                                        'booking_charge' => $current_stock['booking_charge'],
                                        'additional_charge' => $current_stock['additional_charge'],
                                        'value' => $current_stock['value']
                                    ]);   
                    
                    $invoice->amount+=$current_stock['value'];
                }

                $invoice->vat= $invoice->amount*0.2;
                $invoice->total= $invoice->amount + $invoice->vat;
                $invoice->save();
                                
                $function_result = true;
                
            }
            catch(Exception $e){
                $function_result = $e->getMessage();
            }
        });

        return $function_result;
    }
    
    public function updateInvoice($invoice,$request) {

        $function_result = '';
        
        $input = $request->all();

        $input['date'] = isset($input['date']) ? date_format(new DateTime($input['date']), 'Y-m-d') : null;
        $input['payment_date'] = isset($input['payment_date']) ? date_format(new DateTime($input['payment_date']), 'Y-m-d') : null;
        $input['include_staff_wages'] = isset($input['include_staff_wages']) ? $input['include_staff_wages'] : 0;
        $input['stocks'] = $input['stocks'] ?? [];
       
        foreach ($input['stocks'] as $key => &$current_stock)
        {
            $rules['stocks.'.$key.'.service'] = 'required|string';
            $rules['stocks.'.$key.'.quantity'] = 'required|numeric|min:1';
            $rules['stocks.'.$key.'.staff_wages'] = 'required|numeric';
            $rules['stocks.'.$key.'.booking_charge'] = 'required|numeric';
            $rules['stocks.'.$key.'.additional_charge'] = 'required|numeric';
            $rules['stocks.'.$key.'.value'] = 'required|numeric';
        }

        $rules = $rules ?? [
            'stocks.0.service' => 'required|numeric',
            'stocks.0.quantity' => 'required|numeric|min:1',
            'stocks.0.staff_wages' => 'required|numeric',
            'stocks.0.booking_charge' => 'required|numeric',
            'stocks.0.additional_charge' => 'required|numeric',
            'stocks.0.value' => 'required|numeric',
        ];
        
        $rules['client_id'] = 'required|numeric';
        $rules['event_id'] = 'required|numeric';
        $rules['date'] = 'required|date|before:tomorrow';
        $rules['payment_date'] = 'required|date|after:yesterday';
        $rules['grounds'] = 'required_if:have_vat,0';
                    
        $messages= ['stocks.0.product.required' => 'Не е избран продукт.',
                    'stocks.*.quantity.required' => 'Не е избрано количество.',
                    'stocks.*.quantity.min' => 'Невалидно количество.',
                    'stocks.*.price.required' => 'Не е избрана цена.',
                    'stocks.*.price.min' => 'Невалидна цена.',
                    'stocks.*.discount.required' => 'Не е избрана отстъпка.',
                    'stocks.*.discount.min' => 'Невалидна отстъпка.',
                    'grounds.required_if' => 'Полето "Основание" е задължително, когато фактурата е без ДДС'];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails())
        {            
            $errors = $validator->errors();
           
            if(isset($input['date'])){
                $input['date'] = (new DateTime($input['date']))->format('d.m.Y');
            }
            if(isset($input['payment_date'])){
                $input['payment_date'] = (new DateTime($input['payment_date']))->format('d.m.Y');
            }

            foreach ($input['stocks'] as $key => &$current_stock)
            {
                if ($errors->has('stocks.'.$key.'.quantity')){
                    $current_stock['error_quantity'] = $errors->first('stocks.'.$key.'.quantity');
                }
            }
            
            return $errors;
        }        
        
        DB::transaction(function() use(&$input,$invoice,&$function_result)
        {
            try{    
                foreach($invoice->rows as $row){
                    $row->delete();
                }                
                $invoice->amount = $invoice->vat = $invoice->total = 0;
                $invoice->save();
                
                $invoice->update($input);
                
                //Създаване на редовете на документа 
                foreach ($input['stocks'] as &$current_stock){                    
                    InvoiceRow::create([
                                        
                                        'invoice_id' => $invoice->id,
                                        'service' => $current_stock['service'],
                                        'quantity' => $current_stock['quantity'],
                                        'staff_wages' => $current_stock['staff_wages'],
                                        'booking_charge' => $current_stock['booking_charge'],
                                        'additional_charge' => $current_stock['additional_charge'],
                                        'value' => $current_stock['value']
                                    ]);   
                    
                    $invoice->amount+=$current_stock['value'];
                }

                $invoice->vat= $invoice->amount*0.2;
                $invoice->total= $invoice->amount + $invoice->vat;
                $invoice->save();
                                
                $function_result = true;
                
            }
            catch(Exception $e){
                $function_result = $e->getMessage();
            }
        });

        return $function_result;
    }
    
    public function deleteInvoice($invoice) {
        $function_result = '';
        
        DB::transaction(function() use($invoice,&$function_result){
            
            foreach($invoice->rows as $invoice_row){
                $invoice_row->delete();
            } 
                   
            $invoice->delete();  
            
            $function_result = true;
        });

        return $function_result;
    }
    
    public function setInvoicePaidAmount($invoice,$request){
        $invoice->paid = $request->paid;
        $invoice->status = $invoice->paid == $invoice->total ? 2 : ($invoice->paid==0 ? 0 : 1);
        
        $invoice->save();
        
        return true;
    }
    
    public function getEventInvoices($id){
        return Invoice::where('event_id',$id)->get(['invoices.id','invoices.number',DB::raw('date_format(invoices.date,"%d.%m.%Y") as date')]);
    }
    
    public function getPrintableInvoice($id){
        return Invoice::with('event')->with('client')->with('rows')->where('id',$id)->get()->first();
    }
}