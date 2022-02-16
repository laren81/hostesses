<?php

namespace App\Repositories;

use App\Models\Price;

use App\Repositories\Interfaces\PriceRepositoryInterface;

use DB;
use DateTime;

class PriceRepository implements PriceRepositoryInterface
{
    public function all() {
        return Price::leftJoin('regions','regions.id','=','prices.region_id')->select(['prices.*','regions.name'])->get();
    }
    
    public function updatePrices($request){
        $input = $request->all();
        
        foreach($input['id'] as $index=>$id){
            $price = Price::find($id);

            $array_input = array();
            
            for($i=1;$i<12;$i++){
                $array_input['H'.$i] = $input['H'.$i][$index];
                $array_input['M'.$i] = $input['M'.$i][$index];
                $array_input['S'.$i] = $input['S'.$i][$index];
            }
            
            $price->update($array_input);
        }
        
        return true;
    }
}