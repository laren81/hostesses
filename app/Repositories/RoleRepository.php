<?php

namespace App\Repositories;

use App\Models\Role;

use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    public function all()
    {        
        return Role::all();
    }
    
    public function createRole($input){
       
        $role =  Role::create($input);
       
        return $role;
    }
    
    public function findRole($id) {
        return Role::find($id);
    }
    
    public function updateRole($role, $request) {

        $input = $request->all();
        
        $role->update($input);
        
        return $role;
    }
    
    public function deleteRole($role) {
        
        return $role->delete();

    }
    
}
