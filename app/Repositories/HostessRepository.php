<?php

namespace App\Repositories;

use App\Models\Hostess;
use App\Models\User;
use App\Models\Image;

use Img;

use App\Repositories\Interfaces\HostessRepositoryInterface;
use Illuminate\Support\Facades\File;
use DB;
use Illuminate\Support\Str;
use DateTime;
use Illuminate\Support\Facades\Password;

class HostessRepository implements HostessRepositoryInterface
{
    
    public function findHostess($id){
        return Hostess::find($id);
    }
    
    public function findUserHostess($user_id){
        return Hostess::where('user_id',$user_id)->get()->first();
    }
    
    public function createHostess($request) {
        
        $input = $request->all();
        
        DB::beginTransaction();
        
        try{
            if(auth()->check() && auth()->user()->role_id!=1){
                $input['user_id'] = auth()->user()->id;                               
            }
            else{                
                $input['password'] = bcrypt(Str::random(35));
                $input['role_id'] = 2;

                $user = User::create($input);
                    
                $input['user_id'] = $user->id; 
            }
            
            $input['preferred_occupation'] = ','.implode(',',$input['preferred_occupation']).',';
            $input['birth_date'] = date_format(new DateTime($input['birth_date']), 'Y-m-d');
            $input['accommodation_places'] = ','.implode(',',$input['accommodation_places']).',';

            $hostess=Hostess::create($input);
            
            if($request->hasFile('portrait')) {
                $file = $request->file('portrait');                
                $extension = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $fileName = Str::random(5)."-".date('his')."-".Str::random(3).".".$extension;
                $folderpath  = 'public/uploads/images/';

                if (!file_exists('../storage/app/'.$folderpath)){
                    File::makeDirectory('../storage/app/'.$folderpath);
                }

                $file->storeAs($folderpath , $fileName);
                $img = Img::make($file)->resize(185,240);
                if (!file_exists('../storage/app/'.$folderpath.'/thumbs')){
                    File::makeDirectory('../storage/app/'.$folderpath.'/thumbs');
                }
                $img->save('../storage/app/'.$folderpath.'/thumbs/'.$fileName);
                Image::create(['user_id' => $hostess->user_id,'type' => 'portrait' ,'name' => $fileName, 'title' => $name]);
            }
            
            if($request->hasFile('body_image')) {
                $file = $request->file('body_image');                
                $extension = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $fileName = Str::random(5)."-".date('his')."-".Str::random(3).".".$extension;
                $folderpath  = 'public/uploads/images/';

                if (!file_exists('../storage/app/'.$folderpath)){
                    File::makeDirectory('../storage/app/'.$folderpath);
                }

                $file->storeAs($folderpath , $fileName);
                $img = Img::make($file)->resize(185,240);
                if (!file_exists('../storage/app/'.$folderpath.'/thumbs')){
                    File::makeDirectory('../storage/app/'.$folderpath.'/thumbs');
                }
                $img->save('../storage/app/'.$folderpath.'/thumbs/'.$fileName);
                Image::create(['user_id' => $hostess->user_id,'type' => 'body_image' ,'name' => $fileName, 'title' => $name]);
            }
            
            if ($request->hasFile('images')) {
                $files = $request->file('images');
                foreach($files as $file){
                    $extension = $file->getClientOriginalExtension();
                    $name = $file->getClientOriginalName();
                    $fileName = Str::random(5)."-".date('his')."-".Str::random(3).".".$extension;
                    $folderpath  = 'public/uploads/images/';
                           
                    if (!file_exists('../storage/app/'.$folderpath)){
                        File::makeDirectory('../storage/app/'.$folderpath);
                    }
                    
                    $file->storeAs($folderpath , $fileName);
                    $img = Img::make($file)->resize(185,240);
                    if (!file_exists('../storage/app/'.$folderpath.'/thumbs')){
                        File::makeDirectory('../storage/app/'.$folderpath.'/thumbs');
                    }
                    $img->save('../storage/app/'.$folderpath.'/thumbs/'.$fileName);
                    Image::create(['user_id' => $hostess->user_id,'type' => 'image' ,'name' => $fileName, 'title' => $name]);
                }
            }
            
            if(isset($user)){
                $token = Password::getRepository()->create($user);

                $user->setRememberToken($token);
                $user->save();

                $user->sendPasswordGenerationNotification($token);
            }

            DB::commit();
                
        } catch (Exception $ex) {
            DB::rollBack();
            
            return $ex->getMessage();
        }        
        
        return true;
    }
    
