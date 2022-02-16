<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;

use App\Models\Group;

use DataTables;

class RoleController extends Controller
{
    public function index(){
       $roles = $this->roleRepository->all(); 
       
       return view('roles.index', compact('roles'));
    }
   
    public function getRoles(){
        $roles = $this->roleRepository->all();
        
        return DataTables::of($roles)->make(true);
    }
   
    public function create(){
        
        return view('roles.create');
    }
    
    public function store(RoleRequest $request){
        if($this->roleRepository->createRole($request->all())){
            return redirect()->route('admin.roles.index')->with('success','Ролята беше създадена!');
        }
        else{
            return redirect()->route('admin.roles.index')->with('warning','Ролята не беше създадена!');
        }
    }
    
    public function show($id){
        if($role = $this->roleRepository->findRole($id)){
            return view('roles.show', compact('role'));
        }
        else{
            return redirect()->route('admin.roles.index')->with('warning','Ролята не беше намерена.');
        }
    }
    
    public function edit($id){
        if($role = $this->roleRepository->findRole($id)){
            return view('roles.edit', compact('role'));
        }
        else{
            return redirect()->route('admin.roles.index')->with('warning','Ролята не беше намерена.');
        }
    }
    
    public function update(RoleRequest $request,$id){
        if($role = $this->roleRepository->findRole($id)){
            if($this->roleRepository->updateRole($role,$request)){                
                return redirect()->route('admin.roles.index')->with('success','Ролята беше променена!');
            }
            else{
                return redirect()->route('admin.roles.index')->with('warning','Ролята не беше променена!');
            }
        }
        return redirect()->route('admin.roles.index')->with('warning','Ролята не беше намерена!');
    }
    
    public function destroy(Request $request){
        
        $id = $request->get('id');
                
        if($role = $this->roleRepository->findRole($id)){
            if(count($role->users)>0){
                return response()->json(['warning' => 'Ролята е асоциирана с потребители и не може да бъде изтрита!']);
            }
            if($this->roleRepository->deleteRole($role)){
                return response()->json(['success' => 'Ролята беше изтрита!']);
            }
            else{
                return response()->json(['warning' => 'Ролята не беше изтрита!']);
            }
        }
        return response()->json(['warning' => 'Ролята не беше намерена!']);
    }
}
