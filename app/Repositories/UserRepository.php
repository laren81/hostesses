<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Role;

use Img;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\File;
use DB;
use Illuminate\Support\Str;

class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return User::all();    
    }
    
    public function createUser($input){
       $input['password'] = bcrypt(Str::random(35));

       if($input['role_id']==1){
           $input['profile_completed']=1;
       }
       $user = User::create($input);
       
       return $user;
    }
    
    public function findUser($id) {
        return User::find($id);
    }
            
    public function updateUser($user, $request) {

        DB::beginTransaction();
            
        try{
            $input = $request->all();

            if(isset($input['password']) && $input['password']!=''){
                $input['password'] = bcrypt($input['password']);
            }
            else
            {
                unset($input['password']);
            }
            
            $input['active'] = isset($input['active']) ? $input['active'] : 0;
            
            $user->update($input);

            if ($request->hasFile('image')) {

                $file = $request->file('image');

                $extension = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $fileName = str_random(5)."-".date('his')."-".str_random(3).".".$extension;
                $folderpath  = config('asl.images_dir').'/users/';
                $file->storeAs($folderpath , $fileName);

                $avatar = Img::make($file)->resize(48,48);            
                if (!file_exists('../storage/app/'.$folderpath.'/avatars')){
                     File::makeDirectory('../storage/app/'.$folderpath.'/avatars');
                }
                $avatar->save('../storage/app/'.$folderpath.'/avatars/'.$fileName);

                $img = Img::make($file)->resize(150,100);            
                if (!file_exists('../storage/app/'.$folderpath.'/thumbs')){
                     File::makeDirectory('../storage/app/'.$folderpath.'/thumbs');
                }            
                $img->save('../storage/app/'.$folderpath.'/thumbs/'.$fileName);

                Image::create(['imageble_id' => $user->id,'imageble_type' => 'App\User' ,'name' => $fileName, 'title' => $name]);            
            }
            
        DB::commit();
            
        } catch (Exception $e) {
            DB::rollBack();
        }

        return $user;
    }
    
    public function deleteUser($user) {
        
        if($user->image){

            $all_deleted = true;
            
            $image_path = storage_path("app/".config('asl.images_dir')."/users/{$user->image->name}");
            $thumb_path = storage_path("app/".config('asl.images_dir')."/users/thumbs/{$user->image->name}");
            $avatar_path = storage_path("app/".config('asl.images_dir')."/users/avatars/{$user->image->name}");

            if(!File::exists($image_path) || !File::delete($image_path) )
            {
                $all_deleted = false;
            }
            
            if(!File::exists($thumb_path) || !File::delete($thumb_path) )
            {
                $all_deleted = false;
            }
            
            if(!File::exists($avatar_path) || !File::delete($avatar_path) )
            {
                $all_deleted = false;
            }
            
            if($all_deleted){
                $user->image->delete();
            }
        }

        return $user->delete();

    }
    
    public function getUsers(){
        return User::leftJoin('roles','roles.id','=','users.role_id')->get(['users.*','roles.name as role_name']);
    }
    
    public function getRoleUsers($role_id) {
        return User::where('role_id',$role_id)->select(['users.id','users.name'])->get();
    }
}
