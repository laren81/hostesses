<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventOffer extends Model
{
    use HasFactory;
    
    protected $fillable=['event_id','total_amount','note','accepted'];
    
    public function event(){
        return $this->belongsTo('App\Models\Event');
    }
    
    public function rows(){
        return $this->hasMany('App\Models\EventOfferRow');
    }
    
    public function invoice(){
        return $this->hasOne('App\Models\Invoice');
    }
}
