<?php
namespace App\Repositories\Interfaces;

interface InvoiceRepositoryInterface
{
    public function findInvoice($id);
    
    public function getInvoice($id);
    
    public function getInvoices();
    
    public function storeInvoice($request);
    
    public function updateInvoice($invoice,$request);
    
    public function deleteInvoice($invoice);
    
    public function setInvoicePaidAmount($invoice,$request);
    
    public function getEventInvoices($id);
    
    public function getPrintableInvoice($id);
}