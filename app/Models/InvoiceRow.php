<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceRow extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $fillable = ['invoice_id','service','quantity','staff_wages','booking_charge','additional_charge','value'];
    
    public function invoice(){
        return $this->belongsTo('App\Models\Invoice');
    }
}
