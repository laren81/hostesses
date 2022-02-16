<?php

namespace App\Repositories;

use App\Models\Region;

use App\Repositories\Interfaces\RegionRepositoryInterface;

class RegionRepository implements RegionRepositoryInterface
{
    public function all()
    {        
        return Region::orderBy('name')->get();
    }
    
    public function findRegion($id){
        return Region::find($id);
    }    
}