<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\User;
use App\Models\Event;
use App\Models\EventPosition;

use App\Repositories\Interfaces\ClientRepositoryInterface;

use DB;
use Illuminate\Support\Str;
use DateTime;
use Illuminate\Support\Facades\Password;

class ClientRepository implements ClientRepositoryInterface
{
    public function all(){
        return Client::all();
    }
    
    public function findUserClient($user_id){
        return Client::where('user_id',$user_id)->get()->first();
    }
    
    public function findClient($id){
        return Client::find($id);
    }
    
    public function createClient($request) {
        
        $input = $request->all();

        DB::beginTransaction();
        
        try{
            if(auth()->check() && auth()->user()->role_id!=1){
                $input['user_id'] = auth()->user()->id;                               
            }
            else{                
                $input['password'] = bcrypt(Str::random(35));
                $input['role_id'] = 3;
                $input['profile_completed'] = 1;

                $user = User::create($input);
                    
                $input['user_id'] = $user->id; 
            }
            
            $input['date_from'] = date_format(new DateTime($input['date_from']), 'Y-m-d');
            $input['date_to'] = date_format(new DateTime($input['date_to']), 'Y-m-d');

            $client = Client::create($input);   
            
            $input['client_id'] = $client->id;
            $input['region_id'] = $input['event_region_id'];
            $input['city_id'] = $input['event_city_id'];
            
            $event = Event::create($input);            
            
            foreach($input['positions'] as $position){
                
                $position['date_from'] = isset($position['date_from']) ? date_format(new DateTime($position['date_from']), 'Y-m-d') : null;
                $position['date_to'] = isset($position['date_to']) ?  date_format(new DateTime($position['date_to']), 'Y-m-d') : null;           
                $position['event_id'] = $event->id;
                
                EventPosition::create($position);
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
    
    public function updateClient($client,$request) {
        
        $input = $request->all();
        
        DB::beginTransaction();
        
        try{   
            $user = User::find($client->user_id);

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
            
            $client->update($request->all());
            
            DB::commit();
                
        } catch (Exception $ex) {
            DB::rollBack();
            
            return $ex->getMessage();
        }        
        
        return true;    
    }
    
    public function createClientProfile($user,$request){
        
        $input = $request->all();
        
        $input['user_id'] = $user->id;

        DB::beginTransaction();
        
        try{
            
            Client::create($input);
            
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