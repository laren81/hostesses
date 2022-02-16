<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Image;

use Illuminate\Support\Facades\Input;

class ImageController extends Controller
{
    public function deleteImage(Request $request){
        $image = $request->image;
        $id = $request->id;      
        
        if(file_exists(storage_path('app/public/uploads/images/'. $image))){
            unlink(storage_path('app/public/uploads/images/'. $image));
            if(file_exists(storage_path('app/public/uploads/images/thumbs/'.$image))){
                unlink(storage_path('app/public/uploads/images/thumbs/'.$image));
            }
            Image::destroy($id);
            return response()->json(['success' => 'Image deleted']);
        }
        else if(Image::destroy($id)){
            return response()->json(['success' => 'Image deleted']);
        }
        else{
            return response()->json(['warning'=>'Image not found']);
        }
    }
 
}
