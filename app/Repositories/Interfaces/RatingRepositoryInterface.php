<?php
namespace App\Repositories\Interfaces;

interface RatingRepositoryInterface
{  
    public function all();
    
    public function createRating($request);

}