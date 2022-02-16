<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Hostess extends Model
{
    use HasFactory;
    
    public $table = 'hostesses';
    protected $fillable = [ 'user_id','preferred_occupation','sex','address','city_id','region_id','country','nationality','birth_date','type','height','cloth_size','chest','waist','hips','hair_color','eye_color','shoe_size','tattoo','piercing','occupation','profession','education','driver_licence','own_car','trade_licence','health_certificate','de','en','sp','fr','other_language_1','other_language_1_lvl','other_language_2','other_language_2_lvl','other_language_3','other_language_3_lvl','accommodation_places','other_cities','modeling','presentation','gastronomy','team_leader','experience_abroad','musical_instrument','past_experience','public_consent','terms_agreed'];
    
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    
    public function portrait(){
        return $this->hasMany('App\Models\Image','user_id','user_id')->where('type','portrait');
    }
    
    public function body_image(){
        return $this->hasMany('App\Models\Image','user_id','user_id')->where('type','body_image');
    }
    
    public function images(){
        return $this->hasMany('App\Models\Image','user_id','user_id')->where('type','image');
    }
    
    public function all_images(){
        return $this->hasMany('App\Models\Image','user_id','user_id');
    }
    
    public function city(){
        return $this->belongsTo('App\Models\City');
    }
    
    public function region(){
        return $this->belongsTo('App\Models\Region');
    }
}
