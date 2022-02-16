<?php
namespace App\Repositories\Interfaces;

interface RoleRepositoryInterface
{
   public function all();
   
   public function createRole($input);
   
   public function findRole($id);
   
   public function updateRole($role,$request);
   
   public function deleteRole($role);
}
