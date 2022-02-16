<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index(){
        $prices = $this->priceRepository->all();
        
        return view('prices.index',compact('prices'));
    }
    
    public function update(Request $request){
        
        if($this->priceRepository->updatePrices($request)){
            return redirect()->route('admin.prices.index')->with('success','Prices were updated');
        }
        else{
            return redirect()->route('admin.prices.index')->with('warning','Something went wrong');
        }
    }
}
