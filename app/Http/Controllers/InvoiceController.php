<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DataTables;
use PDF;

class InvoiceController extends Controller
{
    public function index(){
        $clients = $this->clientRepository->all();
        $events = $this->eventRepository->getEvents();
        
        return view('invoices.index', compact('clients','events'));
    }
    
    public function getInvoices(){
        $invoices = $this->invoiceRepository->getInvoices();
        
        return DataTables::of($invoices)->make(true);
    }
    
    public function createOfferInvoice($event_offer_id){
        
        $event_offer = $this->eventOfferRepository->getInvoiceOffer($event_offer_id);
        
        if($event_offer){
            return view('invoices.create', compact('event_offer'));
        }
        
        return redirect()->route('admin.event_offers.index')->with('warning','Event offer not found');
    }
    
    public function create(){
        $events = $this->eventRepository->getEvents()->sortBy('name');
        $clients = $this->clientRepository->all()->sortBy('company_name');
        
        return view('invoices.create', compact('events','clients'));
    }
    
    public function store(Request $request){
        $result = $this->invoiceRepository->storeInvoice($request);
        
        if($result===true){
                
            return redirect()->route('admin.invoices.index')->with('success','Invoice was created');
        }  

        if(is_object($result)){
            return redirect()->back()->withInput($request->all())->with('errors',$result);
        }

        return redirect()->back()->withInput($request->all())->with('warning',$result);
    }
    
    public function show($id){
        if($invoice = $this->invoiceRepository->getInvoice($id)){            
            return view('invoices.show', compact('invoice'));
        }
        
        return redirect()->route('admin.invoices.index')->with(['warning' => 'Invoice not found!']);
    }
    
    public function edit($id){
        if($invoice = $this->invoiceRepository->getInvoice($id)){  
            if($invoice->status!=0 && $invoice->paid!=0){
                return redirect()->route('admin.invoices.index')->with(['warning' => 'Invoice has payments and cannot be edited!']);
            }
            return view('invoices.edit', compact('invoice'));
        }
        
        return redirect()->route('admin.invoices.index')->with(['warning' => 'Invoice not found!']);
    }
    
    public function update($id, Request $request){
        if($invoice = $this->invoiceRepository->getInvoice($id)){            
             $result = $this->invoiceRepository->updateInvoice($invoice,$request);
        
            if($result===true){
                return redirect()->route('admin.invoices.index')->with('success','Invoice updated');
            }  

            if(is_object($result)){
                return redirect()->back()->withInput($request->all())->with('errors',$result);
            }

            return redirect()->back()->withInput($request->all())->with('warning',$result);
        }
        
        return redirect()->route('admin.invoices.index')->with(['warning' => 'Invoice not found!']);
    }
    
    public function destroy(Request $request){
        
        $id = $request->get('id');
        
        if($invoice = $this->invoiceRepository->findInvoice($id)){
            
            if($invoice->status!=0 && $invoice->paid!=0){
                return response()->json(['warning' => 'Invoice has payments and cannot be edited!']);
            }
            
            $result = $this->invoiceRepository->deleteInvoice($invoice);
            
            if($result===true){
                return response()->json(['success' => 'Invoice deleted!']);
            }
            else{
                return response()->json(['warning' => $result]);
            }
        }
        
        return response()->json(['warning' => 'Invoice not found!']);
        
    }  
    
    public function setInvoicePaidAmount(Request $request){
        $id = $request->get('id');
        
        if($invoice = $this->invoiceRepository->findInvoice($id)){
            
            $result = $this->invoiceRepository->setInvoicePaidAmount($invoice,$request);
            
            if($result==true){
                return response()->json(['success' => 'Invoice updated!']);
            }
            else{
                return response()->json(['warning' => $result]);
            }
        }
        
        return response()->json(['warning' => 'Invoice not found!']);
    }
    
    public function printInvoice($id){
        if($invoice = $this->invoiceRepository->getPrintableInvoice($id)){
            
            $pdf = PDF::loadView('invoices.print', compact('invoice'));

            return $pdf->stream(); 
            
            //return view('invoices.print', compact('invoice'));
        }
    }
}
