<?php

namespace App\Repositories;

use App\Models\Rating;

use App\Repositories\Interfaces\RatingRepositoryInterface;


class RatingRepository implements RatingRepositoryInterface
{
    public function all()
    {        
        return Rating::all();
    }
    
    public function createRating($request){
        return Rating::create($request->all());
    }
    
    
}