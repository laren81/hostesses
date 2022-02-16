<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\Event;

use App\Repositories\Interfaces\CityRepositoryInterface;
use DB;

class CityRepository implements CityRepositoryInterface
{
    public function all()
    {        
        return City::orderBy('name')->orderBy('zip')->get();
    }
    
    public function eventCities() {
        //$cities = Event::leftJoin('cities','cities.id','=','events.city_id')->where('city_id','!=',0)->distinct()->get(['cities.*']);
        
        $cities = City::whereHas('events')->get();

        return $cities;
    }
    
    public function getClientEventsCities($client_id) {
        //$cities = Event::leftJoin('cities','cities.id','=','events.city_id')->where('client_id',$client_id)->where('city_id','!=',0)->distinct()->get(['cities.*']);
        $cities = City::whereHas('events',function($q) use ($client_id){$q->where('client_id',$client_id);})->get(['cities.*']);

        return $cities;
    }
    
    public function getHostessJobCities($user_id){
        $cities = City::whereHas('events.positions.jobs',function($q) use ($user_id){$q->where('jobs.user_id',$user_id);})->get();
        
        return $cities;
    }
    
    public function findCity($id){
        return City::find($id);
    }
    
    public function getRegionCities($region_id){
        
        $query = City::orderBy('name');
        
        if($region_id!=''){
            $query->where('region_id',$region_id);
        }

        return $query->get();
    }
    
    public function getAutocompleteCities($name,$region_id){
        
        $query = City::where(function($q) use($name){$q->where('name', 'like','%'.$name.'%');$q->orWhere('zip','like','%'.$name.'%');$q->orWhere(DB::raw("concat(zip,' ',name)"),'like','%'.$name.'%');})->orderBy('name')->orderBy('zip')->select(['id','zip','region_id','name']);
        
        if($region_id!=null){
            $query->where('region_id',$region_id);
        }
        
        $cities = $query->get();
        
        return $cities;
    }
}