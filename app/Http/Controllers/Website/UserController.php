<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\HostessRequest;
use App\Http\Requests\ClientRequest;

use Illuminate\Support\Facades\Password;

use DataTables;

use DB;


class UserController extends Controller
{
    public function showUser($id){
        if($user = $this->userRepository->findUser($id)){
            if($user->id!=auth()->user()->id && auth()->user()->role_id!=1){
                return redirect()->route('home')->with('warning','Нямате право да видите този профил');
            }
            else{                
                if($user->role_id==1){
                    return view('users.show',compact('user'));
                }
                else if($user->role_id==2 && $hostess = $this->hostessRepository->findUserHostess($user->id)){
                    $hostess->preferred_occupation = explode(',',trim($hostess->preferred_occupation,','));
                    $hostess->accommodation_places = explode(',',trim($hostess->accommodation_places,','));
                    
                    $main_cities = $this->cityRepository->all()->where('main_city',1);
                    
                    return view('website.hostesses.show',compact('user','hostess','main_cities'));
                }
                else if($user->role_id==3 && $client = $this->clientRepository->findUserClient($user->id)){
                    return view('website.clients.show',compact('user','client'));
                }                
            }
        }
        return redirect()->route('home')->with('warning','Потребителят не беше намерен');
    }
    
    public function createUserProfile(){
        $regions = $this->regionRepository->all();
        $cities = $this->cityRepository->all();
        
        if(auth()->user()->role_id==2){
            $main_cities = $cities->wherE('main_city',1);
            return view('website.hostesses.create_hostess', compact('regions','cities','main_cities'));
        }
        else if(auth()->user()->role_id==3){
            return view('website.clients.create_client', compact('regions','cities'));
        }
    }
   
    public function createHostess(){
        
        $regions = $this->regionRepository->all();
        $cities = $this->cityRepository->all();
        $main_cities = $cities->where('main_city',1);
        
        return view('website.hostesses.create', compact('cities','regions','main_cities'));
    }
    
    public function storeHostess(HostessRequest $request){

        $result = $this->hostessRepository->createHostess($request);

        if($result===true){
            return redirect()->route('home')->with('success','Профилът ви беше създаден');
        }  

        if(is_object($result)){
            return redirect()->back()->withInput($request->all())->with('errors',$result);
        }

        return redirect()->back()->withInput($request->all())->with('warning',$result);
        
    }
    
    public function editHostess($id){
        if($user = $this->userRepository->findUser($id)){
            if($user->id==auth()->user()->id){
                if($hostess = $this->hostessRepository->findUserHostess($user->id)){

                    $hostess->preferred_occupation = explode(',',trim($hostess->preferred_occupation,','));
                    $hostess->accommodation_places = explode(',',trim($hostess->accommodation_places,','));

                    $regions = $this->regionRepository->all();
                    $cities = $this->cityRepository->all();
                    $main_cities = $this->cityRepository->all()->where('main_city',1);

                    return view('website.hostesses.edit', compact('user','hostess','regions','cities','main_cities'));
                }
            }
            return redirect()->route('home')->with('warning','Не можете да редактирате чужд профил');
        }
        
        return redirect()->route('home')->with('warning','Потребителят не беше намерен');
    }
    
    public function updateHostess($id,HostessRequest $request){
        if($hostess = $this->hostessRepository->findHostess($id)){
            $result = $this->hostessRepository->updateHostess($hostess,$request);

                if($result===true){
                    return redirect()->route('users.show',$hostess->user_id)->with('success','Профилът ви беше променен');
                }  

                if(is_object($result)){
                    return redirect()->back()->withInput($request->all())->with('errors',$result);
                }

                return redirect()->back()->withInput($request->all())->with('warning',$result);
        }
        
        return redirect()->route('home')->with('warning','Потребителският профил не беше намерен');
    }
    
    public function storeHostessProfile($id,HostessRequest $request){
        if($user = $this->userRepository->findUser($id)){
            $result = $this->hostessRepository->createHostessProfile($user,$request);
            
            if($result===true){
                return redirect()->route('users.show',$user->id)->with('success','Профилът ви беше създаден');
            }  

            if(is_object($result)){
                return redirect()->back()->withInput($request->all())->with('errors',$result);
            }

            return redirect()->back()->withInput($request->all())->with('warning',$result);
        }
    }
    
    public function createClient(){
        $regions = $this->regionRepository->all();
        $cities = $this->cityRepository->all();
        
        return view('website.clients.create',compact('regions','cities'));
    }
    
    public function storeClient(ClientRequest $request){
        $result = $this->clientRepository->createClient($request);

        if($result===true){
            return redirect()->route('home')->with('success','Профилът ви беше създаден');
        }  

        if(is_object($result)){
            return redirect()->back()->withInput($request->all())->with('errors',$result);
        }

        return redirect()->back()->withInput($request->all())->with('warning',$result);
    }
    
    public function editClient($id){
        if($user = $this->userRepository->findUser($id)){
            if($user->id==auth()->user()->id){
                if($client = $this->clientRepository->findUserClient($user->id)){
                    $regions = $this->regionRepository->all();
                    $cities = $this->cityRepository->all();
        
                    return view('website.clients.edit', compact('user','client','regions','cities'));
                }
            }
            return redirect()->route('home')->with('warning','Не можете да редактирате чужд профил');
        }
        
        return redirect()->route('home')->with('warning','Потребителят не беше намерен');
    }
    
    public function updateClient($id,ClientRequest $request){
        if($client = $this->clientRepository->findClient($id)){
            $result = $this->clientRepository->updateClient($client,$request);

                if($result===true){
                    return redirect()->route('users.show',$client->user_id)->with('success','Профилът ви беше променен');
                }  

                if(is_object($result)){
                    return redirect()->back()->withInput($request->all())->with('errors',$result);
                }

                return redirect()->back()->withInput($request->all())->with('warning',$result);
        }
        
        return redirect()->route('home')->with('warning','Клиентският профил не беше намерен');
    }
    
    public function storeClientProfile($id,ClientRequest $request){
        if($user = $this->userRepository->findUser($id)){
            $result = $this->clientRepository->createClientProfile($user,$request);
            
            if($result===true){
                return redirect()->route('users.show',$user->id)->with('success','Профилът ви беше създаден');
            }  

            if(is_object($result)){
                return redirect()->back()->withInput($request->all())->with('errors',$result);
            }

            return redirect()->back()->withInput($request->all())->with('warning',$result);
        }
    }
    
    public function showHostess($id){
        if($hostess = $this->hostessRepository->findHostess($id)){
            
            $hostess->preferred_occupation = explode(',',trim($hostess->preferred_occupation,','));
            $hostess->accommodation_places = explode(',',trim($hostess->accommodation_places,','));
               
            $main_cities = $this->cityRepository->all()->where('main_city',1);
            
            return view('website.hostesses.show_profile', compact('hostess','main_cities'));
        }
        
        return redirect()->route('home')->with('warning','Something went wrong');
    }
}
