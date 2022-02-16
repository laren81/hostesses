<?php
namespace App\Repositories\Interfaces;

interface CityRepositoryInterface
{  
    public function all();
    
    public function eventCities();
    
    public function findCity($id);
    
    public function getRegionCities($region_id);  
    
    public function getAutocompleteCities($name,$region_id);
    
    public function getClientEventsCities($client_id);
    
    public function getHostessJobCities($user_id);

}