    public function updateHostess($hostess,$request) {
        $input = $request->all();
        
        DB::beginTransaction();
        
        try{            
            $user = User::find($hostess->user_id);
            
            if (! empty($input['password'])){
                $input['password'] = bcrypt($input['password']);
            }
            else{
                unset($input['password']);
            }
        
            if(auth()->user()->role_id==1){
                $input['active'] = isset($input['active']) ? $input['active'] : 0;
            }
            
            $user->update($input);
            
            $input['preferred_occupation'] = ','.implode(',',$input['preferred_occupation']).',';
            $input['birth_date'] = date_format(new DateTime($input['birth_date']), 'Y-m-d');
            $input['accommodation_places'] = ','.implode(',',$input['accommodation_places']).',';

            $hostess->update($input);
            
            if($request->hasFile('portrait')) {
                $file = $request->file('portrait');                
                $extension = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $fileName = Str::random(5)."-".date('his')."-".Str::random(3).".".$extension;
                $folderpath  = 'public/uploads/images/';

                if (!file_exists('../storage/app/'.$folderpath)){
                    File::makeDirectory('../storage/app/'.$folderpath);
                }

                $file->storeAs($folderpath , $fileName);
                $img = Img::make($file)->resize(185,240);
                if (!file_exists('../storage/app/'.$folderpath.'/thumbs')){
                    File::makeDirectory('../storage/app/'.$folderpath.'/thumbs');
                }
                $img->save('../storage/app/'.$folderpath.'/thumbs/'.$fileName);
                Image::create(['user_id' => $hostess->user_id,'type' => 'portrait' ,'name' => $fileName, 'title' => $name]);
            }
            
            if($request->hasFile('body_image')) {
                $file = $request->file('body_image');                
                $extension = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $fileName = Str::random(5)."-".date('his')."-".Str::random(3).".".$extension;
                $folderpath  = 'public/uploads/images/';

                if (!file_exists('../storage/app/'.$folderpath)){
                    File::makeDirectory('../storage/app/'.$folderpath);
                }

                $file->storeAs($folderpath , $fileName);
                $img = Img::make($file)->resize(185,240);
                if (!file_exists('../storage/app/'.$folderpath.'/thumbs')){
                    File::makeDirectory('../storage/app/'.$folderpath.'/thumbs');
                }
                $img->save('../storage/app/'.$folderpath.'/thumbs/'.$fileName);
                Image::create(['user_id' => $hostess->user_id,'type' => 'body_image' ,'name' => $fileName, 'title' => $name]);
            }
            
            if ($request->hasFile('images')) {
                $files = $request->file('images');
                foreach($files as $file){
                    $extension = $file->getClientOriginalExtension();
                    $name = $file->getClientOriginalName();
                    $fileName = Str::random(5)."-".date('his')."-".Str::random(3).".".$extension;
                    $folderpath  = 'public/uploads/images/';
                           
                    if (!file_exists('../storage/app/'.$folderpath)){
                        File::makeDirectory('../storage/app/'.$folderpath);
                    }
                    
                    $file->storeAs($folderpath , $fileName);
                    $img = Img::make($file)->resize(185,240);
                    if (!file_exists('../storage/app/'.$folderpath.'/thumbs')){
                        File::makeDirectory('../storage/app/'.$folderpath.'/thumbs');
                    }
                    $img->save('../storage/app/'.$folderpath.'/thumbs/'.$fileName);
                    Image::create(['user_id' => $hostess->user_id,'type' => 'image' ,'name' => $fileName, 'title' => $name]);
                }
            }

            DB::commit();
                
        } catch (Exception $ex) {
            DB::rollBack();
            
            return $ex->getMessage();
        }        
        
        return true;
    }
    
