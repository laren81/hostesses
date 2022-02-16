<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    
    protected $fillable = [ 'user_id','title','company_name','street','house_number','city_id','region_id','website','terms_agreed'];
    
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    
    public function city(){
        return $this->belongsTo('App\Models\City');
    }
    
    public function region(){
        return $this->belongsTo('App\Models\Region');
    }
}
