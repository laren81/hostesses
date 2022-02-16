<?php
namespace App\Repositories\Interfaces;

interface RegionRepositoryInterface
{  
    public function all();
    
    public function findRegion($id);
    
}