<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    
    public $table = 'jobs';
    protected $fillable = [ 'user_id','event_position_id','status','hostess_comment','admin_comment','client_comment'];
    
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    
    public function event_position(){
        return $this->belongsTo('App\Models\EventPosition');
    }
    
}
