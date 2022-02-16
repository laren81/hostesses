<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [ 'client_id','name','region_id','city_id','internal_location','external_city','location','date_from','date_to','time_from','time_till','urgent','status'];
    
    public function client(){
        return $this->belongsTo('App\Models\Client');
    }
    
    public function region(){
        return $this->belongsTo('App\Models\Region');
    }
    
    public function city(){
        return $this->belongsTo('App\Models\City');
    }
    
    public function positions(){
        return $this->hasMany('App\Models\EventPosition');
    }
    
    public function offer(){
        return $this->hasOne('App\Models\EventOffer');
    }
    
    public function hostesses(){
        
        $event_hostesses = array();
        
        foreach($this->positions as $position){
            array_push($event_hostesses,  ...$position->hostesses()->pluck('id')->toArray());
        }
        
        return array_unique($event_hostesses);    
    }
    
    public function jobs(){
        return $this->hasManyThrough('App\Models\Job','App\Models\EventPosition');
    }
    
    public function invoices(){
        return $this->hasMany('App\Models\Invoice');
    }
    
    public function count_invoices(){
        return $this->hasMany('App\Models\Invoice');
    }
}
