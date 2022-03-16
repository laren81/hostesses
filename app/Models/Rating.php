<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id','job_id','stars','comment'];
    
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    
    public function job(){
        return $this->belongsTo('App\Models\Job');
    }
}
