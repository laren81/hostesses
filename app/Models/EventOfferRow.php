<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventOfferRow extends Model
{
    use HasFactory;
    
    protected $fillable=['event_offer_id','event_position_id','days','staff_wages','booking_charge','additional_charge','total','client_note','admin_note'];
    
    public function event_offer(){
        return $this->belongsTo('App\Models\EventOffer');
    }
    
    public function event_position(){
        return $this->belongsTo('App\Models\EventPosition');
    }
}
