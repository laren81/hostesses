<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $fillable = ['number','client_id','event_id','date','payment_date','payment_type','amount','vat','total','paid','note','include_staff_wages'];
    
    public function client(){
        return $this->belongsTo('App\Models\Client');
    }
    
    public function event(){
        return $this->belongsTo('App\Models\Event');
    }
    
    public function rows(){
        return $this->hasMany('App\Models\InvoiceRow');
    }
    
    public function event_offer(){
        return $this->belongsTo('App\Models\EventOffer');
    }
}
