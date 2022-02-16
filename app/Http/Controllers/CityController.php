<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CityController extends Controller
{
    public function getRegionCities(Request $request){
        
        $region_id = $request->region_id;
        
        return $this->cityRepository->getRegionCities($region_id);
    }
    
    public function getAutocompleteCities(Request $request){
        $name = $request->city; 
        $region_id = $request->region_id ?? null;
        
        $cities = $this->cityRepository->getAutocompleteCities($name,$region_id); 
        
        return $cities;        
    }
}
