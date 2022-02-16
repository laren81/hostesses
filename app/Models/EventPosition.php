<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Hostess;
use DB;

class EventPosition extends Model
{
    use HasFactory;
    
    protected $fillable = [ 'event_id','date_from','date_to','time_from','time_till','staff_number','staff_type','staff_gender','height_from','height_to','size_from','size_to','language_1','language_1_lvl','language_2','language_2_lvl','language_3','language_3_lvl','job_description','outfit','other_comments'];
    
    public function event(){
        return $this->belongsTo('App\Models\Event');
    }
    
    public function jobs(){
        return $this->hasMany('App\Models\Job');
    }
    
    public function hostesses(){
        
        $query = Hostess::leftJoin('users','users.id','=','hostesses.user_id')->leftJoin('cities as c1','c1.id','=','hostesses.city_id')->leftJoin('cities as c2','hostesses.accommodation_places','like',DB::raw("CONCAT('%,',c2.id,',%')"))->where('users.active',1)->where('hostesses.preferred_occupation','like',('%,'.$this->staff_type.',%'));
        
        if($this->staff_gender!=0){
            $query->where('sex',$this->staff_gender);
        }
        
        if($this->height_from!=null){
            $query->where('height','>=',$this->height_from);
        }
        
        if($this->height_to!=null){
            $query->where('height','<=',$this->height_to);
        }
        
        if($this->size_from!=null){
            $query->where('cloth_size','>=',$this->size_from);
        }
        
        if($this->size_to!=null){
            $query->where('cloth_size','<=',$this->size_to);
        }
        
        if($this->language_1!=null){
            $query->where('de','>=',$this->language_1_lvl);
        }
        
        if($this->language_2!=null){
            $query->where('en','>=',$this->language_2_lvl);
        }
        
        if($this->language_3!=null){
            
            if($this->language_3==1){
                $query->where('fr','>=',$this->language_3_lvl);
            }
            else if($this->language_3==2){
                $query->where('sp','>=',$this->language_3_lvl);
            }
            else{
                $query->where(function($q){$q->where(function($q1){$q1->where('other_language_1',$this->language_3);$q1->where('other_language_1_lvl','>=',$this->language_3_lvl);});$q->orWhere(function($q2){$q2->where('other_language_2',$this->language_3);$q2->where('other_language_2_lvl','>=',$this->language_3_lvl);});$q->orWhere(function($q3){$q3->where('other_language_3',$this->language_3);$q3->where('other_language_3_lvl','>=',$this->language_3_lvl);});});
            }
        }
        
        $query->select(['hostesses.*']);
        
        if($this->event->internal_location==1){
            $query->where(function($q){$q->whereRaw('ACOS( SIN(RADIANS(c1.lat))*SIN(RADIANS('.$this->event->city->lat.')) + COS(RADIANS(c1.lat)) * COS(RADIANS('.$this->event->city->lat.')) * COS(RADIANS(c1.lng) - RADIANS('.$this->event->city->lng.')) ) * 6380 < case when hostesses.driver_licence=1 && hostesses.own_car=1 then 200 else 50 end');
                                             $q->orWhereRaw('ACOS( SIN(RADIANS(c2.lat))*SIN(RADIANS('.$this->event->city->lat.')) + COS(RADIANS(c2.lat)) * COS(RADIANS('.$this->event->city->lat.')) * COS(RADIANS(c2.lng) - RADIANS('.$this->event->city->lng.')) ) * 6380 < case when hostesses.driver_licence=1 && hostesses.own_car=1 then 200 else 50 end');});
        }
        else{
            $query->where('other_cities','like','%'.$this->event->external_city.'%');
        }
        $hosteses = $query->groupBy('hostesses.id')->get();
        
        return $hosteses;
    }
    
    public function days(){
       $days =  ($this->date_from!=null && $this->date_to!=null ? (strtotime($this->date_to) - strtotime($this->date_from)) : (strtotime($this->event->date_to) - strtotime($this->event->date_from))) / (60 * 60 * 24) +1;
       
       return $days;
    }
    
    public function hours(){
        $hours =  ($this->time_from!=null && $this->time_till!=null ? (strtotime($this->time_till) - strtotime($this->time_from)) : (strtotime($this->event->time_till) - strtotime($this->event->time_from))) / 3600;
       
       return $hours;
    }
    
    public function charge(){
        $days = $this->days();
        $total_hostess_days = max(11,$days*$this->staff_number);
        
        if($total_hostess_days<=2){
            return 65;
        }
        else if($total_hostess_days>2 && $total_hostess_days<=7){
            return 62;
        }
        else if($total_hostess_days>7 && $total_hostess_days<=15){
            return 52;
        }
        else{
            return 45;
        }
    }
    
    public function wages($raw_wages){
        $hours = $this->hours();

        if($hours<=4){
            $wages = $hours*$raw_wages*1.6;
        }
        else if($hours>4 && $hours<=6){
            $wages = $hours*$raw_wages*1.5;
        }
        else if($hours>6 && $hours<=9){
            $wages = $hours*$raw_wages;
        }
        else{
            $wages = 9*$raw_wages + ($hours-9)*($raw_wages+1);
        }
        return $wages;
    }
    
    public function description(){
        $description = $this->staff_number.' '.__('texte.staff_types_arr')[$this->staff_type].' / ';
            
        if($this->date_from!=null && $this->date_to!=null){
            if(date('m.Y',strtotime($this->date_from)) === date('m.Y',strtotime($this->date_to))){
                $description.=date('d',strtotime($this->date_from)).' - '.date('d.m.Y',strtotime($this->date_to));
            }
            elseif(date('Y',strtotime($this->date_from)) === date('Y',strtotime($this->date_to))){
                $description.=date('d.m',strtotime($this->date_from)).' - '.date('d.m.Y',strtotime($this->date_to));
            }
            else{
                $description.=date('d.m.Y',strtotime($this->date_from)).' - '.date('d.m.Y',strtotime($this->date_to));
            }
        }

        else{
            if(date('m.Y',strtotime($this->event->date_from)) === date('m.Y',strtotime($this->event->date_to))){
                $description.=date('d',strtotime($this->event->date_from)).' - '.date('d.m.Y',strtotime($this->event->date_to));
            }
            elseif(date('Y',strtotime($this->event->date_from)) === date('Y',strtotime($this->event->date_to))){
                $description.=date('d.m',strtotime($this->event->date_from)).' - '.date('d.m.Y',strtotime($this->event->date_to));
            }
            else{
                $description.=date('d.m.Y',strtotime($this->event->date_from)).' - '.date('d.m.Y',strtotime($this->event->date_to));
            }
        }

        $description.=' / ';

        if($this->time_from && $this->time_till){
            $description.=date('H:i',strtotime($this->time_from)).' - '.date('H:i',strtotime($this->time_till));
        }
        else{
            $description.=date('H:i',strtotime($this->event->time_from)).' - '.date('H:i',strtotime($this->event->time_till));
        }

        return $description;
    }
}
