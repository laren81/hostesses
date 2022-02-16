<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    
    public function region(){
        return $this->belongsTo('App\Models\Region');
    }
    
    public function events(){
        return $this->hasMany('App\Models\Event');
    }
}
