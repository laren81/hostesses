<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\HostessRequest;
use App\Http\Requests\ClientRequest;

use Illuminate\Support\Facades\Password;

use DataTables;

use DB;


class UserController extends Controller
{
   
    public function index(){
        $users = $this->userRepository->all(); 
        $roles = $this->roleRepository->all(); 

        return view('users.index', compact('users','roles'));
    }
    
    public function getUsers(){
        $users = $this->userRepository->getUsers();
        
        return DataTables::of($users)->make(true);
    }
   
    public function create(){
        $roles = $this->roleRepository->all();
        return view('users.create',compact('roles'));
    }
    
    public function store(UserRequest $request){
        
        DB::beginTransaction();
            
            if($user = $this->userRepository->createUser($request->all())){            
                $token = Password::getRepository()->create($user);

                $user->setRememberToken($token);
                $user->save();

                
                try {
                    $user->sendPasswordGenerationNotification($token);
                } 
                catch (\Swift_TransportException $e) {
                    DB::rollback();
                    
                    return redirect()->back()->withInput($request->input())->with('danger', $e->getMessage());
                }
                
            }
            else{
                DB::rollback();
                return redirect()->route('admin.users.index')->with('warning','Потребителят не беше създаден!');
            }
            
        DB::commit(); 
        
        return redirect()->route('admin.users.index')->with('success','Потребителят беше създаден!');
    }
    
    public function show($id){
        if($user = $this->userRepository->findUser($id)){
            
            if($user->role_id==3 && $user->profile_completed==1){
                $user_details = $this->clientRepository->findUserClient($user->id);
                $main_cities = collect();
            }
            else if($user->role_id==2 && $user->profile_completed==1){
                $user_details = $this->hostessRepository->findUserHostess($user->id);
                
                $user_details->preferred_occupation = explode(',',trim($user_details->preferred_occupation,','));
                $user_details->accommodation_places = explode(',',trim($user_details->accommodation_places,','));
                
                $main_cities = $this->cityRepository->all()->where('main_city',1);
            }
            else{
                $user_details = collect();
                $main_cities = collect();
            }
            return view('users.show', compact('user','user_details','main_cities'));
        }
        else{
            return redirect()->route('admin.users.index')->with('warning','Потребителят не беше намерен.');
        }
    }
    
    public function edit($id){
        if($user = $this->userRepository->findUser($id)){
            if($user->role_id==1 || $user->profile_completed==0){
                return view('users.edit', compact('user'));
            }   
            else{
                $regions = $this->regionRepository->all();
                $cities = $this->cityRepository->all();                
                
                if($user->role_id==2){
                    $hostess = $this->hostessRepository->findUserHostess($user->id);

                    $hostess->preferred_occupation = explode(',',trim($hostess->preferred_occupation,','));
                    $hostess->accommodation_places = explode(',',trim($hostess->accommodation_places,','));
                    
                    $main_cities = $this->cityRepository->all()->where('main_city',1);
                    
                    return view('users.edit_hostess', compact('user','hostess','regions','cities','main_cities'));
                }
                
                else if($user->role_id==3){
                    $client = $this->clientRepository->findUserClient($user->id);
                    
                    return view('users.edit_client', compact('user','client','regions','cities'));
                }
            }
        }
        else{
            return redirect()->route('admin.users.index')->with('warning','Потребителят не беше намерен.');
        }
    }
        
    public function updateUser(UserRequest $request,$id){
        if($user = $this->userRepository->findUser($id)){
            
            if($this->userRepository->updateUser($user,$request)){
                
                return redirect()->route('admin.users.index')->with('success','Потребителят беше променен!');
            }
            else{
                return redirect()->route('admin.users.index')->with('warning','Потребителят не беше променен!');
            }          
        }
        return redirect()->route('admin.users.index')->with('warning','Потребителят не беше намерен!');
    }
    
    public function updateHostess(HostessRequest $request,$id){
        if($user = $this->userRepository->findUser($request->user_id)){
            if($hostess = $this->hostessRepository->findHostess($request->id)){
                
                $result = $this->hostessRepository->updateHostess($hostess,$request);

                if($result===true){
                    return redirect()->route('admin.users.index')->with('success','Потребителският профил беше променен');
                }  

                if(is_object($result)){
                    return redirect()->back()->withInput($request->all())->with('errors',$result);
                }

                return redirect()->back()->withInput($request->all())->with('warning',$result);
            }

            return redirect()->route('admin.users.index')->with('warning','Потребителският профил не беше намерен');               
        }
        return redirect()->route('admin.users.index')->with('warning','Потребителят не беше намерен!');
    }
    
    public function updateClient(ClientRequest $request,$id){
        if($user = $this->userRepository->findUser($request->user_id)){            
            if($client = $this->clientRepository->findClient($id)){
                
                $result = $this->clientRepository->updateClient($client,$request);

                if($result===true){
                    return redirect()->route('admin.users.index')->with('success','Потребителският профил беше променен');
                }  

                if(is_object($result)){
                    return redirect()->back()->withInput($request->all())->with('errors',$result);
                }

                return redirect()->back()->withInput($request->all())->with('warning',$result);
            }

            return redirect()->route('admin.users.index')->with('warning','Потребителският профил не беше намерен');

        }
        return redirect()->route('admin.users.index')->with('warning','Потребителят не беше намерен!');
    }
    
    public function destroy(Request $request){
        
        $id = $request->get('id');
                
        if($user = $this->userRepository->findUser($id)){

            if($this->userRepository->deleteUser($user)){
                return response()->json(['success' => 'Потребителят беше изтрит!']);
            }
            else{
                return response()->json(['warning' => 'Потребителят не беше изтрит!']);
            }
        }
        return response()->json(['warning' => 'Потребителят не беше намерен!']);
    }
}