    public function createHostessProfile($user,$request){
        $input = $request->all();
        
        $input['user_id'] = $user->id;

        DB::beginTransaction();
        
        try{
            
            $input['preferred_occupation'] = ','.implode(',',$input['preferred_occupation']).',';
            $input['birth_date'] = date_format(new DateTime($input['birth_date']), 'Y-m-d');
            $input['accommodation_places'] = ','.implode(',',$input['accommodation_places']).',';

            $hostess=Hostess::create($input);
            
            if($request->hasFile('portrait')) {
                $file = $request->file('portrait');                
                $extension = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $fileName = Str::random(5)."-".date('his')."-".Str::random(3).".".$extension;
                $folderpath  = 'public/uploads/images/';

                if (!file_exists('../storage/app/'.$folderpath)){
                    File::makeDirectory('../storage/app/'.$folderpath);
                }

                $file->storeAs($folderpath , $fileName);
                $img = Img::make($file)->resize(185,240);
                if (!file_exists('../storage/app/'.$folderpath.'/thumbs')){
                    File::makeDirectory('../storage/app/'.$folderpath.'/thumbs');
                }
                $img->save('../storage/app/'.$folderpath.'/thumbs/'.$fileName);
                Image::create(['user_id' => $hostess->user_id,'type' => 'portrait' ,'name' => $fileName, 'title' => $name]);
            }
            
            if($request->hasFile('body_image')) {
                $file = $request->file('body_image');                
                $extension = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $fileName = Str::random(5)."-".date('his')."-".Str::random(3).".".$extension;
                $folderpath  = 'public/uploads/images/';

                if (!file_exists('../storage/app/'.$folderpath)){
                    File::makeDirectory('../storage/app/'.$folderpath);
                }

                $file->storeAs($folderpath , $fileName);
                $img = Img::make($file)->resize(185,240);
                if (!file_exists('../storage/app/'.$folderpath.'/thumbs')){
                    File::makeDirectory('../storage/app/'.$folderpath.'/thumbs');
                }
                $img->save('../storage/app/'.$folderpath.'/thumbs/'.$fileName);
                Image::create(['user_id' => $hostess->user_id,'type' => 'body_image' ,'name' => $fileName, 'title' => $name]);
            }
            
            if ($request->hasFile('images')) {
                $files = $request->file('images');
                foreach($files as $file){
                    $extension = $file->getClientOriginalExtension();
                    $name = $file->getClientOriginalName();
                    $fileName = Str::random(5)."-".date('his')."-".Str::random(3).".".$extension;
                    $folderpath  = 'public/uploads/images/';
                           
                    if (!file_exists('../storage/app/'.$folderpath)){
                        File::makeDirectory('../storage/app/'.$folderpath);
                    }
                    
                    $file->storeAs($folderpath , $fileName);
                    $img = Img::make($file)->resize(185,240);
                    if (!file_exists('../storage/app/'.$folderpath.'/thumbs')){
                        File::makeDirectory('../storage/app/'.$folderpath.'/thumbs');
                    }
                    $img->save('../storage/app/'.$folderpath.'/thumbs/'.$fileName);
                    Image::create(['user_id' => $hostess->user_id,'type' => 'image' ,'name' => $fileName, 'title' => $name]);
                }
            }
            
            $user->profile_completed = 1;
            $user->save();
            
            DB::commit();
                
        } catch (Exception $ex) {
            DB::rollBack();
            return $ex->getMessage();            
        }        
        
        return true;
    }
}