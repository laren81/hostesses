<?php
namespace App\Repositories\Interfaces;

interface PriceRepositoryInterface
{
   public function all();
   
   public function updatePrices($request);
}
